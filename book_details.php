<?php
session_start();
require_once __DIR__ . '/visitor.php';
require_once __DIR__ . '/includes/config.php';

/* =====================================================================
   TEMPORARY SWITCH
   $WHATSAPP_MODE = true  -> "Buy Now" opens the WhatsApp payment popup
   $WHATSAPP_MODE = false -> "Buy Now" goes to checkout.php again (original)
===================================================================== */
$WHATSAPP_MODE    = true;
$WHATSAPP_NUMBER  = '819050295822';       // for wa.me link
$WHATSAPP_DISPLAY = '+81 90-5029-5822';

/**
 * Current JPY -> LKR rate, fetched automatically and cached for 6 hours.
 * (Same helper as upgrade.php — if you like, move it into includes/fx.php
 * and require it from both pages.)
 */
if (!function_exists('getJpyToLkrRate')) {
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

        if (!empty($cached['rate'])) return (float) $cached['rate'];
        return $fallback;
    }
}
$lkrRate = getJpyToLkrRate();

$sessionUser = null;
if (!empty($_SESSION['user_id'])) {
    $sessionUser = [
        'id'    => $_SESSION['user_id'],
        'name'  => $_SESSION['user_name'] ?? '',
        'email' => $_SESSION['user_email'] ?? '',
    ];
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$book = null;

if ($id > 0) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM books WHERE id = ? AND is_active = 1 LIMIT 1");
        $stmt->execute([$id]);
        $book = $stmt->fetch();
    } catch (\Throwable $e) {
        // fall through — $book stays null, handled below
    }
}

// Book not found — bounce back to the catalogue rather than showing a broken page
if (!$book) {
    header('Location: books.php');
    exit;
}

// Does the logged-in user already have an order for this book?
$existingOrder = null;
if ($sessionUser) {
    try {
        $stmt = $pdo->prepare("SELECT order_status, purchased_at FROM book_purchases WHERE user_id = ? AND book_id = ? ORDER BY purchased_at DESC LIMIT 1");
        $stmt->execute([$sessionUser['id'], $book['id']]);
        $existingOrder = $stmt->fetch();
    } catch (\Throwable $e) {}
}

$orderStatusLabels = [
    'pending'   => ['label' => 'Order Pending',    'note' => 'We\'re confirming your payment before it ships.', 'color' => 'accent'],
    'paid'      => ['label' => 'Paid — Preparing', 'note' => 'Your book is being packed for shipping.',         'color' => 'go'],
    'shipped'   => ['label' => 'Shipped',          'note' => 'On its way to you.',                              'color' => 'primary'],
    'delivered' => ['label' => 'Delivered',        'note' => 'Enjoy the book!',                                 'color' => 'go'],
    'cancelled' => ['label' => 'Order Cancelled',  'note' => 'This order was cancelled.',                       'color' => 'stop'],
];

// sample_images may be stored as JSON array or a comma-separated list — handle both
$sampleImages = [];
if (!empty($book['sample_images'])) {
    $decoded = json_decode($book['sample_images'], true);
    if (is_array($decoded)) {
        $sampleImages = $decoded;
    } else {
        $sampleImages = array_filter(array_map('trim', explode(',', $book['sample_images'])));
    }
}

// A handful of other books to suggest at the bottom of the page
$otherBooks = [];
try {
    $stmt = $pdo->prepare("SELECT id, title_en, title_si, cover_image, price FROM books WHERE is_active = 1 AND id != ? ORDER BY sort_order ASC, id DESC LIMIT 3");
    $stmt->execute([$book['id']]);
    $otherBooks = $stmt->fetchAll();
} catch (\Throwable $e) {}

$pageTitle = htmlspecialchars($book['title_en']) . ' | Menkyoo.jp';
$pageDesc  = !empty($book['subtitle_en']) ? htmlspecialchars($book['subtitle_en']) : 'Bilingual English/Sinhala study guide for Japan\'s driving license theory test.';
$canonical = 'https://menkyoo.jp/book_details.php?id=' . (int) $book['id'];

// Data for the payment popup
$jsBook = [
    'title' => $book['title_en'],
    'titleSi' => $book['title_si'] ?? '',
    'price' => (int) $book['price'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title><?= $pageTitle ?></title>
<meta name="description" content="<?= $pageDesc ?>">
<meta name="robots" content="index, follow">
<link rel="canonical" href="<?= $canonical ?>">
<meta name="theme-color" content="#0F2F6E">

<!-- Open Graph -->
<meta property="og:type" content="book">
<meta property="og:url" content="<?= $canonical ?>">
<meta property="og:title" content="<?= htmlspecialchars($book['title_en']) ?>">
<meta property="og:description" content="<?= $pageDesc ?>">
<?php if (!empty($book['cover_image'])): ?>
<meta property="og:image" content="<?= htmlspecialchars($book['cover_image']) ?>">
<?php endif; ?>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Book",
  "name": <?= json_encode($book['title_en'], JSON_UNESCAPED_UNICODE) ?>,
  "description": <?= json_encode($book['subtitle_en'] ?? $book['description_en'] ?? '', JSON_UNESCAPED_UNICODE) ?>,
  "inLanguage": ["en", "si"],
  "offers": {
    "@type": "Offer",
    "priceCurrency": "JPY",
    "price": <?= (int) $book['price'] ?>,
    "availability": "https://schema.org/InStock"
  }
}
</script>

<?php include __DIR__ . '/includes/theme.php'; ?>
<style>
  html{ -webkit-text-size-adjust:100%; }
  body{ overflow-x:hidden; }
  @keyframes sheetIn{ from{ opacity:0; transform:translateY(24px);} to{ opacity:1; transform:translateY(0);} }
  .sheet-in{ animation: sheetIn .25s ease-out both; }
  @media (prefers-reduced-motion: reduce){ .sheet-in{ animation:none; } }
  .no-scroll{ overflow:hidden; }
  .safe-bottom{ padding-bottom: max(0.75rem, env(safe-area-inset-bottom)); }
</style>
</head>
<body class="bg-paper text-ink font-body min-h-screen flex flex-col">
<script>window.__USER__ = <?php echo $sessionUser ? json_encode($sessionUser, JSON_UNESCAPED_UNICODE) : 'null'; ?>;</script>

<header class="sticky top-0 z-40 bg-primary text-white shadow-lg shadow-primary/10">
  <div class="max-w-5xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-3">
    <a href="index.php" class="flex items-center gap-2 shrink-0">
      <svg width="30" height="30" viewBox="0 0 48 48" fill="none" aria-hidden="true"><circle cx="24" cy="24" r="21" stroke="#F2A73B" stroke-width="3"/><circle cx="24" cy="24" r="5.5" fill="#F2A73B"/><path d="M24 3v10M24 35v10M3 24h10M35 24h10M9.5 9.5l7 7M31.5 31.5l7 7M9.5 38.5l7-7M31.5 16.5l7-7" stroke="#F2A73B" stroke-width="2.5" stroke-linecap="round"/></svg>
      <span class="font-display font-bold leading-tight text-sm sm:text-base">Menkyoo.jp</span>
    </a>
    <div class="flex items-center gap-1 sm:gap-3">
      <a href="books.php" class="text-xs sm:text-sm font-semibold px-3 py-2 rounded-lg hover:bg-white/10 transition">Books</a>
      <?php if ($sessionUser): ?>
        <a href="dashboard.php" class="text-xs sm:text-sm font-semibold px-3 py-2 rounded-lg hover:bg-white/10 transition">Dashboard</a>
      <?php else: ?>
        <a href="login.php?redirect=<?= urlencode('book_details.php?id=' . $book['id']) ?>" class="text-xs sm:text-sm font-semibold bg-accent text-ink px-3 sm:px-4 py-2 rounded-lg hover:brightness-95 transition">Log in</a>
      <?php endif; ?>
    </div>
  </div>
</header>

<main class="flex-grow w-full grid-texture">
  <div class="max-w-5xl mx-auto px-4 sm:px-6 py-6 sm:py-12">

    <!-- Breadcrumb -->
    <a href="books.php" class="inline-flex items-center gap-1 text-sm font-semibold text-primary hover:underline mb-5 sm:mb-6">
      ← Back to Study Guides
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 sm:gap-10">

      <!-- Cover + purchase card -->
      <div class="lg:col-span-2 rise-in">
        <div class="lg:sticky lg:top-24">
          <div class="aspect-[3/4] w-full max-w-[260px] sm:max-w-xs lg:max-w-none mx-auto bg-primary-light rounded-2xl overflow-hidden shadow-lg border border-black/5 relative">
            <?php if (!empty($book['cover_image'])): ?>
              <img src="<?= htmlspecialchars($book['cover_image']) ?>" alt="<?= htmlspecialchars($book['title_en']) ?> cover" class="w-full h-full object-cover">
            <?php else: ?>
              <div class="w-full h-full flex items-center justify-center text-6xl">📘</div>
            <?php endif; ?>
            <?php if ($existingOrder && isset($orderStatusLabels[$existingOrder['order_status']])): $st = $orderStatusLabels[$existingOrder['order_status']]; ?>
              <span class="absolute top-3 right-3 bg-<?= $st['color'] ?> text-white text-[11px] font-bold px-2.5 py-1 rounded-full shadow"><?= strtoupper($st['label']) ?></span>
            <?php endif; ?>
          </div>

          <div class="mt-5 bg-white rounded-2xl border border-black/5 shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
              <span class="text-xs font-semibold text-ink/50 uppercase tracking-wide">Price</span>
              <span class="font-mono font-bold text-2xl text-primary">¥<?= number_format($book['price']) ?></span>
            </div>

            <?php if ($existingOrder && isset($orderStatusLabels[$existingOrder['order_status']])): $st = $orderStatusLabels[$existingOrder['order_status']]; ?>
              <div class="mb-3 flex items-center gap-2 bg-<?= $st['color'] ?>-light text-<?= $st['color'] ?> text-xs font-semibold px-3 py-2 rounded-lg">
                <span class="w-2 h-2 rounded-full bg-<?= $st['color'] ?> shrink-0"></span>
                <span>Your last order: <?= htmlspecialchars($st['label']) ?></span>
              </div>
            <?php endif; ?>

            <?php if ($WHATSAPP_MODE): ?>
              <!-- TEMPORARY: WhatsApp payment popup (works for logged-in and guests) -->
              <button type="button" class="open-pay block w-full text-center bg-accent hover:brightness-95 text-ink font-bold py-3 rounded-xl transition shadow-md text-sm">
                Buy Now →
              </button>
              <p class="text-[11px] text-ink/40 mt-2 text-center">Physical book — payment details via WhatsApp, then posted to your address.</p>
            <?php elseif ($sessionUser): ?>
              <!-- ORIGINAL checkout flow (active when $WHATSAPP_MODE = false) -->
              <a href="checkout.php?book_id=<?= (int) $book['id'] ?>" class="block text-center bg-accent hover:brightness-95 text-ink font-bold py-3 rounded-xl transition shadow-md text-sm">
                Buy Now →
              </a>
              <p class="text-[11px] text-ink/40 mt-2 text-center">Physical book — posted to your address after payment.</p>
            <?php else: ?>
              <a href="login.php?redirect=<?= urlencode('book_details.php?id=' . $book['id']) ?>" class="block text-center bg-accent hover:brightness-95 text-ink font-bold py-3 rounded-xl transition shadow-md text-sm">
                Log in to Buy →
              </a>
              <p class="text-[11px] text-ink/40 mt-2 text-center">Create a free account to purchase — we'll post the book to you.</p>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Details -->
      <div class="lg:col-span-3 rise-in min-w-0">
        <span class="inline-block text-[11px] font-bold tracking-widest uppercase bg-accent-light text-primary px-3 py-1 rounded-full border border-accent/40 mb-3">Physical Book — Shipped to You</span>

        <h1 class="font-display font-bold text-2xl sm:text-3xl text-ink leading-tight break-words"><?= htmlspecialchars($book['title_en']) ?></h1>
        <?php if (!empty($book['title_si'])): ?>
          <p class="font-si text-base text-ink/60 mt-1"><?= htmlspecialchars($book['title_si']) ?></p>
        <?php endif; ?>

        <?php if (!empty($book['subtitle_en'])): ?>
          <p class="text-sm sm:text-base text-ink/70 mt-4 leading-relaxed"><?= htmlspecialchars($book['subtitle_en']) ?></p>
        <?php endif; ?>
        <?php if (!empty($book['subtitle_si'])): ?>
          <p class="font-si text-sm text-ink/50 mt-2 leading-relaxed"><?= htmlspecialchars($book['subtitle_si']) ?></p>
        <?php endif; ?>

        <?php if (!empty($book['description_en']) || !empty($book['description_si'])): ?>
        <div class="mt-6 bg-white rounded-2xl border border-black/5 shadow-sm p-5 sm:p-6 space-y-4">
          <?php if (!empty($book['description_en'])): ?>
            <div>
              <h2 class="text-xs font-bold text-ink/40 uppercase tracking-wide mb-2">About this book</h2>
              <p class="text-sm text-ink/80 leading-relaxed whitespace-pre-line break-words"><?= htmlspecialchars($book['description_en']) ?></p>
            </div>
          <?php endif; ?>
          <?php if (!empty($book['description_si'])): ?>
            <div class="pt-4 border-t border-black/5">
              <h2 class="font-si text-xs font-bold text-ink/40 uppercase tracking-wide mb-2">පොත ගැන</h2>
              <p class="font-si text-sm text-ink/70 leading-relaxed whitespace-pre-line break-words"><?= htmlspecialchars($book['description_si']) ?></p>
            </div>
          <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Sample pages -->
        <?php if (!empty($sampleImages)): ?>
        <div class="mt-6">
          <h2 class="text-xs font-bold text-ink/40 uppercase tracking-wide mb-3">Sample Pages</h2>
          <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
            <?php foreach ($sampleImages as $img): ?>
              <a href="<?= htmlspecialchars($img) ?>" target="_blank" rel="noopener" class="block aspect-[3/4] rounded-xl overflow-hidden border border-black/5 shadow-sm hover:shadow-md transition">
                <img src="<?= htmlspecialchars($img) ?>" alt="Sample page from <?= htmlspecialchars($book['title_en']) ?>" class="w-full h-full object-cover" loading="lazy">
              </a>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>

        <div class="mt-6 flex flex-wrap gap-2 text-xs text-ink/50">
          <span class="bg-primary-light text-primary font-semibold px-3 py-1.5 rounded-full">📦 Physical Book</span>
          <span class="bg-primary-light text-primary font-semibold px-3 py-1.5 rounded-full">EN / SI Bilingual</span>
          <span class="bg-primary-light text-primary font-semibold px-3 py-1.5 rounded-full">🚚 Shipped within Japan</span>
        </div>
      </div>
    </div>

    <!-- Other books -->
    <?php if (!empty($otherBooks)): ?>
    <div class="mt-12 sm:mt-14">
      <h2 class="font-display font-bold text-lg text-ink mb-4">More Study Guides</h2>
      <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 sm:gap-5">
        <?php foreach ($otherBooks as $b): ?>
        <a href="book_details.php?id=<?= (int) $b['id'] ?>" class="group bg-white rounded-2xl border border-black/5 shadow-sm hover:shadow-lg transition overflow-hidden flex flex-col">
          <div class="aspect-[3/4] bg-primary-light overflow-hidden">
            <?php if (!empty($b['cover_image'])): ?>
              <img src="<?= htmlspecialchars($b['cover_image']) ?>" alt="<?= htmlspecialchars($b['title_en']) ?> cover" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" loading="lazy">
            <?php else: ?>
              <div class="w-full h-full flex items-center justify-center text-4xl">📘</div>
            <?php endif; ?>
          </div>
          <div class="p-3 flex-1 flex flex-col">
            <h3 class="font-display font-bold text-xs text-ink leading-snug line-clamp-2"><?= htmlspecialchars($b['title_en']) ?></h3>
            <div class="mt-auto pt-3 flex items-center justify-between">
              <span class="font-mono font-bold text-primary text-sm">¥<?= number_format($b['price']) ?></span>
              <span class="text-[11px] font-bold text-primary group-hover:underline">View →</span>
            </div>
          </div>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

  </div>
</main>

<?php include __DIR__ . '/includes/site-footer.php'; ?>

<?php if ($WHATSAPP_MODE): ?>
<!-- Spacer so the mobile buy bar never covers the footer -->
<div class="h-20 lg:hidden" aria-hidden="true"></div>

<!-- Mobile sticky buy bar -->
<div class="lg:hidden fixed bottom-0 inset-x-0 z-30 bg-white/95 backdrop-blur border-t border-black/10 px-4 pt-3 safe-bottom shadow-[0_-4px_16px_rgba(0,0,0,0.06)]">
  <div class="max-w-5xl mx-auto flex items-center justify-between gap-3">
    <div class="min-w-0">
      <p class="text-[11px] text-ink/50 truncate"><?= htmlspecialchars($book['title_en']) ?></p>
      <p class="font-mono font-bold text-primary text-lg leading-tight">¥<?= number_format($book['price']) ?></p>
    </div>
    <button type="button" class="open-pay shrink-0 bg-accent hover:brightness-95 text-ink font-bold px-6 py-3 rounded-xl shadow-md text-sm">Buy Now →</button>
  </div>
</div>

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
          <p class="text-[11px] font-bold uppercase tracking-wider text-ink/50 mb-3">ඔබේ ඇණවුම</p>

          <div class="flex gap-3">
            <?php if (!empty($book['cover_image'])): ?>
              <img src="<?= htmlspecialchars($book['cover_image']) ?>" alt="" class="w-14 h-[74px] object-cover rounded-md border border-black/5 shrink-0">
            <?php else: ?>
              <div class="w-14 h-[74px] rounded-md bg-primary-light flex items-center justify-center text-2xl shrink-0">📘</div>
            <?php endif; ?>
            <div class="min-w-0">
              <p class="font-semibold text-ink text-sm break-words"><?= htmlspecialchars($book['title_en']) ?></p>
              <?php if (!empty($book['title_si'])): ?>
                <p class="font-si text-xs text-ink/50 mt-0.5 break-words"><?= htmlspecialchars($book['title_si']) ?></p>
              <?php endif; ?>
              <p class="text-xs text-ink/50 mt-1">1 × ¥<?= number_format($book['price']) ?></p>
            </div>
          </div>

          <div class="flex items-center justify-between mt-4 pt-3 border-t border-black/10">
            <span class="text-xs font-semibold text-ink/60">ප්‍රමාණය</span>
            <div class="inline-flex items-center rounded-lg border border-black/10 bg-white overflow-hidden">
              <button type="button" id="qtyMinus" class="w-10 h-10 text-lg font-bold text-primary hover:bg-primary-light" aria-label="Decrease quantity">−</button>
              <span id="qtyVal" class="w-10 text-center font-mono font-semibold" aria-live="polite">1</span>
              <button type="button" id="qtyPlus" class="w-10 h-10 text-lg font-bold text-primary hover:bg-primary-light" aria-label="Increase quantity">+</button>
            </div>
          </div>

          <div class="flex items-end justify-between mt-4">
            <span class="text-xs font-semibold text-ink/60">මුළු මිල</span>
            <div class="text-right">
              <p id="orderJpy" class="font-mono font-bold text-primary text-xl">—</p>
              <p id="orderLkr" class="text-xs text-ink/60 font-medium">—</p>
            </div>
          </div>
          <p class="text-[10px] text-ink/40 mt-3">ශ්‍රී ලංකා රුපියල් අගය වත්මන් විනිමය අනුපාතය අනුව ගණනය කළ ආසන්න අගයකි.</p>
        </div>

        <div class="flex items-center justify-between gap-3 rounded-xl bg-primary-light px-4 py-3">
          <span class="text-xs sm:text-sm text-ink/70">අපගේ WhatsApp අංකය</span>
          <span class="font-mono font-semibold text-primary text-sm sm:text-base whitespace-nowrap"><?= htmlspecialchars($WHATSAPP_DISPLAY) ?></span>
        </div>

        <?php if (!$sessionUser): ?>
          <p class="text-xs text-stop bg-stop/10 border border-stop/20 rounded-lg px-3 py-2">
            ⚠️ ඇණවුම පහසුවෙන් හඳුනාගැනීමට කරුණාකර පළමුව <a href="login.php?redirect=<?= urlencode('book_details.php?id=' . $book['id']) ?>" class="underline font-semibold">Log in</a> වන්න.
          </p>
        <?php endif; ?>

        <a id="waBtn" href="#" target="_blank" rel="noopener"
           class="w-full flex items-center justify-center gap-2 bg-[#25D366] hover:brightness-95 text-white font-bold py-3.5 rounded-xl shadow-md transition text-center">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.5 14.4c-.3-.1-1.7-.8-2-.9-.3-.1-.5-.1-.7.1-.2.3-.8.9-.9 1.1-.2.2-.3.2-.6.1-.3-.1-1.2-.4-2.3-1.4-.8-.8-1.4-1.7-1.6-2-.2-.3 0-.4.1-.6l.4-.5c.1-.2.2-.3.3-.5.1-.2 0-.4 0-.5-.1-.1-.7-1.6-.9-2.2-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.5.1-.8.4-.3.3-1 1-1 2.5s1.1 2.9 1.2 3.1c.1.2 2.1 3.2 5.1 4.5.7.3 1.3.5 1.7.6.7.2 1.4.2 1.9.1.6-.1 1.7-.7 2-1.4.2-.7.2-1.3.2-1.4-.1-.1-.3-.2-.6-.3zM12 2a10 10 0 0 0-8.6 15L2 22l5.1-1.3A10 10 0 1 0 12 2z"/></svg>
          WhatsApp විවෘත කරන්න
        </a>

        <p class="text-[11px] text-ink/50 text-center leading-relaxed">බෙදාහැරීමේ ගාස්තුව සහ ගෙවීම් ක්‍රම WhatsApp හරහා තහවුරු කරන්නෙමු.</p>

        <button type="button" id="payClose" class="w-full border border-black/10 hover:bg-black/5 text-ink/70 font-semibold py-3 rounded-xl transition">වසන්න</button>
      </div>
    </div>
  </div>
</div>

<script>
(function () {
  var book    = <?= json_encode($jsBook, JSON_UNESCAPED_UNICODE) ?>;
  var lkrRate = <?= json_encode($lkrRate) ?>;       // 1 JPY = X LKR (auto-fetched, cached 6h)
  var waNum   = <?= json_encode($WHATSAPP_NUMBER) ?>;
  var email   = <?= json_encode($sessionUser['email'] ?? '') ?>;

  var modal    = document.getElementById('payModal');
  var qtyVal   = document.getElementById('qtyVal');
  var orderJpy = document.getElementById('orderJpy');
  var orderLkr = document.getElementById('orderLkr');
  var waBtn    = document.getElementById('waBtn');
  var qty = 1, lastFocus = null;

  function fmt(n){ return Number(n).toLocaleString('en-US'); }

  function refresh(){
    var total = book.price * qty;
    var jpyTxt = '¥' + fmt(total);
    var lkrTxt = '≈ Rs. ' + fmt(Math.round(total * lkrRate));

    qtyVal.textContent   = qty;
    orderJpy.textContent = jpyTxt;
    orderLkr.textContent = lkrTxt;

    var title = book.title + (book.titleSi ? ' (' + book.titleSi + ')' : '');
    var msg = 'ආයුබෝවන්! Menkyoo.jp වෙතින් පොතක් මිලදී ගැනීමට කැමතියි.\n\n' +
              '📚 පොත: ' + title + '\n' +
              '🔢 ප්‍රමාණය: ' + qty + '\n' +
              '💴 මුළු මිල: ' + jpyTxt + ' (' + lkrTxt + ')\n' +
              (email ? '📧 ගිණුම: ' + email + '\n' : '') +
              '\nකරුණාකර ගෙවීම් විස්තර සහ බෙදාහැරීමේ විස්තර දන්වන්න. ස්තූතියි!';
    waBtn.href = 'https://wa.me/' + waNum + '?text=' + encodeURIComponent(msg);
  }

  function openModal(){
    qty = 1; refresh();
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

  document.querySelectorAll('.open-pay').forEach(function(b){ b.addEventListener('click', openModal); });
  document.getElementById('qtyMinus').addEventListener('click', function(){ if (qty > 1)  { qty--; refresh(); } });
  document.getElementById('qtyPlus').addEventListener('click',  function(){ if (qty < 20) { qty++; refresh(); } });
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