<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/visitor.php';

/*
  Pull the logged-in user from the session and refresh account details
  from the database when a connection is available.
*/

$sessionUser = null;
$remainingDays = 0;
$hasActivePlan = false;

if (!empty($_SESSION['user_id'])) {

    $sessionUser = [
        'id'     => $_SESSION['user_id'],
        'name'   => $_SESSION['user_name'] ?? '',
        'email'  => $_SESSION['user_email'] ?? '',
        'plan'   => $_SESSION['plan_type'] ?? 'free',
        'status' => $_SESSION['subscription_status'] ?? 'inactive',
        'joined' => null,
    ];

    // Best-effort database refresh.
    try {
        require_once __DIR__ . '/includes/config.php';

        $stmt = $pdo->prepare(
            "SELECT * FROM users WHERE id = ? LIMIT 1"
        );

        $stmt->execute([$sessionUser['id']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $sessionUser['name'] = $row['name'] ?? $sessionUser['name'];
            $sessionUser['email'] = $row['email'] ?? $sessionUser['email'];
            $sessionUser['plan'] = $row['plan_type'] ?? $sessionUser['plan'];
            $sessionUser['status'] = $row['subscription_status'] ?? $sessionUser['status'];

            if (!empty($row['created_at'])) {
                $sessionUser['joined'] = substr($row['created_at'], 0, 10);
            }

            // Check active subscription and remaining days.
            $expiresAt =
                $row['expires_at']
                ?? $row['subscription_ends_at']
                ?? $row['subscription_expiry']
                ?? null;

            if ($sessionUser['status'] === 'active' && !empty($expiresAt)) {
                $expireTime = strtotime($expiresAt);

                if ($expireTime !== false && $expireTime > time()) {
                    $hasActivePlan = true;
                    $remainingDays = (int) ceil(
                        ($expireTime - time()) / 86400
                    );
                }

            } elseif (
                $sessionUser['plan'] !== 'free'
                && $sessionUser['status'] === 'active'
            ) {
                $hasActivePlan = true;
                $remainingDays = 30;
            }
        }

    } catch (\Throwable $e) {
        // Continue using session data if database refresh fails.
        error_log('Index database refresh error: ' . $e->getMessage());
    }
}

// Expose resolved plan state to the JavaScript side.
if ($sessionUser !== null) {
    $sessionUser['hasActivePlan'] = $hasActivePlan;
    $sessionUser['remainingDays'] = $remainingDays;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">

    <!-- Primary SEO Meta Tags -->
    <title>Menkyoo.jp Japan Driving License Practice Test (Sinhala) | Free Mock Exam — ජපන් රියදුරු බලපත්‍ර පුහුණු විභාගය</title>
    <meta name="title" content="Japan Driving License Practice Test (Sinhala) | Free Mock Exam — ජපන් රියදුරු බලපත්‍ර පුහුණු විභාගය">
    <meta name="description" content="Pass Japan's driving license theory test on your first try. 1000+ bilingual (English / Sinhala) True-False questions with instant explanations, category practice, and full Karimen/Honmen mock exams. Try 30 questions free.">
    <meta name="keywords" content="japan driving license test sinhala, jp driving license mock exam, gimen test japan, sri lanka japan license practice, karimen mock exam, honmen mock exam, 学科試験 シンハラ語, japan license theory test">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://menkyoo.jp/">

    <!-- Open Graph / Facebook / Social Sharing Meta Tags with Feature Image (menkyoo.png) -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://menkyoo.jp/">
    <meta property="og:title" content="Japan Driving License Practice Test (Sinhala) — ජපන් රියදුරු බලපත්‍ර පුහුණු විභාගය">
    <meta property="og:description" content="Pass Japan's driving license theory test on your first try. Bilingual (English/Sinhala) practice tests with instant explanations and full mock exams.">
    <meta property="og:image" content="https://menkyoo.jp/menkyoo.png">
    <meta property="og:image:secure_url" content="https://menkyoo.jp/menkyoo.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Japan Driving License Practice Test Preview">
    <meta property="og:locale" content="en_US">
    <meta property="og:locale:alternate" content="si_LK">

    <!-- Twitter Card Meta Tags with Feature Image -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="https://menkyoo.jp/">
    <meta name="twitter:title" content="Japan Driving License Practice Test (Sinhala) | Free Mock Exam">
    <meta name="twitter:description" content="Pass Japan's driving license theory test on your first try with bilingual English/Sinhala mock exams and 1000+ questions.">
    <meta name="twitter:image" content="https://menkyoo.jp/menkyoo.png">

    <!-- Theme & UI Settings -->
    <meta name="theme-color" content="#0F2F6E">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">

    <!-- Google Fonts & Tailwind CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=Noto+Sans+Sinhala:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = { theme: { extend: {
        colors: { ink:'#101A30', paper:'#F6F5F1', primary:{DEFAULT:'#0F2F6E',light:'#E7ECFA',dark:'#0A2050'}, accent:{DEFAULT:'#F2A73B',light:'#FDF1DD'}, go:'#1C8F5A', stop:'#D5432E' },
        fontFamily: { display:['"Space Grotesk"','sans-serif'], body:['"Inter"','sans-serif'], sinhala:['"Noto Sans Sinhala"','sans-serif'] }
      }}}
    </script>
    <style>body{font-family:'Inter', sans-serif;}</style>
</head>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          ink:      '#101A30',
          paper:    '#F6F5F1',
          primary:  { DEFAULT: '#0F2F6E', light: '#E7ECFA', dark: '#0A2050' },
          accent:   { DEFAULT: '#F2A73B', light: '#FDF1DD' },
          go:       '#1C8F5A',
          stop:     '#D5432E',
        },
        fontFamily: {
          display: ['"Space Grotesk"', 'sans-serif'],
          body: ['"Inter"', '"Noto Sans Sinhala"', 'sans-serif'],
          si: ['"Noto Sans Sinhala"', 'sans-serif'],
          mono: ['"JetBrains Mono"', 'monospace'],
        },
      }
    }
  }
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Course",
  "name": "Japan Driving License Theory Test Practice",
  "description": "Bilingual English/Sinhala mock exam platform for Japan's driving license theory (gakka) test, with 1000+ practice questions and full Karimen/Honmen mock exams.",
  "provider": { "@type": "Organization", "name": "JP License Prep", "sameAs": "https://your-domain.example/" },
  "inLanguage": ["en", "si"],
  "hasCourseInstance": { "@type": "CourseInstance", "courseMode": "online", "courseWorkload": "PT30M" }
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {"@type":"Question","name":"Is the Japan driving license practice test free?","acceptedAnswer":{"@type":"Answer","text":"Yes. A 30-question mock exam is free for every visitor. Full access to 1000+ questions, category-wise practice, and the full Karimen/Honmen mock exams is available on paid plans."}},
    {"@type":"Question","name":"Are the questions available in Sinhala?","acceptedAnswer":{"@type":"Answer","text":"Every question and explanation is written in both English and Sinhala so you can switch languages instantly while practicing."}},
    {"@type":"Question","name":"Does the app save my progress?","acceptedAnswer":{"@type":"Answer","text":"Yes. Your test progress and history are saved automatically so you can pick up where you left off and track your improvement over time."}}
  ]
}
</script>
<style>
  :root{ color-scheme: light; }
  html{ scroll-behavior: smooth; }
  body{ background:#F6F5F1; }
  .font-si, [data-si]{ font-family:'Noto Sans Sinhala', sans-serif; }

  /* Signature texture — genkouyoushi (manuscript grid) motif, used sparingly */
  .grid-texture{
    background-image:
      linear-gradient(to right, rgba(15,47,110,0.06) 1px, transparent 1px),
      linear-gradient(to bottom, rgba(15,47,110,0.06) 1px, transparent 1px);
    background-size: 28px 28px;
  }

  .skip-link{ position:absolute; left:-999px; top:0; background:#0F2F6E; color:#fff; padding:.75rem 1rem; border-radius:0 0 .5rem 0; z-index:100; }
  .skip-link:focus{ left:0; }

  *:focus-visible{ outline: 3px solid #F2A73B; outline-offset: 2px; }

  @keyframes riseIn{ from{ opacity:0; transform:translateY(10px);} to{ opacity:1; transform:translateY(0);} }
  .rise-in{ animation: riseIn .35s ease-out both; }
  @media (prefers-reduced-motion: reduce){ .rise-in{ animation:none; } html{scroll-behavior:auto;} }

  /* License card — signature dashboard element */
  .license-card{
    position:relative; overflow:hidden; border-radius:1.1rem;
    background: linear-gradient(135deg, #0F2F6E 0%, #16407F 55%, #0A2050 100%);
    color:#fff; padding:1.35rem 1.5rem;
    box-shadow: 0 18px 40px -18px rgba(15,47,110,.6);
  }
  @media (max-width: 400px){
    .license-card{ padding:1.1rem 1.1rem; }
  }
  .license-card::before{
    content:""; position:absolute; inset:0;
    background-image: linear-gradient(115deg, transparent 40%, rgba(255,255,255,.10) 50%, transparent 60%);
  }
  .license-chip{
    width:34px; height:24px; border-radius:5px;
    background: linear-gradient(135deg,#F2A73B,#D98A1E);
    box-shadow: inset 0 0 0 1px rgba(0,0,0,.15);
    position:relative;
  }
  .license-chip::after{
    content:""; position:absolute; inset:4px;
    background-image: repeating-linear-gradient(180deg, rgba(0,0,0,.18) 0 2px, transparent 2px 5px);
    border-radius:2px;
  }
  .barcode{
    height:22px;
    background-image: repeating-linear-gradient(90deg, rgba(255,255,255,.9) 0 2px, transparent 2px 4px, rgba(255,255,255,.55) 4px 5px, transparent 5px 7px);
    opacity:.85; border-radius:2px;
  }

  /* Segmented exam progress bar (in-quiz) */
  .seg-track{ display:flex; gap:3px; }
  .seg{ flex:1; height:6px; border-radius:3px; background:#E4E2DA; transition: background .25s ease; }
  .seg.filled{ background:#0F2F6E; }
  .seg.current{ background:#F2A73B; }

  .btn-primary{ background:#0F2F6E; }
  .btn-primary:hover{ background:#0A2050; }

  /* Coverage bar in the progress widget */
  .cov-track{ height:10px; border-radius:999px; background:#E4E2DA; overflow:hidden; }
  .cov-fill{ height:100%; border-radius:999px; background:linear-gradient(90deg,#0F2F6E,#F2A73B); transition: width .6s ease; }
  .exam-bar-track{ height:8px; border-radius:999px; background:rgba(255,255,255,.18); overflow:hidden; }
  .exam-bar-fill{ height:100%; border-radius:999px; background:#F2A73B; transition: width .6s ease; }
  .exam-bar-fill.passed{ background:#1C8F5A; }

  /* "NEW" badge used on the Books link */
  .new-badge{
    position:absolute; top:-7px; right:-10px;
    background:#F2A73B; color:#101A30; font-size:9px; font-weight:800;
    padding:1px 5px; border-radius:999px; line-height:1.4;
    box-shadow:0 2px 5px rgba(0,0,0,.25);
    animation: badgePulse 2s ease-in-out infinite;
  }
  @keyframes badgePulse{ 0%,100%{ transform:scale(1);} 50%{ transform:scale(1.08);} }
  @media (prefers-reduced-motion: reduce){ .new-badge{ animation:none; } }

  /* Small lock badge shown on category cards for free/guest users */
  .cat-lock-badge{
    position:absolute; top:-7px; right:-7px;
    background:#0F2F6E; color:#fff; font-size:10px;
    width:20px; height:20px; border-radius:999px;
    display:flex; align-items:center; justify-content:center;
    box-shadow:0 2px 5px rgba(0,0,0,.25);
  }

  /* Resource link card — JAF translation guide */
  .resource-link-card{
    display:flex; align-items:center; gap:.75rem;
    background:#fff; border:1px solid rgba(0,0,0,.08);
    border-radius:.9rem; padding:.75rem .9rem;
    transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease;
  }
  .resource-link-card:hover{
    border-color: rgba(15,47,110,.35);
    box-shadow: 0 8px 20px -12px rgba(15,47,110,.35);
    transform: translateY(-1px);
  }
  /* Advertise card variant — amber border so it stands apart from the JAF card */
  .resource-link-card.ad-link-card{ border-color: rgba(242,167,59,.55); background:#FFFBF3; }
  .resource-link-card.ad-link-card:hover{ border-color:#F2A73B; box-shadow: 0 8px 20px -12px rgba(242,167,59,.6); }

  dialog::backdrop{ background: rgba(16,26,48,.55); }
  dialog{ border:none; padding:0; border-radius: 1rem; max-height:90vh; overflow-y:auto; }

  /* ===== Extra small-screen polish (does not touch colors/fonts/layout intent) ===== */
  @media (max-width: 359px){
    #header-title{ font-size:.85rem; }
    .license-card{ padding:1rem; }
  }
</style>
</head>
<body class="bg-paper text-ink font-body min-h-screen flex flex-col overflow-x-hidden">
<script>window.__USER__ = <?php echo $sessionUser ? json_encode($sessionUser, JSON_UNESCAPED_UNICODE) : 'null'; ?>;</script>
<a href="#main-content" class="skip-link font-semibold text-sm">Skip to content</a>

<!-- ============ NAV ============ -->
<header class="sticky top-0 z-40 bg-primary text-white shadow-lg shadow-primary/10">
  <div class="max-w-5xl mx-auto px-3 sm:px-6 h-16 flex items-center justify-between gap-2 sm:gap-3">
    <a href="#main-content" class="flex items-center gap-2 shrink-0 min-w-0">
      <svg width="30" height="30" viewBox="0 0 48 48" fill="none" aria-hidden="true" class="shrink-0"><circle cx="24" cy="24" r="21" stroke="#F2A73B" stroke-width="3"/><circle cx="24" cy="24" r="5.5" fill="#F2A73B"/><path d="M24 3v10M24 35v10M3 24h10M35 24h10M9.5 9.5l7 7M31.5 31.5l7 7M9.5 38.5l7-7M31.5 16.5l7-7" stroke="#F2A73B" stroke-width="2.5" stroke-linecap="round"/></svg>
      <span class="font-display font-bold leading-tight text-sm sm:text-base truncate" id="header-title">Menkyoo.jp</span>
    </a>

    <div class="flex items-center gap-1 sm:gap-3 shrink-0">
      <!-- Books link — new addition, shown to everyone -->
      <a href="books.php" class="relative flex items-center gap-1 text-xs sm:text-sm font-semibold text-white/90 hover:text-white transition px-1 sm:px-2">
        <span aria-hidden="true">📕</span>
        <span class="hidden sm:inline" data-en="Books" data-si="පොත්">Books</span>
        <span class="new-badge">NEW</span>
      </a>

      <div class="bg-white/10 p-1 rounded-lg flex text-xs sm:text-sm">
        <button id="btn-en" onclick="setLanguage('en')" class="px-2 sm:px-3 py-1 rounded-md bg-white text-primary font-semibold transition">EN</button>
        <button id="btn-si" onclick="setLanguage('si')" class="px-2 sm:px-3 py-1 rounded-md text-white font-semibold transition font-si">සිං</button>
      </div>

      <div id="nav-guest">
        <a href="login.php?redirect=index.php" class="text-xs sm:text-sm font-semibold bg-accent text-ink px-2.5 sm:px-4 py-2 rounded-lg hover:brightness-95 transition inline-block whitespace-nowrap">
          <span id="login-btn-text">Log in</span>
        </a>
      </div>
      <div id="nav-user" class="hidden items-center gap-2">
        <a href="dashboard.php" class="hidden sm:inline-flex text-sm font-semibold px-3 py-2 rounded-lg hover:bg-white/10 transition">Dashboard</a>
        <div class="w-9 h-9 rounded-full bg-accent text-ink font-display font-bold flex items-center justify-center shrink-0" id="nav-avatar">U</div>
      </div>
    </div>
  </div>
</header>

<main id="main-content" class="flex-grow w-full">

  <!-- ============ GUEST / QUIZ VIEW ============ -->
  <section id="view-guest">

    <!-- Hero -->
    <div id="hero" class="grid-texture border-b border-black/5">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 pt-10 sm:pt-16 pb-10 sm:pb-14 text-center">

        <!-- Active Subscription Status Banner -->
        <?php if ($hasActivePlan): ?>
        <div class="mb-6 mx-auto max-w-xl bg-go/15 border border-go/40 text-go px-4 py-3 rounded-2xl flex items-center justify-center gap-2 text-sm font-semibold rise-in">
          <span>🌟</span>
          <span>
            <?php echo htmlspecialchars($sessionUser['name']); ?>, ඔබේ සැලැස්ම (Plan) සක්‍රීයයි! ඔබට පුහුණු වීම සඳහා තව දින <strong class="font-mono underline"><?php echo (int)$remainingDays; ?></strong> ක් ඉතිරිව ඇත.
          </span>
        </div>
        <?php endif; ?>

        <!-- ===== Logged-in user progress widget (filled by JS from api/get_user_progress.php) ===== -->
        <?php if ($sessionUser): ?>
        <div id="progress-widget" class="hidden mb-6 mx-auto max-w-2xl text-left rise-in">
          <div class="license-card">
            <div class="relative">
              <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4">
                <div class="min-w-0">
                  <p class="text-[11px] uppercase tracking-[0.2em] text-white/55 font-semibold mb-1">Your Progress</p>
                  <h3 class="font-display text-lg font-bold truncate">👋 <?php echo htmlspecialchars(explode(' ', trim($sessionUser['name'] ?: 'there'))[0]); ?>, keep it up!</h3>
                </div>
                <a href="dashboard.php" class="text-[11px] font-semibold bg-white/10 hover:bg-white/20 px-3 py-1.5 rounded-lg transition shrink-0 self-start sm:self-auto">Full Dashboard →</a>
              </div>

              <!-- Overall question bank coverage -->
              <div class="mb-5">
                <div class="flex justify-between items-baseline text-xs mb-1.5 gap-2">
                  <span class="text-white/70 font-semibold">📚 Question Bank Coverage</span>
                  <span class="font-mono font-bold shrink-0"><span id="pw-answered">0</span> / <span id="pw-total">0</span> (<span id="pw-percent">0</span>%)</span>
                </div>
                <div class="cov-track"><div id="pw-cov-fill" class="cov-fill" style="width:0%"></div></div>
              </div>

              <!-- Karimen / Honmen mini progress -->
              <div class="grid grid-cols-2 gap-2 sm:gap-3">
                <div class="bg-white/5 border border-white/10 rounded-xl p-2.5 sm:p-3 min-w-0">
                  <div class="flex justify-between items-center mb-1.5 gap-1">
                    <span class="text-[11px] font-bold text-white/80">🚗 KARIMEN</span>
                    <span id="pw-karimen-score" class="text-[11px] font-mono font-bold shrink-0">0/50</span>
                  </div>
                  <div class="exam-bar-track"><div id="pw-karimen-fill" class="exam-bar-fill" style="width:0%"></div></div>
                  <p id="pw-karimen-note" class="text-[10px] text-white/40 mt-1.5">No attempts yet</p>
                </div>
                <div class="bg-white/5 border border-white/10 rounded-xl p-2.5 sm:p-3 min-w-0">
                  <div class="flex justify-between items-center mb-1.5 gap-1">
                    <span class="text-[11px] font-bold text-white/80">🚘 HONMEN</span>
                    <span id="pw-honmen-score" class="text-[11px] font-mono font-bold shrink-0">0/100</span>
                  </div>
                  <div class="exam-bar-track"><div id="pw-honmen-fill" class="exam-bar-fill" style="width:0%"></div></div>
                  <p id="pw-honmen-note" class="text-[10px] text-white/40 mt-1.5">No attempts yet</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>

        <span class="inline-block text-[11px] font-bold tracking-widest uppercase bg-accent-light text-accent-dark text-primary px-3 py-1 rounded-full border border-accent/40 mb-4" data-en="Free 30-question mock exam" data-si="නොමිලේ ප්‍රශ්න 30ක පරීක්ෂණය">Free 30-question mock exam</span>
        <h1 class="font-display font-bold text-3xl sm:text-4xl md:text-5xl text-ink leading-tight" id="hero-title">
          Pass Japan's driving license test — practiced in English &amp; Sinhala
        </h1>
        <p class="mt-4 text-sm sm:text-base text-ink/60 max-w-2xl mx-auto" id="hero-sub" data-si="සත්‍ය විභාග ආකෘතියේ True/False ප්‍රශ්න, ක්ෂණික පැහැදිලි කිරීම් සහ ඔබේ ප්‍රගතිය සුරැකෙන පුහුණු වේදිකාව.">
          Real exam-style True/False questions, instant explanations, and a practice platform that remembers your progress.
        </p>
        <div class="mt-7 flex flex-wrap items-center justify-center gap-5 sm:gap-10 text-center">
          <div><p class="font-mono font-bold text-xl sm:text-2xl text-primary">1000+</p><p class="text-[11px] text-ink/50 font-semibold" data-en="Questions" data-si="ප්‍රශ්න">Questions</p></div>
          <div><p class="font-mono font-bold text-xl sm:text-2xl text-primary">EN / SI</p><p class="text-[11px] text-ink/50 font-semibold" data-en="Bilingual" data-si="භාෂා දෙකෙන්">Bilingual</p></div>
          <div><p class="font-mono font-bold text-xl sm:text-2xl text-primary">100%</p><p class="text-[11px] text-ink/50 font-semibold" data-en="Free to start" data-si="ආරම්භය නොමිලේ">Free to start</p></div>
        </div>

        <div class="mt-7 flex flex-col sm:flex-row sm:flex-wrap items-stretch sm:items-center justify-center gap-3 max-w-sm sm:max-w-none mx-auto">
          <button onclick="document.getElementById('filter-box').scrollIntoView({behavior:'smooth'})" class="w-full sm:w-auto bg-primary hover:bg-primary-dark text-white font-semibold px-5 py-2.5 rounded-xl text-sm shadow-md transition" data-en="Start Free Quiz ↓" data-si="නොමිලේ පරීක්ෂණය අරඹන්න ↓">Start Free Quiz ↓</button>
          <a href="lessons.php" class="w-full sm:w-auto bg-white border border-black/10 hover:border-primary/30 text-ink font-semibold px-5 py-2.5 rounded-xl text-sm shadow-sm transition inline-flex items-center justify-center gap-2">
            📚 <span data-en="Browse Lessons →" data-si="පාඩම් බලන්න →">Browse Lessons →</span>
          </a>
          <a href="books.php" class="relative w-full sm:w-auto bg-white border border-accent/40 hover:border-accent text-ink font-semibold px-5 py-2.5 rounded-xl text-sm shadow-sm transition inline-flex items-center justify-center gap-2">
            📕 <span data-en="Shop Books →" data-si="පොත් ගන්න →">Shop Books →</span>
            <span class="new-badge">NEW</span>
          </a>
        </div>

        <!-- Full mock exam quick-start -->
        <div class="mt-3 flex flex-col sm:flex-row sm:flex-wrap items-stretch sm:items-center justify-center gap-3 max-w-sm sm:max-w-none mx-auto">
          <a href="index.php?exam=karimen" onclick="return handleExamLinkClick(event, 'karimen')" class="w-full sm:w-auto bg-primary-light hover:brightness-95 text-primary font-semibold px-5 py-2.5 rounded-xl text-sm shadow-sm transition inline-flex items-center justify-center gap-2">
            🚗 <span data-en="Karimen Mock (50)" data-si="කරිමෙන් (50)">Karimen Mock (50)</span>
          </a>
          <a href="index.php?exam=honmen" onclick="return handleExamLinkClick(event, 'honmen')" class="w-full sm:w-auto bg-accent-light hover:brightness-95 text-accent-dark font-semibold px-5 py-2.5 rounded-xl text-sm shadow-sm transition inline-flex items-center justify-center gap-2">
            🚘 <span data-en="Honmen Mock (100)" data-si="හොන්මෙන් (100)">Honmen Mock (100)</span>
          </a>
        </div>

        <!-- Resource link — JAF license translation guide -->
        <div class="mt-5 max-w-md mx-auto">
          <a href="jaf_license_translation.php" class="resource-link-card rise-in">
            <span class="text-2xl shrink-0" aria-hidden="true">🌐</span>
            <span class="text-left flex-1 min-w-0">
              <span class="block text-xs sm:text-sm font-bold text-ink" data-en="Need your license translated for Japan?" data-si="ජපානය සඳහා ඔබේ බලපත්‍රය පරිවර්තනය කරගන්න ඕනද?">Need your license translated for Japan?</span>
              <span class="block text-[11px] sm:text-xs text-ink/50" data-en="JAF translation guide: fees, documents &amp; how to apply →" data-si="JAF මාර්ගෝපදේශය: ගාස්තු, ලේඛන සහ අයදුම් කරන ආකාරය →">JAF translation guide: fees, documents &amp; how to apply →</span>
            </span>
            <span class="text-primary/40 shrink-0">→</span>
          </a>
        </div>

        <!-- Advertise link — opens ad.php (packages + WhatsApp) -->
        <div class="mt-3 max-w-md mx-auto">
          <a href="ad.php" class="resource-link-card ad-link-card rise-in">
            <span class="text-2xl shrink-0" aria-hidden="true">📢</span>
            <span class="text-left flex-1 min-w-0">
              <span class="block text-xs sm:text-sm font-bold text-ink" data-en="Publish your advertisement here" data-si="ඔබේ දැන්වීම මෙහි පළ කරන්න">Publish your advertisement here</span>
              <span class="block text-[11px] sm:text-xs text-ink/50" data-en="Reach learners in Japan · packages from ¥2,000 →" data-si="ජපානයේ සිටින ශිෂ්‍යයන් වෙත · ¥2,000 සිට පැකේජ →">Reach learners in Japan · packages from ¥2,000 →</span>
            </span>
            <span class="text-accent shrink-0">→</span>
          </a>
        </div>
      </div>

      <!-- Browse by Category showcase -->
      <div id="category-showcase" class="max-w-4xl mx-auto px-4 sm:px-6 pb-10 sm:pb-14 hidden">
        <p class="text-center text-[11px] font-bold text-ink/40 uppercase tracking-widest mb-4" data-en="Browse by Category" data-si="මාතෘකාව අනුව පුහුණු වන්න">Browse by Category</p>
        <div id="category-grid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-2.5"></div>
      </div>
    </div>

    <div class="max-w-2xl w-full mx-auto px-4 sm:px-6 py-8">

      <!-- Exam-mode banner (shown only when ?exam=karimen|honmen is active) -->
      <div id="exam-mode-banner" class="hidden mb-6 rise-in">
        <div class="bg-primary text-white rounded-2xl p-4 flex items-center justify-between gap-3">
          <div class="min-w-0">
            <p class="font-display font-bold text-sm sm:text-base truncate" id="exam-mode-title">KARIMEN Mock Exam</p>
            <p class="text-xs text-white/70" id="exam-mode-sub">50 questions · Pass mark: 45/50</p>
          </div>
          <span class="text-2xl shrink-0" id="exam-mode-icon" aria-hidden="true">🚗</span>
        </div>
      </div>

      <!-- Free-plan lock notice (only shown for the standard 30-question free test, non-premium users) -->
      <div id="free-lock-banner" class="hidden mb-6 bg-primary-light border border-primary/20 rounded-2xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 rise-in">
        <p class="text-xs sm:text-sm font-semibold text-primary" id="free-lock-text">You're on the free set of 30 questions — the same 30 every time. Upgrade for the full 1000+ question bank.</p>
        <a href="upgrade.php" class="text-xs sm:text-sm font-bold bg-accent text-ink px-4 py-2 rounded-lg shrink-0 hover:brightness-95 transition text-center" data-en="Upgrade →" data-si="උසස් කරන්න →">Upgrade →</a>
      </div>

      <!-- Resume banner (guest) -->
      <div id="guest-resume-banner" class="hidden mb-6 bg-accent-light border border-accent/40 rounded-2xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 rise-in">
        <p class="text-sm font-semibold text-ink" id="guest-resume-text">You have a test in progress — continue?</p>
        <div class="flex gap-2 shrink-0">
          <button onclick="resumeSavedProgress()" class="text-sm font-bold bg-ink text-white px-4 py-2 rounded-lg" data-en="Resume →" data-si="දිගටම →">Resume →</button>
          <button onclick="discardSavedProgress()" class="text-sm font-semibold text-ink/60 px-3 py-2" data-en="Discard" data-si="ඉවත් කරන්න">Discard</button>
        </div>
      </div>

      <!-- Category Selector (hidden in full mock exam mode) -->
      <div id="filter-box" class="mb-6 bg-white p-4 rounded-2xl shadow-sm border border-black/5">
        <label id="cat-label" class="block text-sm font-semibold text-ink/60 mb-2">Select Category / මාතෘකාව හෝ පරිච්ඡේදය තෝරන්න:</label>
        <select id="category-select" onchange="changeCategory()" class="w-full p-3 bg-paper border border-black/10 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-primary font-medium text-ink">
          <option value="All">All Categories / සියලුම ප්‍රශ්න (Mock Exam)</option>
        </select>
      </div>

      <!-- Loading -->
      <div id="loading-box" class="text-center py-20">
        <div class="inline-block animate-spin rounded-full h-10 w-10 border-4 border-primary border-t-transparent"></div>
        <p class="mt-4 text-ink/60 font-medium" data-en="Loading questions…" data-si="ප්‍රශ්න පූරණය වෙමින්…">Loading questions…</p>
      </div>

      <!-- Quiz Box -->
      <div id="quiz-box" class="hidden bg-white rounded-2xl shadow-xl p-4 sm:p-8 border border-black/5 rise-in">

        <div class="flex justify-between items-center mb-3 text-sm font-medium text-ink/50 gap-2">
          <span id="progress-text" class="font-mono text-xs sm:text-sm">Question 1 of 30</span>
          <span class="bg-primary-light text-primary px-3 py-1 rounded-full text-xs font-bold font-mono shrink-0">Score: <span id="score-val">0</span></span>
        </div>
        <!-- Progress bar එක මෙහි ඇතුළත් කර ඇත -->
        <div class="seg-track mb-6" id="seg-track" aria-hidden="true"></div>

        <div id="image-container" class="mb-6 hidden text-center relative">
          <div id="img-spinner" class="hidden absolute inset-0 flex items-center justify-center">
            <div class="animate-spin rounded-full h-7 w-7 border-2 border-primary border-t-transparent"></div>
          </div>
          <img id="question-img" src="" alt="Illustration for the current practice question" class="max-h-64 max-w-full mx-auto rounded-lg border shadow-sm" style="transition:opacity .25s ease;">
        </div>

        <div class="mb-8">
          <h2 id="question-text" class="text-base sm:text-xl font-semibold text-ink leading-relaxed"></h2>
        </div>

        <div id="options-box" class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 mb-2" role="group" aria-label="Answer options">
          <button onclick="handleAnswer(1)" class="flex items-center justify-center gap-3 p-3.5 sm:p-4 rounded-xl border-2 border-go/30 bg-go/5 hover:bg-go/10 text-go font-bold transition text-base sm:text-lg shadow-sm active:scale-[0.98]">
            <span id="true-label">正 — True (හරි / ◯)</span>
          </button>
          <button onclick="handleAnswer(0)" class="flex items-center justify-center gap-3 p-3.5 sm:p-4 rounded-xl border-2 border-stop/30 bg-stop/5 hover:bg-stop/10 text-stop font-bold transition text-base sm:text-lg shadow-sm active:scale-[0.98]">
            <span id="false-label">誤 — False (වැරදියයි / ✕)</span>
          </button>
        </div>

        <div id="explanation-box" class="hidden mt-4 p-4 rounded-xl bg-paper border border-black/10 rise-in" role="status" aria-live="polite">
          <div id="result-badge" class="font-bold text-sm mb-1"></div>
          <p id="explanation-text" class="text-sm text-ink/70 leading-relaxed"></p>
          <button onclick="nextQuestion()" class="mt-4 w-full btn-primary text-white font-semibold py-3 rounded-xl transition shadow-md">
            <span id="next-btn-text">Next Question →</span>
          </button>
        </div>
      </div>

      <!-- Completion -->
      <div id="complete-box" class="hidden space-y-6">

        <div class="bg-white rounded-2xl shadow-xl p-5 sm:p-8 border border-black/5 text-center rise-in">
          <div class="inline-flex items-center justify-center w-16 h-16 bg-primary-light text-primary rounded-full text-2xl mb-4">📊</div>
          <h2 class="text-xl sm:text-2xl font-bold text-ink mb-1 font-display" data-en="Test Completed!" data-si="පරීක්ෂණය අවසන්!">Test Completed!</h2>
          <p class="text-sm text-ink/50 mb-6" id="complete-sub" data-en="Here's how you did on this free practice set." data-si="ඔබ නොමිලේ ලබා දෙන ප්‍රශ්නාවලිය සාර්ථකව අවසන් කර ඇත.">Here's how you did on this free practice set.</p>

          <div class="grid grid-cols-3 gap-1.5 sm:gap-3 mb-3 bg-paper p-3 sm:p-4 rounded-xl border border-black/5">
            <div><span class="block text-[10px] sm:text-xs text-ink/40 font-semibold" data-en="Attempted" data-si="උත්සාහ කළ">Attempted</span><span id="dash-attempted" class="text-base sm:text-lg font-bold text-ink font-mono">30</span></div>
            <div class="border-x border-black/10"><span class="block text-[10px] sm:text-xs text-ink/40 font-semibold" data-en="Score" data-si="ලකුණු">Score</span><span id="dash-score" class="text-base sm:text-lg font-bold text-primary font-mono">0 / 30</span></div>
            <div><span class="block text-[10px] sm:text-xs text-ink/40 font-semibold" data-en="Percentage" data-si="ප්‍රතිශතය">Percentage</span><span id="dash-percentage" class="text-base sm:text-lg font-bold text-go font-mono">0%</span></div>
          </div>

          <!-- Pass/Fail banner, shown only for Karimen/Honmen full mock exams -->
          <p id="exam-result-banner" class="hidden mb-4 font-bold text-sm"></p>

          <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <button onclick="restartQuiz()" class="px-5 py-2.5 bg-paper hover:bg-black/5 text-ink font-semibold rounded-xl text-sm transition border border-black/10">
              🔄 <span data-en="Retry Free Test" data-si="නැවත උත්සාහ කරන්න" id="retry-label">Retry Free Test</span>
            </button>
            <a href="dashboard.php" class="px-5 py-2.5 bg-primary-light hover:bg-primary/20 text-primary font-semibold rounded-xl text-sm transition flex items-center justify-center gap-2">
              👤 <span data-en="Go to My Dashboard" data-si="ගිණුමේ විස්තර">Go to My Dashboard</span>
            </a>
          </div>
        </div>

        <!-- Plans Section (සක්‍රීය සැලැස්මක් නොමැති යූසර්වරුන්ට පමණක් පෙන්වයි) -->
        <?php if (!$hasActivePlan): ?>
        <div id="plans-section" class="bg-gradient-to-br from-primary via-primary-dark to-ink text-white rounded-2xl shadow-xl p-5 sm:p-8 border border-white/10 rise-in">
          <div class="text-center max-w-lg mx-auto mb-6">
            <span class="bg-accent text-ink text-xs font-bold px-3 py-1 rounded-full animate-pulse" data-en="🚀 Upgrade Your Plan" data-si="🚀 ඔබේ සැලැස්ම උසස් කරගන්න">🚀 Upgrade Your Plan</span>
            <h3 class="font-display font-bold text-lg sm:text-2xl mt-3 mb-2" data-si="ප්‍රශ්න 1000කට අධික සංඛ්‍යාවකට සහ සියලුම විශේෂාංග වෙත පූර්ණ ප්‍රවේශය ලබා ගන්න">Unlock full access to 1000+ questions and all premium features</h3>
            <p class="text-xs sm:text-sm text-white/70" data-si="විභාගය පහසුවෙන් සමත් වීමට අවශ්‍ය සියලුම මාතෘකා සහ අමතර අභ්‍යාස දැන්ම ලබා ගන්න.">Get unlimited access to all chapters, mock exams, and detailed explanations to pass on your first try.</p>
          </div>

          <ul class="grid grid-cols-1 sm:grid-cols-3 gap-2 max-w-2xl mx-auto mb-7 text-xs sm:text-sm text-white/85">
            <li class="flex items-center gap-2"><span class="text-accent">✓</span><span data-en="1000+ practice questions" data-si="ප්‍රශ්න 1000+ක්">1000+ practice questions</span></li>
            <li class="flex items-center gap-2"><span class="text-accent">✓</span><span data-en="All chapters &amp; categories" data-si="සියලුම පරිච්ඡේද">All chapters &amp; categories</span></li>
            <li class="flex items-center gap-2"><span class="text-accent">✓</span><span data-en="Full Karimen &amp; Honmen mock exams" data-si="සම්පූර්ණ කරිමන් සහ හොන්මන් විභාග">Full Karimen &amp; Honmen mock exams</span></li>
            <li class="flex items-center gap-2"><span class="text-accent">✓</span><span data-en="Progress dashboard" data-si="ප්‍රගති පුවරුව">Progress dashboard</span></li>
            <li class="flex items-center gap-2"><span class="text-accent">✓</span><span data-en="Detailed explanations" data-si="විස්තරාත්මක පැහැදිලි කිරීම්">Detailed explanations</span></li>
            <li class="flex items-center gap-2"><span class="text-accent">✓</span><span data-en="Sinhala + English toggle" data-si="සිංහල + ඉංග්‍රීසි">Sinhala + English toggle</span></li>
          </ul>

          <div class="max-w-md mx-auto text-center">
            <a href="upgrade.php" class="block bg-accent hover:brightness-95 text-ink font-bold py-3.5 rounded-xl transition shadow-lg text-sm">
              <span data-en="View Upgrade Plans →" data-si="සැලසුම් (Plans) නරඹන්න →">View Upgrade Plans →</span>
            </a>
            <p class="text-[11px] text-white/50 mt-3" data-en="Secure checkout · Instant activation · Cancel anytime" data-si="ක්ෂණික සක්‍රීයවීම · ඕනෑම වේලාවක අවලංගු කළ හැක">Secure checkout · Instant activation · Cancel anytime</p>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- ============ Upgrade lock modal (free/guest users trying to access a premium-only category or full mock exam) ============ -->
    <dialog id="upgrade-lock-dialog" class="w-[92vw] sm:w-full max-w-md mx-auto">
      <div class="bg-white rounded-2xl p-4 sm:p-6">
        <div class="flex items-start justify-between gap-3 mb-3">
          <div class="flex items-center gap-2 min-w-0">
            <span class="text-2xl shrink-0" aria-hidden="true">🔒</span>
            <h3 id="upgrade-lock-title" class="font-display font-bold text-base sm:text-lg text-ink">Premium Access Required</h3>
          </div>
          <button type="button" onclick="document.getElementById('upgrade-lock-dialog').close()" class="text-ink/30 hover:text-ink/60 transition text-xl leading-none shrink-0" aria-label="Close">✕</button>
        </div>
        <p id="upgrade-lock-message" class="text-sm text-ink/70 leading-relaxed mb-4"></p>
        <div id="upgrade-lock-stats" class="bg-paper border border-black/5 rounded-xl p-3 mb-5 text-xs text-ink/60 space-y-1.5"></div>
        <div class="flex flex-col sm:flex-row gap-2">
          <a href="upgrade.php" class="flex-1 text-center bg-accent hover:brightness-95 text-ink font-bold py-2.5 rounded-xl text-sm transition">
            🚀 <span data-en="Upgrade Now →" data-si="උසස් කරන්න →">Upgrade Now →</span>
          </a>
          <button type="button" onclick="document.getElementById('upgrade-lock-dialog').close()" class="flex-1 sm:flex-none px-4 py-2.5 rounded-xl text-sm font-semibold border border-black/10 text-ink/60 hover:bg-paper transition" data-en="Close" data-si="වසන්න">Close</button>
        </div>
      </div>
    </dialog>
  </section>
</main>

<footer class="text-center py-8 text-xs text-ink/40 border-t border-black/5 bg-white space-y-2">
  <p>Japan Driving License Practice System &copy; 2026</p>
  <p class="mt-1" data-en="Made for Sri Lankan drivers preparing for Japan's theory test." data-si="ජපානයේ රියදුරු බලපත්‍ර විභාගය සඳහා සූදානම් වන ශ්‍රී ලාංකිකයන් සඳහා නිර්මාණය කර ඇත.">Made for Sri Lankan drivers preparing for Japan's theory test.</p>
  <div class="flex items-center justify-center gap-4 flex-wrap">
    <a href="books.php" class="text-primary hover:underline font-medium inline-flex items-center gap-1 transition">
      <span>📕 Shop Books</span>
    </a>
    <a href="jaf_license_translation.php" class="text-primary hover:underline font-medium inline-flex items-center gap-1 transition">
      <span>🌐 License Translation Guide</span>
    </a>
    <a href="ad.php" class="text-primary hover:underline font-medium inline-flex items-center gap-1 transition">
      <span>📢 Advertise with us</span>
    </a>
    <a href="contact.php" class="text-primary hover:underline font-medium inline-flex items-center gap-1 transition">
      <span>💬 Contact Support / Report Issue</span>
    </a>
  </div>
</footer>

<script>
/* ==============================================================
   AUTH & APP STATE
   ============================================================== */

const LS_PROGRESS_PREFIX = 'jp_quiz_progress_';
// Fixed guest/free-plan seed set — sorted by question id ascending, first 30 taken.
// This guarantees non-paying users always land on the exact same 30 questions,
// no matter how many times or where they retry — only an upgrade unlocks the
// full randomized 1000+ question bank.
const FREE_SET_SIZE = 30;

// Full mock-exam definitions — size, real JP pass mark, labels
const EXAM_MODES = {
  karimen: { key: 'KARIMEN', size: 50,  pass: 45,  label: 'KARIMEN Mock Exam', labelSi: 'කරිමන් ආදර්ශ විභාගය', icon: '🚗' },
  honmen:  { key: 'HONMEN',  size: 100, pass: 90,  label: 'HONMEN Mock Exam',  labelSi: 'හොන්මන් ආදර්ශ විභාගය', icon: '🚘' }
};

let questions = [];
let currentIndex = 0;
let score = 0;
let currentLang = 'en';
let currentCategory = 'All';
let user = null;
let globalCategories = [];
let globalGrandTotal = 0;
let examMode = null;     // set from ?exam=karimen|honmen
let answersLog = [];     // [{question_id, is_correct}] for this session, sent to save_history.php
let lastProgressData = null; // cached result of api/get_user_progress.php, reused in the upgrade-lock modal

const uiTexts = {
  en: { correct: '✅ Correct!', incorrect: '❌ Incorrect!' },
  si: { correct: '✅ නිවැරදියයි!', incorrect: '❌ වැරදියයි!' }
};

/* Is this visitor NOT on an active paid plan? (guests count as free too) */
function isFreeUser() {
  return !(user && user.hasActivePlan);
}

/* ---------------- INIT ---------------- */
window.onload = () => {
  const params = new URLSearchParams(window.location.search);
  const examKey = (params.get('exam') || '').toLowerCase();
  if (EXAM_MODES[examKey]) {
    examMode = EXAM_MODES[examKey];
  }

  user = window.__USER__ || null;

  // Free/guest visitors can't actually use a full Karimen/Honmen mock exam —
  // bounce them straight into the lock modal and fall back to the normal
  // free 30-question set underneath it.
  if (examMode && isFreeUser()) {
    const blockedExam = examMode;
    examMode = null;
    window.history.replaceState({}, '', 'index.php');
    setTimeout(() => openUpgradeLockModal(blockedExam === EXAM_MODES.karimen ? 'karimen' : 'honmen', blockedExam), 300);
  }

  applyTranslations();
  refreshNav();
  setupExamModeUI();
  checkGuestResumeBanner();
  loadProgressWidget();
  fetchQuestions(examMode ? examMode.key : 'All');
};

/* ---------------- AUTH ---------------- */
function logout() {
  window.location.href = 'logout.php';
}

function refreshNav() {
  const guestNav = document.getElementById('nav-guest');
  const userNav = document.getElementById('nav-user');
  if (user) {
    guestNav.classList.add('hidden');
    userNav.classList.remove('hidden');
    userNav.classList.add('flex');
    document.getElementById('nav-avatar').innerText = (user.name || 'U').trim()[0].toUpperCase();
    document.getElementById('nav-avatar').onclick = logout;
    document.getElementById('nav-avatar').title = 'Log out';
  } else {
    guestNav.classList.remove('hidden');
    userNav.classList.add('hidden');
    userNav.classList.remove('flex');
  }
}

/* ---------------- LOGGED-IN USER PROGRESS WIDGET ---------------- */
async function loadProgressWidget() {
  if (!user) return;
  const widget = document.getElementById('progress-widget');
  if (!widget) return;

  try {
    const res = await fetch('api/get_user_progress.php');
    const data = await res.json();
    if (data.status !== 'success') return;

    lastProgressData = data; // cached for the upgrade-lock modal

    document.getElementById('pw-answered').innerText = data.questions_answered;
    document.getElementById('pw-total').innerText = data.total_questions;
    document.getElementById('pw-percent').innerText = data.coverage_percent;
    document.getElementById('pw-cov-fill').style.width = data.coverage_percent + '%';

    const kBest = data.karimen.best, kSize = data.karimen.size, kPass = data.karimen.pass, kAtt = data.karimen.attempts;
    document.getElementById('pw-karimen-score').innerText = `${kBest}/${kSize}`;
    document.getElementById('pw-karimen-fill').style.width = Math.min(100, Math.round(kBest / kSize * 100)) + '%';
    document.getElementById('pw-karimen-fill').classList.toggle('passed', kBest >= kPass);
    document.getElementById('pw-karimen-note').innerText = kAtt > 0
      ? (kBest >= kPass ? `✅ Passed · ${kAtt} attempt${kAtt === 1 ? '' : 's'}` : `${kAtt} attempt${kAtt === 1 ? '' : 's'} · need ${kPass}`)
      : 'No attempts yet';

    const hBest = data.honmen.best, hSize = data.honmen.size, hPass = data.honmen.pass, hAtt = data.honmen.attempts;
    document.getElementById('pw-honmen-score').innerText = `${hBest}/${hSize}`;
    document.getElementById('pw-honmen-fill').style.width = Math.min(100, Math.round(hBest / hSize * 100)) + '%';
    document.getElementById('pw-honmen-fill').classList.toggle('passed', hBest >= hPass);
    document.getElementById('pw-honmen-note').innerText = hAtt > 0
      ? (hBest >= hPass ? `✅ Passed · ${hAtt} attempt${hAtt === 1 ? '' : 's'}` : `${hAtt} attempt${hAtt === 1 ? '' : 's'} · need ${hPass}`)
      : 'No attempts yet';

    widget.classList.remove('hidden');
  } catch (e) {
    console.error('Could not load progress widget:', e);
  }
}

/* ---------------- UPGRADE LOCK MODAL ----------------
   Shown when a free/guest user clicks a specific category (instead of "All")
   or tries to start a full Karimen/Honmen mock exam — both of which need an
   active plan. Shows how many questions they'd unlock, the total bank size,
   and (if logged in) their current progress, then offers Upgrade or Close. */
function openUpgradeLockModal(kind, meta) {
  const titleEl = document.getElementById('upgrade-lock-title');
  const msgEl = document.getElementById('upgrade-lock-message');
  const statsEl = document.getElementById('upgrade-lock-stats');

  titleEl.innerText = currentLang === 'si' ? 'Premium ප්‍රවේශයක් අවශ්‍යයි' : 'Premium Access Required';

  let msg = '';
  let statsHtml = '';

  if (kind === 'category') {
    const catName = currentLang === 'si' ? (meta.catSi || meta.catEn) : meta.catEn;
    msg = currentLang === 'si'
      ? `"${catName}" කැටගරිය සම්පූර්ණයෙන් practice කිරීමට upgrade කිරීම අවශ්‍යයි. Free plan එකෙන් ලැබෙන්නේ සියලුම කැටගරි වලින් මිශ්‍ර වූ ස්ථාවර ප්‍රශ්න 30ක් පමණි.`
      : `Practicing the "${catName}" category needs an upgrade. The free plan only gives a fixed set of 30 mixed questions.`;
    statsHtml += `<div class="flex justify-between"><span>${currentLang === 'si' ? 'මේ කැටගරියේ ප්‍රශ්න' : 'Questions in this category'}</span><span class="font-mono font-bold text-ink">${meta.count || 0}</span></div>`;
  } else {
    // karimen / honmen
    const exam = meta;
    const examLabel = currentLang === 'si' ? exam.labelSi : exam.label;
    msg = currentLang === 'si'
      ? `${examLabel} සඳහා ප්‍රශ්න ${exam.size}ක් අවශ්‍යයි (සමත් වීමට ${exam.pass}ක් ලබා ගත යුතුයි). Free plan එකෙන් ලැබෙන්නේ ස්ථාවර ප්‍රශ්න 30ක් පමණි — සම්පූර්ණ ආදර්ශ විභාගය සඳහා upgrade කරන්න.`
      : `${examLabel} needs ${exam.size} questions (pass mark ${exam.pass}). The free plan only gives a fixed set of 30 — upgrade to unlock the full mock exam.`;
    statsHtml += `<div class="flex justify-between"><span>${currentLang === 'si' ? 'මෙම විභාගයේ ප්‍රශ්න' : 'Questions in this exam'}</span><span class="font-mono font-bold text-ink">${exam.size}</span></div>`;
    statsHtml += `<div class="flex justify-between"><span>${currentLang === 'si' ? 'සමත් වීමට අවශ්‍ය' : 'Pass mark'}</span><span class="font-mono font-bold text-ink">${exam.pass}/${exam.size}</span></div>`;
  }

  statsHtml += `<div class="flex justify-between"><span>${currentLang === 'si' ? 'මුළු ප්‍රශ්න බැංකුව' : 'Total question bank'}</span><span class="font-mono font-bold text-primary">${globalGrandTotal || '1000+'}</span></div>`;

  if (lastProgressData) {
    statsHtml += `<div class="flex justify-between pt-1.5 border-t border-black/5 mt-0.5"><span>${currentLang === 'si' ? 'ඔබ පිළිතුරු දී ඇති ප්‍රශ්න' : 'Your progress so far'}</span><span class="font-mono font-bold text-go">${lastProgressData.questions_answered}/${lastProgressData.total_questions} (${lastProgressData.coverage_percent}%)</span></div>`;
  } else if (!user) {
    statsHtml += `<div class="pt-1.5 border-t border-black/5 mt-0.5 text-[11px] text-ink/40">${currentLang === 'si' ? 'ලොග් වී ඔබේ ප්‍රගතිය track කරගන්න.' : 'Log in to track your progress.'}</div>`;
  }

  msgEl.innerText = msg;
  statsEl.innerHTML = statsHtml;
  document.getElementById('upgrade-lock-dialog').showModal();
}

/* Intercepts clicks on the Karimen/Honmen quick-start links for free/guest users */
function handleExamLinkClick(e, examKey) {
  if (isFreeUser()) {
    e.preventDefault();
    openUpgradeLockModal(examKey, EXAM_MODES[examKey]);
    return false;
  }
  return true;
}

/* ---------------- EXAM MODE UI ---------------- */
function setupExamModeUI() {
  if (!examMode) return;

  // Full mock exams pull from the whole bank — category picking doesn't apply
  document.getElementById('filter-box').classList.add('hidden');
  document.getElementById('category-showcase').classList.add('hidden');
  document.getElementById('free-lock-banner').classList.add('hidden');

  const banner = document.getElementById('exam-mode-banner');
  const title = currentLang === 'si' ? examMode.labelSi : examMode.label;
  document.getElementById('exam-mode-title').innerText = title;
  document.getElementById('exam-mode-sub').innerText =
    (currentLang === 'si' ? `ප්‍රශ්න ${examMode.size} · සමත් ලකුණු: ${examMode.pass}/${examMode.size}` : `${examMode.size} questions · Pass mark: ${examMode.pass}/${examMode.size}`);
  document.getElementById('exam-mode-icon').innerText = examMode.icon;
  banner.classList.remove('hidden');
}

/* Show/hide the "you're on the fixed free 30" notice for the standard free test */
function updateFreeLockBanner() {
  const el = document.getElementById('free-lock-banner');
  if (!el) return;
  const shouldShow = !examMode && isFreeUser() && currentCategory === 'All';
  el.classList.toggle('hidden', !shouldShow);
  if (shouldShow) {
    document.getElementById('free-lock-text').innerText = currentLang === 'si'
      ? 'ඔබට ලැබෙන්නේ නොමිලේ ලබා දෙන එකම ප්‍රශ්න 30 — කී පාරක් උත්සාහ කළත් වෙනස් වන්නේ නැත. සම්පූර්ණ 1000+ ප්‍රශ්න බැංකුව සඳහා උසස් කරගන්න.'
      : "You're on the free set of 30 questions — the same 30 every time. Upgrade for the full 1000+ question bank.";
  }
}

/* ---------------- PROGRESS SAVE / RESUME (in-quiz) ---------------- */
function progressKey(cat) { return LS_PROGRESS_PREFIX + (examMode ? examMode.key : cat); }

function saveProgress() {
  if (!questions.length) return;
  const data = { questions, currentIndex, score, category: currentCategory, examKey: examMode ? examMode.key : null, ts: Date.now() };
  localStorage.setItem(progressKey(currentCategory), JSON.stringify(data));
}

function clearProgress(cat) { localStorage.removeItem(progressKey(cat)); }

function findAnySavedProgress() {
  for (let i = 0; i < localStorage.length; i++) {
    const key = localStorage.key(i);
    if (key && key.startsWith(LS_PROGRESS_PREFIX)) {
      try {
        const data = JSON.parse(localStorage.getItem(key));
        if (data && data.currentIndex < data.questions.length) {
          return { category: data.category, data };
        }
      } catch (e) {}
    }
  }
  return null;
}

function checkGuestResumeBanner() {
  // Don't show the generic resume banner while inside a fresh exam-mode link
  if (examMode) return;
  const saved = findAnySavedProgress();
  if (!saved) return;
  document.getElementById('guest-resume-banner').classList.remove('hidden');
  document.getElementById('guest-resume-text').innerText =
    (currentLang === 'si' ? 'ඔබට අතරමග පරීක්ෂණයක් ඇත — ' : 'You have a test in progress — ') +
    `Q${saved.data.currentIndex + 1}/${saved.data.questions.length}`;
}

function loadFromSaved(category, data) {
  currentCategory = category;
  questions = data.questions;
  currentIndex = data.currentIndex;
  score = data.score;
  answersLog = [];
  preloadQuizImages(questions); // warm the cache for a resumed set too
  if (data.examKey && EXAM_MODES[data.examKey.toLowerCase()]) {
    examMode = EXAM_MODES[data.examKey.toLowerCase()];
    setupExamModeUI();
  }
  if (document.getElementById('category-select')) document.getElementById('category-select').value = category;
  document.getElementById('loading-box').classList.add('hidden');
  document.getElementById('complete-box').classList.add('hidden');
  if (!examMode) document.getElementById('filter-box').classList.remove('hidden');
  document.getElementById('quiz-box').classList.remove('hidden');
  document.getElementById('guest-resume-banner').classList.add('hidden');
  updateFreeLockBanner();
  loadQuestion();
}

function resumeSavedProgress() {
  const saved = findAnySavedProgress();
  if (saved) loadFromSaved(saved.category, saved.data);
}
function discardSavedProgress() {
  const saved = findAnySavedProgress();
  if (saved) clearProgress(saved.category);
  document.getElementById('guest-resume-banner').classList.add('hidden');
}

/* ---------------- SHUFFLE ---------------- */
function shuffleArray(array) {
  for (let i = array.length - 1; i > 0; i--) {
    let j = Math.floor(Math.random() * (i + 1));
    [array[i], array[j]] = [array[j], array[i]];
  }
  return array;
}

/* Deterministic pick for free/guest users on the standard "All" mock test:
   sort by question id ascending and take the first N — always the same set,
   no matter how many times or where the visitor tries. */
function pickFixedSet(list, n) {
  return list.slice().sort((a, b) => (parseInt(a.id) || 0) - (parseInt(b.id) || 0)).slice(0, n);
}

/* ---------------- IMAGE PRELOADING (fast, smooth image switches) ----------------
   Warms the browser's image cache for every question in the current set as soon
   as it's loaded, so flipping between questions never shows a blank/slow image —
   it's already sitting in cache by the time the user gets there. */
const preloadedImageCache = new Set();

function preloadImage(src) {
  if (!src || src === 'null' || preloadedImageCache.has(src)) return;
  preloadedImageCache.add(src);
  const im = new Image();
  im.src = src;
}

function preloadQuizImages(qs) {
  if (!Array.isArray(qs)) return;
  qs.forEach(q => { if (q && q.img) preloadImage(q.img); });
}

/* ---------------- FETCH QUESTIONS ---------------- */
async function fetchQuestions(category = 'All') {
  currentCategory = category;

  const savedRaw = localStorage.getItem(progressKey(category));
  if (savedRaw && !user) {
    try {
      const data = JSON.parse(savedRaw);
      if (data.currentIndex < data.questions.length) {
        document.getElementById('guest-resume-banner').classList.remove('hidden');
        document.getElementById('guest-resume-text').innerText =
          (currentLang === 'si' ? 'ඔබට අතරමග පරීක්ෂණයක් ඇත — ' : 'You have a test in progress — ') +
          `Q${data.currentIndex + 1}/${data.questions.length}`;
      }
    } catch (e) {}
  }

  const CATS_KEY = 'driving_quiz_categories';

  try {
    // Full mock exams always pull from the entire bank — never filtered by category
    let url = 'api/get_questions.php';
    if (!examMode && category !== 'All') url += `?category=${encodeURIComponent(category)}`;

    let response = await fetch(url);
    let result = await response.json();

    if (result.status === 'error') {
      console.error('API error:', result.message);
      document.getElementById('loading-box').innerHTML = `<p class="text-stop font-medium">Server error: ${result.message}</p>`;
      return;
    }

    let allFetchedQuestions = [];
    if (result.status === 'success' && Array.isArray(result.data)) {
      allFetchedQuestions = result.data;
    } else if (Array.isArray(result)) {
      allFetchedQuestions = result;
    }

    if (allFetchedQuestions.length > 0) {
      if (typeof result.grand_total === 'number') {
        globalGrandTotal = result.grand_total;
        sessionStorage.setItem('driving_quiz_grand_total', String(result.grand_total));
      }
      if (Array.isArray(result.categories) && result.categories.length > 0) {
        globalCategories = result.categories;
        sessionStorage.setItem(CATS_KEY, JSON.stringify(result.categories));
      } else {
        let uniqueMap = new Map();
        allFetchedQuestions.forEach(q => {
          let c = q.category || 'General Rules';
          let cs = q.category_si || c;
          uniqueMap.set(c, cs);
        });
        globalCategories = Array.from(uniqueMap, ([category, category_si]) => ({ category, category_si }));
      }

      // Free/guest users doing the standard "All" mock test always get the
      // exact same fixed 30 questions. Everyone else (premium users, category
      // practice, or full Karimen/Honmen mock exams) still gets a fresh shuffle.
      if (!examMode && category === 'All' && isFreeUser()) {
        questions = pickFixedSet(allFetchedQuestions, FREE_SET_SIZE);
      } else {
        shuffleArray(allFetchedQuestions);
        questions = allFetchedQuestions.slice(0, examMode ? examMode.size : 30);
      }
      currentIndex = 0; score = 0; answersLog = [];
      preloadQuizImages(questions); // warm the cache for the whole set right away

      if (!examMode) {
        populateDropdown(globalCategories, category);
        renderCategoryShowcase(globalCategories);
      }
      updateFreeLockBanner();
      showQuizBox();
      loadQuestion();
    } else {
      document.getElementById('loading-box').innerHTML = `<p class="text-stop font-medium">No questions found in database.</p>`;
    }
  } catch (error) {
    console.error('Error:', error);
    document.getElementById('loading-box').innerHTML = `<p class="text-stop font-medium">Server connection failed.</p>`;
  }
}

function showQuizBox() {
  document.getElementById('loading-box').classList.add('hidden');
  document.getElementById('complete-box').classList.add('hidden');
  if (!examMode) document.getElementById('filter-box').classList.remove('hidden');
  document.getElementById('quiz-box').classList.remove('hidden');
}

function populateDropdown(categories, selectedCategory) {
  let select = document.getElementById('category-select');
  let currentVal = select.value || selectedCategory;
  while (select.options.length > 1) select.remove(1);

  select.options[0].text = currentLang === 'si' ? 'සියලුම ප්‍රශ්න (Mock Exam)' : 'All Categories / සියලුම ප්‍රශ්න (Mock Exam)';

  if (Array.isArray(categories)) {
    categories.forEach(catObj => {
      let catEn = typeof catObj === 'string' ? catObj : catObj.category;
      let catSi = typeof catObj === 'string' ? catObj : (catObj.category_si || catEn);

      if (catEn && catEn.trim() !== '') {
        let opt = document.createElement('option');
        opt.value = catEn;
        opt.innerText = (currentLang === 'si' ? catSi : catEn) + (isFreeUser() ? ' 🔒' : '');
        if (catEn === currentVal) opt.selected = true;
        select.appendChild(opt);
      }
    });
  }
}

/* Browse-by-category cards. For free/guest users, every card except "All"
   opens the upgrade-lock modal instead of loading that category. */
function renderCategoryShowcase(categories) {
  const wrap = document.getElementById('category-showcase');
  const grid = document.getElementById('category-grid');
  if (!Array.isArray(categories) || categories.length === 0) {
    wrap.classList.add('hidden');
    return;
  }

  grid.innerHTML = '';

  const makeCard = (catEn, catSi, isAll, count) => {
    const locked = !isAll && isFreeUser();
    const card = document.createElement('button');
    card.type = 'button';
    card.className = 'relative text-left bg-white border rounded-xl p-3 transition hover:shadow-md hover:-translate-y-0.5 flex items-center justify-between gap-2 min-w-0 ' +
      (isAll ? 'border-accent bg-accent-light' : 'border-black/5 hover:border-primary/30');
    const countLabel = currentLang === 'si' ? `ප්‍රශ්න ${count}` : `${count} questions`;
    card.innerHTML = `
      ${locked ? '<span class="cat-lock-badge" aria-hidden="true">🔒</span>' : ''}
      <span class="min-w-0 flex-1">
        <span class="block text-xs font-semibold text-ink truncate">${isAll ? (currentLang === 'si' ? 'සියලුම ප්‍රශ්න' : 'All Categories') : (currentLang === 'si' ? catSi : catEn)}</span>
        <span class="block text-[11px] text-ink/40 font-si truncate">${isAll ? (currentLang === 'si' ? 'All Categories' : 'සියලුම ප්‍රශ්න') : (currentLang === 'si' ? catEn : catSi)}</span>
        <span class="inline-block mt-1 text-[10px] font-bold font-mono ${isAll ? 'text-primary' : 'text-go'} bg-black/5 px-1.5 py-0.5 rounded">${countLabel}</span>
      </span>
      <span class="text-primary/40 shrink-0">→</span>
    `;
    card.addEventListener('click', () => {
      if (locked) {
        openUpgradeLockModal('category', { catEn, catSi, count });
        return;
      }
      document.getElementById('category-select').value = catEn;
      changeCategory();
      document.getElementById('filter-box').scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
    return card;
  };

  grid.appendChild(makeCard('All', 'සියලුම', true, globalGrandTotal || categories.reduce((sum, c) => sum + (c.count || 0), 0)));

  categories.forEach(catObj => {
    const catEn = typeof catObj === 'string' ? catObj : catObj.category;
    const catSi = typeof catObj === 'string' ? catObj : (catObj.category_si || catEn);
    const count = (typeof catObj === 'object' && catObj.count) ? catObj.count : 0;
    if (catEn && catEn.trim() !== '') grid.appendChild(makeCard(catEn, catSi, false, count));
  });

  wrap.classList.remove('hidden');
}

/* Dropdown-based category change. Free/guest users picking anything other
   than "All" get bounced to the upgrade-lock modal and the dropdown resets
   back to "All" instead of loading that category. */
function changeCategory() {
  let selectedCat = document.getElementById('category-select').value;

  if (selectedCat !== 'All' && isFreeUser()) {
    document.getElementById('category-select').value = 'All';
    const catMeta = globalCategories.find(c => (typeof c === 'string' ? c : c.category) === selectedCat);
    openUpgradeLockModal('category', {
      catEn: selectedCat,
      catSi: (catMeta && catMeta.category_si) ? catMeta.category_si : selectedCat,
      count: (catMeta && catMeta.count) ? catMeta.count : 0
    });
    return;
  }

  document.getElementById('quiz-box').classList.add('hidden');
  document.getElementById('complete-box').classList.add('hidden');
  document.getElementById('loading-box').classList.remove('hidden');
  fetchQuestions(selectedCat);
}

/* ---------------- QUIZ FLOW ---------------- */
function renderSegments() {
  const track = document.getElementById('seg-track');
  track.innerHTML = '';
  questions.forEach((_, i) => {
    const seg = document.createElement('div');
    seg.className = 'seg' + (i < currentIndex ? ' filled' : i === currentIndex ? ' current' : '');
    track.appendChild(seg);
  });
}

function loadQuestion() {
  if (currentIndex >= questions.length) { showCompletion(); return; }

  let q = questions[currentIndex];
  document.getElementById('progress-text').innerText = `Question ${currentIndex + 1} of ${questions.length}`;
  document.getElementById('score-val').innerText = score;
  renderSegments();

  let qText = currentLang === 'si' && q.question_si ? q.question_si : q.question_en;
  document.getElementById('question-text').innerText = qText;

  let imgContainer = document.getElementById('image-container');
  let imgElement = document.getElementById('question-img');
  let imgSpinner = document.getElementById('img-spinner');
  if (q.img && q.img !== 'null' && q.img !== '') {
    imgContainer.classList.remove('hidden');

    // If this exact image is already sitting in the browser cache (from our
    // preload pass), the load event fires almost instantly and we skip the
    // spinner flash entirely. Otherwise show a brief spinner while it loads.
    const alreadyCached = preloadedImageCache.has(q.img);
    imgElement.style.opacity = alreadyCached ? '1' : '0';
    if (imgSpinner) imgSpinner.classList.toggle('hidden', alreadyCached);

    imgElement.onload = () => {
      imgElement.style.opacity = '1';
      if (imgSpinner) imgSpinner.classList.add('hidden');
    };
    imgElement.onerror = () => {
      if (imgSpinner) imgSpinner.classList.add('hidden');
      imgContainer.classList.add('hidden');
    };
    imgElement.src = q.img;

    // Extra insurance: explicitly preload the next couple of questions' images
    // right now, in case the bulk preload for a large set is still in flight.
    preloadImage(questions[currentIndex + 1] && questions[currentIndex + 1].img);
    preloadImage(questions[currentIndex + 2] && questions[currentIndex + 2].img);
  } else {
    imgContainer.classList.add('hidden');
  }

  document.getElementById('explanation-box').classList.add('hidden');
  setButtonsEnabled(true);
  saveProgress();
}

function handleAnswer(selectedAnswer) {
  let q = questions[currentIndex];
  let isCorrect = (selectedAnswer === parseInt(q.correct_answer));
  if (isCorrect) { score++; document.getElementById('score-val').innerText = score; }

  // Track every answered question for the coverage/progress widget
  if (q.id) answersLog.push({ question_id: q.id, is_correct: isCorrect ? 1 : 0 });

  let expBox = document.getElementById('explanation-box');
  let badge = document.getElementById('result-badge');
  let expText = document.getElementById('explanation-text');

  badge.innerHTML = isCorrect ? uiTexts[currentLang].correct : uiTexts[currentLang].incorrect;
  badge.className = `font-bold text-sm mb-1 ${isCorrect ? 'text-go' : 'text-stop'}`;

  let explanation = currentLang === 'si' && q.explanation_si ? q.explanation_si : q.explanation_en;
  expText.innerText = explanation ? explanation : (currentLang === 'si' ? 'අතිරේක විස්තරයක් නොමැත.' : 'No explanation available.');

  expBox.classList.remove('hidden');
  setButtonsEnabled(false);
  saveProgress();
}

function setButtonsEnabled(enabled) {
  document.querySelectorAll('#options-box button').forEach(btn => {
    btn.disabled = !enabled;
    btn.classList.toggle('opacity-50', !enabled);
    btn.classList.toggle('cursor-not-allowed', !enabled);
  });
}

function nextQuestion() { currentIndex++; loadQuestion(); }

/* ---------------- LANGUAGE ---------------- */
function applyTranslations() {
  document.querySelectorAll('[data-en]').forEach(el => {
    const txt = currentLang === 'si' ? (el.getAttribute('data-si') || el.getAttribute('data-en')) : el.getAttribute('data-en');
    el.innerText = txt;
  });
  document.getElementById('true-label').innerText = currentLang === 'si' ? '正 — True (හරි / ◯)' : '正 — True (◯)';
  document.getElementById('false-label').innerText = currentLang === 'si' ? '誤 — වැරදියයි (✕)' : '誤 — False (✕)';
  document.getElementById('next-btn-text').innerText = currentLang === 'si' ? 'මීළඟ ප්‍රශ්නය →' : 'Next Question →';
  document.getElementById('login-btn-text').innerText = currentLang === 'si' ? 'ලොග් වෙන්න' : 'Log in';
  document.getElementById('cat-label').innerText = currentLang === 'si'
    ? 'මාතෘකාව හෝ පරිච්ඡේදය තෝරන්න:'
    : 'Select Category / Chapter:';
  if (examMode) setupExamModeUI();
  updateFreeLockBanner();
}

function setLanguage(lang) {
  currentLang = lang;
  document.getElementById('btn-en').className = "px-2 sm:px-3 py-1 rounded-md font-semibold transition " + (lang === 'en' ? 'bg-white text-primary' : 'text-white');
  document.getElementById('btn-si').className = "px-2 sm:px-3 py-1 rounded-md font-semibold transition font-si " + (lang === 'si' ? 'bg-white text-primary' : 'text-white');

  applyTranslations();
  document.documentElement.lang = lang;

  if (!examMode) {
    populateDropdown(globalCategories, currentCategory);
    renderCategoryShowcase(globalCategories);
  }

  if (questions.length > 0 && currentIndex < questions.length) {
    let q = questions[currentIndex];
    document.getElementById('question-text').innerText = (lang === 'si' && q.question_si) ? q.question_si : q.question_en;
    let explanation = (lang === 'si' && q.explanation_si) ? q.explanation_si : q.explanation_en;
    if (!document.getElementById('explanation-box').classList.contains('hidden')) {
      document.getElementById('explanation-text').innerText = explanation || 'No explanation available.';
    }
  }
}

/* ---------------- COMPLETION ---------------- */
function showCompletion() {
  document.getElementById('filter-box').classList.add('hidden');
  document.getElementById('quiz-box').classList.add('hidden');
  document.getElementById('complete-box').classList.remove('hidden');

  let total = questions.length > 0 ? questions.length : (examMode ? examMode.size : 30);
  let percentage = Math.round((score / total) * 100);

  document.getElementById('dash-attempted').innerText = total;
  document.getElementById('dash-score').innerText = `${score} / ${total}`;
  document.getElementById('dash-percentage').innerText = `${percentage}%`;

  const resultBanner = document.getElementById('exam-result-banner');
  if (examMode) {
    const passed = score >= examMode.pass;
    resultBanner.classList.remove('hidden');
    resultBanner.className = `mb-4 font-bold text-sm ${passed ? 'text-go' : 'text-stop'}`;
    const examLabel = currentLang === 'si' ? examMode.labelSi : examMode.label;
    resultBanner.innerText = passed
      ? (currentLang === 'si' ? `✅ සමත් විය — ${examLabel} (${examMode.pass}/${examMode.size} ට වඩා)` : `✅ PASSED — ${examLabel} (needed ${examMode.pass}/${examMode.size})`)
      : (currentLang === 'si' ? `❌ තවම සමත් නැත — ${examLabel} (${examMode.pass}/${examMode.size} අවශ්‍යයි)` : `❌ NOT YET — ${examLabel} (needed ${examMode.pass}/${examMode.size})`);
    document.getElementById('complete-sub').innerText = currentLang === 'si'
      ? `${examLabel} සම්පූර්ණයි — ඔබේ ප්‍රතිඵලය මෙන්න.`
      : `${examLabel} complete — here's your result.`;
    document.getElementById('retry-label').innerText = currentLang === 'si' ? 'නැවත උත්සාහ කරන්න' : `Retry ${examMode.key}`;
  } else {
    resultBanner.classList.add('hidden');
    document.getElementById('complete-sub').innerText = (!examMode && isFreeUser() && currentCategory === 'All')
      ? (currentLang === 'si' ? 'ඔබ නොමිලේ ලබා දෙන එකම ප්‍රශ්න 30 සම්පූර්ණ කළා — නැවත උත්සාහ කළත් මේම ප්‍රශ්නම එනවා.' : "You've completed the fixed free set of 30 — retrying gives you these exact same questions.")
      : (currentLang === 'si' ? 'ඔබ නොමිලේ ලබා දෙන ප්‍රශ්නාවලිය සාර්ථකව අවසන් කර ඇත.' : "Here's how you did on this free practice set.");
    document.getElementById('retry-label').innerText = currentLang === 'si' ? 'නැවත උත්සාහ කරන්න' : 'Retry Free Test';
  }

  if (user) {
    fetch('api/save_history.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        category: examMode ? examMode.key : currentCategory,
        exam_type: examMode ? examMode.key.toLowerCase() : 'category',
        score,
        total_questions: total,
        answers: answersLog
      })
    }).then(() => loadProgressWidget())
      .catch(err => console.error('Could not save test history:', err));
  }

  clearProgress(examMode ? examMode.key : currentCategory);
}

function restartQuiz() {
  document.getElementById('complete-box').classList.add('hidden');
  document.getElementById('loading-box').classList.remove('hidden');
  document.getElementById('exam-result-banner').classList.add('hidden');
  if (examMode) {
    fetchQuestions(examMode.key);
  } else {
    let selectedCat = document.getElementById('category-select').value;
    clearProgress(selectedCat);
    fetchQuestions(selectedCat);
  }
}
</script>
</body>
</html>