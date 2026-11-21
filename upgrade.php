<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require __DIR__ . '/includes/config.php';
require_once __DIR__ . '/visitor.php';

if (STRIPE_LIVE_MODE) {
    require_once __DIR__ . '/vendor/autoload.php';
    \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
}

/* =====================================================================
   TEMPORARY SWITCHES
   - $WHATSAPP_MODE = true  -> "Pay with Card" opens the WhatsApp payment popup
   - $FREE_PROMO    = false -> free plans are OFF (set true + uncomment the
                               "FREE GRANT" block below to turn them back on)
   When Stripe is ready: set $WHATSAPP_MODE = false (and STRIPE_LIVE_MODE true).
===================================================================== */
$WHATSAPP_MODE   = true;
$FREE_PROMO      = false;
$WHATSAPP_NUMBER = '819050295822';            // for wa.me link
$WHATSAPP_DISPLAY = '+81 90-5029-5822';

$isLoggedIn = isset($_SESSION['user_id']);
$userEmail  = $_SESSION['user_email'] ?? '';
$errorMessage = "";
$successMessage = "";

$planNames = [
    '1_month'  => '1 Month Japan Driving License Plan',
    '6_months' => '6 Months Japan Driving License Plan',
    '1_year'   => '1 Year Japan Driving License Plan',
];
$planLabelsSi = [
    '1_month'  => 'මාස 1 ක් (1 Month Plan)',
    '6_months' => 'මාස 6 ක් (6 Months Plan)',
    '1_year'   => 'වසර 1 ක් (1 Year Plan)',
];
$planPrices = [ // JPY, whole yen (Stripe's smallest unit for JPY is 1, not cents)
    '1_month'  => 1500,
    '6_months' => 3500,
    '1_year'   => 5000,
];

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
$baseUrl = $scheme . $_SERVER['HTTP_HOST'];

/**
 * Current JPY -> LKR rate, fetched automatically and cached for 6 hours.
 * (Google has no free public API, so a free exchange-rate API is used.)
 * Falls back to the last cached value, then to a safe default.
 */
function getJpyToLkrRate(): float {
    $fallback  = 2.09;
    $cacheFile = sys_get_temp_dir() . '/jpy_lkr_rate.json';
    $ttl       = 6 * 3600;

    if (is_file($cacheFile)) {
        $cached = json_decode((string) @file_get_contents($cacheFile), true);
        if (!empty($cached['rate']) && (time() - ($cached['time'] ?? 0)) < $ttl) {
            return (float) $cached['rate'];
        }
    }

    $ctx = stream_context_create(['http' => ['timeout' => 4]]);
    $raw = @file_get_contents('https://open.er-api.com/v6/latest/JPY', false, $ctx);
    if ($raw !== false) {
        $data = json_decode($raw, true);
        if (!empty($data['rates']['LKR'])) {
            $rate = (float) $data['rates']['LKR'];
            @file_put_contents($cacheFile, json_encode(['rate' => $rate, 'time' => time()]));
            return $rate;
        }
    }

    if (!empty($cached['rate'])) return (float) $cached['rate']; // stale cache is better than nothing
    return $fallback;
}
$lkrRate = getJpyToLkrRate();

/**
 * Actually grant a plan on the user's account — the one place both the
 * "Stripe not live yet" path and the "payment confirmed" path call into,
 * so the account-upgrade logic only exists once.
 */
function grantPlan(PDO $pdo, int $userId, string $plan): bool {
    $monthsByPlan = ['1_month' => 1, '6_months' => 6, '1_year' => 12];
    $labelByPlan  = ['1_month' => '1-Month Plan', '6_months' => '6-Month Plan', '1_year' => '1-Year Plan'];

    $months = $monthsByPlan[$plan] ?? 1;
    $label = $labelByPlan[$plan] ?? 'Premium Plan';
    $expiry = date('Y-m-d H:i:s', strtotime("+$months months"));

    $stmt = $pdo->prepare("UPDATE users SET subscription_status = 'active', plan_type = ?, subscription_expiry = ?, membership_status = ? WHERE id = ?");
    return $stmt->execute([
        $plan,
        $expiry,
        $label,
        $userId
    ]);
}

/* ==================== 1. Plan selected -> "Pay with Card" clicked ==================== */
if (!$WHATSAPP_MODE && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['plan'])) {
    if (!$isLoggedIn) {
        header("Location: login.php?redirect=upgrade.php");
        exit();
    }

    $plan = $_POST['plan'];
    $userId = (int) $_SESSION['user_id'];

    if (!isset($planPrices[$plan])) {
        exit('Invalid plan selected.');
    }

    /* ---------- FREE GRANT (DISABLED TEMPORARILY) ----------
       To re-enable free upgrades: set $FREE_PROMO = true above,
       and uncomment this whole block (change `if (false)` back to
       `if (!STRIPE_LIVE_MODE)` and remove the `else` guard below).

    if (!STRIPE_LIVE_MODE) {
        try {
            if (grantPlan($pdo, $userId, $plan)) {
                $_SESSION['subscription_status'] = 'active';
                $_SESSION['plan_type'] = $plan;
                header("Location: dashboard.php?upgraded=1");
                exit();
            } else {
                $errorMessage = "ගිණුම Upgrade කිරීමේදී දෝෂයක් ඇති විය.";
            }
        } catch (\PDOException $e) {
            $errorMessage = "ගිණුම Upgrade කිරීමේදී දෝෂයක් ඇති විය: " . $e->getMessage();
        }
    } else {
    ---------- END FREE GRANT ---------- */

    if (STRIPE_LIVE_MODE) {
        // Real Stripe Checkout.
        try {
            $checkout_session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'customer_email' => $userEmail ?: null,
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'jpy',
                        'product_data' => ['name' => $planNames[$plan]],
                        'unit_amount' => $planPrices[$plan],
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => $baseUrl . '/upgrade.php?payment=success&session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => $baseUrl . '/upgrade.php',
                'metadata' => [
                    'user_id' => $userId,
                    'plan_type' => $plan,
                ],
            ]);

            header("HTTP/1.1 303 See Other");
            header("Location: " . $checkout_session->url);
            exit();
        } catch (\Exception $e) {
            $errorMessage = "Stripe Error: " . $e->getMessage();
        }
    }
    // } // <- closing brace of the `else {` above (uncomment together with FREE GRANT block)
}

/* ==================== 2. Back from Stripe Checkout ====================
   We fetch the actual Checkout Session from Stripe by its ID and only grant
   access if Stripe confirms payment_status === 'paid'.
========================================================================= */
if (STRIPE_LIVE_MODE && isset($_GET['payment']) && $_GET['payment'] === 'success' && isset($_GET['session_id'])) {
    if (!$isLoggedIn) {
        header("Location: login.php?redirect=upgrade.php");
        exit();
    }

    if (empty($_SESSION['upgrade_processed_session']) || $_SESSION['upgrade_processed_session'] !== $_GET['session_id']) {
        try {
            $checkoutSession = \Stripe\Checkout\Session::retrieve($_GET['session_id']);

            if ($checkoutSession->payment_status === 'paid'
                && (int) $checkoutSession->metadata->user_id === (int) $_SESSION['user_id']
                && isset($planPrices[$checkoutSession->metadata->plan_type])
            ) {
                $plan = $checkoutSession->metadata->plan_type;

                if (grantPlan($pdo, (int) $_SESSION['user_id'], $plan)) {
                    $_SESSION['subscription_status'] = 'active';
                    $_SESSION['plan_type'] = $plan;
                    $_SESSION['upgrade_processed_session'] = $_GET['session_id'];
                    header("Location: dashboard.php?upgraded=1");
                    exit();
                } else {
                    $errorMessage = "ගිණුම Upgrade කිරීමේදී දෝෂයක් ඇති විය.";
                }
            } else {
                $errorMessage = "ගෙවීම තහවුරු කළ නොහැක. කරුණාකර නැවත උත්සාහ කරන්න.";
            }
        } catch (\Exception $e) {
            $errorMessage = "Stripe Error: " . $e->getMessage();
        }
    } else {
        header("Location: dashboard.php");
        exit();
    }
}

/* Helper: the button used in every pricing card */
function planButton(string $plan, string $label, string $classes, bool $whatsappMode): void {
    if ($whatsappMode) {
        echo '<button type="button" data-plan="' . htmlspecialchars($plan) . '" class="open-pay ' . $classes . '">' . $label . '</button>';
    } else {
        echo '<form method="POST"><input type="hidden" name="plan" value="' . htmlspecialchars($plan) . '">'
           . '<button type="submit" class="' . $classes . '">' . $label . '</button></form>';
    }
}

// Data handed to the popup's JavaScript
$jsPlans = [];
foreach ($planPrices as $key => $yen) {
    $jsPlans[$key] = ['name' => $planLabelsSi[$key], 'jpy' => $yen];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Upgrade to Premium - Japan Driving License Practice | ප්‍රිමියම් ප්‍රවේශය</title>
<meta name="description" content="Unlock 1000+ Japan driving license practice questions, unlimited mock exams and full category access.">
<meta name="robots" content="noindex, follow">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@600;700&family=Inter:wght@400;500;600;700&family=Noto+Sans+Sinhala:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          ink: '#101A30',
          paper: '#F6F5F1',
          primary: { DEFAULT: '#0F2F6E', light: '#E7ECFA', dark: '#0A2050' },
          accent: { DEFAULT: '#F2A73B', light: '#FDF1DD' },
          go: '#1C8F5A',
          stop: '#D5432E',
        },
        fontFamily: {
          display: ['"Space Grotesk"', 'sans-serif'],
          body: ['"Inter"', '"Noto Sans Sinhala"', 'sans-serif'],
          mono: ['"JetBrains Mono"', 'monospace'],
        },
      }
    }
  }
</script>
<style>
  html{ -webkit-text-size-adjust:100%; }
  body{ font-family:'Inter','Noto Sans Sinhala',sans-serif; overflow-x:hidden; }
  .grid-texture{
    background-image:
      linear-gradient(to right, rgba(15,47,110,0.06) 1px, transparent 1px),
      linear-gradient(to bottom, rgba(15,47,110,0.06) 1px, transparent 1px);
    background-size: 28px 28px;
  }
  *:focus-visible{ outline: 3px solid #F2A73B; outline-offset: 2px; }
  @keyframes riseIn{ from{ opacity:0; transform:translateY(10px);} to{ opacity:1; transform:translateY(0);} }
  .rise-in{ animation: riseIn .35s ease-out both; }
  @keyframes sheetIn{ from{ opacity:0; transform:translateY(24px);} to{ opacity:1; transform:translateY(0);} }
  .sheet-in{ animation: sheetIn .25s ease-out both; }
  @media (prefers-reduced-motion: reduce){ .rise-in,.sheet-in{ animation:none; } }
  .no-scroll{ overflow:hidden; }
</style>
</head>
<body class="bg-paper text-ink font-body min-h-screen flex flex-col">

<header class="bg-primary text-white shadow-lg">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-2">
    <a href="index.php" class="flex items-center gap-2 min-w-0">
      <svg class="shrink-0" width="28" height="28" viewBox="0 0 48 48" fill="none" aria-hidden="true"><circle cx="24" cy="24" r="21" stroke="#F2A73B" stroke-width="3"/><circle cx="24" cy="24" r="5.5" fill="#F2A73B"/><path d="M24 3v10M24 35v10M3 24h10M35 24h10M9.5 9.5l7 7M31.5 31.5l7 7M9.5 38.5l7-7M31.5 16.5l7-7" stroke="#F2A73B" stroke-width="2.5" stroke-linecap="round"/></svg>
      <div class="leading-tight min-w-0">
        <span class="font-display font-bold text-sm sm:text-base block truncate">Japan License Prep</span>
        <span class="text-[11px] text-white/60 hidden sm:block">ප්‍රිමියම් ගිණුම් ප්‍රවේශය</span>
      </div>
    </a>
    <?php if ($isLoggedIn): ?>
      <a href="dashboard.php" class="shrink-0 text-xs sm:text-sm font-semibold bg-white/10 hover:bg-white/20 text-white px-3 sm:px-4 py-2 rounded-lg transition">👤 Dashboard</a>
    <?php else: ?>
      <a href="login.php?redirect=upgrade.php" class="shrink-0 text-xs sm:text-sm font-semibold bg-accent text-ink hover:brightness-95 px-3 sm:px-4 py-2 rounded-lg transition">Login</a>
    <?php endif; ?>
  </div>
</header>

<main class="grid-texture flex-grow">
  <div class="max-w-3xl w-full mx-auto px-4 sm:px-6 py-8 sm:py-14">

    <!-- Heading -->
    <div class="text-center mb-8 sm:mb-10 rise-in">
      <span class="inline-block bg-accent-light text-primary text-[11px] font-bold px-3 py-1 rounded-full uppercase tracking-wider border border-accent/40">Unlock Full Access</span>
      <h1 class="font-display text-xl sm:text-3xl font-bold text-ink mt-3 mb-2 leading-snug">ජපන් රියදුරු බලපත්‍ර විභාගය පළමු වරටම සමත් වන්න</h1>
      <p class="text-ink/60 text-sm max-w-xl mx-auto">ප්‍රශ්න 1000 කට අධික සංඛ්‍යාවක්, ආදර්ශ විභාග (Mock Tests) සහ වැදගත් රීති මාලාවක් සමඟ සම්පූර්ණ ප්‍රවේශය ලබා ගන්න.</p>
      <?php if ($FREE_PROMO && !STRIPE_LIVE_MODE): ?>
        <p class="mt-3 inline-block text-[11px] font-semibold text-primary bg-primary-light px-3 py-1 rounded-full">🎁 Card payments are being set up — upgrades are free for now, just log in and choose a plan.</p>
      <?php endif; ?>
    </div>

    <?php if (!empty($errorMessage)): ?>
      <div class="mb-6 p-4 bg-stop/10 border border-stop/30 text-stop rounded-xl text-center font-medium break-words">
        <?php echo htmlspecialchars($errorMessage); ?>
      </div>
    <?php endif; ?>

    <!-- Pricing Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

      <!-- 1 Month Plan -->
      <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 border border-black/5 flex flex-col justify-between rise-in">
        <div>
          <span class="bg-black/5 text-ink/60 text-xs font-bold px-3 py-1 rounded-full">Try It Out</span>
          <h3 class="font-display font-bold text-xl text-ink mt-4">1 Month Plan</h3>
          <p class="text-4xl font-black text-primary my-3 font-mono">
            <?php if ($FREE_PROMO && !STRIPE_LIVE_MODE): ?>
              <span class="text-ink/30 line-through text-2xl align-middle mr-1">¥1,500</span><span class="text-go">FREE</span>
            <?php else: ?>
              ¥1,500<span class="text-base font-normal text-ink/40"> / mo</span>
            <?php endif; ?>
          </p>
          <p class="text-xs text-ink/50 mb-6">මාසයක් සම්පූර්ණ ප්‍රවේශය — ටික කාලයක් උත්සාහ කර බලන්න.</p>

          <ul class="space-y-3 text-sm text-ink/70 mb-8">
            <li class="flex items-start gap-2"><span class="text-go">✓</span> ප්‍රශ්න 1000+ කට සම්පූර්ණ ප්‍රවේශය</li>
            <li class="flex items-start gap-2"><span class="text-go">✓</span> අසීමිත Mock Tests පුහුණුව</li>
            <li class="flex items-start gap-2"><span class="text-go">✓</span> සිංහල සහ ඉංග්‍රීසි භාෂා දෙකෙන්ම</li>
          </ul>
        </div>
        <?php planButton('1_month',
            STRIPE_LIVE_MODE || $WHATSAPP_MODE ? 'Pay with Card (¥1,500) →' : 'Claim 1 Month Free →',
            'w-full bg-white border-2 border-primary text-primary hover:bg-primary-light font-semibold py-3 rounded-xl transition text-center block',
            $WHATSAPP_MODE); ?>
      </div>

      <!-- 6 Months Plan -->
      <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 border border-black/5 flex flex-col justify-between rise-in">
        <div>
          <span class="bg-primary-light text-primary text-xs font-bold px-3 py-1 rounded-full">Most Popular</span>
          <h3 class="font-display font-bold text-xl text-ink mt-4">6 Months Plan</h3>
          <p class="text-4xl font-black text-primary my-3 font-mono">
            <?php if ($FREE_PROMO && !STRIPE_LIVE_MODE): ?>
              <span class="text-ink/30 line-through text-2xl align-middle mr-1">¥3,500</span><span class="text-go">FREE</span>
            <?php else: ?>
              ¥3,500<span class="text-base font-normal text-ink/40"> / 6mo</span>
            <?php endif; ?>
          </p>
          <p class="text-xs text-ink/50 mb-6">මාස 6ක් පුරා අඛණ්ඩ පුහුණු වීමේ පහසුකම සහ සියලුම ප්‍රශ්න.</p>

          <ul class="space-y-3 text-sm text-ink/70 mb-8">
            <li class="flex items-start gap-2"><span class="text-go">✓</span> ප්‍රශ්න 1000+ කට සම්පූර්ණ ප්‍රවේශය</li>
            <li class="flex items-start gap-2"><span class="text-go">✓</span> අසීමිත Mock Tests පුහුණුව</li>
            <li class="flex items-start gap-2"><span class="text-go">✓</span> සිංහල සහ ඉංග්‍රීසි භාෂා දෙකෙන්ම</li>
          </ul>
        </div>
        <?php planButton('6_months',
            STRIPE_LIVE_MODE || $WHATSAPP_MODE ? 'Pay with Card (¥3,500) →' : 'Claim 6 Months Free →',
            'w-full bg-primary hover:bg-primary-dark text-white font-semibold py-3 rounded-xl transition shadow-md text-center block',
            $WHATSAPP_MODE); ?>
      </div>

      <!-- 1 Year Plan -->
      <div class="relative bg-gradient-to-br from-primary via-primary-dark to-ink text-white rounded-2xl shadow-xl p-6 sm:p-8 border-2 border-accent flex flex-col justify-between rise-in mt-2 md:mt-0">
        <span class="absolute -top-3 left-1/2 -translate-x-1/2 bg-accent text-ink text-[11px] font-bold px-3 py-1 rounded-full shadow whitespace-nowrap">Best Value</span>
        <div>
          <span class="bg-accent text-ink text-xs font-bold px-2.5 py-1 rounded-full">Save the Most</span>
          <h3 class="font-display font-bold text-xl text-white mt-4">1 Year Plan</h3>
          <p class="text-4xl font-black text-accent my-3 font-mono">
            <?php if ($FREE_PROMO && !STRIPE_LIVE_MODE): ?>
              <span class="text-white/30 line-through text-2xl align-middle mr-1">¥5,000</span><span class="text-accent">FREE</span>
            <?php else: ?>
              ¥5,000<span class="text-base font-normal text-white/60"> / yr</span>
            <?php endif; ?>
          </p>
          <p class="text-xs text-white/70 mb-6">වසරක පූර්ණ ප්‍රවේශය සහ විශේෂ විභාග මඟපෙන්වීම්.</p>

          <ul class="space-y-3 text-sm text-white/85 mb-8">
            <li class="flex items-start gap-2"><span class="text-accent">✓</span> වසරක පූර්ණ ප්‍රවේශය (1 Year Access)</li>
            <li class="flex items-start gap-2"><span class="text-accent">✓</span> විශේෂ විභාග කෙටි ක්‍රම සහ සටහන්</li>
            <li class="flex items-start gap-2"><span class="text-accent">✓</span> ප්‍රමුඛතා පදනම මත සහය</li>
          </ul>
        </div>
        <?php planButton('1_year',
            STRIPE_LIVE_MODE || $WHATSAPP_MODE ? 'Pay with Card (¥5,000) →' : 'Claim 1 Year Free →',
            'w-full bg-accent hover:brightness-95 text-ink font-bold py-3 rounded-xl transition shadow-lg text-center block',
            $WHATSAPP_MODE); ?>
      </div>

    </div>

    <p class="text-center text-[11px] text-ink/40 mt-6">
      <?= $WHATSAPP_MODE ? '🔒 Secure · Activation after payment confirmation' : (STRIPE_LIVE_MODE ? '🔒 Secure checkout via Stripe · Instant activation' : '🔒 Secure · Instant activation') ?>
    </p>

    <!-- Back Link -->
    <div class="text-center mt-8">
      <a href="index.php" class="text-sm text-ink/50 hover:text-primary font-medium transition">← Back to Practice Quiz / මුල් පිටුවට යන්න</a>
    </div>

  </div>
</main>

<footer class="text-center py-6 text-xs text-ink/40 border-t border-black/5 bg-white">
  Japan Driving License Practice System &copy; 2026
</footer>

<?php if ($WHATSAPP_MODE): ?>
<!-- ==================== WhatsApp payment popup ==================== -->
<div id="payModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true" aria-labelledby="payTitle">
  <div id="payBackdrop" class="absolute inset-0 bg-ink/60 backdrop-blur-sm"></div>

  <div class="relative h-full w-full flex items-end sm:items-center justify-center p-0 sm:p-6">
    <div class="sheet-in bg-white w-full sm:max-w-md rounded-t-3xl sm:rounded-2xl shadow-2xl max-h-[92vh] overflow-y-auto overscroll-contain">

      <div class="sticky top-0 bg-white/95 backdrop-blur px-5 sm:px-6 pt-5 pb-3 flex items-start justify-between gap-3 border-b border-black/5">
        <h2 id="payTitle" class="font-display text-lg sm:text-xl font-bold text-ink leading-snug">ගෙවීම් විස්තර ලබාගන්න</h2>
        <button type="button" id="payX" class="shrink-0 -mr-1 w-9 h-9 rounded-full hover:bg-black/5 text-ink/60 text-xl leading-none" aria-label="Close">&times;</button>
      </div>

      <div class="px-5 sm:px-6 py-5 space-y-4">
        <p class="text-sm text-ink/70 leading-relaxed">
          ගෙවීම් කරන ආකාරය පිළිබඳ විස්තර ලබාගැනීමට කරුණාකර අපගේ WhatsApp අංකයට පණිවිඩයක් එවන්න. පහත බොත්තම එබූ විට ඔබේ ඇණවුමේ විස්තර සහිත පණිවිඩයක් සකසා WhatsApp විවෘත වේ.
        </p>

        <div class="rounded-xl border border-black/10 bg-paper p-4">
          <p class="text-[11px] font-bold uppercase tracking-wider text-ink/50 mb-2">ඔබේ ඇණවුම</p>
          <div class="flex items-start justify-between gap-3">
            <div class="min-w-0">
              <p id="orderPlan" class="font-semibold text-ink text-sm sm:text-base break-words">—</p>
              <p class="text-xs text-ink/50 mt-0.5">ප්‍රිමියම් පැකේජය</p>
            </div>
            <div class="text-right shrink-0">
              <p id="orderJpy" class="font-mono font-bold text-primary text-lg">—</p>
              <p id="orderLkr" class="text-xs text-ink/60 font-medium">—</p>
            </div>
          </div>
          <p class="text-[10px] text-ink/40 mt-3">ශ්‍රී ලංකා රුපියල් අගය වත්මන් විනිමය අනුපාතය අනුව ගණනය කළ ආසන්න අගයකි.</p>
        </div>

        <div class="flex items-center justify-between gap-3 rounded-xl bg-primary-light px-4 py-3">
          <span class="text-xs sm:text-sm text-ink/70">අපගේ WhatsApp අංකය</span>
          <span class="font-mono font-semibold text-primary text-sm sm:text-base whitespace-nowrap"><?= htmlspecialchars($WHATSAPP_DISPLAY) ?></span>
        </div>

        <?php if (!$isLoggedIn): ?>
          <p class="text-xs text-stop bg-stop/10 border border-stop/20 rounded-lg px-3 py-2">
            ⚠️ ගිණුම Activate කිරීමට පහසුවන පරිදි කරුණාකර පළමුව <a href="login.php?redirect=upgrade.php" class="underline font-semibold">Login</a> වන්න.
          </p>
        <?php endif; ?>

        <a id="waBtn" href="#" target="_blank" rel="noopener"
           class="w-full flex items-center justify-center gap-2 bg-[#25D366] hover:brightness-95 text-white font-bold py-3.5 rounded-xl shadow-md transition text-center">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.5 14.4c-.3-.1-1.7-.8-2-.9-.3-.1-.5-.1-.7.1-.2.3-.8.9-.9 1.1-.2.2-.3.2-.6.1-.3-.1-1.2-.4-2.3-1.4-.8-.8-1.4-1.7-1.6-2-.2-.3 0-.4.1-.6l.4-.5c.1-.2.2-.3.3-.5.1-.2 0-.4 0-.5-.1-.1-.7-1.6-.9-2.2-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.5.1-.8.4-.3.3-1 1-1 2.5s1.1 2.9 1.2 3.1c.1.2 2.1 3.2 5.1 4.5.7.3 1.3.5 1.7.6.7.2 1.4.2 1.9.1.6-.1 1.7-.7 2-1.4.2-.7.2-1.3.2-1.4-.1-.1-.3-.2-.6-.3zM12 2a10 10 0 0 0-8.6 15L2 22l5.1-1.3A10 10 0 1 0 12 2z"/></svg>
          WhatsApp විවෘත කරන්න
        </a>

        <p class="text-[11px] text-ink/50 text-center leading-relaxed">ගෙවීම් ක්‍රම WhatsApp හරහා තහවුරු කරන්නෙමු. ගෙවීම තහවුරු වූ පසු ඔබේ ගිණුම Activate කරනු ලැබේ.</p>

        <button type="button" id="payClose" class="w-full border border-black/10 hover:bg-black/5 text-ink/70 font-semibold py-3 rounded-xl transition">වසන්න</button>
      </div>
    </div>
  </div>
</div>

<script>
(function () {
  var plans   = <?= json_encode($jsPlans, JSON_UNESCAPED_UNICODE) ?>;
  var lkrRate = <?= json_encode($lkrRate) ?>;       // 1 JPY = X LKR (auto-fetched, cached 6h)
  var waNum   = <?= json_encode($WHATSAPP_NUMBER) ?>;
  var email   = <?= json_encode($userEmail) ?>;

  var modal    = document.getElementById('payModal');
  var orderPlan= document.getElementById('orderPlan');
  var orderJpy = document.getElementById('orderJpy');
  var orderLkr = document.getElementById('orderLkr');
  var waBtn    = document.getElementById('waBtn');
  var lastFocus = null;

  function fmt(n){ return Number(n).toLocaleString('en-US'); }

  function openModal(key){
    var p = plans[key]; if(!p) return;
    var lkr = Math.round(p.jpy * lkrRate);
    var jpyTxt = '¥' + fmt(p.jpy);
    var lkrTxt = '≈ Rs. ' + fmt(lkr);

    orderPlan.textContent = p.name;
    orderJpy.textContent  = jpyTxt;
    orderLkr.textContent  = lkrTxt;

    var msg = 'ආයුබෝවන්! Japan License Prep වෙතින් ප්‍රිමියම් පැකේජයක් මිලදී ගැනීමට කැමතියි.\n\n' +
              '📦 පැකේජය: ' + p.name + '\n' +
              '💴 මිල: ' + jpyTxt + ' (' + lkrTxt + ')\n' +
              (email ? '📧 ගිණුම: ' + email + '\n' : '') +
              '\nකරුණාකර ගෙවීම් විස්තර දන්වන්න. ස්තූතියි!';
    waBtn.href = 'https://wa.me/' + waNum + '?text=' + encodeURIComponent(msg);

    lastFocus = document.activeElement;
    modal.classList.remove('hidden');
    document.body.classList.add('no-scroll');
    document.getElementById('payClose').focus();
  }

  function closeModal(){
    modal.classList.add('hidden');
    document.body.classList.remove('no-scroll');
    if (lastFocus) lastFocus.focus();
  }

  document.querySelectorAll('.open-pay').forEach(function(b){
    b.addEventListener('click', function(){ openModal(b.getAttribute('data-plan')); });
  });
  document.getElementById('payClose').addEventListener('click', closeModal);
  document.getElementById('payX').addEventListener('click', closeModal);
  document.getElementById('payBackdrop').addEventListener('click', closeModal);
  document.addEventListener('keydown', function(e){
    if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
  });
})();
</script>
<?php endif; ?>

</body>
</html>