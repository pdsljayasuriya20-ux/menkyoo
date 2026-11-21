<?php
session_start();
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/visitor.php'; // keep consistent with rest of site (safe to remove if not present)

/* Pull every sign, grouped by category, ordered the way we want them shown */
$stmt = $pdo->query("SELECT * FROM all_signs ORDER BY category, sort_order, sign_code");
$allSigns = $stmt->fetchAll();

$categories = [
    'information' => ['en' => 'Information Signs', 'si' => 'මාර්ග උපදේශන සලකුණු', 'icon' => '🛣️'],
    'warning'     => ['en' => 'Warning Signs',     'si' => 'අවවාද සලකුණු',       'icon' => '⚠️'],
    'regulatory'  => ['en' => 'Regulatory Signs',  'si' => 'නියාමන සලකුණු',      'icon' => '🚫'],
    'instruction' => ['en' => 'Instruction Signs', 'si' => 'උපදෙස් සලකුණු',      'icon' => '➡️'],
    'auxiliary'   => ['en' => 'Auxiliary Signs',   'si' => 'අතිරේක සලකුණු',      'icon' => '🔖'],
];

/* Group signs by category for easy rendering */
$grouped = [];
foreach ($allSigns as $sign) {
    $grouped[$sign['category']][] = $sign;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">

<title>Japan Road Signs Guide (Sinhala) | ජපානයේ මාර්ග සලකුණු මාර්ගෝපදේශය — Menkyoo.jp</title>
<meta name="description" content="ජපානයේ රියදුරු බලපත්‍ර විභාගය සඳහා අවශ්‍ය සියලුම මාර්ග සලකුණු (Road Signs) සිංහලෙන් සහ ඉංග්‍රීසියෙන් - රූප සමඟ. Complete Japan road sign guide in Sinhala and English.">
<link rel="canonical" href="https://menkyoo.jp/road-signs-in-japan.php">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=Noto+Sans+Sinhala:wght@400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = { theme: { extend: {
    colors: { ink:'#101A30', paper:'#F6F5F1', primary:{DEFAULT:'#0F2F6E',light:'#E7ECFA',dark:'#0A2050'}, accent:{DEFAULT:'#F2A73B',light:'#FDF1DD'}, go:'#1C8F5A', stop:'#D5432E' },
    fontFamily: { display:['"Space Grotesk"','sans-serif'], body:['"Inter"','"Noto Sans Sinhala"','sans-serif'], si:['"Noto Sans Sinhala"','sans-serif'] }
  }}}
</script>
<style>
  :root{ color-scheme: light; }
  html{ scroll-behavior: smooth; }
  body{ background:#F6F5F1; }
  .font-si, [data-si]{ font-family:'Noto Sans Sinhala', sans-serif; }
  .grid-texture{
    background-image:
      linear-gradient(to right, rgba(15,47,110,0.06) 1px, transparent 1px),
      linear-gradient(to bottom, rgba(15,47,110,0.06) 1px, transparent 1px);
    background-size: 28px 28px;
  }
  .sign-card{ transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease; cursor: pointer; }
  .sign-card:hover{ transform: translateY(-3px); box-shadow: 0 12px 26px -14px rgba(15,47,110,.35); border-color: rgba(15,47,110,.3); }
  .sign-img-wrap{ position: relative; background:
      linear-gradient(45deg, #fff 25%, transparent 25%), linear-gradient(-45deg, #fff 25%, transparent 25%),
      linear-gradient(45deg, transparent 75%, #fff 75%), linear-gradient(-45deg, transparent 75%, #fff 75%);
    background-size: 16px 16px; background-position: 0 0, 0 8px, 8px -8px, -8px 0; background-color:#f1f0ea;
  }
  .cat-tab{ transition: all .2s ease; }
  .cat-tab.active{ background:#0F2F6E; color:#fff; }
  @media (prefers-reduced-motion: reduce){ html{scroll-behavior:auto;} }

  /* ---------- Copy / screenshot deterrents ---------- */
  /* Note: a screenshot can never be fully blocked by a website (OS/browser level control),
     this just raises friction and stamps a watermark so reused images are traceable. */
  * { -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; }
  input, textarea { -webkit-user-select: text; user-select: text; }
  img { -webkit-user-drag: none; user-drag: none; pointer-events: none; -webkit-touch-callout: none; }
  .sign-img-wrap::after{
    content: "MENKYOO.JP";
    position: absolute; inset: 0;
    display: flex; align-items: center; justify-content: center;
    font-family: 'Space Grotesk', sans-serif;
    font-size: 11px; font-weight: 800; letter-spacing: 2px;
    color: rgba(15,47,110,0.14);
    transform: rotate(-20deg);
    pointer-events: none;
  }
  #modalImgWrap::after{ font-size: 16px; }
  @media print {
    body::before{
      content: "Menkyoo.jp — printing is disabled for this page.";
      display:block; text-align:center; padding: 3rem 1rem; font-family: sans-serif; font-size: 1.1rem;
    }
    header, main, footer, #signModalOverlay { display: none !important; }
  }
</style>
</head>
<body class="bg-paper text-ink font-body min-h-screen flex flex-col">

<!-- ============ NAV (matches site header) ============ -->
<header class="sticky top-0 z-40 bg-primary text-white shadow-lg shadow-primary/10">
  <div class="max-w-5xl mx-auto px-3 sm:px-6 h-16 flex items-center justify-between gap-2 sm:gap-3">
    <a href="index.php" class="flex items-center gap-2 shrink-0 min-w-0">
      <svg width="30" height="30" viewBox="0 0 48 48" fill="none" aria-hidden="true" class="shrink-0"><circle cx="24" cy="24" r="21" stroke="#F2A73B" stroke-width="3"/><circle cx="24" cy="24" r="5.5" fill="#F2A73B"/><path d="M24 3v10M24 35v10M3 24h10M35 24h10M9.5 9.5l7 7M31.5 31.5l7 7M9.5 38.5l7-7M31.5 16.5l7-7" stroke="#F2A73B" stroke-width="2.5" stroke-linecap="round"/></svg>
      <span class="font-display font-bold leading-tight text-sm sm:text-base truncate">Menkyoo.jp</span>
    </a>
    <div class="flex items-center gap-1 sm:gap-3 shrink-0">
      <a href="index.php" class="text-xs sm:text-sm font-semibold text-white/90 hover:text-white transition px-1 sm:px-2" data-en="Quiz" data-si="ප්‍රශ්නාවලිය">Quiz</a>
      <a href="lessons.php" class="text-xs sm:text-sm font-semibold text-white/90 hover:text-white transition px-1 sm:px-2" data-en="Lessons" data-si="පාඩම්">Lessons</a>
      <div class="bg-white/10 p-1 rounded-lg flex text-xs sm:text-sm">
        <button id="btn-en" onclick="setLanguage('en')" class="px-2 sm:px-3 py-1 rounded-md bg-white text-primary font-semibold transition">EN</button>
        <button id="btn-si" onclick="setLanguage('si')" class="px-2 sm:px-3 py-1 rounded-md text-white font-semibold transition font-si">සිං</button>
      </div>
    </div>
  </div>
</header>

<main class="flex-grow w-full">

  <!-- ============ HERO / TEACHER INTRO ============ -->
  <div class="grid-texture border-b border-black/5">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 pt-10 sm:pt-14 pb-8 sm:pb-10 text-center">
      <span class="inline-block text-[11px] font-bold tracking-widest uppercase bg-accent-light text-primary px-3 py-1 rounded-full border border-accent/40 mb-4" data-en="Sinhala + English Guide" data-si="සිංහල + ඉංග්‍රීසි මාර්ගෝපදේශය">Sinhala + English Guide</span>
      <h1 class="font-display font-bold text-3xl sm:text-4xl md:text-5xl text-ink leading-tight" data-en="Japan Road Signs — Explained Sign by Sign" data-si="ජපානයේ මාර්ග සලකුණු">
        Japan Road Signs — Explained Sign by Sign
      </h1>
      <div class="mt-5 max-w-2xl mx-auto text-left bg-white border border-black/5 rounded-2xl p-4 sm:p-5 shadow-sm">
        <p class="text-sm sm:text-base text-ink/70 leading-relaxed font-si" data-si="ආයුබෝවන්!  ජපානයේ මාර්ග සලකුණු මුලින්ම බැලුවහම ටිකක් අමාරු වගේ පෙනුනත්, ඒවා පහසුවෙන් මතක තියාගන්න පුළුවන් - මොකද සෑම හැඩයක්ම (චතුරස්‍රය, ත්‍රිකෝණය, රවුම) සහ වර්ණයක්ම (රතු, කහ, නිල්) වෙනම අර්ථයක් දරනවා. පහත ලැයිස්තුවේ Category එකකින් එකක් අනුව, රූපය බලලා, තේරුම කියවලා පුරුදු වෙන්න. එහෙනම් Karimen/Honmen විභාගයේදී ඔබට ලේසියෙන්ම හඳුනාගන්න පුළුවන් වේවි. Ganbatte! 頑張って！">
          ආයුබෝවන්! ජපානයේ මාර්ග සලකුණු මුලින්ම බැලුවහම ටිකක් අමාරු වගේ පෙනුනත්, ඒවා පහසුවෙන් මතක තියාගන්න පුළුවන් — මොකද සෑම හැඩයක්ම (චතුරස්‍රය, ත්‍රිකෝණය, රවුම) සහ වර්ණයක්ම (රතු, කහ, නිල්) වෙනම අර්ථයක් දරනවා. පහත Category එකකින් එකක් අනුව, රූපය බලලා, තේරුම කියවලා පුරුදු වෙන්න. එහෙනම් Karimen/Honmen විභාගයේදී ඔබට ලේසියෙන්ම හඳුනාගන්න පුළුවන් වේවි. Ganbatte! 頑張って！
        </p>
        <p class="text-xs text-ink/40 mt-3 font-si" data-si="සලකුණක් මත click කරලා පොඩි විස්තරයක් බලන්න.">Tap any sign to see a bit more detail.</p>
      </div>

      <!-- Legend / shape-color key -->
      <div class="mt-6 grid grid-cols-2 sm:grid-cols-5 gap-2 text-left max-w-3xl mx-auto">
        <div class="bg-white border border-black/5 rounded-xl p-3">
          <p class="text-xs font-bold text-primary">🛣️ <span data-en="Blue Square" data-si="නිල් හතරැස්">Blue Square</span></p>
          <p class="text-[11px] text-ink/50 mt-0.5 font-si" data-si="උපදේශනය">Information</p>
        </div>
        <div class="bg-white border border-black/5 rounded-xl p-3">
          <p class="text-xs font-bold text-accent-dark">⚠️ <span data-en="Yellow Triangle" data-si="කහ ත්‍රිකෝණය">Yellow Triangle</span></p>
          <p class="text-[11px] text-ink/50 mt-0.5 font-si" data-si="අවවාදය">Warning</p>
        </div>
        <div class="bg-white border border-black/5 rounded-xl p-3">
          <p class="text-xs font-bold text-stop">🚫 <span data-en="Red Circle" data-si="රතු රවුම">Red Circle</span></p>
          <p class="text-[11px] text-ink/50 mt-0.5 font-si" data-si="නියාමනය">Regulatory</p>
        </div>
        <div class="bg-white border border-black/5 rounded-xl p-3">
          <p class="text-xs font-bold text-go">➡️ <span data-en="Blue Circle" data-si="නිල් රවුම">Blue Circle</span></p>
          <p class="text-[11px] text-ink/50 mt-0.5 font-si" data-si="උපදෙස්">Instruction</p>
        </div>
        <div class="bg-white border border-black/5 rounded-xl p-3 col-span-2 sm:col-span-1">
          <p class="text-xs font-bold text-ink">🔖 <span data-en="Small Plate" data-si="කුඩා පුවරුව">Small Plate</span></p>
          <p class="text-[11px] text-ink/50 mt-0.5 font-si" data-si="අතිරේකය">Auxiliary</p>
        </div>
      </div>
    </div>
  </div>

  <!-- ============ CATEGORY TABS ============ -->
  <div class="sticky top-16 z-30 bg-paper/95 backdrop-blur border-b border-black/5">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 py-3 flex gap-2 overflow-x-auto no-scrollbar">
      <button class="cat-tab active shrink-0 px-4 py-2 rounded-full text-xs sm:text-sm font-semibold border border-black/10 bg-white" data-cat="all" onclick="filterCategory('all')">
        <span data-en="All Signs" data-si="සියල්ල">All Signs</span>
      </button>
      <?php foreach ($categories as $key => $cat): ?>
      <button class="cat-tab shrink-0 px-4 py-2 rounded-full text-xs sm:text-sm font-semibold border border-black/10 bg-white" data-cat="<?php echo $key; ?>" onclick="filterCategory('<?php echo $key; ?>')">
        <?php echo $cat['icon']; ?> <span data-en="<?php echo htmlspecialchars($cat['en']); ?>" data-si="<?php echo htmlspecialchars($cat['si']); ?>"><?php echo htmlspecialchars($cat['en']); ?></span>
      </button>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- ============ SIGNS GRID (grouped by category) ============ -->
  <div class="max-w-5xl mx-auto px-4 sm:px-6 py-8 sm:py-10">

    <?php if (empty($allSigns)): ?>
      <div class="text-center py-16 bg-white rounded-2xl border border-black/5">
        <p class="text-ink/60 font-si" data-si="දත්ත සමුදායේ තවම මාර්ග සලකුණු එකතු කර නැත. all_signs.sql ෆයිල් එක import කරන්න.">No signs found in the database yet. Please import all_signs.sql.</p>
      </div>
    <?php endif; ?>

    <?php foreach ($categories as $key => $cat):
        if (empty($grouped[$key])) continue; ?>
    <section class="sign-category-section mb-10" data-cat-section="<?php echo $key; ?>">
      <div class="flex items-center gap-3 mb-4">
        <span class="text-2xl"><?php echo $cat['icon']; ?></span>
        <div>
          <h2 class="font-display font-bold text-lg sm:text-xl text-ink" data-en="<?php echo htmlspecialchars($cat['en']); ?>" data-si="<?php echo htmlspecialchars($cat['si']); ?>"><?php echo htmlspecialchars($cat['en']); ?></h2>
          <p class="text-xs text-ink/40 font-mono"><?php echo count($grouped[$key]); ?> <span data-en="signs" data-si="සලකුණු">signs</span></p>
        </div>
      </div>

      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
        <?php foreach ($grouped[$key] as $sign):
            $nameJa = $sign['name_ja'] ?? '';
            $romaji = $sign['name_ja_romaji'] ?? '';
        ?>
        <div class="sign-card bg-white border border-black/5 rounded-xl overflow-hidden shadow-sm"
             onclick="openSignModal(this)"
             data-code="<?php echo htmlspecialchars($sign['sign_code']); ?>"
             data-name-en="<?php echo htmlspecialchars($sign['name_en']); ?>"
             data-name-si="<?php echo htmlspecialchars($sign['name_si']); ?>"
             data-name-ja="<?php echo htmlspecialchars($nameJa); ?>"
             data-romaji="<?php echo htmlspecialchars($romaji); ?>"
             data-img="images/signs/<?php echo htmlspecialchars($sign['image_file']); ?>"
             data-cat-icon="<?php echo htmlspecialchars($cat['icon']); ?>"
             data-cat-en="<?php echo htmlspecialchars($cat['en']); ?>"
             data-cat-si="<?php echo htmlspecialchars($cat['si']); ?>">
          <div class="sign-img-wrap aspect-square flex items-center justify-center p-3">
            <img
              src="images/signs/<?php echo htmlspecialchars($sign['image_file']); ?>"
              alt="<?php echo htmlspecialchars($sign['sign_code'] . ' - ' . $sign['name_en']); ?>"
              loading="lazy"
              class="max-h-full max-w-full object-contain"
              oncontextmenu="return false;"
              onerror="this.onerror=null;this.src='images/signs/placeholder.png';this.classList.add('opacity-40');">
          </div>
          <div class="p-3 border-t border-black/5">
            <p class="text-[10px] font-mono font-bold text-primary/70 mb-0.5">(<?php echo htmlspecialchars($sign['sign_code']); ?>)</p>
            <p class="text-xs sm:text-sm font-semibold text-ink leading-snug" data-en="<?php echo htmlspecialchars($sign['name_en']); ?>" data-si="<?php echo htmlspecialchars($sign['name_si']); ?>"><?php echo htmlspecialchars($sign['name_en']); ?></p>
            <p class="text-[11px] text-ink/40 mt-1 font-si"><?php echo htmlspecialchars($sign['name_si']); ?></p>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </section>
    <?php endforeach; ?>

  </div>

  <!-- ============ CTA back to quiz ============ -->
  <div class="max-w-2xl mx-auto px-4 sm:px-6 pb-14">
    <div class="bg-gradient-to-br from-primary via-primary-dark to-ink text-white rounded-2xl shadow-xl p-6 sm:p-8 text-center">
      <h3 class="font-display font-bold text-lg sm:text-xl mb-2" data-en="Now test what you learned" data-si="දැන් ඉගෙනගත් දේ පරීක්ෂා කරමු">Now test what you learned</h3>
      <p class="text-xs sm:text-sm text-white/70 mb-5 font-si" data-si="මතකයේ තියෙනවද බලමු — ප්‍රශ්නාවලියට යන්න.">See if it stuck — go take the practice quiz.</p>
      <a href="index.php" class="inline-block bg-accent hover:brightness-95 text-ink font-bold px-6 py-3 rounded-xl text-sm transition">
        <span data-en="Go to Practice Quiz →" data-si="පුහුණු ප්‍රශ්නාවලියට →">Go to Practice Quiz →</span>
      </a>
    </div>
  </div>

</main>

<footer class="text-center py-8 text-xs text-ink/40 border-t border-black/5 bg-white space-y-2">
  <p>Japan Driving License Practice System &copy; <?php echo date('Y'); ?></p>
  <p class="mt-1 font-si" data-si="ජපානයේ රියදුරු බලපත්‍ර විභාගය සඳහා සූදානම් වන ශ්‍රී ලාංකිකයන් සඳහා නිර්මාණය කර ඇත.">Made for Sri Lankan drivers preparing for Japan's theory test.</p>
</footer>

<!-- ============ SIGN DETAIL MODAL ============ -->
<div id="signModalOverlay" class="hidden fixed inset-0 z-50 bg-ink/70 backdrop-blur-sm flex items-center justify-center p-4" onclick="if(event.target===this) closeSignModal();">
  <div class="bg-white rounded-2xl max-w-sm w-full overflow-hidden shadow-2xl relative">
    <button onclick="closeSignModal()" aria-label="Close" class="absolute top-3 right-3 w-8 h-8 rounded-full bg-black/5 hover:bg-black/10 flex items-center justify-center text-ink/60 text-lg leading-none z-10">&times;</button>

    <div id="modalImgWrap" class="sign-img-wrap aspect-square flex items-center justify-center p-6">
      <img id="modalImg" src="" alt="" class="max-h-full max-w-full object-contain" oncontextmenu="return false;" draggable="false">
    </div>

    <div class="p-5 border-t border-black/5">
      <div class="flex items-center gap-2 mb-2">
        <span id="modalCatIcon" class="text-lg"></span>
        <p id="modalCat" class="text-[11px] font-bold text-accent-dark uppercase tracking-wide font-si"></p>
      </div>
      <p id="modalCode" class="text-[11px] font-mono font-bold text-primary/70 mb-2"></p>

      <p id="modalSi" class="text-lg sm:text-xl font-bold text-ink font-si leading-snug"></p>
      <p id="modalEn" class="text-xs text-ink/50 mt-1"></p>

      <div id="modalJaWrap" class="hidden mt-3 pt-3 border-t border-black/5">
        <p id="modalJa" class="text-sm text-ink/70"></p>
        <p id="modalRomaji" class="text-xs text-ink/40 italic mt-0.5"></p>
      </div>
    </div>
  </div>
</div>

<script>
const uiState = { lang: 'en' };

function applyTranslations() {
  document.querySelectorAll('[data-en]').forEach(el => {
    const txt = uiState.lang === 'si' ? (el.getAttribute('data-si') || el.getAttribute('data-en')) : el.getAttribute('data-en');
    el.innerText = txt;
  });
}

function setLanguage(lang) {
  uiState.lang = lang;
  document.getElementById('btn-en').className = "px-2 sm:px-3 py-1 rounded-md font-semibold transition " + (lang === 'en' ? 'bg-white text-primary' : 'text-white');
  document.getElementById('btn-si').className = "px-2 sm:px-3 py-1 rounded-md font-semibold transition font-si " + (lang === 'si' ? 'bg-white text-primary' : 'text-white');
  applyTranslations();
  document.documentElement.lang = lang;
}

function filterCategory(cat) {
  document.querySelectorAll('.cat-tab').forEach(btn => btn.classList.toggle('active', btn.dataset.cat === cat));
  document.querySelectorAll('.sign-category-section').forEach(section => {
    section.style.display = (cat === 'all' || section.dataset.catSection === cat) ? '' : 'none';
  });
  if (cat !== 'all') {
    document.querySelector(`[data-cat-section="${cat}"]`)?.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
}

/* ---------- Sign detail modal ---------- */
function openSignModal(card) {
  const d = card.dataset;

  document.getElementById('modalImg').src = d.img;
  document.getElementById('modalImg').alt = d.code + ' - ' + d.nameEn;

  document.getElementById('modalCatIcon').innerText = d.catIcon;
  document.getElementById('modalCat').innerText = uiState.lang === 'si' ? d.catSi : d.catEn;
  document.getElementById('modalCode').innerText = '(' + d.code + ')';

  document.getElementById('modalSi').innerText = d.nameSi;
  document.getElementById('modalEn').innerText = d.nameEn;

  const jaWrap = document.getElementById('modalJaWrap');
  if (d.nameJa) {
    jaWrap.classList.remove('hidden');
    document.getElementById('modalJa').innerText = d.nameJa;
    document.getElementById('modalRomaji').innerText = d.romaji ? '(' + d.romaji + ')' : '';
  } else {
    jaWrap.classList.add('hidden');
  }

  document.getElementById('signModalOverlay').classList.remove('hidden');
  document.body.style.overflow = 'hidden';
}

function closeSignModal() {
  document.getElementById('signModalOverlay').classList.add('hidden');
  document.body.style.overflow = '';
}

document.addEventListener('keydown', e => {
  if (e.key === 'Escape') closeSignModal();
});

/* ---------- Copy / screenshot / devtools deterrents ----------
   Honest note: none of this can technically stop a screenshot (that's an
   OS/browser-level action outside any website's control). This just makes
   casual copy-paste and right-click saving harder, and stamps a watermark
   onto every sign image so anything that does get screenshotted still
   carries the site's mark. */
document.addEventListener('contextmenu', e => e.preventDefault());
document.addEventListener('dragstart', e => e.preventDefault());
document.addEventListener('selectstart', e => {
  if (!['INPUT', 'TEXTAREA'].includes(e.target.tagName)) e.preventDefault();
});
document.addEventListener('copy', e => {
  if (!['INPUT', 'TEXTAREA'].includes(e.target.tagName)) e.preventDefault();
});
document.addEventListener('keydown', e => {
  const k = e.key.toLowerCase();
  if (e.key === 'F12') e.preventDefault();
  if ((e.ctrlKey || e.metaKey) && e.shiftKey && ['i', 'j', 'c'].includes(k)) e.preventDefault();
  if ((e.ctrlKey || e.metaKey) && ['s', 'u', 'p'].includes(k)) e.preventDefault();
});

window.onload = () => { applyTranslations(); };
</script>
</body>
</html>