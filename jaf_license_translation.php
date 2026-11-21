<?php
session_start();
require_once __DIR__ . '/visitor.php';

$sessionUser = null;
if (!empty($_SESSION['user_id'])) {
    $sessionUser = [
        'id'    => $_SESSION['user_id'],
        'name'  => $_SESSION['user_name'] ?? '',
        'email' => $_SESSION['user_email'] ?? '',
    ];
}
?>
<!DOCTYPE html>
<html lang="si">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">

<title>JAF හරහා විදේශීය රියදුරු බලපත්‍ර පරිවර්තනයක් ලබාගන්නා සම්පූර්ණ මාර්ගෝපදේශය | Menkyoo.jp</title>
<meta name="description" content="JAF (Japan Automobile Federation) හරහා විදේශීය රියදුරු බලපත්‍රයක් ජපන් භාෂාවට පරිවර්තනය කරගන්නේ කෙසේද? අයදුම් කරන ආකාරය, අවශ්‍ය ලේඛන, ගාස්තු, ගෙවීම් ක්‍රම, convenience store එකෙන් print කරගන්නා ආකාරය සහ නිතර අසන ප්‍රශ්න ඇතුළු සම්පූර්ණ මාර්ගෝපදේශය.">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://menkyoo.jp/jaf_license_translation.php">

<meta property="og:type" content="article">
<meta property="og:title" content="JAF හරහා විදේශීය රියදුරු බලපත්‍ර පරිවර්තනයක් ලබාගන්නා සම්පූර්ණ මාර්ගෝපදේශය">
<meta property="og:description" content="අයදුම් කරන ආකාරය, ලේඛන, ගාස්තු, ගෙවීම් ක්‍රම සහ FAQ ඇතුළු සම්පූර්ණ මාර්ගෝපදේශය — Menkyoo.jp">
<meta property="og:locale" content="si_LK">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=Noto+Sans+Sinhala:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = { theme: { extend: {
    colors: { ink:'#101A30', paper:'#F6F5F1', primary:{DEFAULT:'#0F2F6E',light:'#E7ECFA',dark:'#0A2050'}, accent:{DEFAULT:'#F2A73B',light:'#FDF1DD'}, go:'#1C8F5A', stop:'#D5432E' },
    fontFamily: { display:['"Space Grotesk"','sans-serif'], body:['"Noto Sans Sinhala"','"Inter"','sans-serif'], si:['"Noto Sans Sinhala"','sans-serif'], mono:['"JetBrains Mono"','monospace'] }
  }}}
</script>
<style>
  body{ font-family:'Noto Sans Sinhala','Inter',sans-serif; background:#F6F5F1; }
  *:focus-visible{ outline: 3px solid #F2A73B; outline-offset: 2px; }
  .grid-texture{
    background-image:
      linear-gradient(to right, rgba(15,47,110,0.06) 1px, transparent 1px),
      linear-gradient(to bottom, rgba(15,47,110,0.06) 1px, transparent 1px);
    background-size: 28px 28px;
  }
  @keyframes riseIn{ from{ opacity:0; transform:translateY(8px);} to{ opacity:1; transform:translateY(0);} }
  .rise-in{ animation: riseIn .3s ease-out both; }
  @media (prefers-reduced-motion: reduce){ .rise-in{ animation:none; } }
  details > summary{ list-style:none; cursor:pointer; }
  details > summary::-webkit-details-marker{ display:none; }
  details[open] .chev{ transform:rotate(90deg); }
  .chev{ transition: transform .2s ease; }
  .notice-box{ background:#FDF1DD; border:1px solid rgba(242,167,59,.4); }
  .danger-box{ background:#FBEAE6; border:1px solid rgba(213,67,46,.35); }
  table.feetbl{ width:100%; border-collapse:collapse; font-size:.85rem; }
  table.feetbl th, table.feetbl td{ border:1px solid rgba(0,0,0,.08); padding:.5rem .6rem; text-align:left; }
  table.feetbl th{ background:#E7ECFA; color:#0F2F6E; }
  .toc a{ display:block; padding:.4rem .6rem; border-radius:.5rem; }
  .toc a:hover{ background:#E7ECFA; }
</style>
</head>
<body class="bg-paper text-ink font-body min-h-screen flex flex-col">

<header class="sticky top-0 z-40 bg-primary text-white shadow-lg shadow-primary/10">
  <div class="max-w-3xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-3">
    <a href="index.php" class="flex items-center gap-2 shrink-0">
      <svg width="28" height="28" viewBox="0 0 48 48" fill="none" aria-hidden="true"><circle cx="24" cy="24" r="21" stroke="#F2A73B" stroke-width="3"/><circle cx="24" cy="24" r="5.5" fill="#F2A73B"/><path d="M24 3v10M24 35v10M3 24h10M35 24h10M9.5 9.5l7 7M31.5 31.5l7 7M9.5 38.5l7-7M31.5 16.5l7-7" stroke="#F2A73B" stroke-width="2.5" stroke-linecap="round"/></svg>
      <span class="font-display font-bold text-sm sm:text-base">Menkyoo.jp</span>
    </a>
    <a href="index.php" class="text-xs sm:text-sm font-semibold bg-accent text-ink px-3 sm:px-4 py-2 rounded-lg hover:brightness-95 transition">
      පරීක්ෂණය අරඹන්න
    </a>
  </div>
</header>

<main class="flex-grow w-full">
  <div class="grid-texture border-b border-black/5">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 pt-10 sm:pt-14 pb-8 text-center">
      <span class="inline-block text-[11px] font-bold tracking-widest uppercase bg-accent-light text-primary px-3 py-1 rounded-full border border-accent/40 mb-4">JAF සම්පූර්ණ මාර්ගෝපදේශය</span>
      <h1 class="font-display font-bold text-2xl sm:text-3xl md:text-4xl text-ink leading-tight">
        විදේශීය රියදුරු බලපත්‍ර පරිවර්තනයක් ලබාගන්නා ආකාරය
      </h1>
      <p class="mt-3 text-sm sm:text-base text-ink/60 max-w-xl mx-auto">
        JAF (Japan Automobile Federation) හරහා ඔබේ රියදුරු බලපත්‍රය ජපන් භාෂාවට පරිවර්තනය කරගැනීමට අවශ්‍ය සියලුම පියවර — අයදුම් කරන ආකාරයේ සිට convenience store එකෙන් print කරගැනීම දක්වා.
      </p>
    </div>
  </div>

  <div class="max-w-3xl mx-auto px-4 sm:px-6 py-8 space-y-6">

    <!-- Table of contents -->
    <nav class="toc bg-white rounded-2xl border border-black/5 shadow-sm p-4 text-sm rise-in">
      <p class="font-display font-bold text-ink mb-1 px-1">මෙම ලිපියේ අන්තර්ගතය</p>
      <a href="#overseas" class="text-primary">1. විදේශයන්හි සිටින අයට වැදගත් නිවේදනය</a>
      <a href="#howto" class="text-primary">2. අයදුම් කරන ආකාරය</a>
      <a href="#docs" class="text-primary">3. අවශ්‍ය ලේඛන</a>
      <a href="#fees" class="text-primary">4. නිකුත් කිරීමේ ගාස්තු</a>
      <a href="#flow-card" class="text-primary">5. අයදුම් ක්‍රියාවලිය — Credit Card ගෙවීම</a>
      <a href="#flow-cash" class="text-primary">6. අයදුම් ක්‍රියාවලිය — Convenience Store කැෂ් ගෙවීම</a>
      <a href="#cvs" class="text-primary">7. Convenience Store එකේදී ගෙවන ආකාරය (කඩේ අනුව)</a>
      <a href="#print" class="text-primary">8. පරිවර්තනය Print කරගන්නා ආකාරය</a>
      <a href="#receipt" class="text-primary">9. රිසිට්පත ලබාගන්නා ආකාරය</a>
      <a href="#samples" class="text-primary">10. පරිවර්තන සාම්පල</a>
      <a href="#precautions" class="text-primary">11. වැදගත් අවවාද</a>
      <a href="#faq" class="text-primary">12. නිතර අසන ප්‍රශ්න (FAQ)</a>
    </nav>

    <!-- 1. Overseas notice -->
    <section id="overseas" class="danger-box rounded-2xl p-5 rise-in">
      <h2 class="font-display font-bold text-base sm:text-lg text-ink mb-2">⚠️ 1. විදේශයන්හි සිටින අයට වැදගත් නිවේදනය</h2>
      <p class="text-sm text-ink/80 leading-relaxed mb-2">
        <strong>2025 අප්‍රේල් 1</strong> වන දින සිට, පරිවර්තන අයදුම්පත් <strong>මාර්ගගතව (Online) පමණක්</strong> භාරගනු ලැබේ. කවුන්ටරයෙන් හෝ තැපෑලෙන් ඉදිරිපත් කරන අයදුම්පත් තවදුරටත් භාරගනු නොලැබේ.
      </p>
      <p class="text-sm text-ink/80 leading-relaxed mb-2">
        ඔබ දැනට ජපානයෙන් පිටත සිටින්නේ නම්, කණගාටුවෙන් වුවත් JAF හරහා පරිවර්තනයක් ඉල්ලුම් කළ නොහැක — මාර්ගගත application site එකට ප්‍රවේශ විය හැක්කේ ජපානය තුළ ඇති network එකකින් පමණි.
      </p>
      <p class="text-sm text-ink/80 leading-relaxed font-semibold mb-1">ජපානයට පැමිණීමට පෙර පරිවර්තනයක් ලබාගැනීමට ක්‍රම:</p>
      <ol class="list-decimal list-inside text-sm text-ink/80 leading-relaxed space-y-1 mb-2">
        <li><strong>නියෝජිත අයදුම්කරුවෙකු හරහා (Proxy application)</strong> — ජපානයේ ඔබ හඳුනන කෙනෙක් සිටී නම්, ඔවුන්ට ඔබ වෙනුවෙන් නියෝජිතයෙකු ලෙස ඔබ පැමිණීමට පෙර අයදුම් කළ හැක.</li>
        <li><strong>ඒජන්සියක් හරහා</strong> — සංචාරක නියෝජිත ආයතන (travel agencies) වැනි ව්‍යාපාර මාර්ගගතව සොයාගත් විට, ඒවා නියෝජිත අයදුම් සේවා ලබා දිය හැක.</li>
        <li><strong>වෙනත් ක්‍රම</strong> — ඔබේ රියදුරු බලපත්‍රය නිකුත් කළ අධිකාරිය හෝ ජපානයේ ඇති ඔබේ රටේ තානාපති/කොන්සල් කාර්යාලය හරහාද ජපන් පරිවර්තන ලේඛන ලබාගත හැක. උදාහරණයක් ලෙස, ජර්මනිය සඳහා <strong>ADAC</strong> හරහා ජපන් පරිවර්තන ලබාගත හැක.</li>
      </ol>
      <p class="text-xs text-ink/60 leading-relaxed">
        ※ පරිවර්තන ලේඛන <strong>කඩදාසි ස්වරූපයෙන් පමණක්</strong> වලංගුයි — copy, PDF, ෆොටෝ එකක් වලංගු නොවේ.<br>
        ※ පෞද්ගලිකත්ව ආරක්ෂාව සඳහා, email මගින් කරන පරිවර්තන ඉල්ලීම් භාරගනු නොලැබේ.
      </p>
    </section>

    <!-- 2. How to apply -->
    <section id="howto" class="bg-white rounded-2xl border border-black/5 shadow-sm p-5 rise-in">
      <h2 class="font-display font-bold text-base sm:text-lg text-ink mb-3">📝 2. අයදුම් කරන ආකාරය</h2>
      <ul class="space-y-2 text-sm text-ink/70 leading-relaxed">
        <li class="flex gap-2"><span class="text-accent-dark font-bold">•</span><span><strong>අයදුම් කරන ආකාරය:</strong> මාර්ගගත අයදුම්පත් <a href="https://translation.jaf.or.jp/honyaku/uketuke/?select_language=en" target="_blank" rel="noopener" class="text-primary hover:underline">Translation Application Site</a> එකෙන් ඉදිරිපත් කළ හැක. ※ ප්‍රවේශය ලැබෙන්නේ ජපානය තුළ ඇති network එකකින් පමණි.</span></li>
        <li class="flex gap-2"><span class="text-accent-dark font-bold">•</span><span><strong>ගෙවීමේ ක්‍රමය:</strong> Credit Card හෝ convenience store එකකදී cash ගෙවීම.</span></li>
        <li class="flex gap-2"><span class="text-accent-dark font-bold">•</span><span><strong>පරිවර්තනය ලැබෙන ආකාරය:</strong> ජපානය තුළ ඕනෑම convenience store එකකින් print කරගත හැක.</span></li>
        <li class="flex gap-2"><span class="text-accent-dark font-bold">•</span><span><strong>නිකුත් කිරීමට ගතවන දින ගණන:</strong>
          <ul class="list-disc list-inside ml-4 mt-1 space-y-1">
            <li>ස්විට්සර්ලන්තය, ජර්මනිය, ප්‍රංශය, බෙල්ජියම, මොනාකෝ, තායිවානය නිකුත් කළ බලපත්‍රවල ජපන් පරිවර්තන, සහ ජපන් බලපත්‍රවල චීන පරිවර්තන — සාමාන්‍යයෙන් <strong>වැඩ කරන දින 2–3ක්</strong>.</li>
            <li>ඉහත සඳහන් නොවන අනෙකුත් රටවල් / ප්‍රදේශ — සාමාන්‍යයෙන් <strong>වැඩ කරන දින 5–10ක්</strong>.</li>
          </ul>
        </span></li>
      </ul>
    </section>

    <!-- 3. Documents required -->
    <section id="docs" class="bg-white rounded-2xl border border-black/5 shadow-sm p-5 rise-in">
      <h2 class="font-display font-bold text-base sm:text-lg text-ink mb-3">📄 3. අවශ්‍ය ලේඛන</h2>
      <p class="text-sm text-ink/70 leading-relaxed mb-3"><strong>සියලුම රටවල් සඳහා —</strong> වලංගු රියදුරු බලපත්‍රයේ ඉදිරිපස සහ පිටුපස පින්තූර (image data).</p>
      <p class="text-sm font-semibold text-ink mb-2">රට අනුව අමතරව අවශ්‍ය ලේඛන:</p>
      <ul class="space-y-2 text-sm text-ink/70 leading-relaxed">
        <li class="flex gap-2"><span class="text-accent-dark font-bold">•</span><span><strong>චීන ජනරජය:</strong> රියදුරු බලපත්‍රයේ subpage එක පෙන්වන ලේඛනය.</span></li>
        <li class="flex gap-2"><span class="text-accent-dark font-bold">•</span><span><strong>සිරියානු අරාබි ජනරජය:</strong> Passport එක.</span></li>
        <li class="flex gap-2"><span class="text-accent-dark font-bold">•</span><span><strong>දකුණු කොරියාව, මියන්මාරය, සහ අරාබි භාෂාවෙන් ලියැවුණු බලපත්‍ර:</strong> Residence Card, ජපානයේ ලිපිනය සනාථ කරන ලේඛනයක් (certificate of residence), හෝ passport එක.</span></li>
      </ul>
    </section>

    <!-- 4. Fees -->
    <section id="fees" class="bg-white rounded-2xl border border-black/5 shadow-sm p-5 rise-in">
      <h2 class="font-display font-bold text-base sm:text-lg text-ink mb-3">💴 4. නිකුත් කිරීමේ ගාස්තු</h2>
      <div class="overflow-x-auto -mx-1 px-1">
        <table class="feetbl mb-3">
          <thead>
            <tr><th>පරිවර්තන වර්ගය</th><th>භාවිතයේ අරමුණ</th><th>පරිවර්තන ගාස්තුව</th><th>Print ගාස්තුව</th></tr>
          </thead>
          <tbody>
            <tr><td rowspan="2">ජපන් පරිවර්තනය</td><td>මුල් බලපත්‍රයට එකතු කර ජපානයේ රථ ධාවනය කිරීමට ※</td><td class="font-mono">¥6,000 (බදු රහිත)</td><td class="font-mono">¥20/පිටුව</td></tr>
            <tr><td>ජපන් රියදුරු බලපත්‍රයකට මාරු වීමට (Gaimen Kirikae)</td><td class="font-mono">¥6,600 (10% බද්ද ඇතුළත්)</td><td class="font-mono">¥20/පිටුව</td></tr>
            <tr><td>චීන පරිවර්තනය</td><td>තායිවානයේ රථ ධාවනය කිරීමට</td><td class="font-mono">¥7,000 (10% බද්ද ඇතුළත්)</td><td class="font-mono">¥20/පිටුව</td></tr>
          </tbody>
        </table>
      </div>
      <p class="text-xs text-ink/60 leading-relaxed">
        ※ මෙම ගාස්තුව සීමා වන්නේ පහත රටවල් / ප්‍රදේශ නිකුත් කළ බලපත්‍ර හිමියන්ට පමණි: ස්විට්සර්ලන්තය, ජර්මනිය, ප්‍රංශය, බෙල්ජියම, මොනාකෝ, තායිවානය.
      </p>
    </section>

    <!-- 5. Credit card flow -->
    <section id="flow-card" class="bg-white rounded-2xl border border-black/5 shadow-sm p-5 rise-in">
      <h2 class="font-display font-bold text-base sm:text-lg text-ink mb-3">💳 5. අයදුම් ක්‍රියාවලිය — Credit Card ගෙවීම</h2>
      <ul class="space-y-2 text-sm text-ink/70 leading-relaxed">
        <li class="flex gap-2"><span class="text-accent-dark font-bold">•</span><span>මාර්ගගතව අයදුම් කරන විට, ගෙවීම් කළ හැක්කේ Credit Card එකකින් පමණි. Debit/Prepaid කාඩ්පත් හෝ වෙනත් ගෙවීම් ක්‍රම භාරගනු නොලැබේ.</span></li>
        <li class="flex gap-2"><span class="text-accent-dark font-bold">•</span><span>සාමාන්‍යයෙන්, JAF කාර්ය මණ්ඩලය පරිවර්තන කටයුතු ආරම්භ කිරීමෙන් පසු අයදුම්පත අවලංගු කළ නොහැක. පරිවර්තන කටයුතු තවම ආරම්භ වී නොමැති නම්, My Page එකෙන් අවලංගු කළ හැක.</span></li>
      </ul>
    </section>

    <!-- 6. Cash flow -->
    <section id="flow-cash" class="bg-white rounded-2xl border border-black/5 shadow-sm p-5 rise-in">
      <h2 class="font-display font-bold text-base sm:text-lg text-ink mb-3">🏪 6. අයදුම් ක්‍රියාවලිය — Convenience Store කැෂ් ගෙවීම</h2>
      <ul class="space-y-2 text-sm text-ink/70 leading-relaxed">
        <li class="flex gap-2"><span class="text-accent-dark font-bold">•</span><span>convenience store එකකදී cash ගෙවීමට තෝරාගත් විට, ඔබේ අයදුම්පත භාරගත් පසු JAF ගෙන් ගෙවීම් උපදෙස් සහිත email එකක් ලැබේ (එදිනම සිට සති 1–2ක් දක්වා ගතවිය හැක). email එකේ උපදෙස් අනුව ගෙවීම සම්පූර්ණ කරන්න.</span></li>
        <li class="flex gap-2"><span class="text-accent-dark font-bold">•</span><span>ගෙවීම තහවුරු වූ වහාම JAF කාර්ය මණ්ඩලය පරිවර්තන කටයුතු ආරම්භ කරයි.</span></li>
        <li class="flex gap-2"><span class="text-accent-dark font-bold">•</span><span>JAF ව්‍යාපාරික වේලාවෙන් පිටත පැන නගින ගැටලු සම්බන්ධයෙන් ක්ෂණිකව ප්‍රතිචාර දැක්වීමට JAF හට නොහැකි විය හැක.</span></li>
        <li class="flex gap-2"><span class="text-accent-dark font-bold">•</span><span>convenience store එකේදී ගෙවීම <strong>cash මගින් පමණි</strong> — credit card, e-money, හෝ QR code ගෙවීම් භාරගනු නොලැබේ.</span></li>
        <li class="flex gap-2"><span class="text-accent-dark font-bold">•</span><span>පරිවර්තන කටයුතු ආරම්භ කිරීමෙන් පසු අවලංගු කළ නොහැක. තවම ආරම්භ වී නොමැති නම් My Page එකෙන් අවලංගු කළ හැක.</span></li>
        <li class="flex gap-2"><span class="text-accent-dark font-bold">•</span><span>පරිවර්තනය සාමාන්‍යයෙන් ගෙවීම තහවුරු වූ <strong>ඊළඟ දිනයේ</strong> නිකුත් වේ. ගෙවීමෙන් පසු පරිවර්තනය නිකුත් වන තෙක් convenience store එකේ රැඳී නොසිටින්න.</span></li>
      </ul>
    </section>

    <!-- 7. Convenience store payment steps -->
    <section id="cvs" class="bg-white rounded-2xl border border-black/5 shadow-sm p-5 rise-in">
      <h2 class="font-display font-bold text-base sm:text-lg text-ink mb-3">🏬 7. Convenience Store එකේදී ගෙවන ආකාරය (කඩේ අනුව)</h2>
      <p class="text-sm text-ink/70 leading-relaxed mb-3">
        My Page එකෙන් convenience store එක තෝරාගත් පසු, JAF විසින් payment slip number එකක් හෝ payment slip එකක් ලබා දෙනු ඇත. පහත එක් එක් store එකේදී ගෙවන ආකාරය බලන්න:
      </p>

      <div class="space-y-2">
        <details class="border border-black/5 rounded-xl bg-paper" open>
          <summary class="p-3 flex items-center justify-between gap-2">
            <span class="text-sm font-semibold text-ink">🔵 7-ELEVEN</span>
            <span class="chev text-ink/30 shrink-0">›</span>
          </summary>
          <div class="px-3 pb-3 text-sm text-ink/70 leading-relaxed space-y-2">
            <p><strong>1. ගෙවීම් තොරතුරු ඇතුළත් කිරීම:</strong> Pull-down menu එකෙන් "セブンイレブン (7-ELEVEN)" තෝරන්න. reception system එකෙන් auto-fill වූ තොරතුරු (accept number, phone, email) වැරදි නොවන බව සහතික කර "確認/Confirm" ක්ලික් කරන්න.</p>
            <p><strong>2. විස්තර තහවුරු කිරීම:</strong> ගෙවීමේ ක්‍රමය සහ මුදල පරීක්ෂා කර "支払う/Pay" ක්ලික් කරන්න.</p>
            <p><strong>3. අයදුම්පත සම්පූර්ණ වීම:</strong> "Payment slip number" එකක් ලැබේ — එය memo/screenshot එකක් ලෙස සුරකින්න. එසේත් නැතිනම් "Display payment slip" ක්ලික් කර payment slip එක print කරගන්න හෝ screenshot එකක් ගන්න. ගෙවීම් තහවුරු කිරීමේ email එකක්ද ලැබෙනු ඇත.</p>
            <p><strong>4. 7-Eleven store එකේ ගෙවීම:</strong> "Payment number" එකෙන් ගෙවනවා නම් — ඒ අංකය staff ට කියන්න. "Payment slip" එකෙන් ගෙවනවා නම් — print/screenshot එක store එකට රැගෙන යන්න.</p>
          </div>
        </details>

        <details class="border border-black/5 rounded-xl bg-paper">
          <summary class="p-3 flex items-center justify-between gap-2">
            <span class="text-sm font-semibold text-ink">🟢 FamilyMart</span>
            <span class="chev text-ink/30 shrink-0">›</span>
          </summary>
          <div class="px-3 pb-3 text-sm text-ink/70 leading-relaxed space-y-2">
            <p><strong>1–2.</strong> Pull-down menu එකෙන් "ファミリーマート (FamilyMart)" තෝරා, auto-fill තොරතුරු පරීක්ෂා කර "確認/Confirm" → "支払う/Pay" ක්ලික් කරන්න.</p>
            <p><strong>3.</strong> FamilyMart store එකේදී ගෙවීම සඳහා <strong>company code</strong> එකක් සහ <strong>order number</strong> එකක් ලැබේ — ඒවා print කර හෝ ලියාගන්න.</p>
            <p><strong>4. Store එකේදී:</strong> store එකේ ඇති multi-function copier එකේ ("Fami Port") උඩ screen එකේ "代金支払い/チャージ（コンビニでお支払い）" බටනය තෝරන්න (භාෂාව මාරු කළ හැක). "番号入力" තෝරා company code එක (20020) ඇතුළත් කර OK ක්ලික් කරන්න, පසුව order number එක (8න් පටන් ගන්නා ඉලක්කම් 12ක්) ඇතුළත් කරන්න. නියම නීති කියවා "同意して進む" ක්ලික් කරන්න, විස්තර තහවුරු කර "確認" ක්ලික් කරන්න. "application ticket" එකක් print වේ — එය රැගෙන cashier වෙතින් cash ගෙවන්න. ※ ticket එක print වී මිනිත්තු 30කින් වලංගු වේ.</p>
          </div>
        </details>

        <details class="border border-black/5 rounded-xl bg-paper">
          <summary class="p-3 flex items-center justify-between gap-2">
            <span class="text-sm font-semibold text-ink">🔴 LAWSON / MINISTOP</span>
            <span class="chev text-ink/30 shrink-0">›</span>
          </summary>
          <div class="px-3 pb-3 text-sm text-ink/70 leading-relaxed space-y-2">
            <p><strong>1–2.</strong> Pull-down menu එකෙන් "ローソン (LAWSON)" හෝ "ミニストップ (MINISTOP)" තෝරා, auto-fill තොරතුරු පරීක්ෂා කර "確認/Confirm" → "支払う/Pay" ක්ලික් කරන්න.</p>
            <p><strong>3.</strong> Store එකේදී ගෙවීම සඳහා <strong>"Receipt number"</strong> එකක් ලැබේ — print කර හෝ ලියාගන්න. ගෙවීමේදී මෙම අංකයට අමතරව, ඔබ registration එකේදී දුන් phone number එකද අවශ්‍ය වේ.</p>
            <p><strong>4. Store එකේදී:</strong> store එකේ ඇති "Loppi" terminal එකේ "各種番号をお持ちの方" බටනය තෝරන්න. Receipt number එක ඇතුළත් කර "次へ" ක්ලික් කරන්න, පසුව phone number එක ඇතුළත් කර "次へ" ක්ලික් කරන්න. විස්තර තහවුරු කර "はい" → notes කියවා "確定する" ක්ලික් කරන්න. "application ticket" එකක් print වේ (මිනිත්තු 30ක් වලංගු) — එය cashier වෙතින් cash ගෙවන්න, ගෙවීමෙන් පසු receipt එකක් ලබාගන්න.</p>
          </div>
        </details>

        <details class="border border-black/5 rounded-xl bg-paper">
          <summary class="p-3 flex items-center justify-between gap-2">
            <span class="text-sm font-semibold text-ink">🟡 Seicomart</span>
            <span class="chev text-ink/30 shrink-0">›</span>
          </summary>
          <div class="px-3 pb-3 text-sm text-ink/70 leading-relaxed space-y-2">
            <p><strong>1–2.</strong> Pull-down menu එකෙන් "セイコーマート (Seicomart)" තෝරා, auto-fill තොරතුරු පරීක්ෂා කර "確認/Confirm" → "支払う/Pay" ක්ලික් කරන්න.</p>
            <p><strong>3.</strong> Store එකේදී ගෙවීම සඳහා <strong>"Receipt number"</strong> එකක් ලැබේ — print කර හෝ ලියාගන්න. ගෙවීමේදී registration එකේදී දුන් phone number එකද අවශ්‍ය වේ.</p>
            <p><strong>4. Store එකේදී:</strong> cashier ට ඔබ online ගෙවීමක් කරන බව කියන්න. cash register screen එකේදී පෙර ලියාගත් Receipt number එක ඇතුළත් කරන්න, පසුව registration එකේ දුන් phone number එක ඇතුළත් කර "登録" ක්ලික් කරන්න. ගෙවීමේ විස්තර පරීක්ෂා කර "OK" ක්ලික් කරන්න, පසුව cash ගෙවන්න. ※ ගෙවීම cash මගින් පමණි, ගෙවීමෙන් පසු refund නොලැබේ.</p>
          </div>
        </details>
      </div>
    </section>

    <!-- 8. Printing -->
    <section id="print" class="bg-white rounded-2xl border border-black/5 shadow-sm p-5 rise-in">
      <h2 class="font-display font-bold text-base sm:text-lg text-ink mb-3">🖨️ 8. පරිවර්තනය Print කරගන්නා ආකාරය</h2>
      <p class="text-sm text-ink/70 leading-relaxed mb-2">
        Translation Application Site එකෙන් අයදුම් කර ඇත්නම්, ජපානය තුළ ඕනෑම convenience store එකකදී <strong>netprint®</strong> සේවාව හරහා පරිවර්තනය print කරගත හැක.
      </p>
      <p class="text-xs text-ink/60 leading-relaxed">
        ※ මුල් print reference number එක සතියක් වලංගුයි. නමුත් අයදුම් කළ දින සිට වසරක් ඇතුළත My Page එකෙන් අලුත් reference number එකක් reissue කරගත හැක.
      </p>
    </section>

    <!-- 9. Receipts -->
    <section id="receipt" class="bg-white rounded-2xl border border-black/5 shadow-sm p-5 rise-in">
      <h2 class="font-display font-bold text-base sm:text-lg text-ink mb-3">🧾 9. රිසිට්පත ලබාගන්නා ආකාරය</h2>
      <p class="text-sm text-ink/70 leading-relaxed">
        රිසිට්පත් Translation Application Site එකේ My Page එකෙන් නිකුත් කරගත හැක. නිකුත් කරගත හැකි වේලාව ගෙවීමේ ක්‍රමය අනුව වෙනස් වේ — විස්තර සඳහා පහත <a href="#faq" class="text-primary hover:underline">FAQ</a> කොටස බලන්න.
      </p>
    </section>

    <!-- 10. Samples -->
    <section id="samples" class="bg-white rounded-2xl border border-black/5 shadow-sm p-5 rise-in">
      <h2 class="font-display font-bold text-base sm:text-lg text-ink mb-3">🗂️ 10. පරිවර්තන සාම්පල</h2>
      <p class="text-sm text-ink/70 leading-relaxed mb-2">JAF විසින් නිකුත් කරන ජපන් පරිවර්තනවල, කාලයත් සමඟ paper format එක වෙනස් වී ඇත:</p>
      <ul class="list-disc list-inside text-sm text-ink/70 leading-relaxed space-y-1 mb-2">
        <li>2017 දෙසැම්බර්ට පෙර නිකුත් කළ ජපන් පරිවර්තනය</li>
        <li>2017 දෙසැම්බර් සිට (copy guard paper භාවිතයෙන්)</li>
        <li>2022 නොවැම්බර් සිට (copy-protection printing)</li>
        <li>2024 නොවැම්බර් සිට, background pattern printing සම්බන්ධ text එකක් රතු frame එකට එකතු කර ඇත (copy prevention)</li>
      </ul>
      <p class="text-xs text-ink/60 leading-relaxed mb-2">※ 2022 ඔක්තෝබර් සිට, convenience store එකකින් print කරගන්නා පරිවර්තන (3),(4) ආකෘතියේ paper එකේ print වේ; තැපෑලෙන් ලැබෙන හෝ පෞද්ගලිකව ලබාගන්නා පරිවර්තන (2) ආකෘතියේ paper එකේ print වේ.</p>
      <p class="text-sm text-ink/70 leading-relaxed">
        සමහර රටවල් නිකුත් කළ බලපත්‍රවලට, බලපත්‍ර වර්ගය/වෙනත් විස්තර පැහැදිලි කිරීම සඳහා <strong>Appendix</strong> එකක් අවශ්‍ය වේ. ඔබේ පරිවර්තනයට Appendix එකක් අවශ්‍ය නම්, ප්‍රධාන ලේඛනයේ පහළ වම් කෙළවරේ එය සටහන් වී ඇත — convenience store එකෙන් print කරගන්නා විට Appendix එකද print කර ජපානයේ රථ ධාවනය කිරීමට එය සමඟ රැගෙන යාමට අමතක නොකරන්න.
      </p>
    </section>

    <!-- 11. Precautions -->
    <section id="precautions" class="notice-box rounded-2xl p-5 rise-in">
      <h2 class="font-display font-bold text-base sm:text-lg text-ink mb-3">⚠️ 11. වැදගත් අවවාද</h2>
      <ul class="space-y-2 text-sm text-ink/80 leading-relaxed">
        <li class="flex gap-2"><span class="text-accent-dark font-bold">•</span><span>විදේශීය බලපත්‍රයක් ජපන් බලපත්‍රයකට මාරු කිරීමට (Gaimen Kirikae) කොන්දේසි දෙකක් සම්පූර්ණ විය යුතුය: (1) විදේශීය බලපත්‍රය වලංගු විය යුතුය (කල් ඉකුත් වූ බලපත්‍ර මාරු කළ නොහැක), (2) බලපත්‍රය ලබාගත් දින සිට එය නිකුත් කළ රටේ අවම වශයෙන් මුළු මසුන් 3ක් වාසය කර ඇති බව සනාථ කළ යුතුය.</span></li>
        <li class="flex gap-2"><span class="text-accent-dark font-bold">•</span><span>JAF විසින් International Driving Permits පරිවර්තනය කරන්නේ නැත.</span></li>
        <li class="flex gap-2"><span class="text-accent-dark font-bold">•</span><span>ඔබේ විදේශීය රියදුරු බලපත්‍රය renew කළහොත් හෝ ලිපිනය වැනි වෙනස්කම් සිදු කළහොත්, අලුත් පරිවර්තනයක් ලබාගත යුතුය.</span></li>
        <li class="flex gap-2"><span class="text-accent-dark font-bold">•</span><span>බලපත්‍රය අනුව, සමහර අවස්ථාවලදී JAF හට පරිවර්තනයක් නිකුත් කිරීමට නොහැකි විය හැක.</span></li>
        <li class="flex gap-2"><span class="text-accent-dark font-bold">•</span><span>අයදුම් කළ හැක්කේ ජපානය තුළ සිට, මාර්ගගතව පමණි.</span></li>
        <li class="flex gap-2"><span class="text-accent-dark font-bold">•</span><span>ගෙවීම් සම්පූර්ණ කිරීමේ ගැටලු මගහරවා ගැනීම සඳහා, Debit/Prepaid කාඩ්පත් භාරගනු නොලැබේ.</span></li>
        <li class="flex gap-2"><span class="text-accent-dark font-bold">•</span><span>JAF පරිවර්තනයක් ලබාගැනීමට නොහැකි වීම නිසා ඔබේ සංචාරක සැලසුම්වල සිදුවන වෙනස්කම් සම්බන්ධයෙන් JAF වගකිව යුතු නොවේ.</span></li>
        <li class="flex gap-2"><span class="text-accent-dark font-bold">•</span><span>අයදුම් කිරීමට පෙර ඉහත සියලුම තොරතුරු හා අවවාද හොඳින් කියවා තේරුම් ගන්න.</span></li>
      </ul>
    </section>

    <!-- 12. FAQ -->
    <section id="faq" class="bg-white rounded-2xl border border-black/5 shadow-sm p-5 rise-in">
      <h2 class="font-display font-bold text-base sm:text-lg text-ink mb-4">❓ 12. නිතර අසන ප්‍රශ්න (FAQ)</h2>

      <h3 class="font-display font-bold text-sm text-primary mt-4 mb-2">අයදුම් කිරීම / ගෙවීම් / ගාස්තු</h3>
      <div class="space-y-2">
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">පරිවර්තනයක් නිකුත් කිරීමට කීයක් වැය වේද?<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">නිකුත් කිරීමේ ගාස්තුව පරිවර්තනයේ භාවිතයේ අරමුණ අනුව වෙනස් වේ. විස්තර සඳහා ඉහත <a href="#fees" class="text-primary hover:underline">"නිකුත් කිරීමේ ගාස්තු"</a> කොටස බලන්න.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">ඕනෑම convenience store එකකින් පරිවර්තනය print කරගත හැකිද?<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">ඔබ ලියාපදිංචි කළ store එකේ multi-function copier එකෙන් netprint® සේවාව හරහා print කරගත හැක. විස්තර සඳහා ඉහත <a href="#print" class="text-primary hover:underline">"Print කරගන්නා ආකාරය"</a> කොටස බලන්න.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">ගෙවීමට කුමන credit card වර්ග භාරගනු ලැබේද?<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">VISA, MasterCard, JCB, American Express, හෝ Diners Club භාවිත කළ හැක.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">Card ගෙවීම error එකක් ලෙස පෙන්වයි.<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">Debit/Prepaid කාඩ්පත් භාවිත කළ නොහැක. අයදුම්පත සම්පූර්ණ වූ බව සනාථ කරන email එකක් ලැබී නොමැති නම්, ඔබේ අයදුම්පත සම්පූර්ණ වී නැත — නැවත අයදුම් කළ යුතුය. පරිවර්තනය නිකුත් වන තෙක් කිසිදු ගාස්තුවක් අය නොකෙරේ.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">Installments (කොටස් වශයෙන්) ගෙවිය හැකිද?<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">නැත. සම්පූර්ණ මුදල එකවර පමණක් භාරගනු ලැබේ.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">Credit card එකෙන් අය කරන්නේ කවදාද?<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">පරිවර්තනය convenience store එකකින් print කිරීමට සූදානම් වූ විට card එකෙන් අය කෙරේ. ඔබ නියෝජිතයෙකු ලෙස එකවර අයදුම්පත් කිහිපයක් ඉදිරිපත් කර ඇත්නම්, සියලුම පරිවර්තන print කිරීමට සූදානම් වූ විට card එකෙන් අය කෙරේ.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">Refund කරන ආකාරය කෙසේද?<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">එය ඔබේ ගෙවීමේ ක්‍රමය මත රඳා පවතී. My Page එකේ පහළ ඇති Message හරහා JAF ට හෝ JAF Customer Service Center එකට සම්බන්ධ වන්න.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">එකවර පුද්ගලයන් කිහිප දෙනෙකු සඳහා අයදුම් කරන්නේ කෙසේද?<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">Translation Application Site එකේ ඉහළ ඇති "නියෝජිතයෙකු ලෙස පුද්ගලයන් කිහිප දෙනෙකු සඳහා අයදුම් කිරීම" කොටස තෝරන්න. එකවර අයදුම් කළ හැක්කේ උපරිම 30ක් දක්වා පමණි.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">Convenience store එකේ ගෙවීමට කාලසීමාව කුමක්ද?<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">දළ වශයෙන් මාස 2ක්. එම කාලය ඉකුත් වී ඇත්නම්, convenience store එක නැවත තෝරාගන්න.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">ගෙවන convenience store එක වෙනස් කළ හැකිද?<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">ඔබේ අයදුම්පත අවලංගු කර නැවත අයදුම් කරන්න.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">Convenience store එකේ ගෙවන්නේ කෙසේද? / ගෙවීම පිළිබඳ email එකක් ලැබුණේ නැහැ.<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">JAF කාර්ය මණ්ඩලයේ අයෙකු ඔබ ලියාපදිංචි කළ තොරතුරු තහවුරු කිරීමෙන් පසුව, ගෙවීම සම්බන්ධ email එකක් ලැබේ — මෙයට සතියක් පමණ ගතවිය හැක. email එක ලැබුණු පසු, ඔබ ගෙවීමට කැමති convenience store එක තෝරා උපදෙස් අනුව ගෙවීම සම්පූර්ණ කරන්න.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">convenience store payment number එක සොයාගන්නේ කෙසේද?<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">Application site එකේ My Page එකෙන් පරීක්ෂා කළ හැක. නමුත් My Page එකේ වෙනස්කම් පිළිබිඹු වීමට පැයක් පමණ ගතවිය හැක. ඉක්මනින් අවශ්‍ය නම්, communication section එක හරහා අප හා සම්බන්ධ වන්න.</div></details>
      </div>

      <h3 class="font-display font-bold text-sm text-primary mt-6 mb-2">පරිවර්තනයක් සඳහා අයදුම් කිරීම</h3>
      <div class="space-y-2">
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">රියදුරු බලපත්‍රයට අමතරව අවශ්‍ය වන්නේ කුමක්ද?<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">(1) වලංගු රියදුරු බලපත්‍රයේ ඉදිරිපස සහ පිටුපස පින්තූර, සහ (2) පරිවර්තන ගාස්තුව. බලපත්‍රය නිකුත් කළ රට අනුව අමතර ලේඛන අවශ්‍ය විය හැක — විස්තර සඳහා ඉහත <a href="#docs" class="text-primary hover:underline">"අවශ්‍ය ලේඛන"</a> කොටස බලන්න.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">Counter එකෙන් හෝ තැපෑලෙන් අයදුම් කළ හැකිද?<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">නැත. Counter එකෙන් හෝ තැපෑලෙන් අයදුම් කළ නොහැක. මාර්ගගතව පමණක් අයදුම් කරන්න.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">වෙනත් කෙනෙකුට මා වෙනුවෙන් අයදුම් කළ හැකිද?<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">ඔව්, නියෝජිතයන්ගෙන් අයදුම්පත් භාරගනු ලැබේ. Translation Application Site එකේ ඉහළ ඇති නියෝජිතයන් සඳහා වන කොටස තෝරා තොරතුරු ඇතුළත් කරන්න.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">Email address එක register කරන්නේ කොහෙද?<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">"Start application procedure" ක්ලික් කර email address registration එකට යන්න.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">Verification email එකක් ලැබුණේ නැහැ.<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">ලියාපදිංචි කළ email address එක නිවැරදිද කියා පරීක්ෂා කරන්න. jafnavi.jp domain එකෙන් email ලැබීමට setting එක ඉඩ දෙන බවද තහවුරු කරන්න.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">Print කරගැනීමට කොපමණ කාලයක් ගතවේද?<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">සාමාන්‍යයෙන් අයදුම් කළ දින සිට print කළ හැකි වන තෙක් සති 1–2ක් ගතවේ. අරාබි භාෂාවෙන් ලියැවුණු බලපත්‍ර, හෝ දකුණු කොරියාව, තායිලන්තය, මියන්මාරය වැනි රටවල් නිකුත් කළ බලපත්‍ර සඳහා සති 2–3ක් ගතවිය හැක. බලපත්‍රය අනුව සොයා බැලීමට තව කාලයක් ගතවිය හැකි නිසා, කලින්ම අයදුම් කරන්න.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">අයදුම් කළ දිනයේම පරිවර්තනය නිකුත් කළ හැකිද?<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">නැත. JAF එදිනෙදා (same-day) delivery ලබා නොදේ.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">තැපෑලෙන් අයදුම් කළ විට එය ප්‍රතික්ෂේප වුණා.<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">තැපැල් අයදුම්පත් භාරගනු නොලැබේ. මාර්ගගතව අයදුම් කරන්න.</div></details>
      </div>

      <h3 class="font-display font-bold text-sm text-primary mt-6 mb-2">Print කිරීම / නිකුත් කිරීම</h3>
      <div class="space-y-2">
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">කුමන convenience store වලින් print කරගත හැකිද?<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">ජපානය තුළ ඕනෑම 7-Eleven, FamilyMart, LAWSON, MINISTOP, හෝ Poplar Group store එකකින් print කරගත හැක (සුළු ව්‍යතිරේකයන් හැර).</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">Convenience store එකේ print කිරීම සාර්ථක වුණේ නැහැ.<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">My Page එකේ පහළ ඇති Message හරහා JAF ට හෝ JAF Customer Service Center එකට සම්බන්ධ වන්න.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">"Specific countries" යනුවෙන් අදහස් කරන්නේ කුමක්ද?<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">ස්විට්සර්ලන්තය, ජර්මනිය, ප්‍රංශය, බෙල්ජියම, මොනාකෝ, තායිවානය. මෙම රටවලින් නිකුත් කළ බලපත්‍රයක් ඇත්නම්, මුල් බලපත්‍රය සමඟ ජපන් පරිවර්තනයක් රැගෙන ගිය විට ජපානයේ නීති අනුව රථ ධාවනය කළ හැක.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">පරිවර්තනය නැවත print කළ හැකිද?<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">නැත. පරිවර්තනය print කළ හැක්කේ එක් වරක් පමණි. නැවත print කිරීමට අවශ්‍ය නම් අලුත් පරිවර්තනයක් අයදුම් කරන්න.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">පරිවර්තනය PDF එකක් ලෙස ලබාගත හැකිද / ගෙදරදී print කළ හැකිද?<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">නැත. ජපානයේ ඕනෑම convenience store එකකින් හෝ JAF branch එකකින් print කරගත් මුල් කඩදාසි පිටපත පමණක් වලංගුයි.</div></details>
      </div>

      <h3 class="font-display font-bold text-sm text-primary mt-6 mb-2">JAF පරිවර්තන</h3>
      <div class="space-y-2">
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">International Driving Permit එක පරිවර්තනය කරගත හැකිද?<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">නැත. JAF International Driving Permits පරිවර්තනය කරන්නේ නැත.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">පරිවර්තනයට කල් ඉකුත්වීමේ දිනයක් තිබේද? කොපමණ කලක් වලංගුද?<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">මුල් රියදුරු බලපත්‍රය වලංගු පවතින තාක් පරිවර්තනයද වලංගුයි. ස්විට්සර්ලන්තය, ජර්මනිය, ප්‍රංශය, බෙල්ජියම, මොනාකෝ, තායිවානය නිකුත් කළ බලපත්‍රවල පරිවර්තන, ජපානයට පැමිණි දින සිට වසරක් වලංගුයි (ආපසු පැමිණ නම්, නැවත ඇතුළු වූ දින සිට වසරක්). මාස 3කට අඩු කාලයක් තුළ ජපානයෙන් පිටව ආපසු පැමිණෙන ලියාපදිංචි (Basic Resident Register) පදිංචිකරුවන්ට කොන්දේසි වෙනස් වේ — විස්තර සඳහා ඔබේ ප්‍රදේශයේ Driver's License Center අමතන්න.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">බලපත්‍රය ලබාගත් රටේ මුළු මසුන් 3ක් වාසය කර නොමැති නම් පරිවර්තනයක් අයදුම් කළ හැකිද?<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">මුලින්ම, ඔබේ බලපත්‍රය මාරු කළ හැකිදැයි Driver's License Center එකෙන් පරීක්ෂා කරන්න.</div></details>
      </div>

      <h3 class="font-display font-bold text-sm text-primary mt-6 mb-2">අවලංගු කිරීම්</h3>
      <div class="space-y-2">
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">අයදුම්පත අවලංගු කිරීමට කැමති නම් කුමක් කළ යුතුද?<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">එය ඔබ කළ ගෙවීමේ ක්‍රමය මත රඳා පවතී. JAF පරිවර්තන කටයුතු ආරම්භ කිරීමට පෙර credit card එකෙන් ගෙවා ඇත්නම්, My Page එකෙන් අවලංගු කළ හැක. convenience store එකකින් cash ගෙවීමට සැලසුම් කර ඇත්නම්, ගෙවීමට පෙර අවලංගු කළ හැක — පරිවර්තන කටයුතු ආරම්භ වී ඇත්දැයි My Page එකෙන් පරීක්ෂා කරන්න.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">පරිවර්තනයේ වැරැද්දක් තිබේ. කුමක් කළ යුතුද?<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">My Page එකේ පහළ ඇති Message හරහා JAF ට හෝ JAF Customer Service Center එකට සම්බන්ධ වන්න.</div></details>
      </div>

      <h3 class="font-display font-bold text-sm text-primary mt-6 mb-2">Application Site එක භාවිත කිරීම</h3>
      <div class="space-y-2">
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">නම කුමන භාෂාවෙන් ඇතුළත් කළ යුතුද?<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">ඔබේ රියදුරු බලපත්‍රයේ ඇති පරිදිම නම ඇතුළත් කරන්න, එය Latin අකුරෙන් නොමැති නම් හැර. බලපත්‍රයේ නම අරාබි, කොරියානු, තායි, බුරුම, හෝ රුසියානු වැනි වෙනත් අකුරින් ලියා ඇත්නම්, එය ජපන් හෝ ඉංග්‍රීසි භාෂාවෙන් ඇතුළත් කරන්න.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">ලියාපදිංචි වන අතරතුර hotel කිහිපයක නවාතැන් ගන්නවා නම් කුමන ලිපිනය භාවිත කළ යුතුද?<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">බෙදාහැරීමේ නියමිත දිනයේ (සාමාන්‍යයෙන් අයදුම් කළ දින සිට සති 1–2කින්) ඔබ නවාතැන් ගන්නා hotel එකේ ලිපිනය ලියාපදිංචි කරන්න. එම ලිපිනයට බෙදාහැරීමක් ලබාගැනීම අපහසු නම්, නියෝජිතයෙකුගේ ලිපිනය ලියාපදිංචි කරන්න.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">බලපත්‍ර අංකය කොහෙද තියෙන්නේ කියා තේරෙන්නේ නෑ.<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">බලපත්‍ර අංකය සාමාන්‍යයෙන් "license no." හෝ "registration no." ලෙස සඳහන් ස්ථානයේ ඇත. පරිවර්තන කටයුතු ආරම්භ කිරීමට පෙර JAF කාර්ය මණ්ඩලය මෙය තහවුරු කරන බැවින් නොසැලකිලිමත් වන්න.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">නැවත ජපානයට පැමිණි විට එකම account එක භාවිත කළ හැකිද?<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">මුල් පරිවර්තනය නිකුත් වී ඇති කාලයක් ගතවූ පසු ඔබේ account තොරතුරු delete වේ. අලුත් පරිවර්තනයක් අවශ්‍ය නම් අලුත් account එකකින් අයදුම් කරන්න.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">Message එක සොයාගන්නේ කොහෙද?<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">log in වී අදාළ අයදුම්පතේ issuance status එක බැලූ පසු, My Page එකේ පහළම Message එක ඇත.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">ලියාපදිංචි තොරතුරු වෙනස් කරන්නේ කෙසේද?<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">තහවුරු කිරීමට තවම සූදානම් නම්, Back බටනයෙන් නැවත ගොස් වෙනස් කරන්න. දැනටමත් ලියාපදිංචිය තහවුරු කර ඇත්නම්, My Page එකේ Message හරහා JAF ට වෙනස්කම් අවශ්‍ය බව දන්වන්න.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">ජපන් නොව චීන පරිවර්තනයක් අවශ්‍යයි, setting එක වෙනස් කළ නොහැකියි.<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">Application screen එකේ ඉහළ වම් කෙළවරේ JAF logo එක ක්ලික් කර top page එකට ගොස්, screen එකේ පහළ ඇති Chinese translation page එකට log in වී අයදුම් කරන්න.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">ගෙවීමේ රිසිට්පතක් ලබාගන්නේ කෙසේද?<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">ගෙවීමේ ක්‍රමය අනුව රිසිට්පත නිකුත් වන කාලය තීරණය වේ. <strong>Credit Card ගෙවීම:</strong> පරිවර්තනය නිකුත් කිරීමට ලැබෙන ඊළඟ දින සිට My Page එකේ පහළ receipt එකට යවනු ලබන්නාගේ නම සඳහන් කර ලබාගන්න. <strong>Convenience store cash ගෙවීම:</strong> convenience store එකේදී ගෙවීම කළ ඊළඟ දින සිට ලබාගත හැක. ※ My Page එකට log in වීමේ කාලය ඉකුත් වීමට පෙර රිසිට්පත print කළ යුතුය. රිසිට්පත් එක් වරක් පමණක් නිකුත් වේ — නම වෙනස් කිරීමට අවශ්‍ය නම් වහාම Message හරහා හෝ JAF branch එකකට සම්බන්ධ වන්න.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">මගේ පෙර අයදුම්පත් ඉතිහාසය පරීක්ෂා කළ හැකිද?<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">අවසන් අයදුම් කිරීමෙන් වසරක් ඇතුළත නම් ඉතිහාසය පරීක්ෂා කළ හැක. වසරකට වඩා කාලයක් ගතවී ඇත්නම් account තොරතුරු delete වී ඇත.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">Driver's license image එක upload කළ නොහැක.<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">image data ගබඩා කර ඇති format එක පරීක්ෂා කරන්න. Translation Application Site එකේ භාවිත කළ හැක්කේ <strong>JPEG</strong> format එක පමණි.</div></details>
        <details class="border border-black/5 rounded-xl bg-paper"><summary class="p-3 text-sm font-semibold text-ink flex justify-between gap-2">iPhone එකෙන් ගත් image data register කළ නොහැක.<span class="chev text-ink/30">›</span></summary><div class="px-3 pb-3 text-sm text-ink/70">iPhone එකේ ෆොටෝ JPEG format එකේ save කිරීමට: Settings → Camera → Formats → Most Compatible තෝරා පසුව ෆොටෝ එක ගන්න.</div></details>
      </div>
    </section>

    <!-- CTA back to site -->
    <div class="bg-gradient-to-br from-primary via-primary-dark to-ink text-white rounded-2xl shadow-xl p-6 text-center rise-in">
      <h3 class="font-display font-bold text-lg mb-2">ජපන් රියදුරු බලපත්‍ර න්‍යාය විභාගයට සූදානම්ද?</h3>
      <p class="text-xs sm:text-sm text-white/70 mb-4">Menkyoo.jp හි ප්‍රශ්න 1000+ක් සමඟ නොමිලේ පුහුණු වන්න.</p>
      <a href="index.php" class="inline-block bg-accent hover:brightness-95 text-ink font-bold px-6 py-3 rounded-xl transition shadow-lg text-sm">
        නොමිලේ පරීක්ෂණය ආරම්භ කරන්න →
      </a>
    </div>

    <p class="text-[11px] text-ink/40 text-center pt-2">
      මූලාශ්‍රය: JAF (Japan Automobile Federation) — Driving License Translation Application Service (DLTAS). නිල හා යාවත්කාලීන තොරතුරු සඳහා
      <a href="https://english.jaf.or.jp/driving-in-japan/drive-in-japan/about-dltas" target="_blank" rel="noopener" class="text-primary hover:underline">JAF නිල වෙබ් අඩවිය</a> පරීක්ෂා කරන්න.
    </p>

  </div>
</main>

<footer class="text-center py-8 text-xs text-ink/40 border-t border-black/5 bg-white">
  <p>Japan Driving License Practice System &copy; 2026</p>
  <a href="index.php" class="text-primary hover:underline font-medium">→ නොමිලේ පරීක්ෂණය අරඹන්න</a>
</footer>

</body>
</html>