<?php
// How to Get a Japanese Driving License Guide - Bilingual PHP Page
$lang = isset($_GET['lang']) && $_GET['lang'] === 'si' ? 'si' : 'en';
$alt_lang = $lang === 'en' ? 'si' : 'en';
$page_url = "https://" . ($_SERVER['HTTP_HOST'] ?? 'menkyoo.jp') . ($_SERVER['REQUEST_URI'] ?? '/how_get_jp_license.php');
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title><?= $lang === 'en' ? 'How to Get a Japanese Driving License — and Pass the Written Test in English | Menkyoo.jp' : 'ජපන් රියදුරු බලපත්‍රයක් ලබා ගන්නේ කෙසේද | Menkyoo.jp' ?></title>

<!-- SEO Meta Tags -->
<meta name="description" content="<?= $lang === 'en' ? 'Complete guide on how to get a Japanese driving license, covering Karimen, Honmen, Moped Gentsuki license, driving school lessons, and passing the English written test.' : 'ජපන් රියදුරු බලපත්‍රයක් ලබා ගැනීම, කරිමන් (Karimen), හොන්මන් (Honmen), මොපෙඩ් (Gentsuki) බලපත්‍රය සහ ඉංග්‍රීසි ලිඛිත පරීක්ෂණය සමත් වීම පිළිබඳ සම්පූර්ණ මාර්ගෝපදේශය.' ?>">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://menkyoo.jp/how_get_jp_license.php">

<!-- Open Graph -->
<meta property="og:title" content="<?= $lang === 'en' ? 'How to Get a Japanese Driving License — Complete English Guide' : 'ජපන් රියදුරු බලපත්‍රයක් ලබා ගන්නේ කෙසේද' ?>">
<meta property="og:description" content="<?= $lang === 'en' ? 'Step-by-step guide to passing the Japanese driving license written test in English, covering Karimen, Honmen, and Moped tests.' : 'කරිමන්, හොන්මන් සහ මොපෙඩ් පරීක්ෂණ ඇතුළුව ජපන් රියදුරු බලපත්‍ර ලිඛිත පරීක්ෂණය ඉංග්‍රීසියෙන් සමත් වීම සඳහා පියවරෙන් පියවර මාර්ගෝපදේශය.' ?>">
<meta property="og:image" content="https://menkyoo.jp/menkyoo.png">
<meta property="og:type" content="article">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=Noto+Sans+Sinhala:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = { theme: { extend: {
    colors: { ink:'#101A30', paper:'#F6F5F1', primary:{DEFAULT:'#0F2F6E',light:'#E7ECFA',dark:'#0A2050'}, accent:{DEFAULT:'#F2A73B',light:'#FDF1DD'}, go:'#1C8F5A', stop:'#D5432E' },
    fontFamily: { display:['"Space Grotesk"','sans-serif'], body:['"Inter"','"Noto Sans Sinhala"','sans-serif'], si:['"Noto Sans Sinhala"','sans-serif'], mono:['"JetBrains Mono"','monospace'] }
  }}}
</script>
<style>
  body{ font-family:'Inter','Noto Sans Sinhala',sans-serif; }
  .font-si, [lang="si"] { font-family:'Noto Sans Sinhala', sans-serif; }
  *:focus-visible{ outline: 3px solid #F2A73B; outline-offset: 2px; }
  html{ scroll-behavior: smooth; }
  @keyframes riseIn{ from{ opacity:0; transform:translateY(8px);} to{ opacity:1; transform:translateY(0);} }
  .rise-in{ animation: riseIn .3s ease-out both; }
  @media (prefers-reduced-motion: reduce){ .rise-in{ animation:none; } html{scroll-behavior:auto;} }
  .grid-texture{
    background-image:
      linear-gradient(to right, rgba(15,47,110,0.06) 1px, transparent 1px),
      linear-gradient(to bottom, rgba(15,47,110,0.06) 1px, transparent 1px);
    background-size: 28px 28px;
  }
</style>
</head>
<body class="bg-paper text-ink font-body min-h-screen flex flex-col">

<header class="sticky top-0 z-40 bg-primary text-white shadow-lg shadow-primary/10">
  <div class="max-w-5xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-3">
    <a href="index.php" class="flex items-center gap-2 shrink-0">
      <svg width="28" height="28" viewBox="0 0 48 48" fill="none" aria-hidden="true"><circle cx="24" cy="24" r="21" stroke="#F2A73B" stroke-width="3"/><circle cx="24" cy="24" r="5.5" fill="#F2A73B"/><path d="M24 3v10M24 35v10M3 24h10M35 24h10M9.5 9.5l7 7M31.5 31.5l7 7M9.5 38.5l7-7M31.5 16.5l7-7" stroke="#F2A73B" stroke-width="2.5" stroke-linecap="round"/></svg>
      <span class="font-display font-bold text-sm sm:text-base">Menkyoo.jp</span>
    </a>
    <div class="flex items-center gap-2 sm:gap-3">
      <div class="bg-white/10 p-1 rounded-lg flex text-xs sm:text-sm">
        <a href="?lang=en" class="px-2.5 sm:px-3 py-1 rounded-md font-semibold transition <?= $lang === 'en' ? 'bg-white text-primary' : 'text-white' ?>">EN</a>
        <a href="?lang=si" class="px-2.5 sm:px-3 py-1 rounded-md font-semibold transition font-si <?= $lang === 'si' ? 'bg-white text-primary' : 'text-white' ?>">සිං</a>
      </div>
      <a href="index.php" class="text-xs sm:text-sm font-semibold bg-accent text-ink px-3 sm:px-4 py-2 rounded-lg hover:brightness-95 transition">
        <?= $lang === 'si' ? 'පරීක්ෂණය' : 'Take Quiz' ?>
      </a>
    </div>
  </div>
</header>

<main class="flex-grow w-full">
  <div class="grid-texture border-b border-black/5">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 py-8 sm:py-12 text-center rise-in">
      <span class="inline-block text-[11px] font-bold tracking-widest uppercase bg-accent-light text-primary px-3 py-1 rounded-full border border-accent/40 mb-3">
        <?= $lang === 'en' ? 'Comprehensive Guide' : 'සම්පූර්ණ මාර්ගෝපදේශය' ?>
      </span>
      <h1 class="font-display font-bold text-2xl sm:text-3xl text-ink leading-tight">
        <?= $lang === 'en' ? 'How to Get a Japanese Driving License — and Pass the Written Test in English' : 'ජපන් රියදුරු බලපත්‍රයක් ලබා ගන්නේ කෙසේද — සහ ලිඛිත පරීක්ෂණය ඉංග්‍රීසියෙන් සමත් වන්නේ කෙසේද' ?>
      </h1>
      <p class="text-sm text-ink/60 mt-2 max-w-xl mx-auto">
        <?= $lang === 'en' ? 'Getting a Japanese driving license as a foreigner can feel daunting — but the written (theory) test can be taken in English, and with the right practice it\'s very passable.' : 'විදේශිකයෙකුට ජපන් රියදුරු බලපත්‍රයක් ලබා ගැනීම අභියෝගයක් විය හැක — නමුත් ලිඛිත (න්‍යායාත්මක) පරීක්ෂණය ඉංග්‍රීසියෙන් ලබා ගත හැකි අතර, නිවැරදි පුහුණුවක් සමඟ එය පහසුවෙන් සමත් විය හැකිය.' ?>
      </p>
    </div>
  </div>

  <div class="max-w-3xl mx-auto px-4 sm:px-6 py-8 sm:py-10">

    <!-- Feature image -->
    <div class="rounded-xl overflow-hidden mb-6 border border-black/10 bg-white shadow-sm rise-in">
      <img src="images/japanese-driving-license-banner.jpg" alt="Japanese Driving License Guide" class="w-full h-56 sm:h-80 object-cover" onerror="this.src='https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?auto=format&amp;fit=crop&amp;w=1200&amp;q=80'">
    </div>

    <!-- Share bar -->
    <div class="flex flex-wrap items-center justify-between bg-white border border-black/5 rounded-xl px-4 py-3 mb-6 text-xs font-semibold text-ink/70 shadow-sm">
      <span><?= $lang === 'en' ? 'Share this guide:' : 'මෙම ලිපිය බෙදා ගන්න:' ?></span>
      <div class="flex gap-2">
        <a href="https://twitter.com/intent/tweet?text=<?= urlencode($lang === 'en' ? 'How to Get a Japanese Driving License — Complete Guide' : 'ජපන් රියදුරු බලපත්‍රයක් ලබා ගන්නේ කෙසේද') ?>&url=<?= urlencode($page_url) ?>" target="_blank" rel="noopener" class="bg-paper px-3 py-1.5 rounded-lg border border-black/10 hover:bg-primary hover:text-white transition">Twitter / X</a>
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($page_url) ?>" target="_blank" rel="noopener" class="bg-paper px-3 py-1.5 rounded-lg border border-black/10 hover:bg-primary hover:text-white transition">Facebook</a>
        <a href="https://api.whatsapp.com/send?text=<?= urlencode(($lang === 'en' ? 'Check out this guide on getting a Japanese driving license: ' : 'ජපන් රියදුරු බලපත්‍රයක් ගැන දැන ගැනීමට මෙම මාර්ගෝපදේශය බලන්න: ') . $page_url) ?>" target="_blank" rel="noopener" class="bg-paper px-3 py-1.5 rounded-lg border border-black/10 hover:bg-primary hover:text-white transition">WhatsApp</a>
      </div>
    </div>

    <div class="space-y-4">

      <!-- Lesson 1 -->
      <details class="bg-white rounded-xl border border-black/5 shadow-sm rise-in" open>
        <summary class="p-4 sm:p-5 cursor-pointer list-none flex items-start gap-3">
          <span class="shrink-0 w-7 h-7 rounded-full bg-primary-light text-primary flex items-center justify-center text-xs font-bold font-mono mt-0.5">1</span>
          <span class="flex-1 font-display font-bold text-ink"><?= $lang === 'en' ? 'Types of Driving Licenses in Japan' : 'ජපානයේ රියදුරු බලපත්‍ර වර්ග' ?></span>
        </summary>
        <div class="px-4 sm:px-5 pb-5 ml-10 text-sm sm:text-base text-ink/80 leading-relaxed space-y-3">
          <p><?= $lang === 'en' ? 'In Japan, there are several types of driving licenses that you can obtain, depending on your qualifications and driving experience. The types of licenses include:' : 'ජපානයේදී ඔබේ සුදුසුකම් සහ රිය පැදවීමේ අත්දැකීම් මත පදනම්ව ලබා ගත හැකි රියදුරු බලපත්‍ර වර්ග කිහිපයක් තිබේ. ඒවා නම්:' ?></p>
          <ul class="list-disc pl-5 space-y-2">
            <li><strong><?= $lang === 'en' ? 'Ordinary Vehicle Class 1 (一般車第一種):' : 'සාමාන්‍ය වාහන පළමු පන්තිය (一般車第一種):' ?></strong> <?= $lang === 'en' ? 'This is for vehicles with up to 9 passengers. It\'s the most common type of license and covers most cars that people drive for personal use.' : 'මෙය මගීන් 9 දෙනෙකු දක්වා රැගෙන යා හැකි වාහන සඳහා වේ. මෙය වඩාත් පොදු බලපත්‍ර වර්ගය වන අතර පුද්ගලික භාවිතය සඳහා පදවන බොහෝ කාර් ආවරණය කරයි.' ?></li>
            <li><strong><?= $lang === 'en' ? 'Ordinary Vehicle Class 2 (一般車第二種):' : 'සාමාන්‍ය වාහන දෙවන පන්තිය (一般車第二種):' ?></strong> <?= $lang === 'en' ? 'This license is for vehicles with 10 or more passengers. It\'s generally used for bus drivers.' : 'මෙම බලපත්‍රය මගීන් 10 දෙනෙකු හෝ වැඩි සංඛ්‍යාවක් සිටින වාහන සඳහා වේ. එය සාමාන්‍යයෙන් බස් රියදුරන් සඳහා භාවිතා කරයි.' ?></li>
            <li><strong><?= $lang === 'en' ? 'Motorcycle & Gentsuki (原付) - Moped License:' : 'මෝටර් රථ සහ Gentsuki (原付) - මොපෙඩ් බලපත්‍රය:' ?></strong> <?= $lang === 'en' ? 'Allows you to operate mopeds or scooters with an engine displacement of up to 50cc. Popular in urban areas for convenience.' : 'එන්ජින් ධාරිතාව 50cc දක්වා වූ මොපෙඩ් හෝ ස්කූටර් ක්‍රියාත්මක කිරීමට ඉඩ සලසයි. නගර ප්‍රදේශවල ඉතා ජනප්‍රියයි.' ?></li>
          </ul>
        </div>
      </details>

      <!-- Lesson 2 -->
      <details class="bg-white rounded-xl border border-black/5 shadow-sm rise-in">
        <summary class="p-4 sm:p-5 cursor-pointer list-none flex items-start gap-3">
          <span class="shrink-0 w-7 h-7 rounded-full bg-primary-light text-primary flex items-center justify-center text-xs font-bold font-mono mt-0.5">2</span>
          <span class="flex-1 font-display font-bold text-ink"><?= $lang === 'en' ? 'Gentsuki (原付) - Moped License Process' : 'Gentsuki (原付) - මොපෙඩ් බලපත්‍ර ක්‍රියාවලිය' ?></span>
        </summary>
        <div class="px-4 sm:px-5 pb-5 ml-10 text-sm sm:text-base text-ink/80 leading-relaxed space-y-3">
          <p><?= $lang === 'en' ? 'Mopeds are a popular choice in Japan due to their convenience. To apply, you must be at least 16 years old. If you already hold an Ordinary or Motorcycle license, the practical test is waived.' : 'මොපෙඩ් යනු පහසුව නිසා ජපානයේ ජනප්‍රිය තේරීමකි. අයදුම් කිරීමට අවම වශයෙන් අවුරුදු 16ක් විය යුතුය. ඔබට දැනටමත් සාමාන්‍ය හෝ මෝටර් රථ බලපත්‍රයක් ඇත්නම්, ප්‍රායෝගික පරීක්ෂණය අවශ්‍ය නොවේ.' ?></p>
          <ul class="list-disc pl-5 space-y-2">
            <li><strong><?= $lang === 'en' ? 'Theory Test:' : 'න්‍යාය පරීක්ෂණය:' ?></strong> <?= $lang === 'en' ? 'Consists of 50 multiple-choice questions. You need at least 45 correct answers to pass.' : 'බහු තේරීම් ප්‍රශ්න 50 කින් සමන්විත වේ. සමත් වීමට නිවැරදි පිළිතුරු 45 ක් අවශ්‍ය වේ.' ?></li>
            <li><strong><?= $lang === 'en' ? 'Practical Test:' : 'ප්‍රායෝගික පරීක්ෂණය:' ?></strong> <?= $lang === 'en' ? 'Focuses on basic driving skills, turning, stopping, and strict traffic rule compliance.' : 'මූලික රිය පැදවීමේ කුසලතා, හැරවීම් සහ නැවැත්වීම් පරීක්ෂා කෙරේ.' ?></li>
          </ul>
        </div>
      </details>

      <!-- Lesson 3 -->
      <details class="bg-white rounded-xl border border-black/5 shadow-sm rise-in">
        <summary class="p-4 sm:p-5 cursor-pointer list-none flex items-start gap-3">
          <span class="shrink-0 w-7 h-7 rounded-full bg-primary-light text-primary flex items-center justify-center text-xs font-bold font-mono mt-0.5">3</span>
          <span class="flex-1 font-display font-bold text-ink"><?= $lang === 'en' ? "Karimen (仮免) - Provisional License" : "Karimen (仮免) - තාවකාලික බලපත්‍රය" ?></span>
        </summary>
        <div class="px-4 sm:px-5 pb-5 ml-10 text-sm sm:text-base text-ink/80 leading-relaxed space-y-3">
          <p><?= $lang === 'en' ? 'The first major stage is the Karimen, allowing you to practice driving on public roads.' : 'පළමු ප්‍රධාන අදියර වන්නේ කරිමන් වන අතර, එය මහජන මාර්ගවල රිය පැදවීම පුහුණු වීමට ඉඩ සලසයි.' ?></p>
          <ul class="list-disc pl-5 space-y-2">
            <li><strong><?= $lang === 'en' ? 'Theory Test:' : 'න්‍යාය පරීක්ෂණය:' ?></strong> <?= $lang === 'en' ? '50 true-or-false questions; minimum pass mark is 45 correct answers.' : 'සත්‍ය/අසත්‍ය ප්‍රශ්න 50ක්; සමත්වීමට නිවැරදි පිළිතුරු 45ක් අවශ්‍ය වේ.' ?></li>
            <li><strong><?= $lang === 'en' ? 'Practical Test:' : 'ප්‍රායෝගික පරීක්ෂණය:' ?></strong> <?= $lang === 'en' ? 'Starts with 100 points, requiring 90 points to pass. Critical errors (e.g., running a red light) cause immediate disqualification.' : 'ලකුණු 100කින් ආරම්භ වන අතර සමත්වීමට ලකුණු 90ක් අවශ්‍ය වේ. බරපතල වැරදි (රතු එළිය පසුකර යාම වැනි) ක්ෂණික අසමත් වීමට හේතු වේ.' ?></li>
          </ul>
        </div>
      </details>

      <!-- Lesson 4 -->
      <details class="bg-white rounded-xl border border-black/5 shadow-sm rise-in">
        <summary class="p-4 sm:p-5 cursor-pointer list-none flex items-start gap-3">
          <span class="shrink-0 w-7 h-7 rounded-full bg-primary-light text-primary flex items-center justify-center text-xs font-bold font-mono mt-0.5">4</span>
          <span class="flex-1 font-display font-bold text-ink"><?= $lang === 'en' ? 'Honmen & Full License Written Test' : 'හොන්මන් (Honmen) සහ පූර්ණ බලපත්‍ර ලිඛිත පරීක්ෂණය' ?></span>
        </summary>
        <div class="px-4 sm:px-5 pb-5 ml-10 text-sm sm:text-base text-ink/80 leading-relaxed space-y-3">
          <p><?= $lang === 'en' ? 'The final theory test for the actual full license is comprehensive and challenging.' : 'සැබෑ පූර්ණ බලපත්‍රය සඳහා වන අවසාන න්‍යාය පරීක්ෂණය ඉතා විස්තරාත්මක සහ අභියෝගාත්මක වේ.' ?></p>
          <ul class="list-disc pl-5 space-y-2">
            <li><strong><?= $lang === 'en' ? 'Exam Structure:' : 'විභාග ව්‍යුහය:' ?></strong> <?= $lang === 'en' ? 'Includes 90 true-or-false questions and 5 danger prediction questions (total 100 points).' : 'සත්‍ය/අසත්‍ය ප්‍රශ්න 90ක් සහ අනතුරු අපේක්ෂා ප්‍රශ්න 5ක් (මුළු ලකුණු 100යි).' ?></li>
            <li><strong><?= $lang === 'en' ? 'Passing Score:' : 'සමත් ලකුණු සීමාව:' ?></strong> <?= $lang === 'en' ? 'You need at least 90 out of 100 points to pass.' : 'සමත්වීමට අවම වශයෙන් ලකුණු 90ක් ලබා ගත යුතුය.' ?></li>
          </ul>
        </div>
      </details>

      <!-- Lesson 5 -->
      <details class="bg-white rounded-xl border border-black/5 shadow-sm rise-in">
        <summary class="p-4 sm:p-5 cursor-pointer list-none flex items-start gap-3">
          <span class="shrink-0 w-7 h-7 rounded-full bg-primary-light text-primary flex items-center justify-center text-xs font-bold font-mono mt-0.5">5</span>
          <span class="flex-1 font-display font-bold text-ink"><?= $lang === 'en' ? 'Japanese Driving School & Preparation' : 'ජපන් රියදුරු පාසල සහ විභාගයට සූදානම් වීම' ?></span>
        </summary>
        <div class="px-4 sm:px-5 pb-5 ml-10 text-sm sm:text-base text-ink/80 leading-relaxed space-y-3">
          <p><?= $lang === 'en' ? 'Enrolling in an official driving school provides structured learning through orientation, classroom theory lessons, and practical training on grounds and public roads.' : 'නිල රියදුරු පාසලක ලියාපදිංචි වීමෙන් දිශානති, පන්ති කාමර න්‍යාය පාඩම් සහ ප්‍රායෝගික පුහුණුව හරහා ක්‍රමානුකූල ඉගෙනුමක් ලබා ගත හැකිය.' ?></p>
          <p><?= $lang === 'en' ? 'To prepare completely in English without struggling with language barriers, our interactive app offers 1,000+ practice questions, mock tests using real pass marks, and automatic weakness tracking.' : 'භාෂා බාධක වලින් තොරව ඉංග්‍රීසියෙන්ම සම්පූර්ණ සූදානමක් ලබා ගැනීමට අපගේ අන්තර්ක්‍රියාකාරී යෙදුම මඟින් ප්‍රශ්න 1,000කට අධික ප්‍රමාණයක්, සැබෑ සමත් ලකුණු භාවිතා කරන ආදර්ශ විභාග සහ ස්වයංක්‍රීය දුර්වලතා නිරීක්ෂණය ලබා දේ.' ?></p>
        </div>
      </details>

    </div>

    <!-- FAQ -->
    <div class="mt-10 bg-white rounded-xl border border-black/5 shadow-sm p-5 sm:p-6 rise-in">
      <h3 class="font-display text-lg font-bold text-ink mb-4">
        <?= $lang === 'en' ? 'Common Questions About the Japanese Driving Test' : 'ජපන් රියදුරු පරීක්ෂණය පිළිබඳ නිතර අසන ප්‍රශ්න' ?>
      </h3>
      <div class="space-y-3 text-sm">
        <div class="bg-paper p-4 rounded-lg border border-black/5">
          <h4 class="font-semibold text-primary mb-1"><?= $lang === 'en' ? 'Can I take the Japanese driving test in English?' : 'මට ජපන් රියදුරු පරීක්ෂණය ඉංග්‍රීසියෙන් ගත හැකිද?' ?></h4>
          <p class="text-ink/70"><?= $lang === 'en' ? 'Yes. The written test is offered in English at many driver\'s license centers across Japan.' : 'ඔව්. ජපානයේ බොහෝ රියදුරු බලපත්‍ර මධ්‍යස්ථානවල ලිඛිත පරීක්ෂණය ඉංග්‍රීසියෙන් ලබා දේ.' ?></p>
        </div>
        <div class="bg-paper p-4 rounded-lg border border-black/5">
          <h4 class="font-semibold text-primary mb-1"><?= $lang === 'en' ? 'What are the pass marks for Karimen and Honmen?' : 'කරිමන් සහ හොන්මන් සඳහා සමත් ලකුණු කීයද?' ?></h4>
          <p class="text-ink/70"><?= $lang === 'en' ? 'Karimen is 45/50, and Honmen is 90/100 (including hazard prediction questions).' : 'කරිමන් සඳහා 50න් 45ක් සහ හොන්මන් සඳහා 100න් 90ක් අවශ්‍ය වේ.' ?></p>
        </div>
      </div>
    </div>

    <!-- CTA back to quiz -->
    <div class="mt-8 bg-gradient-to-br from-primary via-primary-dark to-ink text-white rounded-xl p-6 text-center rise-in">
      <p class="font-display font-bold text-lg mb-1"><?= $lang === 'en' ? 'Ready to put this into practice?' : 'දැන් පුහුණුවට යොමු වෙන්නද?' ?></p>
      <p class="text-sm text-white/70 mb-4"><?= $lang === 'en' ? 'Try a free 30-question mock exam, bilingual, with instant explanations.' : 'නොමිලේ ප්‍රශ්න 30ක ආදර්ශ විභාගයක් අද ම උත්සාහ කරන්න.' ?></p>
      <a href="index.php" class="inline-block bg-accent text-ink font-bold px-5 py-2.5 rounded-lg text-sm hover:brightness-95 transition"><?= $lang === 'en' ? 'Start Free Quiz →' : 'නොමිලේ පරීක්ෂණය අරඹන්න →' ?></a>
    </div>

  </div>
</main>

<footer class="text-center py-8 text-xs text-ink/40 border-t border-black/5 bg-white">
  <p>Japan Driving License Practice System &copy; <?= date('Y') ?></p>
  <p class="mt-1"><?= $lang === 'en' ? 'Ready to test yourself?' : 'දැන් ඔබම පරීක්ෂා කරගන්නද?' ?></p>
  <a href="index.php" class="text-primary hover:underline font-medium">→ <?= $lang === 'en' ? 'Take the free mock exam' : 'නොමිලේ පරීක්ෂණය අරඹන්න' ?></a>
</footer>

</body>
</html>