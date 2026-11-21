<?php
session_start();

/* ---------- Advertise page: packages + WhatsApp auto-message ---------- */
// WhatsApp number 090-5029-5822 in international format (Japan = 81, drop the leading 0)
$WA_NUMBER = '819050295822';
$WA_DISPLAY = '090-5029-5822';

$packages = [
    'home_6m'  => ['place' => 'home', 'months' => 6,  'price' => 2000],
    'home_12m' => ['place' => 'home', 'months' => 12, 'price' => 5000],
    'all_6m'   => ['place' => 'all',  'months' => 6,  'price' => 5000],
    'all_12m'  => ['place' => 'all',  'months' => 12, 'price' => 10000],
];

/* English fallback link (works even if JavaScript is off). JS rebuilds it in the chosen language. */
function waLinkEn(string $number, array $pkg): string {
    $placeEn = $pkg['place'] === 'home' ? 'Home page' : 'Home page + all inside pages';
    $periodEn = $pkg['months'] === 12 ? '1 year' : '6 months';
    $msg = "Hello Menkyoo.jp,\nI would like to advertise on your website.\n\n"
         . "Package: {$placeEn} – {$periodEn} (¥" . number_format($pkg['price']) . ")\n\n"
         . "Business / ad name:\nContact number:\n\n"
         . "Please send me the details and how to activate it.";
    return 'https://wa.me/' . $number . '?text=' . rawurlencode($msg);
}
$generalMsgEn = "Hello Menkyoo.jp,\nI would like to know more about advertising on your website. Please send me the details.";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Advertise on Menkyoo.jp | දැන්වීම් පළ කරන්න</title>
    <meta name="description" content="Advertise your business to Sri Lankan learners preparing for Japan's driving license test. Home page ads from ¥2,000 for 6 months.">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://menkyoo.jp/ad.php">
    <meta name="theme-color" content="#0F2F6E">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=Noto+Sans+Sinhala:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = { theme: { extend: {
        colors: { ink:'#101A30', paper:'#F6F5F1', primary:{DEFAULT:'#0F2F6E',light:'#E7ECFA',dark:'#0A2050'}, accent:{DEFAULT:'#F2A73B',light:'#FDF1DD',dark:'#C47F12'}, go:'#1C8F5A', stop:'#D5432E', wa:'#25D366' },
        fontFamily: { display:['"Space Grotesk"','sans-serif'], body:['"Inter"','"Noto Sans Sinhala"','sans-serif'], si:['"Noto Sans Sinhala"','sans-serif'], mono:['"JetBrains Mono"','monospace'] }
      }}}
    </script>
    <style>
      body{ font-family:'Inter','Noto Sans Sinhala',sans-serif; background:#F6F5F1; }
      .font-si{ font-family:'Noto Sans Sinhala',sans-serif; }
      html{ scroll-behavior:smooth; }
      .grid-texture{
        background-image:
          linear-gradient(to right, rgba(15,47,110,0.06) 1px, transparent 1px),
          linear-gradient(to bottom, rgba(15,47,110,0.06) 1px, transparent 1px);
        background-size: 28px 28px;
      }
      *:focus-visible{ outline:3px solid #F2A73B; outline-offset:2px; }
      @keyframes riseIn{ from{opacity:0; transform:translateY(10px);} to{opacity:1; transform:translateY(0);} }
      .rise-in{ animation:riseIn .35s ease-out both; }
      @media (prefers-reduced-motion: reduce){ .rise-in{animation:none;} html{scroll-behavior:auto;} }
      .price-card{ transition: box-shadow .2s ease, transform .2s ease, border-color .2s ease; }
      .price-card:hover{ transform:translateY(-2px); box-shadow:0 14px 30px -16px rgba(15,47,110,.45); border-color:rgba(15,47,110,.3); }
    </style>
</head>
<body class="text-ink font-body min-h-screen flex flex-col overflow-x-hidden">

<!-- ============ NAV ============ -->
<header class="sticky top-0 z-40 bg-primary text-white shadow-lg shadow-primary/10">
  <div class="max-w-5xl mx-auto px-3 sm:px-6 h-16 flex items-center justify-between gap-2">
    <a href="index.php" class="flex items-center gap-2 shrink-0 min-w-0">
      <svg width="30" height="30" viewBox="0 0 48 48" fill="none" aria-hidden="true" class="shrink-0"><circle cx="24" cy="24" r="21" stroke="#F2A73B" stroke-width="3"/><circle cx="24" cy="24" r="5.5" fill="#F2A73B"/><path d="M24 3v10M24 35v10M3 24h10M35 24h10M9.5 9.5l7 7M31.5 31.5l7 7M9.5 38.5l7-7M31.5 16.5l7-7" stroke="#F2A73B" stroke-width="2.5" stroke-linecap="round"/></svg>
      <span class="font-display font-bold leading-tight text-sm sm:text-base truncate">Menkyoo.jp</span>
    </a>
    <div class="flex items-center gap-2 sm:gap-3 shrink-0">
      <a href="index.php" class="text-xs sm:text-sm font-semibold text-white/90 hover:text-white transition" data-en="← Back to site" data-si="← වෙබ් අඩවියට">← Back to site</a>
      <div class="bg-white/10 p-1 rounded-lg flex text-xs sm:text-sm">
        <button id="btn-en" onclick="setLanguage('en')" class="px-2 sm:px-3 py-1 rounded-md bg-white text-primary font-semibold transition">EN</button>
        <button id="btn-si" onclick="setLanguage('si')" class="px-2 sm:px-3 py-1 rounded-md text-white font-semibold transition font-si">සිං</button>
      </div>
    </div>
  </div>
</header>

<main class="flex-grow w-full">

  <!-- Hero -->
  <section class="grid-texture border-b border-black/5">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 pt-10 sm:pt-14 pb-10 text-center">
      <span class="inline-block text-[11px] font-bold tracking-widest uppercase bg-accent-light text-primary px-3 py-1 rounded-full border border-accent/40 mb-4" data-en="📢 Advertise with us" data-si="📢 අප සමඟ දැන්වීම් පළ කරන්න">📢 Advertise with us</span>
      <h1 class="font-display font-bold text-3xl sm:text-4xl text-ink leading-tight" data-en="Put your business in front of learners preparing for Japan's driving test" data-si="ජපානයේ රියදුරු බලපත්‍ර විභාගයට සූදානම් වන අයට ඔබේ ව්‍යාපාරය පෙන්වන්න">Put your business in front of learners preparing for Japan's driving test</h1>
      <p class="mt-4 text-sm sm:text-base text-ink/60 max-w-xl mx-auto" data-en="Menkyoo.jp is used every day by Sri Lankans living in Japan. Pick a package below and message us on WhatsApp — we'll reply with the details and activate your ad." data-si="Menkyoo.jp ජපානයේ වෙසෙන ශ්‍රී ලාංකිකයන් දිනපතා භාවිතා කරයි. පහත පැකේජයක් තෝරා WhatsApp හරහා අපට පණිවිඩයක් එවන්න — අපි විස්තර දැනුම් දී ඔබේ දැන්වීම activate කරන්නෙමු.">Menkyoo.jp is used every day by Sri Lankans living in Japan. Pick a package below and message us on WhatsApp — we'll reply with the details and activate your ad.</p>
    </div>
  </section>

  <div class="max-w-4xl mx-auto px-4 sm:px-6 py-10 space-y-10">

    <!-- Package group 1: Home page only -->
    <section class="rise-in">
      <div class="flex items-center gap-3 mb-4">
        <span class="text-2xl" aria-hidden="true">🏠</span>
        <div>
          <h2 class="font-display font-bold text-lg sm:text-xl" data-en="Home Page Ad" data-si="මුල් පිටුවේ දැන්වීම">Home Page Ad</h2>
          <p class="text-xs text-ink/50" data-en="Shown on the Menkyoo.jp home page only" data-si="Menkyoo.jp මුල් පිටුවේ පමණක් පෙන්වයි">Shown on the Menkyoo.jp home page only</p>
        </div>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

        <div class="price-card bg-white border border-black/5 rounded-2xl p-5 shadow-sm flex flex-col">
          <p class="text-xs font-bold uppercase tracking-widest text-ink/40" data-en="6 Months" data-si="මාස 6">6 Months</p>
          <p class="font-mono font-bold text-4xl text-primary mt-2">¥2,000</p>
          <p class="text-xs text-ink/50 mt-1" data-en="Home page · 6 months" data-si="මුල් පිටුව · මාස 6">Home page · 6 months</p>
          <a href="<?= htmlspecialchars(waLinkEn($WA_NUMBER, $packages['home_6m'])) ?>" target="_blank" rel="noopener" data-pkg="home_6m"
             class="wa-btn mt-5 inline-flex items-center justify-center gap-2 bg-wa hover:brightness-95 text-white font-bold text-sm py-3 rounded-xl transition">
            <span aria-hidden="true">💬</span><span data-en="Get this on WhatsApp" data-si="WhatsApp හරහා ලබාගන්න">Get this on WhatsApp</span>
          </a>
        </div>

        <div class="price-card bg-white border border-black/5 rounded-2xl p-5 shadow-sm flex flex-col">
          <p class="text-xs font-bold uppercase tracking-widest text-ink/40" data-en="1 Year" data-si="අවුරුදු 1">1 Year</p>
          <p class="font-mono font-bold text-4xl text-primary mt-2">¥5,000</p>
          <p class="text-xs text-ink/50 mt-1" data-en="Home page · 1 year" data-si="මුල් පිටුව · අවුරුදු 1">Home page · 1 year</p>
          <a href="<?= htmlspecialchars(waLinkEn($WA_NUMBER, $packages['home_12m'])) ?>" target="_blank" rel="noopener" data-pkg="home_12m"
             class="wa-btn mt-5 inline-flex items-center justify-center gap-2 bg-wa hover:brightness-95 text-white font-bold text-sm py-3 rounded-xl transition">
            <span aria-hidden="true">💬</span><span data-en="Get this on WhatsApp" data-si="WhatsApp හරහා ලබාගන්න">Get this on WhatsApp</span>
          </a>
        </div>

      </div>
    </section>

    <!-- Package group 2: Home + inside pages -->
    <section class="rise-in">
      <div class="flex items-center gap-3 mb-4">
        <span class="text-2xl" aria-hidden="true">🌐</span>
        <div>
          <h2 class="font-display font-bold text-lg sm:text-xl" data-en="Home + All Inside Pages" data-si="මුල් පිටුව + සියලුම අභ්‍යන්තර පිටු">Home + All Inside Pages</h2>
          <p class="text-xs text-ink/50" data-en="Maximum exposure — your ad appears across the whole site" data-si="උපරිම නිරාවරණය — ඔබේ දැන්වීම මුළු වෙබ් අඩවියේම පෙන්වයි">Maximum exposure — your ad appears across the whole site</p>
        </div>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

        <div class="price-card bg-white border-2 border-accent/60 rounded-2xl p-5 shadow-sm flex flex-col relative">
          <span class="absolute -top-2.5 left-4 bg-accent text-ink text-[10px] font-extrabold px-2.5 py-0.5 rounded-full" data-en="MOST VISIBLE" data-si="වැඩිම නිරාවරණය">MOST VISIBLE</span>
          <p class="text-xs font-bold uppercase tracking-widest text-ink/40" data-en="6 Months" data-si="මාස 6">6 Months</p>
          <p class="font-mono font-bold text-4xl text-primary mt-2">¥5,000</p>
          <p class="text-xs text-ink/50 mt-1" data-en="Home + inside pages · 6 months" data-si="මුල් පිටුව + අභ්‍යන්තර පිටු · මාස 6">Home + inside pages · 6 months</p>
          <a href="<?= htmlspecialchars(waLinkEn($WA_NUMBER, $packages['all_6m'])) ?>" target="_blank" rel="noopener" data-pkg="all_6m"
             class="wa-btn mt-5 inline-flex items-center justify-center gap-2 bg-wa hover:brightness-95 text-white font-bold text-sm py-3 rounded-xl transition">
            <span aria-hidden="true">💬</span><span data-en="Get this on WhatsApp" data-si="WhatsApp හරහා ලබාගන්න">Get this on WhatsApp</span>
          </a>
        </div>

        <div class="price-card bg-white border-2 border-accent/60 rounded-2xl p-5 shadow-sm flex flex-col relative">
          <span class="absolute -top-2.5 left-4 bg-accent text-ink text-[10px] font-extrabold px-2.5 py-0.5 rounded-full" data-en="MOST VISIBLE" data-si="වැඩිම නිරාවරණය">MOST VISIBLE</span>
          <p class="text-xs font-bold uppercase tracking-widest text-ink/40" data-en="1 Year" data-si="අවුරුදු 1">1 Year</p>
          <p class="font-mono font-bold text-4xl text-primary mt-2">¥10,000</p>
          <p class="text-xs text-ink/50 mt-1" data-en="Home + inside pages · 1 year" data-si="මුල් පිටුව + අභ්‍යන්තර පිටු · අවුරුදු 1">Home + inside pages · 1 year</p>
          <a href="<?= htmlspecialchars(waLinkEn($WA_NUMBER, $packages['all_12m'])) ?>" target="_blank" rel="noopener" data-pkg="all_12m"
             class="wa-btn mt-5 inline-flex items-center justify-center gap-2 bg-wa hover:brightness-95 text-white font-bold text-sm py-3 rounded-xl transition">
            <span aria-hidden="true">💬</span><span data-en="Get this on WhatsApp" data-si="WhatsApp හරහා ලබාගන්න">Get this on WhatsApp</span>
          </a>
        </div>

      </div>
    </section>

    <!-- How to activate -->
    <section class="bg-white border border-black/5 rounded-2xl p-5 sm:p-7 shadow-sm">
      <h2 class="font-display font-bold text-lg sm:text-xl mb-4" data-en="How to activate your ad" data-si="ඔබේ දැන්වීම activate කරගන්නා ආකාරය">How to activate your ad</h2>
      <ol class="space-y-4 text-sm">
        <li class="flex gap-3">
          <span class="shrink-0 w-7 h-7 rounded-full bg-primary text-white font-mono font-bold text-xs flex items-center justify-center">1</span>
          <span data-en="Tap a “Get this on WhatsApp” button above. A ready-made message opens in WhatsApp — just press send." data-si="ඉහත “WhatsApp හරහා ලබාගන්න” බොත්තමක් ඔබන්න. සූදානම් කළ පණිවිඩයක් WhatsApp හි විවෘත වේ — send කරන්න පමණයි.">Tap a “Get this on WhatsApp” button above. A ready-made message opens in WhatsApp — just press send.</span>
        </li>
        <li class="flex gap-3">
          <span class="shrink-0 w-7 h-7 rounded-full bg-primary text-white font-mono font-bold text-xs flex items-center justify-center">2</span>
          <span data-en="We reply with full details and payment information, and ask for your ad content (image or text, plus a link or phone number)." data-si="අපි සම්පූර්ණ විස්තර සහ ගෙවීම් තොරතුරු එවන අතර ඔබේ දැන්වීමේ අන්තර්ගතය (රූපයක් හෝ අකුරු, සමඟ link එකක් හෝ දුරකථන අංකයක්) ඉල්ලමු.">We reply with full details and payment information, and ask for your ad content (image or text, plus a link or phone number).</span>
        </li>
        <li class="flex gap-3">
          <span class="shrink-0 w-7 h-7 rounded-full bg-primary text-white font-mono font-bold text-xs flex items-center justify-center">3</span>
          <span data-en="Once payment is confirmed, your ad goes live and runs for the full period you chose." data-si="ගෙවීම තහවුරු වූ පසු ඔබේ දැන්වීම පළ වී ඔබ තෝරාගත් කාලය පුරා පෙන්වයි.">Once payment is confirmed, your ad goes live and runs for the full period you chose.</span>
        </li>
      </ol>
    </section>

    <!-- Just asking -->
    <section class="text-center bg-primary-light border border-primary/10 rounded-2xl p-6">
      <p class="font-display font-bold text-base sm:text-lg text-ink mb-1" data-en="Not sure which package fits? Ask us first." data-si="ඔබට ගැලපෙන පැකේජය මොකක්ද කියා විශ්වාස නැද්ද? මුලින් අහන්න.">Not sure which package fits? Ask us first.</p>
      <p class="text-xs text-ink/50 mb-4">WhatsApp: <span class="font-mono font-semibold"><?= htmlspecialchars($WA_DISPLAY) ?></span></p>
      <a id="wa-general" href="https://wa.me/<?= $WA_NUMBER ?>?text=<?= rawurlencode($generalMsgEn) ?>" target="_blank" rel="noopener"
         class="inline-flex items-center justify-center gap-2 bg-wa hover:brightness-95 text-white font-bold text-sm px-6 py-3 rounded-xl transition shadow-md">
        <span aria-hidden="true">💬</span><span data-en="Ask for details on WhatsApp" data-si="WhatsApp හරහා විස්තර විමසන්න">Ask for details on WhatsApp</span>
      </a>
    </section>

  </div>
</main>

<footer class="text-center py-8 text-xs text-ink/40 border-t border-black/5 bg-white space-y-2">
  <p>Japan Driving License Practice System &copy; 2026</p>
  <div class="flex items-center justify-center gap-4 flex-wrap">
    <a href="index.php" class="text-primary hover:underline font-medium">🏠 Home</a>
    <a href="contact.php" class="text-primary hover:underline font-medium">💬 Contact Support</a>
  </div>
</footer>

<script>
const WA_NUMBER = '<?= $WA_NUMBER ?>';
let currentLang = 'en';

const PACKAGES = {
  home_6m:  { place: 'home', months: 6,  price: '¥2,000'  },
  home_12m: { place: 'home', months: 12, price: '¥5,000'  },
  all_6m:   { place: 'all',  months: 6,  price: '¥5,000'  },
  all_12m:  { place: 'all',  months: 12, price: '¥10,000' }
};

/* Builds the auto WhatsApp message in the language currently selected on the page. */
function buildMessage(pkgKey) {
  const p = PACKAGES[pkgKey];
  if (currentLang === 'si') {
    const place = p.place === 'home' ? 'මුල් පිටුව' : 'මුල් පිටුව + සියලුම අභ්‍යන්තර පිටු';
    const period = p.months === 12 ? 'අවුරුදු 1' : 'මාස 6';
    return 'ආයුබෝවන් Menkyoo.jp,\nමට ඔබේ website එකේ දැන්වීමක් පළ කිරීමට අවශ්‍යයි.\n\n'
         + `Package: ${place} – ${period} (${p.price})\n\n`
         + 'ව්‍යාපාරයේ / දැන්වීමේ නම:\nදුරකථන අංකය:\n\n'
         + 'කරුණාකර විස්තර සහ activate කරගන්නා ආකාරය දන්වන්න.';
  }
  const place = p.place === 'home' ? 'Home page' : 'Home page + all inside pages';
  const period = p.months === 12 ? '1 year' : '6 months';
  return 'Hello Menkyoo.jp,\nI would like to advertise on your website.\n\n'
       + `Package: ${place} – ${period} (${p.price})\n\n`
       + 'Business / ad name:\nContact number:\n\n'
       + 'Please send me the details and how to activate it.';
}

function generalMessage() {
  return currentLang === 'si'
    ? 'ආයුබෝවන් Menkyoo.jp,\nමට ඔබේ website එකේ දැන්වීම් පළ කිරීම ගැන වැඩි විස්තර දැනගන්න ඕනේ. කරුණාකර විස්තර එවන්න.'
    : 'Hello Menkyoo.jp,\nI would like to know more about advertising on your website. Please send me the details.';
}

function updateWaLinks() {
  document.querySelectorAll('.wa-btn').forEach(a => {
    a.href = 'https://wa.me/' + WA_NUMBER + '?text=' + encodeURIComponent(buildMessage(a.dataset.pkg));
  });
  document.getElementById('wa-general').href = 'https://wa.me/' + WA_NUMBER + '?text=' + encodeURIComponent(generalMessage());
}

function applyTranslations() {
  document.querySelectorAll('[data-en]').forEach(el => {
    el.innerText = currentLang === 'si' ? (el.getAttribute('data-si') || el.getAttribute('data-en')) : el.getAttribute('data-en');
  });
}

function setLanguage(lang) {
  currentLang = lang;
  document.getElementById('btn-en').className = 'px-2 sm:px-3 py-1 rounded-md font-semibold transition ' + (lang === 'en' ? 'bg-white text-primary' : 'text-white');
  document.getElementById('btn-si').className = 'px-2 sm:px-3 py-1 rounded-md font-semibold transition font-si ' + (lang === 'si' ? 'bg-white text-primary' : 'text-white');
  document.documentElement.lang = lang;
  applyTranslations();
  updateWaLinks();
}

updateWaLinks();
</script>
</body>
</html>