<?php
session_start();
require_once __DIR__ . '/visitor.php';
require_once __DIR__ . '/includes/config.php';

$sessionUser = null;
if (!empty($_SESSION['user_id'])) {
    $sessionUser = [
        'id'      => $_SESSION['user_id'],
        'name'    => $_SESSION['user_name'] ?? '',
        'email'   => $_SESSION['user_email'] ?? '',
        'plan'    => $_SESSION['plan_type'] ?? 'free',
        'status'  => $_SESSION['subscription_status'] ?? 'inactive',
    ];
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$sessionUser['id']]);
        $row = $stmt->fetch();
        if ($row) {
            $sessionUser['name']   = $row['name'] ?? $sessionUser['name'];
            $sessionUser['email']  = $row['email'] ?? $sessionUser['email'];
            $sessionUser['plan']   = $row['plan_type'] ?? $sessionUser['plan'];
            $sessionUser['status'] = $row['subscription_status'] ?? $sessionUser['status'];
        }
    } catch (\Throwable $e) {}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>Rules of the Road — Full Table of Contents | Japan Driving License Guide (Sinhala/English)</title>
<meta name="description" content="The complete chapter-by-chapter table of contents for Japan's official Rules of the Road driving manual, in English and Sinhala — pedestrian rules, licensing, driving technique, expressways, motorcycles, accidents and more.">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://menkyoo.jp/lessons/rules-of-the-road-toc.php">
<meta name="theme-color" content="#0F2F6E">
<?php include __DIR__ . '/includes/theme.php'; ?>
<style>
  details > summary{ list-style:none; cursor:pointer; }
  details > summary::-webkit-details-marker{ display:none; }
  details[open] .chev{ transform:rotate(90deg); }
  .chev{ transition: transform .2s ease; }
  .chapter-num{
    width:2.5rem; height:2.5rem; border-radius:.75rem;
    background: linear-gradient(135deg, #0F2F6E 0%, #16407F 100%);
    color:#fff; display:flex; align-items:center; justify-content:center;
    font-family:'Space Grotesk',sans-serif; font-weight:700; font-size:1rem; flex-shrink:0;
  }
  .link-card{ transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease; }
  .link-card:hover{ transform: translateY(-3px); box-shadow: 0 14px 28px -16px rgba(15,47,110,.35); border-color: rgba(15,47,110,.3); }
  .link-icon{
    width:3.25rem; height:3.25rem; border-radius:1rem;
    background: linear-gradient(135deg, #0F2F6E 0%, #16407F 100%);
    color:#fff; display:flex; align-items:center; justify-content:center;
    font-size:1.5rem; flex-shrink:0;
  }
</style>
</head>
<body class="bg-paper text-ink font-body min-h-screen flex flex-col">
<script>window.__USER__ = <?php echo $sessionUser ? json_encode($sessionUser, JSON_UNESCAPED_UNICODE) : 'null'; ?>;</script>

<header class="sticky top-0 z-40 bg-primary text-white shadow-lg shadow-primary/10">
  <div class="max-w-5xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-3">
    <a href="../index.php" class="flex items-center gap-2 shrink-0">
      <svg width="30" height="30" viewBox="0 0 48 48" fill="none" aria-hidden="true"><circle cx="24" cy="24" r="21" stroke="#F2A73B" stroke-width="3"/><circle cx="24" cy="24" r="5.5" fill="#F2A73B"/><path d="M24 3v10M24 35v10M3 24h10M35 24h10M9.5 9.5l7 7M31.5 31.5l7 7M9.5 38.5l7-7M31.5 16.5l7-7" stroke="#F2A73B" stroke-width="2.5" stroke-linecap="round"/></svg>
      <span class="font-display font-bold leading-tight text-sm sm:text-base">Menkyoo.jp</span>
    </a>
    <div class="flex items-center gap-2 sm:gap-3">
      <div class="bg-white/10 p-1 rounded-lg flex text-xs sm:text-sm">
        <button id="btn-en" onclick="setLanguage('en')" class="px-2.5 sm:px-3 py-1 rounded-md bg-white text-primary font-semibold transition">EN</button>
        <button id="btn-si" onclick="setLanguage('si')" class="px-2.5 sm:px-3 py-1 rounded-md text-white font-semibold transition font-si">සිං</button>
      </div>
      <?php if ($sessionUser): ?>
        <a href="../dashboard.php" class="text-xs sm:text-sm font-semibold px-3 py-2 rounded-lg hover:bg-white/10 transition">Dashboard</a>
      <?php else: ?>
        <a href="../login.php" class="text-xs sm:text-sm font-semibold bg-accent text-ink px-3 sm:px-4 py-2 rounded-lg hover:brightness-95 transition">Log in</a>
      <?php endif; ?>
    </div>
  </div>
</header>

<main class="flex-grow w-full max-w-3xl mx-auto px-4 sm:px-6 py-10 sm:py-14">

  <!-- Hero -->
  <div class="text-center mb-10 rise-in">
    <span class="inline-block text-[11px] font-bold tracking-widest uppercase bg-accent-light text-primary px-3 py-1 rounded-full border border-accent/40 mb-3" data-en="Official Rules of the Road" data-si="නිල මාර්ග නීති අත්පොත">Official Rules of the Road</span>
    <h1 class="font-display font-bold text-2xl sm:text-3xl text-ink" data-en="Study Resources" data-si="අධ්‍යයන සම්පත්">Study Resources</h1>
    <p class="text-sm text-ink/60 mt-2 max-w-xl mx-auto" data-en="Pick a resource below to start studying." data-si="පහත සම්පතක් තෝරාගෙන අධ්‍යයනය ආරම්භ කරන්න.">Pick a resource below to start studying.</p>
  </div>

  <div class="space-y-4">

    <!-- Card 1: JAF License Translation -->
    <a href="/jaf_license_translation.php" class="link-card block bg-white rounded-2xl border border-black/5 shadow-sm p-5 rise-in">
      <div class="flex items-center gap-4">
        <span class="link-icon">📘</span>
        <span class="flex-1 min-w-0">
          <span class="block font-display font-bold text-base sm:text-lg text-ink" data-en="JAF License Translation Guide" data-si="JAF බලපත්‍ර පරිවර්තන මාර්ගෝපදේශය">JAF License Translation Guide</span>
          <span class="block text-xs sm:text-sm text-ink/50 mt-1 font-si" data-en="ශ්‍රී ලංකා රියදුරු බලපත්‍රය JAF හරහා පරිවර්තනය කරගන්නේ කෙසේද යන්න පියවරෙන් පියවර" data-si="Step-by-step guide to getting your Sri Lankan license translated through JAF">ශ්‍රී ලංකා රියදුරු බලපත්‍රය JAF හරහා පරිවර්තනය කරගන්නේ කෙසේද යන්න පියවරෙන් පියවර</span>
        </span>
        <span class="chev text-ink/30 shrink-0 text-xl">›</span>
      </div>
    </a>

    <!-- Card 2: Road Signs Guide -->
    <a href="/road-signs-in-japan.php" class="link-card block bg-white rounded-2xl border border-black/5 shadow-sm p-5 rise-in">
      <div class="flex items-center gap-4">
        <span class="link-icon">🛣️</span>
        <span class="flex-1 min-w-0">
          <span class="block font-display font-bold text-base sm:text-lg text-ink" data-en="Japan Road Signs Guide" data-si="ජපානයේ මාර්ග සලකුණු මාර්ගෝපදේශය">Japan Road Signs Guide</span>
          <span class="block text-xs sm:text-sm text-ink/50 mt-1 font-si" data-en="සියලුම මාර්ග සලකුණු රූප සමඟ, සිංහලෙන් සහ ඉංග්‍රීසියෙන් පැහැදිලි කර ඇත" data-si="Every official road sign explained with images, in Sinhala and English">සියලුම මාර්ග සලකුණු රූප සමඟ, සිංහලෙන් සහ ඉංග්‍රීසියෙන් පැහැදිලි කර ඇත</span>
        </span>
        <span class="chev text-ink/30 shrink-0 text-xl">›</span>
      </div>
    </a>

  </div>

  <!-- Footer Actions -->
  <div class="mt-10 pt-6 border-t border-black/10 flex flex-col sm:flex-row items-center justify-between gap-4">
    <a href="../lessons.php" class="text-sm font-semibold text-primary hover:underline" data-en="← Back to All Lessons" data-si="← සියලුම පාඩම් වෙත යන්න">← Back to All Lessons</a>
    <a href="../index.php" class="bg-primary hover:bg-primary-dark text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition shadow-md" data-en="Start Free Practice Quiz →" data-si="නොමිලේ පරීක්ෂණය අරඹන්න →">Start Free Practice Quiz →</a>
  </div>

</main>

<?php include __DIR__ . '/includes/site-footer.php'; ?>

<script>
let currentLang = 'en';

function setLanguage(lang) {
  currentLang = lang;
  document.getElementById('btn-en').className = "px-2.5 sm:px-3 py-1 rounded-md font-semibold transition " + (lang === 'en' ? 'bg-white text-primary' : 'text-white');
  document.getElementById('btn-si').className = "px-2.5 sm:px-3 py-1 rounded-md font-semibold transition font-si " + (lang === 'si' ? 'bg-white text-primary' : 'text-white');

  document.querySelectorAll('[data-en]').forEach(el => {
    const txt = lang === 'si' ? (el.getAttribute('data-si') || el.getAttribute('data-en')) : el.getAttribute('data-en');
    el.innerText = txt;
  });
  document.documentElement.lang = lang;
}
</script>
</body>
</html>