<?php
session_start();
require_once __DIR__ . '/../visitor.php';

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
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>Types of Traffic Signs — Japan Driving Rules Reference (Sinhala) | Menkyoo.jp</title>
<meta name="description" content="A complete bilingual (English / Sinhala) reference of Japan's traffic signs: prohibition, guide, warning, instruction and auxiliary signs, with images and plain explanations.">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://menkyoo.jp/traffic-signs.php">
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
  .font-si, [data-si]{ font-family:'Noto Sans Sinhala', sans-serif; }
  *:focus-visible{ outline: 3px solid #F2A73B; outline-offset: 2px; }
  @keyframes riseIn{ from{ opacity:0; transform:translateY(8px);} to{ opacity:1; transform:translateY(0);} }
  .rise-in{ animation: riseIn .3s ease-out both; }
  @media (prefers-reduced-motion: reduce){ .rise-in{ animation:none; } }
  .grid-texture{
    background-image:
      linear-gradient(to right, rgba(15,47,110,0.06) 1px, transparent 1px),
      linear-gradient(to bottom, rgba(15,47,110,0.06) 1px, transparent 1px);
    background-size: 28px 28px;
  }
  #sign-nav::-webkit-scrollbar{ display:none; }
  #sign-nav{ -ms-overflow-style:none; scrollbar-width:none; }
</style>
</head>
<body class="bg-paper text-ink font-body min-h-screen flex flex-col">
<script>window.__USER__ = <?php echo $sessionUser ? json_encode($sessionUser, JSON_UNESCAPED_UNICODE) : 'null'; ?>;</script>

<header class="sticky top-0 z-40 bg-primary text-white shadow-lg shadow-primary/10">
  <div class="max-w-5xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-3">
    <a href="index.php" class="flex items-center gap-2 shrink-0">
      <svg width="28" height="28" viewBox="0 0 48 48" fill="none" aria-hidden="true"><circle cx="24" cy="24" r="21" stroke="#F2A73B" stroke-width="3"/><circle cx="24" cy="24" r="5.5" fill="#F2A73B"/><path d="M24 3v10M24 35v10M3 24h10M35 24h10M9.5 9.5l7 7M31.5 31.5l7 7M9.5 38.5l7-7M31.5 16.5l7-7" stroke="#F2A73B" stroke-width="2.5" stroke-linecap="round"/></svg>
      <span class="font-display font-bold text-sm sm:text-base">Menkyoo.jp</span>
    </a>
    <div class="flex items-center gap-2 sm:gap-3">
      <div class="bg-white/10 p-1 rounded-lg flex text-xs sm:text-sm">
        <button id="btn-en" onclick="setLanguage('en')" class="px-2.5 sm:px-3 py-1 rounded-md bg-white text-primary font-semibold transition">EN</button>
        <button id="btn-si" onclick="setLanguage('si')" class="px-2.5 sm:px-3 py-1 rounded-md text-white font-semibold transition font-si">සිං</button>
      </div>
      <a href="index.php" class="text-xs sm:text-sm font-semibold bg-accent text-ink px-3 sm:px-4 py-2 rounded-lg hover:brightness-95 transition">
        <span data-en="Take Quiz" data-si="පරීක්ෂණය">Take Quiz</span>
      </a>
    </div>
  </div>
</header>

<main class="flex-grow w-full">

  <div class="grid-texture border-b border-black/5">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 pt-10 sm:pt-14 pb-8 sm:pb-10 text-center">
      <span class="inline-block text-[11px] font-bold tracking-widest uppercase bg-accent-light text-primary px-3 py-1 rounded-full border border-accent/40 mb-4" data-en="Reference Guide" data-si="යොමු මාර්ගෝපදේශය">Reference Guide</span>
      <h1 class="font-display font-bold text-2xl sm:text-4xl text-ink leading-tight" data-en="Types of Traffic Signs" data-si="ගමනාගමන ලකුණු වර්ග">Types of Traffic Signs</h1>
      <p class="mt-4 text-sm sm:text-base text-ink/60 max-w-2xl mx-auto" data-en="There are four main types of road traffic signs in Japan: Prohibition signs (regulations), Guide signs, Warning signs, and Guide signs (instructions) — plus the auxiliary supplementary signs and a few special-purpose marks used alongside them." data-si="ජපානයේ ප්‍රධාන ගමනාගමන ලකුණු වර්ග හතරක් ඇත: තහනම් ලකුණු, උපදෙස් ලකුණු, අවවාද ලකුණු සහ මාර්ග ලකුණු — මීට අමතරව අතිරේක ලකුණු සහ විශේෂ අරමුණු සඳහා ලකුණු කිහිපයක්ද භාවිතා වේ.">
        There are four main types of road traffic signs in Japan: Prohibition signs (regulations), Guide signs, Warning signs, and Guide signs (instructions) — plus the auxiliary supplementary signs and a few special-purpose marks used alongside them.
      </p>
    </div>
  </div>

  <div class="max-w-4xl mx-auto px-4 sm:px-6 py-8">

    <nav id="sign-nav" class="flex gap-2 overflow-x-auto mb-10 pb-1">
<a href="#sec-0" class="shrink-0 text-xs font-semibold bg-white border border-black/10 hover:border-primary/40 hover:text-primary text-ink/70 px-3 py-1.5 rounded-full transition whitespace-nowrap" data-en="Prohibition Signs (Regulations)" data-si="Prohibition Signs (Regulations)">Prohibition Signs (Regulations)</a>
<a href="#sec-1" class="shrink-0 text-xs font-semibold bg-white border border-black/10 hover:border-primary/40 hover:text-primary text-ink/70 px-3 py-1.5 rounded-full transition whitespace-nowrap" data-en="Guide Signs" data-si="Guide Signs">Guide Signs</a>
<a href="#sec-2" class="shrink-0 text-xs font-semibold bg-white border border-black/10 hover:border-primary/40 hover:text-primary text-ink/70 px-3 py-1.5 rounded-full transition whitespace-nowrap" data-en="Warning Signs" data-si="Warning Signs">Warning Signs</a>
<a href="#sec-3" class="shrink-0 text-xs font-semibold bg-white border border-black/10 hover:border-primary/40 hover:text-primary text-ink/70 px-3 py-1.5 rounded-full transition whitespace-nowrap" data-en="Guide Signs (Instructions)" data-si="Guide Signs (Instructions)">Guide Signs (Instructions)</a>
<a href="#sec-4" class="shrink-0 text-xs font-semibold bg-white border border-black/10 hover:border-primary/40 hover:text-primary text-ink/70 px-3 py-1.5 rounded-full transition whitespace-nowrap" data-en="Auxiliary Signs (Supplementary Information)" data-si="Auxiliary Signs (Supplementary Information)">Auxiliary Signs (Supplementary Information)</a>
<a href="#sec-5" class="shrink-0 text-xs font-semibold bg-white border border-black/10 hover:border-primary/40 hover:text-primary text-ink/70 px-3 py-1.5 rounded-full transition whitespace-nowrap" data-en="Other Signs" data-si="Other Signs">Other Signs</a>
    </nav>

    <section id="sec-0" class="mb-10 scroll-mt-24">
      <div class="flex items-center gap-3 mb-4">
        <span class="w-8 h-8 rounded-lg bg-primary text-white flex items-center justify-center font-display font-bold text-sm shrink-0">1</span>
        <div>
          <h2 class="font-display font-bold text-lg sm:text-xl text-ink" data-en="Prohibition Signs (Regulations)" data-si="Prohibition Signs (Regulations)">Prohibition Signs (Regulations)</h2>
          <p class="text-xs text-ink/40 font-si">禁止標識 &middot; 53 <span data-en="signs" data-si="ලකුණු">signs</span></p>
        </div>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei01.jpg" alt="No Passage" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei01.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="No Passage" data-si="ගමන් කිරීම තහනම්">No Passage</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="No passage is allowed for all pedestrians, vehicles, and trams." data-si="පදිකයින්, වාහන සහ ට්‍රෑම් සියල්ලටම ගමන් කිරීම තහනම්ය.">No passage is allowed for all pedestrians, vehicles, and trams.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei02.jpg" alt="No Vehicle Passage" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei02.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="No Vehicle Passage" data-si="වාහන ගමන් කිරීම තහනම්">No Vehicle Passage</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Vehicles (automobiles, motorized bicycles, and light vehicles) are not allowed to pass." data-si="වාහන (මෝටර් රථ, මෝටර් සයිකල් සහ සැහැල්ලු වාහන) ගමන් කිරීමට අවසර නැත.">Vehicles (automobiles, motorized bicycles, and light vehicles) are not allowed to pass.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei03.jpg" alt="No Vehicle Entry" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei03.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="No Vehicle Entry" data-si="වාහන ඇතුළුවීම තහනම්">No Vehicle Entry</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Vehicles are not allowed to enter (often placed at the exit of one-way roads)." data-si="වාහන ඇතුළුවීමට අවසර නැත (බොහෝවිට එක්මාර්ග පාරවල නික්මුම් ස්ථානවල තබා ඇත).">Vehicles are not allowed to enter (often placed at the exit of one-way roads).</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei04.jpg" alt="No Passage for Non-Motorcycle Vehicles" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei04.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="No Passage for Non-Motorcycle Vehicles" data-si="මෝටර් සයිකල් හැර අනෙක් වාහන තහනම්">No Passage for Non-Motorcycle Vehicles</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Motorcycles (large and standard motorcycles) are allowed to pass, but other vehicles are not." data-si="මෝටර් සයිකල් (විශාල හා සාමාන්‍ය) ගමන් කළ හැකි නමුත් අනෙකුත් වාහනවලට අවසර නැත.">Motorcycles (large and standard motorcycles) are allowed to pass, but other vehicles are not.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei05.jpg" alt="No Passage for Large Cargo Vehicles, etc." loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei05.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="No Passage for Large Cargo Vehicles, etc." data-si="විශාල භාණ්ඩ වාහන තහනම්">No Passage for Large Cargo Vehicles, etc.</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Large cargo vehicles, large special vehicles, and specific medium cargo vehicles are not allowed to pass." data-si="විශාල භාණ්ඩ වාහන, විශාල විශේෂ වාහන සහ ඇතැම් මධ්‍යම භාණ්ඩ වාහන ගමන් කිරීමට අවසර නැත.">Large cargo vehicles, large special vehicles, and specific medium cargo vehicles are not allowed to pass.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei06.jpg" alt="No Passage for Cargo Vehicles Exceeding Specified Maximum Load" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei06.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="No Passage for Cargo Vehicles Exceeding Specified Maximum Load" data-si="නියමිත බර ඉක්මවූ භාණ්ඩ වාහන තහනම්">No Passage for Cargo Vehicles Exceeding Specified Maximum Load</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Cargo vehicles exceeding the maximum load indicated by the supplementary sign are not allowed to pass." data-si="අතිරේක ලකුණින් දක්වන උපරිම බර ඉක්මවන භාණ්ඩ වාහන ගමන් කිරීමට අවසර නැත.">Cargo vehicles exceeding the maximum load indicated by the supplementary sign are not allowed to pass.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei07.jpg" alt="No Passage for Large Passenger Vehicles, etc." loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei07.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="No Passage for Large Passenger Vehicles, etc." data-si="විශාල මගී වාහන තහනම්">No Passage for Large Passenger Vehicles, etc.</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Large passenger vehicles and specific medium passenger vehicles are not allowed to pass." data-si="විශාල මගී වාහන සහ ඇතැම් මධ්‍යම මගී වාහන ගමන් කිරීමට අවසර නැත.">Large passenger vehicles and specific medium passenger vehicles are not allowed to pass.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei08.jpg" alt="No Passage for Motorcycles and Motorized Bicycles" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei08.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="No Passage for Motorcycles and Motorized Bicycles" data-si="මෝටර් සයිකල් හා මෝටර් බයිසිකල් තහනම්">No Passage for Motorcycles and Motorized Bicycles</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Motorcycles (large and standard motorcycles) and motorized bicycles are not allowed to pass." data-si="මෝටර් සයිකල් (විශාල හා සාමාන්‍ය) සහ මෝටර් බයිසිකල් ගමන් කිරීමට අවසර නැත.">Motorcycles (large and standard motorcycles) and motorized bicycles are not allowed to pass.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei09.jpg" alt="No Passage for Light Vehicles Except Bicycles" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei09.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="No Passage for Light Vehicles Except Bicycles" data-si="බයිසිකල් හැර සැහැල්ලු වාහන තහනම්">No Passage for Light Vehicles Except Bicycles</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Light vehicles such as carts and handcars, except bicycles, are not allowed to pass." data-si="කරත්ත සහ අත්-කරත්ත වැනි සැහැල්ලු වාහන (බයිසිකල් හැර) ගමන් කිරීමට අවසර නැත.">Light vehicles such as carts and handcars, except bicycles, are not allowed to pass.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei10.jpg" alt="No Bicycle Passage" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei10.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="No Bicycle Passage" data-si="බයිසිකල් ගමන් කිරීම තහනම්">No Bicycle Passage</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Bicycles are not allowed to pass." data-si="බයිසිකල් ගමන් කිරීමට අවසර නැත.">Bicycles are not allowed to pass.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei11.jpg" alt="No Passage for Specified Vehicle Combinations" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei11.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="No Passage for Specified Vehicle Combinations" data-si="නිශ්චිත වාහන සංයෝජන තහනම්">No Passage for Specified Vehicle Combinations</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Vehicles indicated on the sign are not allowed to pass. In this case, automobiles and motorized bicycles are not allowed to pass." data-si="ලකුණේ දක්වා ඇති වාහන ගමන් කිරීමට අවසර නැත. මෙහිදී මෝටර් රථ සහ මෝටර් බයිසිකල් ගමන් කිරීමට අවසර නැත.">Vehicles indicated on the sign are not allowed to pass. In this case, automobiles and motorized bicycles are not allowed to pass.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei12.png" alt="No Two-Person Riding on Large and Standard Motorcycles" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei12.png</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="No Two-Person Riding on Large and Standard Motorcycles" data-si="විශාල/සාමාන්‍ය මෝටර් සයිකලයේ දෙදෙනෙකු ගමන් කිරීම තහනම්">No Two-Person Riding on Large and Standard Motorcycles</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Two-person riding on large and standard motorcycles is not allowed (except for those with sidecars)." data-si="විශාල සහ සාමාන්‍ය මෝටර් සයිකල්වල දෙදෙනෙකු එකවර ගමන් කිරීමට අවසර නැත (සයිඩ්කාර් සහිත ඒවා හැර).">Two-person riding on large and standard motorcycles is not allowed (except for those with sidecars).</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei13.jpg" alt="No Travel Except in Designated Direction" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei13.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="No Travel Except in Designated Direction" data-si="නියමිත දිශාවට හැර වෙනත් දිශාවට ගමන් තහනම්">No Travel Except in Designated Direction</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Vehicles must not travel in any direction other than the one indicated by the arrow." data-si="ඊතලයෙන් දක්වන දිශාව හැර වෙනත් දිශාවකට වාහන ගමන් නොකළ යුතුය.">Vehicles must not travel in any direction other than the one indicated by the arrow.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei14.jpg" alt="No Vehicle Crossing" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei14.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="No Vehicle Crossing" data-si="වාහන හරස් වීම තහනම්">No Vehicle Crossing</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Vehicles must not cross (except for left turns to enter or exit facilities or places outside the road)." data-si="වාහන හරහා නොයා යුතුය (මාර්ගයෙන් පිටත ස්ථානවලට ඇතුල්වීමට/පිටවීමට වම් හැරීම් හැර).">Vehicles must not cross (except for left turns to enter or exit facilities or places outside the road).</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei15.jpg" alt="No U-Turn" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei15.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="No U-Turn" data-si="යූ-හැරවුම තහනම්">No U-Turn</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Vehicles are not allowed to make a U-turn." data-si="වාහන යූ-හැරවුමක් කිරීමට අවසර නැත.">Vehicles are not allowed to make a U-turn.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei16.jpg" alt="No Overtaking by Crossing Right Side" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei16.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="No Overtaking by Crossing Right Side" data-si="දකුණට හරහා ගොස් පසුකර යාම තහනම්">No Overtaking by Crossing Right Side</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Vehicles must not cross to the right side of the road to overtake (overtaking without crossing to the right side is allowed)." data-si="පසුකර යාම සඳහා මාර්ගයේ දකුණු පැත්තට හරහා නොයා යුතුය (දකුණට හරහා නොගොස් පසුකර යාම අවසර ඇත).">Vehicles must not cross to the right side of the road to overtake (overtaking without crossing to the right side is allowed).</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei17.jpg" alt="No Overtaking" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei17.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="No Overtaking" data-si="පසුකර යාම තහනම්">No Overtaking</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Vehicles are not allowed to overtake." data-si="වාහන පසුකර යාමට අවසර නැත.">Vehicles are not allowed to overtake.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei18.jpg" alt="No Parking or Stopping" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei18.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="No Parking or Stopping" data-si="නැවතීම හෝ නවතා තැබීම තහනම්">No Parking or Stopping</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Vehicles are not allowed to park or stop (the numbers above indicate the prohibited time, in this case from 8 AM to 8 PM)." data-si="වාහන නවතා තැබීමට හෝ නැවතීමට අවසර නැත (ඉහත අංක තහනම් කාලය දක්වයි, මෙහිදී උදේ 8සිට රාත්‍රී 8 දක්වා).">Vehicles are not allowed to park or stop (the numbers above indicate the prohibited time, in this case from 8 AM to 8 PM).</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei19.jpg" alt="No Parking" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei19.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="No Parking" data-si="නවතා තැබීම තහනම්">No Parking</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Vehicles are not allowed to park (the numbers above indicate the prohibited time, in this case from 8 AM to 8 PM)." data-si="වාහන නවතා තැබීමට අවසර නැත (ඉහත අංක තහනම් කාලය දක්වයි, මෙහිදී උදේ 8සිට රාත්‍රී 8 දක්වා).">Vehicles are not allowed to park (the numbers above indicate the prohibited time, in this case from 8 AM to 8 PM).</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei20.jpg" alt="Parking Space Requirement" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei20.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Parking Space Requirement" data-si="නැවතුම් ඉඩ අවශ්‍යතාවය">Parking Space Requirement</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Vehicles must not park unless there is the parking space indicated by the supplementary sign (in this case, 6 meters) on the right side of the vehicle." data-si="අතිරේක ලකුණේ දක්වන නැවතුම් ඉඩ (මෙහිදී මීටර් 6ක්) වාහනයේ දකුණු පැත්තේ නොමැති නම් නවතා තැබිය නොහැක.">Vehicles must not park unless there is the parking space indicated by the supplementary sign (in this case, 6 meters) on the right side of the vehicle.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei21.jpg" alt="Time-Restricted Parking Zone" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei21.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Time-Restricted Parking Zone" data-si="කාල සීමිත නැවතුම් කලාපය">Time-Restricted Parking Zone</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Parking is allowed only during the indicated time, and parking beyond the time limit is prohibited (in this case, parking for more than 60 minutes between 8 AM and 8 PM is not allowed)." data-si="දක්වා ඇති කාලය තුළ පමණක් නැවතීමට අවසර ඇති අතර, ඉන් ඔබ්බට නැවතීම තහනම් (මෙහිදී උදේ 8-8 අතර මිනිත්තු 60කට වඩා නැවතීම තහනම්).">Parking is allowed only during the indicated time, and parking beyond the time limit is prohibited (in this case, parking for more than 60 minutes between 8 AM and 8 PM is not allowed).</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei22.jpg" alt="No Passage for Vehicles Carrying Hazardous Materials" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei22.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="No Passage for Vehicles Carrying Hazardous Materials" data-si="අන්තරාදායක ද්‍රව්‍ය සහිත වාහන තහනම්">No Passage for Vehicles Carrying Hazardous Materials</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Vehicles carrying hazardous materials such as explosives, poisons, or toxic substances are not allowed to pass." data-si="පිපිරන ද්‍රව්‍ය, විෂ හෝ විෂජනක ද්‍රව්‍ය වැනි අන්තරාදායක ද්‍රව්‍ය රැගෙන යන වාහන ගමන් කිරීමට අවසර නැත.">Vehicles carrying hazardous materials such as explosives, poisons, or toxic substances are not allowed to pass.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei23.jpg" alt="Weight Limit" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei23.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Weight Limit" data-si="බර සීමාව">Weight Limit</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Vehicles exceeding the weight limit indicated on the sign are not allowed to pass. *Total weight includes the vehicle, passengers, and cargo." data-si="ලකුණේ දක්වා ඇති බර සීමාව ඉක්මවන වාහන ගමන් කිරීමට අවසර නැත. *මුළු බරට වාහනය, මගීන් සහ භාණ්ඩ ඇතුළත්ය.">Vehicles exceeding the weight limit indicated on the sign are not allowed to pass. *Total weight includes the vehicle, passengers, and cargo.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei24.jpg" alt="Height Limit" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei24.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Height Limit" data-si="උස සීමාව">Height Limit</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Vehicles exceeding the height limit indicated on the sign are not allowed to pass (including the height of the cargo)." data-si="ලකුණේ දක්වා ඇති උස සීමාව ඉක්මවන වාහන ගමන් කිරීමට අවසර නැත (භාණ්ඩවල උසද ඇතුළත්ව).">Vehicles exceeding the height limit indicated on the sign are not allowed to pass (including the height of the cargo).</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei25.jpg" alt="Width Limit" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei25.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Width Limit" data-si="පළල සීමාව">Width Limit</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Vehicles exceeding the width limit indicated on the sign are not allowed to pass (including the width of the cargo)." data-si="ලකුණේ දක්වා ඇති පළල සීමාව ඉක්මවන වාහන ගමන් කිරීමට අවසර නැත (භාණ්ඩවල පළලද ඇතුළත්ව).">Vehicles exceeding the width limit indicated on the sign are not allowed to pass (including the width of the cargo).</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei26.jpg" alt="Maximum Speed" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei26.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Maximum Speed" data-si="උපරිම වේගය">Maximum Speed</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Vehicles and trams must not exceed the maximum speed indicated on the sign. However, for motorized bicycles or vehicles towing others, if the speed indicated on the sign is higher than the legal speed limit, they must not exceed the legal speed limit." data-si="වාහන සහ ට්‍රෑම් ලකුණේ දක්වා ඇති උපරිම වේගය ඉක්මවිය නොහැක. නමුත් මෝටර් බයිසිකල් හෝ අන් වාහන අදින වාහන සඳහා, ලකුණේ වේගය නීතිමය සීමාවට වඩා වැඩි නම්, නීතිමය සීමාව ඉක්මවිය නොහැක.">Vehicles and trams must not exceed the maximum speed indicated on the sign. However, for motorized bicycles or vehicles towing others, if the speed indicated on the sign is higher than the legal speed limit, they must not exceed the legal speed limit.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei27.jpg" alt="Maximum Speed for Specific Vehicle Types" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei27.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Maximum Speed for Specific Vehicle Types" data-si="නිශ්චිත වාහන වර්ග සඳහා උපරිම වේගය">Maximum Speed for Specific Vehicle Types</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Vehicles indicated on the supplementary sign must not exceed the speed indicated on the main sign." data-si="අතිරේක ලකුණේ දක්වා ඇති වාහන ප්‍රධාන ලකුණේ වේගය ඉක්මවිය නොහැක.">Vehicles indicated on the supplementary sign must not exceed the speed indicated on the main sign.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei28.jpg" alt="Minimum Speed" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei28.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Minimum Speed" data-si="අවම වේගය">Minimum Speed</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Vehicles must not travel at a speed lower than the one indicated on the sign." data-si="ලකුණේ දක්වා ඇති වේගයට වඩා අඩු වේගයකින් වාහන ගමන් නොකළ යුතුය.">Vehicles must not travel at a speed lower than the one indicated on the sign.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei29.jpg" alt="Motor Vehicles Only" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei29.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Motor Vehicles Only" data-si="මෝටර් වාහන පමණි">Motor Vehicles Only</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates a highway or road exclusively for motor vehicles. Pedestrians, motorized bicycles, and light vehicles are not allowed to pass." data-si="මෝටර් වාහන සඳහා පමණක් වූ මහාමාර්ගයක් හෝ මාර්ගයක් දක්වයි. පදිකයින්, මෝටර් බයිසිකල් සහ සැහැල්ලු වාහන ගමන් කිරීමට අවසර නැත.">Indicates a highway or road exclusively for motor vehicles. Pedestrians, motorized bicycles, and light vehicles are not allowed to pass.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei30.jpg" alt="Bicycles Only" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei30.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Bicycles Only" data-si="බයිසිකල් පමණි">Bicycles Only</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates a bicycle path or bicycle-only road, where vehicles other than standard bicycles and pedestrians are not allowed to pass." data-si="බයිසිකල් මාර්ගයක් හෝ බයිසිකල් පමණක් සඳහා වූ මාර්ගයක් දක්වයි, එහි සාමාන්‍ය බයිසිකල් හා පදිකයින් හැර වෙනත් වාහන ගමන් කිරීමට අවසර නැත.">Indicates a bicycle path or bicycle-only road, where vehicles other than standard bicycles and pedestrians are not allowed to pass.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei31.jpg" alt="Bicycles and Pedestrians Only" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei31.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Bicycles and Pedestrians Only" data-si="බයිසිකල් සහ පදිකයින් පමණි">Bicycles and Pedestrians Only</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that only bicycles and pedestrians are allowed to pass. Vehicles other than bicycles are not allowed." data-si="බයිසිකල් සහ පදිකයින් පමණක් ගමන් කිරීමට අවසර ඇති බව දක්වයි. බයිසිකල් හැර වෙනත් වාහනවලට අවසර නැත.">Indicates that only bicycles and pedestrians are allowed to pass. Vehicles other than bicycles are not allowed.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei32.jpg" alt="Pedestrians Only" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei32.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Pedestrians Only" data-si="පදිකයින් පමණි">Pedestrians Only</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates a pedestrian-only road or pathway designated for pedestrian passage. Vehicles are not allowed to pass (except with special permission)." data-si="පදිකයින් සඳහා පමණක් වූ මාර්ගයක් හෝ පාරක් දක්වයි. වාහන ගමන් කිරීමට අවසර නැත (විශේෂ අවසරයක් ඇතිව හැර).">Indicates a pedestrian-only road or pathway designated for pedestrian passage. Vehicles are not allowed to pass (except with special permission).</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei33.jpg" alt="One-Way Traffic" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei33.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="One-Way Traffic" data-si="එක්මාර්ග ගමනාගමනය">One-Way Traffic</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Vehicles can travel in the direction indicated by the arrow. Travel in the opposite direction is not allowed." data-si="ඊතලයෙන් දක්වන දිශාවට වාහන ගමන් කළ හැක. ප්‍රතිවිරුද්ධ දිශාවට ගමන් කිරීමට අවසර නැත.">Vehicles can travel in the direction indicated by the arrow. Travel in the opposite direction is not allowed.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei34.jpg" alt="Vehicle Lane Designation" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei34.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Vehicle Lane Designation" data-si="වාහන මංතීරු නියම කිරීම">Vehicle Lane Designation</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="A sign indicating the lane designation for vehicles, which must follow the designated lanes (in this case, for light vehicles and motorcycles)." data-si="වාහන සඳහා මංතීරු නියම කරන ලකුණකි, එය අනුගමනය කළ යුතුය (මෙහිදී සැහැල්ලු වාහන හා මෝටර් සයිකල් සඳහා).">A sign indicating the lane designation for vehicles, which must follow the designated lanes (in this case, for light vehicles and motorcycles).</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei35.jpg" alt="Lane Designation for Specific Vehicle Types" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei35.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Lane Designation for Specific Vehicle Types" data-si="නිශ්චිත වාහන වර්ග සඳහා මංතීරු නියම කිරීම">Lane Designation for Specific Vehicle Types</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates the lane designation for specific vehicle types, where large cargo vehicles, specific medium cargo vehicles, and large special vehicles must use the leftmost lane." data-si="නිශ්චිත වාහන වර්ග සඳහා මංතීරු දක්වයි, විශාල භාණ්ඩ වාහන, ඇතැම් මධ්‍යම භාණ්ඩ වාහන සහ විශාල විශේෂ වාහන වම්පස ම මංතීරුව භාවිත කළ යුතුය.">Indicates the lane designation for specific vehicle types, where large cargo vehicles, specific medium cargo vehicles, and large special vehicles must use the leftmost lane.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei36.jpg" alt="Lane Designation for Towed Vehicles on Highways" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei36.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Lane Designation for Towed Vehicles on Highways" data-si="මහාමාර්ගවල අදින වාහන සඳහා මංතීරු">Lane Designation for Towed Vehicles on Highways</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates the lane designation for towed vehicles on highways. Towed vehicles must follow the designated lane." data-si="මහාමාර්ගවල අදින වාහන සඳහා මංතීරු දක්වයි. අදින වාහන නියමිත මංතීරුව අනුගමනය කළ යුතුය.">Indicates the lane designation for towed vehicles on highways. Towed vehicles must follow the designated lane.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei37.jpg" alt="Dedicated Lane" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei37.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Dedicated Lane" data-si="විශේෂිත මංතීරුව">Dedicated Lane</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates a dedicated lane for the vehicles shown on the sign (in this case, for route buses, etc.)." data-si="ලකුණේ දක්වා ඇති වාහන සඳහා විශේෂිත මංතීරුවක් දක්වයි (මෙහිදී මාර්ග බස් රථ සඳහා).">Indicates a dedicated lane for the vehicles shown on the sign (in this case, for route buses, etc.).</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei38.jpg" alt="Priority Lane for Route Buses, etc." loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei38.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Priority Lane for Route Buses, etc." data-si="මාර්ග බස් රථ සඳහා ප්‍රමුඛතා මංතීරුව">Priority Lane for Route Buses, etc.</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates a priority lane for route buses, etc. When a route bus approaches, small special vehicles, motorized bicycles, and other vehicles must move to another lane. Vehicles cannot use this lane when it is expected to be congested and prevent exiting the lane." data-si="මාර්ග බස් රථ සඳහා ප්‍රමුඛතා මංතීරුවක් දක්වයි. මාර්ග බස් රථයක් ළඟාවන විට කුඩා විශේෂ වාහන, මෝටර් බයිසිකල් සහ අනෙකුත් වාහන වෙනත් මංතීරුවකට මාරු විය යුතුය.">Indicates a priority lane for route buses, etc. When a route bus approaches, small special vehicles, motorized bicycles, and other vehicles must move to another lane. Vehicles cannot use this lane when it is expected to be congested and prevent exiting the lane.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei39.jpg" alt="Designated First Lane for Towed Vehicles on Motor Vehicle Roads" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei39.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Designated First Lane for Towed Vehicles on Motor Vehicle Roads" data-si="මෝටර් වාහන මාර්ගවල අදින වාහන සඳහා පළමු මංතීරුව">Designated First Lane for Towed Vehicles on Motor Vehicle Roads</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that towed vehicles must use the leftmost lane on motor vehicle-only roads." data-si="මෝටර් වාහන පමණක් සඳහා වූ මාර්ගවල අදින වාහන වම්පස ම මංතීරුව භාවිත කළ යුතු බව දක්වයි.">Indicates that towed vehicles must use the leftmost lane on motor vehicle-only roads.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei40.jpg" alt="Directional Lane Designation" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei40.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Directional Lane Designation" data-si="දිශානුගත මංතීරු නියම කිරීම">Directional Lane Designation</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates the lane designation for different directions at an intersection." data-si="හන්දියක විවිධ දිශා සඳහා මංතීරු දක්වයි.">Indicates the lane designation for different directions at an intersection.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei41.jpg" alt="Two-Stage Right Turn for Motorized Bicycles" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei41.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Two-Stage Right Turn for Motorized Bicycles" data-si="මෝටර් බයිසිකල් සඳහා ද්විවිධ දකුණු හැරවුම">Two-Stage Right Turn for Motorized Bicycles</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Motorized bicycles must make a right turn by following the edge of the intersection in two stages (small right turns are not allowed)." data-si="මෝටර් බයිසිකල් හන්දියේ දාරය ඔස්සේ අදියර දෙකකින් දකුණට හැරිය යුතුය (කුඩා දකුණු හැරවුම් අවසර නැත).">Motorized bicycles must make a right turn by following the edge of the intersection in two stages (small right turns are not allowed).</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei42.jpg" alt="Small Right Turn for Motorized Bicycles" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei42.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Small Right Turn for Motorized Bicycles" data-si="මෝටර් බයිසිකල් සඳහා කුඩා දකුණු හැරවුම">Small Right Turn for Motorized Bicycles</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Motorized bicycles must make a small right turn by moving to the center of the road (or the right edge for one-way roads) in advance. *A small right turn means turning right by moving to the center or right edge beforehand." data-si="මෝටර් බයිසිකල් කලින් මාර්ගයේ මැදට (එක්මාර්ග පාරක නම් දකුණු දාරයට) ගොස් කුඩා දකුණු හැරවුමක් කළ යුතුය.">Motorized bicycles must make a small right turn by moving to the center of the road (or the right edge for one-way roads) in advance. *A small right turn means turning right by moving to the center or right edge beforehand.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei43.jpg" alt="Sound Horn" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei43.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Sound Horn" data-si="හෝන් නාද කරන්න">Sound Horn</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates a location where vehicles and trams must sound their horn." data-si="වාහන සහ ට්‍රෑම් හෝන් නාද කළ යුතු ස්ථානයක් දක්වයි.">Indicates a location where vehicles and trams must sound their horn.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei44.jpg" alt="Horn Use Zone" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei44.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Horn Use Zone" data-si="හෝන් භාවිත කලාපය">Horn Use Zone</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates a zone where vehicles and trams must sound their horn." data-si="වාහන සහ ට්‍රෑම් හෝන් නාද කළ යුතු කලාපයක් දක්වයි.">Indicates a zone where vehicles and trams must sound their horn.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei45.jpg" alt="Proceed Slowly" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei45.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Proceed Slowly" data-si="සෙමින් ගමන් කරන්න">Proceed Slowly</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Vehicles and trams must proceed slowly (at a speed allowing immediate stopping)." data-si="වාහන සහ ට්‍රෑම් සෙමින් ගමන් කළ යුතුය (ක්ෂණිකව නැවතිය හැකි වේගයකින්).">Vehicles and trams must proceed slowly (at a speed allowing immediate stopping).</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei46.jpg" alt="Priority Road Ahead" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei46.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Priority Road Ahead" data-si="ඉදිරියේ ප්‍රමුඛතා මාර්ගයකි">Priority Road Ahead</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Because the intersecting road ahead is a priority road, vehicles and trams must proceed slowly (at a speed allowing immediate stopping)." data-si="ඉදිරියේ හරහා යන මාර්ගය ප්‍රමුඛතා මාර්ගයක් වන බැවින්, වාහන සහ ට්‍රෑම් සෙමින් ගමන් කළ යුතුය.">Because the intersecting road ahead is a priority road, vehicles and trams must proceed slowly (at a speed allowing immediate stopping).</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei47.jpg" alt="Stop" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei47.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Stop" data-si="නවතින්න">Stop</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Vehicles and trams must stop immediately before the stop line. If there is no stop line, they must stop before the intersection (sign)." data-si="වාහන සහ ට්‍රෑම් නැවතුම් රේඛාවට පෙර ක්ෂණිකව නැවතිය යුතුය. නැවතුම් රේඛාවක් නොමැති නම්, හන්දියට පෙර නැවතිය යුතුය.">Vehicles and trams must stop immediately before the stop line. If there is no stop line, they must stop before the intersection (sign).</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei48.jpg" alt="Priority Road Ahead and Stop" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei48.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Priority Road Ahead and Stop" data-si="ඉදිරියේ ප්‍රමුඛතා මාර්ගයකි, නවතින්න">Priority Road Ahead and Stop</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Because the intersecting road ahead is a priority road, vehicles and trams must stop immediately before the stop line. If there is no stop line, they must stop before the intersection (sign)." data-si="ඉදිරියේ හරහා යන මාර්ගය ප්‍රමුඛතා මාර්ගයක් වන බැවින්, වාහන සහ ට්‍රෑම් නැවතුම් රේඛාවට පෙර ක්ෂණිකව නැවතිය යුතුය.">Because the intersecting road ahead is a priority road, vehicles and trams must stop immediately before the stop line. If there is no stop line, they must stop before the intersection (sign).</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei49.jpg" alt="No Pedestrian Passage" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei49.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="No Pedestrian Passage" data-si="පදිකයින් ගමන් කිරීම තහනම්">No Pedestrian Passage</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that pedestrians are not allowed to pass. Vehicles are allowed to pass." data-si="පදිකයින් ගමන් කිරීමට අවසර නැති බව දක්වයි. වාහනවලට ගමන් කිරීමට අවසර ඇත.">Indicates that pedestrians are not allowed to pass. Vehicles are allowed to pass.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei50.jpg" alt="No Pedestrian Crossing" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei50.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="No Pedestrian Crossing" data-si="පදිකයින් හරස් වීම තහනම්">No Pedestrian Crossing</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that pedestrians are not allowed to cross." data-si="පදිකයින් හරහා යාමට අවසර නැති බව දක්වයි.">Indicates that pedestrians are not allowed to cross.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei51.jpg" alt="Time-Restricted Parking Zone for Elderly Drivers, etc." loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei51.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Time-Restricted Parking Zone for Elderly Drivers, etc." data-si="වැඩිහිටි රියදුරන් සඳහා කාල සීමිත නැවතුම් කලාපය">Time-Restricted Parking Zone for Elderly Drivers, etc.</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that only vehicles with elderly driver designations can park during the specified time. General vehicles without the designation cannot park." data-si="නියමිත කාලය තුළ වැඩිහිටි රියදුරු නම් කිරීම් සහිත වාහන පමණක් නැවතිය හැකි බව දක්වයි.">Indicates that only vehicles with elderly driver designations can park during the specified time. General vehicles without the designation cannot park.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei52.jpg" alt="Clockwise Traffic at Roundabout" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei52.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Clockwise Traffic at Roundabout" data-si="රවුම් සන්ධියේ ඔරලෝසු දිශාවට ගමනාගමනය">Clockwise Traffic at Roundabout</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="A sign indicating that traffic must proceed clockwise at the roundabout ahead." data-si="ඉදිරියේ ඇති රවුම් සන්ධියේ ගමනාගමනය ඔරලෝසු දිශාවට විය යුතු බව දක්වයි.">A sign indicating that traffic must proceed clockwise at the roundabout ahead.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/kisei53.jpg" alt="One-Way Bicycle Traffic" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>kisei53.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="One-Way Bicycle Traffic" data-si="බයිසිකල් සඳහා එක්මාර්ග ගමනාගමනය">One-Way Bicycle Traffic</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="A sign indicating one-way traffic for bicycles on sidewalks or bike paths. Bicycles can travel in the direction indicated by the arrow, but not in the opposite direction." data-si="පදික මංතීරුවල හෝ බයිසිකල් මාර්ගවල බයිසිකල් සඳහා එක්මාර්ග ගමනාගමනය දක්වයි.">A sign indicating one-way traffic for bicycles on sidewalks or bike paths. Bicycles can travel in the direction indicated by the arrow, but not in the opposite direction.</p>
        </div>
      </div>
      </div>
    </section>

    <section id="sec-1" class="mb-10 scroll-mt-24">
      <div class="flex items-center gap-3 mb-4">
        <span class="w-8 h-8 rounded-lg bg-primary text-white flex items-center justify-center font-display font-bold text-sm shrink-0">2</span>
        <div>
          <h2 class="font-display font-bold text-lg sm:text-xl text-ink" data-en="Guide Signs" data-si="Guide Signs">Guide Signs</h2>
          <p class="text-xs text-ink/40 font-si">指示標識 &middot; 13 <span data-en="signs" data-si="ලකුණු">signs</span></p>
        </div>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/shiji01.jpg" alt="Bicycles May Ride Side by Side" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>shiji01.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Bicycles May Ride Side by Side" data-si="බයිසිකල් පෙළගැසී ගමන් කළ හැක">Bicycles May Ride Side by Side</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that standard bicycles may ride side by side." data-si="සාමාන්‍ය බයිසිකල් පෙළගැසී ගමන් කළ හැකි බව දක්වයි.">Indicates that standard bicycles may ride side by side.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/shiji02.jpg" alt="Vehicles Permitted on Tram Tracks" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>shiji02.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Vehicles Permitted on Tram Tracks" data-si="ට්‍රෑම් මාර්ගයේ වාහන ගමන් කිරීමට අවසර">Vehicles Permitted on Tram Tracks</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that vehicles are allowed to travel on tram tracks (only specified vehicles if indicated by a supplementary sign)." data-si="වාහන ට්‍රෑම් මාර්ගයේ ගමන් කිරීමට අවසර ඇති බව දක්වයි.">Indicates that vehicles are allowed to travel on tram tracks (only specified vehicles if indicated by a supplementary sign).</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/shiji03.jpg" alt="Parking Permitted" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>shiji03.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Parking Permitted" data-si="නැවතීමට අවසර">Parking Permitted</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that vehicles are allowed to park." data-si="වාහන නවතා තැබීමට අවසර ඇති බව දක්වයි.">Indicates that vehicles are allowed to park.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/shiji04.jpg" alt="Stopping Permitted" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>shiji04.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Stopping Permitted" data-si="තාවකාලික නැවතීමට අවසර">Stopping Permitted</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that vehicles are allowed to stop." data-si="වාහන නැවතීමට අවසර ඇති බව දක්වයි.">Indicates that vehicles are allowed to stop.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/shiji05.jpg" alt="Priority Road" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>shiji05.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Priority Road" data-si="ප්‍රමුඛතා මාර්ගය">Priority Road</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that the road with the sign is a priority road." data-si="ලකුණ ඇති මාර්ගය ප්‍රමුඛතා මාර්ගයක් බව දක්වයි.">Indicates that the road with the sign is a priority road.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/shiji06.jpg" alt="Center Line" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>shiji06.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Center Line" data-si="මධ්‍ය රේඛාව">Center Line</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that the sign&#x27;s position is at the center or center line of the road." data-si="ලකුණේ ස්ථානය මාර්ගයේ මධ්‍යයේ හෝ මධ්‍ය රේඛාවේ බව දක්වයි.">Indicates that the sign&#x27;s position is at the center or center line of the road.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/shiji07.jpg" alt="Stop Line" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>shiji07.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Stop Line" data-si="නැවතුම් රේඛාව">Stop Line</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that the sign&#x27;s position is where vehicles must stop." data-si="වාහන නැවතිය යුතු ස්ථානය දක්වයි.">Indicates that the sign&#x27;s position is where vehicles must stop.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/shiji08.jpg" alt="Pedestrian Crossing" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>shiji08.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Pedestrian Crossing" data-si="පදික මාර්ගය">Pedestrian Crossing</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates a pedestrian crossing." data-si="පදික මාර්ගයක් දක්වයි.">Indicates a pedestrian crossing.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/shiji09.jpg" alt="Bicycle Crossing" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>shiji09.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Bicycle Crossing" data-si="බයිසිකල් හරස් මාර්ගය">Bicycle Crossing</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates a bicycle crossing." data-si="බයිසිකල් හරස් මාර්ගයක් දක්වයි.">Indicates a bicycle crossing.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/shiji10.jpg" alt="Pedestrian and Bicycle Crossing" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>shiji10.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Pedestrian and Bicycle Crossing" data-si="පදික සහ බයිසිකල් හරස් මාර්ගය">Pedestrian and Bicycle Crossing</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates both a pedestrian crossing and a bicycle crossing." data-si="පදික මාර්ගය සහ බයිසිකල් හරස් මාර්ගය දෙකම දක්වයි.">Indicates both a pedestrian crossing and a bicycle crossing.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/shiji11.jpg" alt="Safety Zone" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>shiji11.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Safety Zone" data-si="ආරක්ෂිත කලාපය">Safety Zone</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates a safety zone for pedestrians where vehicles are not allowed to pass." data-si="වාහන ගමන් කිරීමට අවසර නැති පදිකයින් සඳහා ආරක්ෂිත කලාපයක් දක්වයි.">Indicates a safety zone for pedestrians where vehicles are not allowed to pass.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/shiji12.jpg" alt="Advance Notice of Regulation" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>shiji12.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Advance Notice of Regulation" data-si="නියාමන පූර්ව දැනුම්දීම">Advance Notice of Regulation</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates in advance that the traffic regulation shown on the sign is in effect ahead." data-si="ලකුණේ දක්වන නියාමනය ඉදිරියේ බලාත්මක බව කලින් දැනුම් දෙයි.">Indicates in advance that the traffic regulation shown on the sign is in effect ahead.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/shiji13.jpg" alt="Stopping Permitted for Elderly Driver Designated Vehicles" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>shiji13.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Stopping Permitted for Elderly Driver Designated Vehicles" data-si="වැඩිහිටි රියදුරු වාහන සඳහා නැවතීමට අවසර">Stopping Permitted for Elderly Driver Designated Vehicles</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates a location where only vehicles with elderly driver designations are allowed to stop." data-si="වැඩිහිටි රියදුරු නම් කිරීම් සහිත වාහන පමණක් නැවතීමට අවසර ඇති ස්ථානයක් දක්වයි.">Indicates a location where only vehicles with elderly driver designations are allowed to stop.</p>
        </div>
      </div>
      </div>
    </section>

    <section id="sec-2" class="mb-10 scroll-mt-24">
      <div class="flex items-center gap-3 mb-4">
        <span class="w-8 h-8 rounded-lg bg-primary text-white flex items-center justify-center font-display font-bold text-sm shrink-0">3</span>
        <div>
          <h2 class="font-display font-bold text-lg sm:text-xl text-ink" data-en="Warning Signs" data-si="Warning Signs">Warning Signs</h2>
          <p class="text-xs text-ink/40 font-si">警戒標識 &middot; 26 <span data-en="signs" data-si="ලකුණු">signs</span></p>
        </div>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/keikai01.jpg" alt="Crossroad Intersection Ahead" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>keikai01.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Crossroad Intersection Ahead" data-si="ඉදිරියේ හතරමං සන්ධියකි">Crossroad Intersection Ahead</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that there is a crossroad intersection ahead." data-si="ඉදිරියේ හතරමං සන්ධියක් ඇති බව දක්වයි.">Indicates that there is a crossroad intersection ahead.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/keikai02.jpg" alt="T-Shaped Intersection Ahead" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>keikai02.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="T-Shaped Intersection Ahead" data-si="ඉදිරියේ T-හැඩැති සන්ධියකි">T-Shaped Intersection Ahead</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that there is a T-shaped intersection ahead." data-si="ඉදිරියේ T-හැඩැති සන්ධියක් ඇති බව දක්වයි.">Indicates that there is a T-shaped intersection ahead.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/keikai03.jpg" alt="T-Shaped Intersection Ahead" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>keikai03.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="T-Shaped Intersection Ahead" data-si="ඉදිරියේ T-හැඩැති සන්ධියකි">T-Shaped Intersection Ahead</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that there is a T-shaped intersection ahead." data-si="ඉදිරියේ T-හැඩැති සන්ධියක් ඇති බව දක්වයි.">Indicates that there is a T-shaped intersection ahead.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/keikai04.jpg" alt="Y-Shaped Intersection Ahead" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>keikai04.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Y-Shaped Intersection Ahead" data-si="ඉදිරියේ Y-හැඩැති සන්ධියකි">Y-Shaped Intersection Ahead</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that there is a Y-shaped intersection ahead." data-si="ඉදිරියේ Y-හැඩැති සන්ධියක් ඇති බව දක්වයි.">Indicates that there is a Y-shaped intersection ahead.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/keikai05.jpg" alt="Roundabout Ahead" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>keikai05.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Roundabout Ahead" data-si="ඉදිරියේ රවුම් සන්ධියකි">Roundabout Ahead</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that there is a roundabout ahead." data-si="ඉදිරියේ රවුම් සන්ධියක් ඇති බව දක්වයි.">Indicates that there is a roundabout ahead.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/keikai06.jpg" alt="Right (Left) Curve Ahead" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>keikai06.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Right (Left) Curve Ahead" data-si="ඉදිරියේ දකුණු(වම්) වක්‍රයකි">Right (Left) Curve Ahead</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that there is a right or left curve ahead." data-si="ඉදිරියේ දකුණට හෝ වමට වක්‍රයක් ඇති බව දක්වයි.">Indicates that there is a right or left curve ahead.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/keikai07.jpg" alt="Right (Left) Sharp Turn Ahead" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>keikai07.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Right (Left) Sharp Turn Ahead" data-si="ඉදිරියේ තියුණු හැරවුමකි">Right (Left) Sharp Turn Ahead</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that there is a sharp right or left turn ahead." data-si="ඉදිරියේ තියුණු දකුණු හෝ වම් හැරවුමක් ඇති බව දක්වයි.">Indicates that there is a sharp right or left turn ahead.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/keikai08.jpg" alt="Right (Left) Reverse Curve Ahead" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>keikai08.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Right (Left) Reverse Curve Ahead" data-si="ඉදිරියේ ප්‍රතිවිරුද්ධ වක්‍රයකි">Right (Left) Reverse Curve Ahead</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that there is a reverse right or left curve ahead." data-si="ඉදිරියේ ප්‍රතිවිරුද්ධ දිශා වක්‍රයක් ඇති බව දක්වයි.">Indicates that there is a reverse right or left curve ahead.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/keikai09.jpg" alt="Right (Left) Reverse Sharp Turn Ahead" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>keikai09.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Right (Left) Reverse Sharp Turn Ahead" data-si="ඉදිරියේ ප්‍රතිවිරුද්ධ තියුණු හැරවුමකි">Right (Left) Reverse Sharp Turn Ahead</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that there is a reverse sharp right or left turn ahead." data-si="ඉදිරියේ ප්‍රතිවිරුද්ධ තියුණු හැරවුමක් ඇති බව දක්වයි.">Indicates that there is a reverse sharp right or left turn ahead.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/keikai10.jpg" alt="Right (Left) Hairpin Curve Ahead" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>keikai10.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Right (Left) Hairpin Curve Ahead" data-si="ඉදිරියේ කෙස්පින් වක්‍රයකි">Right (Left) Hairpin Curve Ahead</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that there is a right or left hairpin curve ahead." data-si="ඉදිරියේ තියුණු කෙස්පින් වක්‍රයක් ඇති බව දක්වයි.">Indicates that there is a right or left hairpin curve ahead.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/keikai11.jpg" alt="Railway Crossing Ahead" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>keikai11.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Railway Crossing Ahead" data-si="ඉදිරියේ දුම්රිය හරස් මාර්ගයකි">Railway Crossing Ahead</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that there is a railway crossing ahead." data-si="ඉදිරියේ දුම්රිය හරස් මාර්ගයක් ඇති බව දක්වයි.">Indicates that there is a railway crossing ahead.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/keikai12.jpg" alt="School, Kindergarten, Nursery, etc. Ahead" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>keikai12.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="School, Kindergarten, Nursery, etc. Ahead" data-si="ඉදිරියේ පාසලක්/ළමා නිවාසයකි">School, Kindergarten, Nursery, etc. Ahead</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that there is a school, kindergarten, nursery, or similar facility ahead." data-si="ඉදිරියේ පාසලක්, පෙර පාසලක් හෝ ළමා නිවාසයක් ඇති බව දක්වයි.">Indicates that there is a school, kindergarten, nursery, or similar facility ahead.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/keikai13.jpg" alt="Traffic Signal Ahead" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>keikai13.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Traffic Signal Ahead" data-si="ඉදිරියේ ගමනාගමන සංඥා පහනකි">Traffic Signal Ahead</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that there is a traffic signal ahead." data-si="ඉදිරියේ ගමනාගමන සංඥා පහනක් ඇති බව දක්වයි.">Indicates that there is a traffic signal ahead.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/keikai14.jpg" alt="Slippery Road" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>keikai14.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Slippery Road" data-si="ලිස්සන මාර්ගය">Slippery Road</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that the road ahead is slippery due to ice or other conditions." data-si="ඉදිරි මාර්ගය අයිස් හෝ වෙනත් හේතුවකින් ලිස්සන බව දක්වයි.">Indicates that the road ahead is slippery due to ice or other conditions.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/keikai15.jpg" alt="Falling Rocks Hazard" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>keikai15.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Falling Rocks Hazard" data-si="ගල් වැටීමේ අනතුර">Falling Rocks Hazard</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that there is a risk of falling rocks on the road ahead." data-si="ඉදිරි මාර්ගයේ ගල් වැටීමේ අවදානමක් ඇති බව දක්වයි.">Indicates that there is a risk of falling rocks on the road ahead.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/keikai16.jpg" alt="Uneven Road Surface" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>keikai16.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Uneven Road Surface" data-si="අසමාන මාර්ග පෘෂ්ඨය">Uneven Road Surface</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that the road surface ahead has unevenness (bumps or dips)." data-si="ඉදිරි මාර්ග පෘෂ්ඨය අසමාන (උස්පහත්) බව දක්වයි.">Indicates that the road surface ahead has unevenness (bumps or dips).</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/keikai17.jpg" alt="Merging Traffic Ahead" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>keikai17.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Merging Traffic Ahead" data-si="ඉදිරියේ ගමනාගමන එකතුවීමකි">Merging Traffic Ahead</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that there is merging traffic ahead." data-si="ඉදිරියේ මාර්ග දෙකක ගමනාගමනය එකතු වන බව දක්වයි.">Indicates that there is merging traffic ahead.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/keikai18.jpg" alt="Lane Reduction Ahead" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>keikai18.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Lane Reduction Ahead" data-si="ඉදිරියේ මංතීරු අඩුවීමකි">Lane Reduction Ahead</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that the number of lanes decreases ahead." data-si="ඉදිරියේ මංතීරු ගණන අඩුවන බව දක්වයි.">Indicates that the number of lanes decreases ahead.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/keikai19.jpg" alt="Road Narrows Ahead" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>keikai19.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Road Narrows Ahead" data-si="ඉදිරියේ මාර්ගය පටුවෙයි">Road Narrows Ahead</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that the road width narrows ahead." data-si="ඉදිරියේ මාර්ග පළල පටු වන බව දක්වයි.">Indicates that the road width narrows ahead.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/keikai20.jpg" alt="Two-Way Traffic" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>keikai20.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Two-Way Traffic" data-si="ද්විමාර්ග ගමනාගමනය">Two-Way Traffic</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that the road has two-way traffic." data-si="මාර්ගයේ ද්විමාර්ග ගමනාගමනයක් ඇති බව දක්වයි.">Indicates that the road has two-way traffic.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/keikai21.jpg" alt="Steep Uphill Grade Ahead" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>keikai21.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Steep Uphill Grade Ahead" data-si="ඉදිරියේ තියුණු නැගුමකි">Steep Uphill Grade Ahead</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that there is a steep uphill grade ahead." data-si="ඉදිරියේ තියුණු නැගුම් බෑවුමක් ඇති බව දක්වයි.">Indicates that there is a steep uphill grade ahead.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/keikai22.jpg" alt="Steep Downhill Grade Ahead" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>keikai22.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Steep Downhill Grade Ahead" data-si="ඉදිරියේ තියුණු බැසීමකි">Steep Downhill Grade Ahead</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that there is a steep downhill grade ahead." data-si="ඉදිරියේ තියුණු බැසුම් බෑවුමක් ඇති බව දක්වයි.">Indicates that there is a steep downhill grade ahead.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/keikai23.jpg" alt="Road Work in Progress" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>keikai23.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Road Work in Progress" data-si="මාර්ග ඉදිකිරීම් සිදුවෙමින්">Road Work in Progress</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that road work is in progress." data-si="මාර්ග ඉදිකිරීම් වැඩ සිදුවෙමින් පවතින බව දක්වයි.">Indicates that road work is in progress.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/keikai24.jpg" alt="Crosswind Caution" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>keikai24.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Crosswind Caution" data-si="හරස් සුළං පිළිබඳ අවවාදය">Crosswind Caution</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that caution is needed due to crosswinds." data-si="හරස් සුළං හේතුවෙන් ප්‍රවේශම් විය යුතු බව දක්වයි.">Indicates that caution is needed due to crosswinds.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/keikai25.jpg" alt="Animal Crossing Hazard" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>keikai25.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Animal Crossing Hazard" data-si="සතුන් හරහා යාමේ අනතුර">Animal Crossing Hazard</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that there is a risk of animals crossing the road." data-si="මාර්ගය හරහා සතුන් යාමේ අවදානමක් ඇති බව දක්වයි.">Indicates that there is a risk of animals crossing the road.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/keikai26.jpg" alt="Other Hazards" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>keikai26.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Other Hazards" data-si="වෙනත් අනතුරු">Other Hazards</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that there are other hazards ahead." data-si="ඉදිරියේ වෙනත් අනතුරු ඇති බව දක්වයි.">Indicates that there are other hazards ahead.</p>
        </div>
      </div>
      </div>
    </section>

    <section id="sec-3" class="mb-10 scroll-mt-24">
      <div class="flex items-center gap-3 mb-4">
        <span class="w-8 h-8 rounded-lg bg-primary text-white flex items-center justify-center font-display font-bold text-sm shrink-0">4</span>
        <div>
          <h2 class="font-display font-bold text-lg sm:text-xl text-ink" data-en="Guide Signs (Instructions)" data-si="Guide Signs (Instructions)">Guide Signs (Instructions)</h2>
          <p class="text-xs text-ink/40 font-si">案内標識 &middot; 36 <span data-en="signs" data-si="ලකුණු">signs</span></p>
        </div>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai01.png" alt="Municipality" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai01.png</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Municipality" data-si="නගරය">Municipality</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates the name of the municipality being entered." data-si="ඇතුල් වන නගරයේ නම දක්වයි.">Indicates the name of the municipality being entered.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai02.png" alt="Prefecture" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai02.png</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Prefecture" data-si="ප්‍රාන්තය">Prefecture</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates the name of the prefecture being entered." data-si="ඇතුල් වන ප්‍රාන්තයේ නම දක්වයි.">Indicates the name of the prefecture being entered.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai03.png" alt="Prefecture" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai03.png</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Prefecture" data-si="ප්‍රාන්තය">Prefecture</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates the name of the prefecture being entered." data-si="ඇතුල් වන ප්‍රාන්තයේ නම දක්වයි.">Indicates the name of the prefecture being entered.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai04.jpg" alt="Entrance Direction" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai04.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Entrance Direction" data-si="ඇතුල්වීමේ දිශාව">Entrance Direction</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Shows the direction toward a nearby entrance, such as for an expressway." data-si="ළඟම ඇති ඇතුල්වීමේ දිශාව (එක්ස්ප්‍රස්වේ වැනි) පෙන්වයි.">Shows the direction toward a nearby entrance, such as for an expressway.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai05.jpg" alt="Entrance Advance Notice" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai05.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Entrance Advance Notice" data-si="ඇතුල්වීම පිළිබඳ පූර්ව දැනුම්දීම">Entrance Advance Notice</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Gives advance notice of an upcoming entrance ahead." data-si="ඉදිරියේ ඇති ඇතුල්වීමක් පිළිබඳ කලින් දැනුම් දෙයි.">Gives advance notice of an upcoming entrance ahead.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai06.jpg" alt="Designated Road with Relaxed Gross Weight Limit" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai06.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Designated Road with Relaxed Gross Weight Limit" data-si="බර සීමාව ලිහිල් කළ මාර්ගය">Designated Road with Relaxed Gross Weight Limit</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates a road on which a higher-than-standard gross vehicle weight limit is permitted." data-si="සම්මතයට වඩා වැඩි මුළු බර සීමාවකට අවසර ඇති මාර්ගයක් දක්වයි.">Indicates a road on which a higher-than-standard gross vehicle weight limit is permitted.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai07.png" alt="Designated Road with Relaxed Height Limit" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai07.png</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Designated Road with Relaxed Height Limit" data-si="උස සීමාව ලිහිල් කළ මාර්ගය">Designated Road with Relaxed Height Limit</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates a road on which a higher-than-standard vehicle height limit is permitted." data-si="සම්මතයට වඩා වැඩි උස සීමාවකට අවසර ඇති මාර්ගයක් දක්වයි.">Indicates a road on which a higher-than-standard vehicle height limit is permitted.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai08.jpg" alt="Direction and Distance" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai08.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Direction and Distance" data-si="දිශාව සහ දුර">Direction and Distance</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Shows the direction and remaining distance to a destination or junction." data-si="ගමනාන්තයට හෝ හන්දියට දිශාව සහ ඉතිරි දුර පෙන්වයි.">Shows the direction and remaining distance to a destination or junction.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai09.jpg" alt="Direction and Lane" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai09.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Direction and Lane" data-si="දිශාව සහ මංතීරුව">Direction and Lane</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Shows which lane to use for a given direction." data-si="නිශ්චිත දිශාවක් සඳහා භාවිත කළ යුතු මංතීරුව පෙන්වයි.">Shows which lane to use for a given direction.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai10.gif" alt="Exit Advance Notice" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai10.gif</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Exit Advance Notice" data-si="පිටවීම පිළිබඳ පූර්ව දැනුම්දීම">Exit Advance Notice</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Gives advance notice of an upcoming exit." data-si="ඉදිරියේ ඇති පිටවීමක් පිළිබඳ කලින් දැනුම් දෙයි.">Gives advance notice of an upcoming exit.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai11.jpg" alt="Direction and Orientation Advance Notice" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai11.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Direction and Orientation Advance Notice" data-si="දිශාව පිළිබඳ පූර්ව දැනුම්දීම">Direction and Orientation Advance Notice</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Gives advance notice of the direction and compass orientation ahead." data-si="ඉදිරි දිශාව පිළිබඳ කලින් දැනුම් දෙයි.">Gives advance notice of the direction and compass orientation ahead.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai12.jpg" alt="Direction and Orientation" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai12.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Direction and Orientation" data-si="දිශාව හා නැඹුරුව">Direction and Orientation</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Shows the direction and compass orientation of a route." data-si="මාර්ගයේ දිශාව හා නැඹුරුව පෙන්වයි.">Shows the direction and compass orientation of a route.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai13.png" alt="Direction, Orientation, and Distance" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai13.png</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Direction, Orientation, and Distance" data-si="දිශාව, නැඹුරුව සහ දුර">Direction, Orientation, and Distance</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Shows the direction, compass orientation, and distance to a destination." data-si="ගමනාන්තයට දිශාව, නැඹුරුව සහ දුර පෙන්වයි.">Shows the direction, compass orientation, and distance to a destination.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai14.jpg" alt="Direction, Orientation, and Road Nickname Advance Notice" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai14.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Direction, Orientation, and Road Nickname Advance Notice" data-si="මාර්ග නාමය පිළිබඳ පූර්ව දැනුම්දීම">Direction, Orientation, and Road Nickname Advance Notice</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Gives advance notice of the direction, orientation, and nickname of the road ahead." data-si="ඉදිරි මාර්ගයේ දිශාව, නැඹුරුව සහ නම කලින් දැනුම් දෙයි.">Gives advance notice of the direction, orientation, and nickname of the road ahead.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai15.jpg" alt="Direction, Orientation, and Road Nickname" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai15.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Direction, Orientation, and Road Nickname" data-si="දිශාව, නැඹුරුව සහ මාර්ග නාමය">Direction, Orientation, and Road Nickname</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Shows the direction, orientation, and nickname of the current road." data-si="වර්තමාන මාර්ගයේ දිශාව, නැඹුරුව සහ නම පෙන්වයි.">Shows the direction, orientation, and nickname of the current road.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai16.png" alt="Direction and Exit Advance Notice" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai16.png</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Direction and Exit Advance Notice" data-si="පිටවීම පිළිබඳ පූර්ව දැනුම්දීම">Direction and Exit Advance Notice</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Gives advance notice of the direction and an upcoming exit." data-si="ඉදිරි පිටවීම සහ දිශාව කලින් දැනුම් දෙයි.">Gives advance notice of the direction and an upcoming exit.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai17.jpg" alt="Direction, Lane, and Exit Advance Notice" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai17.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Direction, Lane, and Exit Advance Notice" data-si="දිශාව, මංතීරුව සහ පිටවීම පිළිබඳ පූර්ව දැනුම්දීම">Direction, Lane, and Exit Advance Notice</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Gives advance notice of the direction, lane, and an upcoming exit." data-si="ඉදිරි පිටවීම, දිශාව සහ මංතීරුව කලින් දැනුම් දෙයි.">Gives advance notice of the direction, lane, and an upcoming exit.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai18.jpg" alt="Direction and Exit" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai18.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Direction and Exit" data-si="දිශාව සහ පිටවීම">Direction and Exit</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Shows the direction and the exit to take." data-si="ගත යුතු පිටවීම සහ දිශාව පෙන්වයි.">Shows the direction and the exit to take.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai19.jpg" alt="Exit" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai19.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Exit" data-si="පිටවීම">Exit</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Marks the location of an exit." data-si="පිටවීමේ ස්ථානය දක්වයි.">Marks the location of an exit.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai20.jpg" alt="Notable Location" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai20.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Notable Location" data-si="කැපී පෙනෙන ස්ථානය">Notable Location</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Points toward a notable nearby location or landmark." data-si="ළඟම ඇති කැපී පෙනෙන ස්ථානයක් හෝ සලකුණක් පෙන්වයි.">Points toward a notable nearby location or landmark.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai21.png" alt="Major Location" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai21.png</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Major Location" data-si="ප්‍රධාන ස්ථානය">Major Location</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Points toward a major nearby city or location." data-si="ළඟම ඇති ප්‍රධාන නගරයක් හෝ ස්ථානයක් පෙන්වයි.">Points toward a major nearby city or location.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai22.gif" alt="Toll Booth" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai22.gif</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Toll Booth" data-si="ගාස්තු කුටිය">Toll Booth</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates the location of a toll booth ahead." data-si="ඉදිරියේ ඇති ගාස්තු කුටියේ ස්ථානය දක්වයි.">Indicates the location of a toll booth ahead.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai23.gif" alt="Service Area Advance Notice" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai23.gif</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Service Area Advance Notice" data-si="සේවා ප්‍රදේශය පිළිබඳ පූර්ව දැනුම්දීම">Service Area Advance Notice</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Gives advance notice of an upcoming service area." data-si="ඉදිරියේ ඇති සේවා ප්‍රදේශයක් පිළිබඳ කලින් දැනුම් දෙයි.">Gives advance notice of an upcoming service area.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai24.gif" alt="Service Area" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai24.gif</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Service Area" data-si="සේවා ප්‍රදේශය">Service Area</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Marks the location of a service area." data-si="සේවා ප්‍රදේශයේ ස්ථානය දක්වයි.">Marks the location of a service area.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai25.jpg" alt="Emergency Telephone" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai25.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Emergency Telephone" data-si="හදිසි දුරකථනය">Emergency Telephone</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates the location of an emergency telephone." data-si="හදිසි දුරකථනයේ ස්ථානය දක්වයි.">Indicates the location of an emergency telephone.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai26.jpg" alt="Pull-off Area" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai26.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Pull-off Area" data-si="නවතී විවේක ගැනීමේ ප්‍රදේශය">Pull-off Area</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates a pull-off area for stopped or resting vehicles." data-si="නවතී විවේක ගැනීමට වාහන සඳහා වූ ප්‍රදේශයක් දක්වයි.">Indicates a pull-off area for stopped or resting vehicles.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai27.jpg" alt="Emergency Parking Strip" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai27.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Emergency Parking Strip" data-si="හදිසි නැවතුම් තීරුව">Emergency Parking Strip</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates an emergency parking strip along the road." data-si="මාර්ගය ඔස්සේ හදිසි නැවතුම් තීරුවක් දක්වයි.">Indicates an emergency parking strip along the road.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai28.jpg" alt="Parking Lot" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai28.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Parking Lot" data-si="නැවතුම් ස්ථානය">Parking Lot</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates the location of a parking lot." data-si="නැවතුම් ස්ථානයේ ස්ථානය දක්වයි.">Indicates the location of a parking lot.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai29.jpg" alt="Climbing Lane" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai29.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Climbing Lane" data-si="නැගුම් මංතීරුව">Climbing Lane</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates a climbing lane for slower vehicles on an uphill grade." data-si="නැගුම් බෑවුමක සෙමින් ගමන් කරන වාහන සඳහා මංතීරුවක් දක්වයි.">Indicates a climbing lane for slower vehicles on an uphill grade.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai30.jpg" alt="National Highway Number" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai30.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="National Highway Number" data-si="ජාතික මහාමාර්ග අංකය">National Highway Number</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates the route number of a national highway." data-si="ජාතික මහාමාර්ගයේ අංකය දක්වයි.">Indicates the route number of a national highway.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai31.jpg" alt="Prefectural Road Number" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai31.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Prefectural Road Number" data-si="ප්‍රාන්ත මාර්ග අංකය">Prefectural Road Number</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates the route number of a prefectural road." data-si="ප්‍රාන්ත මාර්ගයේ අංකය දක්වයි.">Indicates the route number of a prefectural road.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai32.jpg" alt="Road Nickname" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai32.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Road Nickname" data-si="මාර්ග නාමය">Road Nickname</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates the common nickname of the road." data-si="මාර්ගයේ පොදු නම දක්වයි.">Indicates the common nickname of the road.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai33.png" alt="Detour" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai33.png</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Detour" data-si="විකල්ප මාර්ගය">Detour</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates a detour route." data-si="විකල්ප මාර්ගයක් දක්වයි.">Indicates a detour route.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai34.jpg" alt="Sloped Road" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai34.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Sloped Road" data-si="බෑවුම් මාර්ගය">Sloped Road</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that the road ahead has a slope or grade." data-si="ඉදිරි මාර්ගයේ බෑවුමක් ඇති බව දක්වයි.">Indicates that the road ahead has a slope or grade.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai35.jpg" alt="Bus Stop" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai35.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Bus Stop" data-si="බස් නැවතුම්පොළ">Bus Stop</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Marks the location of a bus stop." data-si="බස් නැවතුම්පොළේ ස්ථානය දක්වයි.">Marks the location of a bus stop.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/annai36.jpg" alt="Tram Stop" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>annai36.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Tram Stop" data-si="ට්‍රෑම් නැවතුම්පොළ">Tram Stop</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Marks the location of a tram stop." data-si="ට්‍රෑම් නැවතුම්පොළේ ස්ථානය දක්වයි.">Marks the location of a tram stop.</p>
        </div>
      </div>
      </div>
    </section>

    <section id="sec-4" class="mb-10 scroll-mt-24">
      <div class="flex items-center gap-3 mb-4">
        <span class="w-8 h-8 rounded-lg bg-primary text-white flex items-center justify-center font-display font-bold text-sm shrink-0">5</span>
        <div>
          <h2 class="font-display font-bold text-lg sm:text-xl text-ink" data-en="Auxiliary Signs (Supplementary Information)" data-si="Auxiliary Signs (Supplementary Information)">Auxiliary Signs (Supplementary Information)</h2>
          <p class="text-xs text-ink/40 font-si">補助標識 &middot; 21 <span data-en="signs" data-si="ලකුණු">signs</span></p>
        </div>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/hojo01.jpg" alt="Distance/Area" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>hojo01.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Distance/Area" data-si="දුර/ප්‍රදේශය">Distance/Area</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Specifies the distance or area over which the main sign&#x27;s regulation applies." data-si="ප්‍රධාන ලකුණේ නියාමනය බලපාන දුර හෝ ප්‍රදේශය දක්වයි.">Specifies the distance or area over which the main sign&#x27;s regulation applies.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/hojo02.jpg" alt="Day/Time" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>hojo02.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Day/Time" data-si="දිනය/වේලාව">Day/Time</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Specifies the days or times during which the main sign&#x27;s regulation applies." data-si="ප්‍රධාන ලකුණේ නියාමනය බලපාන දින හෝ වේලාවන් දක්වයි.">Specifies the days or times during which the main sign&#x27;s regulation applies.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/hojo03.jpg" alt="Vehicle Type" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>hojo03.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Vehicle Type" data-si="වාහන වර්ගය">Vehicle Type</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Specifies which vehicle types the main sign&#x27;s regulation applies to." data-si="ප්‍රධාන ලකුණේ නියාමනය බලපාන වාහන වර්ග දක්වයි.">Specifies which vehicle types the main sign&#x27;s regulation applies to.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/hojo04.gif" alt="Parking Space" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>hojo04.gif</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Parking Space" data-si="නැවතුම් ඉඩ">Parking Space</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Specifies the required parking space indicated with the main sign." data-si="ප්‍රධාන ලකුණ සමඟ අවශ්‍ය නැවතුම් ඉඩ දක්වයි.">Specifies the required parking space indicated with the main sign.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/hojo05.jpg" alt="Start" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>hojo05.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Start" data-si="ආරම්භය">Start</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Marks the starting point of the regulation shown on the main sign." data-si="ප්‍රධාන ලකුණේ නියාමනයේ ආරම්භක ස්ථානය දක්වයි.">Marks the starting point of the regulation shown on the main sign.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/hojo06.jpg" alt="Within Section/Area" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>hojo06.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Within Section/Area" data-si="කොටස/ප්‍රදේශය තුළ">Within Section/Area</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that the regulation applies within the marked section or area." data-si="නියාමනය සලකුණු කළ කොටස හෝ ප්‍රදේශය තුළ බලපාන බව දක්වයි.">Indicates that the regulation applies within the marked section or area.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/hojo07.jpg" alt="End" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>hojo07.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="End" data-si="අවසානය">End</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Marks the end point of the regulation shown on the main sign." data-si="ප්‍රධාන ලකුණේ නියාමනයේ අවසාන ස්ථානය දක්වයි.">Marks the end point of the regulation shown on the main sign.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/hojo08.gif" alt="No Overtaking" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>hojo08.gif</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="No Overtaking" data-si="පසුකර යාම තහනම් (අතිරේකය)">No Overtaking</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Supplements the main sign to clarify that overtaking is also prohibited." data-si="පසුකර යාමද තහනම් බව පැහැදිලි කිරීමට ප්‍රධාන ලකුණට එකතු කරයි.">Supplements the main sign to clarify that overtaking is also prohibited.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/hojo09.jpg" alt="School Route" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>hojo09.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="School Route" data-si="පාසල් මාර්ගය">School Route</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates that the road is a designated school route." data-si="මාර්ගය නම් කළ පාසල් මාර්ගයක් බව දක්වයි.">Indicates that the road is a designated school route.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/hojo10.jpg" alt="Railway Crossing Caution" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>hojo10.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Railway Crossing Caution" data-si="දුම්රිය හරස් මාර්ග අවවාදය">Railway Crossing Caution</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Adds a caution note about an upcoming railway crossing." data-si="ඉදිරි දුම්රිය හරස් මාර්ගය පිළිබඳ අවවාද සටහනක් එකතු කරයි.">Adds a caution note about an upcoming railway crossing.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/hojo11.jpg" alt="Crosswind Caution" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>hojo11.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Crosswind Caution" data-si="හරස් සුළං අවවාදය">Crosswind Caution</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Adds a caution note about crosswinds in the area." data-si="ප්‍රදේශයේ හරස් සුළං පිළිබඳ අවවාද සටහනක් එකතු කරයි.">Adds a caution note about crosswinds in the area.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/hojo12.jpg" alt="Animal Caution" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>hojo12.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Animal Caution" data-si="සතුන් පිළිබඳ අවවාදය">Animal Caution</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Adds a caution note about animals in the area." data-si="ප්‍රදේශයේ සතුන් පිළිබඳ අවවාද සටහනක් එකතු කරයි.">Adds a caution note about animals in the area.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/hojo13.jpg" alt="Caution" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>hojo13.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Caution" data-si="අවවාදය">Caution</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="A general caution supplement attached to the main sign." data-si="ප්‍රධාන ලකුණට අනුයුක්ත සාමාන්‍ය අවවාද සටහනකි.">A general caution supplement attached to the main sign.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/hojo14.jpg" alt="Caution Notes" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>hojo14.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Caution Notes" data-si="අවවාද සටහන්">Caution Notes</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Additional caution notes attached to the main sign." data-si="ප්‍රධාන ලකුණට අනුයුක්ත අමතර අවවාද සටහන්.">Additional caution notes attached to the main sign.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/hojo15.jpg" alt="Reason for Restriction" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>hojo15.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Reason for Restriction" data-si="සීමා කිරීමට හේතුව">Reason for Restriction</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="States the reason for the restriction shown on the main sign." data-si="ප්‍රධාන ලකුණේ දක්වන සීමා කිරීමට හේතුව සඳහන් කරයි.">States the reason for the restriction shown on the main sign.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/hojo16.jpg" alt="Direction" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>hojo16.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Direction" data-si="දිශාව">Direction</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Specifies the direction the main sign&#x27;s regulation applies to." data-si="ප්‍රධාන ලකුණේ නියාමනය බලපාන දිශාව දක්වයි.">Specifies the direction the main sign&#x27;s regulation applies to.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/hojo17.jpg" alt="Place Name" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>hojo17.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Place Name" data-si="ස්ථාන නාමය">Place Name</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="States the place name relevant to the main sign." data-si="ප්‍රධාන ලකුණට අදාළ ස්ථාන නාමය සඳහන් කරයි.">States the place name relevant to the main sign.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/hojo18.gif" alt="Priority Road Ahead" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>hojo18.gif</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Priority Road Ahead" data-si="ඉදිරියේ ප්‍රමුඛතා මාර්ගයකි (අතිරේකය)">Priority Road Ahead</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Supplements the main sign to note that a priority road is ahead." data-si="ඉදිරියේ ප්‍රමුඛතා මාර්ගයක් ඇති බව ප්‍රධාන ලකුණට එකතු කරයි.">Supplements the main sign to note that a priority road is ahead.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/hojo19.jpg" alt="Starting Point" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>hojo19.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Starting Point" data-si="ආරම්භක ස්ථානය">Starting Point</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Marks the starting point referenced by the main sign." data-si="ප්‍රධාන ලකුණ දක්වන ආරම්භක ස්ථානය සලකුණු කරයි.">Marks the starting point referenced by the main sign.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/hojo20.jpg" alt="Endpoint" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>hojo20.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Endpoint" data-si="අවසාන ස්ථානය">Endpoint</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Marks the endpoint referenced by the main sign." data-si="ප්‍රධාන ලකුණ දක්වන අවසාන ස්ථානය සලකුණු කරයි.">Marks the endpoint referenced by the main sign.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/hojo21.jpg" alt="Designated Vehicle Only" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>hojo21.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Designated Vehicle Only" data-si="නිශ්චිත වාහන පමණි">Designated Vehicle Only</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Specifies that the main sign&#x27;s regulation applies only to a designated vehicle type." data-si="ප්‍රධාන ලකුණේ නියාමනය නිශ්චිත වාහන වර්ගයකට පමණක් බලපාන බව දක්වයි.">Specifies that the main sign&#x27;s regulation applies only to a designated vehicle type.</p>
        </div>
      </div>
      </div>
    </section>

    <section id="sec-5" class="mb-10 scroll-mt-24">
      <div class="flex items-center gap-3 mb-4">
        <span class="w-8 h-8 rounded-lg bg-primary text-white flex items-center justify-center font-display font-bold text-sm shrink-0">6</span>
        <div>
          <h2 class="font-display font-bold text-lg sm:text-xl text-ink" data-en="Other Signs" data-si="Other Signs">Other Signs</h2>
          <p class="text-xs text-ink/40 font-si">その他の標識 &middot; 8 <span data-en="signs" data-si="ලකුණු">signs</span></p>
        </div>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/etc01.jpg" alt="Novice Driver Sign" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>etc01.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Novice Driver Sign" data-si="අලුත් රියදුරු ලකුණ">Novice Driver Sign</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="A mark indicating a novice driver, required to be displayed by those within one year of obtaining their license. Surrounding drivers are obligated to protect vehicles displaying this sign." data-si="බලපත්‍රය ලබාගෙන වසරක් ඇතුළත රියදුරන් පෙන්විය යුතු අලුත් රියදුරු ලකුණකි. අවට රියදුරන් මෙම ලකුණ පෙන්වන වාහන ආරක්ෂා කිරීමට බැඳී සිටී.">A mark indicating a novice driver, required to be displayed by those within one year of obtaining their license. Surrounding drivers are obligated to protect vehicles displaying this sign.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/etc02.jpg" alt="Elderly Driver Sign" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>etc02.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Elderly Driver Sign" data-si="වැඩිහිටි රියදුරු ලකුණ">Elderly Driver Sign</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="A mark indicating that an elderly person is driving. Surrounding drivers are obligated to protect vehicles displaying this sign." data-si="වැඩිහිටියෙකු රිය පදවන බව දක්වන ලකුණකි. අවට රියදුරන් මෙම ලකුණ පෙන්වන වාහන ආරක්ෂා කිරීමට බැඳී සිටී.">A mark indicating that an elderly person is driving. Surrounding drivers are obligated to protect vehicles displaying this sign.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/etc03.jpg" alt="Physically Disabled Driver Sign" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>etc03.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Physically Disabled Driver Sign" data-si="ශාරීරික ආබාධිත රියදුරු ලකුණ">Physically Disabled Driver Sign</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="A mark indicating that a person with a physical disability is driving. Surrounding drivers are obligated to protect vehicles displaying this sign." data-si="ශාරීරික ආබාධිතයෙකු රිය පදවන බව දක්වන ලකුණකි.">A mark indicating that a person with a physical disability is driving. Surrounding drivers are obligated to protect vehicles displaying this sign.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/etc04.jpg" alt="Hearing-Impaired Driver Sign" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>etc04.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Hearing-Impaired Driver Sign" data-si="ශ්‍රවණ ආබාධිත රියදුරු ලකුණ">Hearing-Impaired Driver Sign</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="A mark indicating that a person with a hearing impairment is driving. Surrounding drivers are obligated to protect vehicles displaying this sign." data-si="ශ්‍රවණ ආබාධිතයෙකු රිය පදවන බව දක්වන ලකුණකි.">A mark indicating that a person with a hearing impairment is driving. Surrounding drivers are obligated to protect vehicles displaying this sign.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/etc05.jpg" alt="Provisional License Practice Sign" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>etc05.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Provisional License Practice Sign" data-si="තාවකාලික බලපත්‍ර පුහුණු ලකුණ">Provisional License Practice Sign</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="A sign required to be displayed by provisional license holders when practicing on the road." data-si="තාවකාලික බලපත්‍රධාරීන් මාර්ගයේ පුහුණුවන විට පෙන්විය යුතු ලකුණකි.">A sign required to be displayed by provisional license holders when practicing on the road.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/etc06.jpg" alt="Left Turn Permitted" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>etc06.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Left Turn Permitted" data-si="වම් හැරවුමට අවසර">Left Turn Permitted</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="At intersections with this sign, left turns are permitted regardless of the traffic signal." data-si="මෙම ලකුණ ඇති හන්දිවල, ගමනාගමන සංඥා පහන නොසලකා වම් හැරවුමට අවසර ඇත.">At intersections with this sign, left turns are permitted regardless of the traffic signal.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/etc07.jpg" alt="Wheel Clamp Zone" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>etc07.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Wheel Clamp Zone" data-si="රෝද අගුළු කලාපය">Wheel Clamp Zone</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Used in conjunction with no-parking signs. Vehicles parked in violation in areas with this sign will have a wheel clamp attached by the police." data-si="නවතීම තහනම් ලකුණු සමඟ භාවිත වේ. නීති විරෝධීව නවතන වාහනවලට පොලිසිය රෝද අගුළු දමයි.">Used in conjunction with no-parking signs. Vehicles parked in violation in areas with this sign will have a wheel clamp attached by the police.</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition rise-in flex flex-col">
        <div class="bg-paper h-28 flex items-center justify-center border-b border-black/5 p-3">
          <img src="../images/lessons/sign/etc08.jpg" alt="Designated Fire Hydrant" loading="lazy" class="max-h-full max-w-full object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-[10px] text-ink/30 font-mono\'>etc08.jpg</span>'">
        </div>
        <div class="p-4 flex-1">
          <h3 class="text-sm font-bold text-ink mb-1.5 leading-snug" data-en="Designated Fire Hydrant" data-si="නම් කළ ගිනි නිවන ජල නළය">Designated Fire Hydrant</h3>
          <p class="text-xs text-ink/60 leading-relaxed font-si" data-en="Indicates the presence of a fire hydrant designated under fire prevention laws for firefighting activities." data-si="ගිනි නිවීමේ කටයුතු සඳහා ගිනි නිවාරණ නීති යටතේ නම් කළ ජල නළයක් ඇති බව දක්වයි.">Indicates the presence of a fire hydrant designated under fire prevention laws for firefighting activities.</p>
        </div>
      </div>
      </div>
    </section>

  </div>
</main>

<footer class="text-center py-8 text-xs text-ink/40 border-t border-black/5 bg-white">
  <p>Japan Driving License Practice System &copy; 2026</p>
  <p class="mt-1" data-en="Ready to put this into practice?" data-si="දැන් පුහුණු විය යුතුද?">Ready to put this into practice?</p>
  <a href="index.php" class="text-primary hover:underline font-medium">&rarr; <span data-en="Take the free mock exam" data-si="නොමිලේ පරීක්ෂණය අරඹන්න">Take the free mock exam</span></a>
</footer>

<script>
function setLanguage(lang) {
  document.getElementById('btn-en').className = "px-2.5 sm:px-3 py-1 rounded-md font-semibold transition " + (lang === 'en' ? 'bg-white text-primary' : 'text-white');
  document.getElementById('btn-si').className = "px-2.5 sm:px-3 py-1 rounded-md font-semibold transition font-si " + (lang === 'si' ? 'bg-white text-primary' : 'text-white');
  document.documentElement.lang = lang;
  document.querySelectorAll('[data-en]').forEach(el => {
    el.innerText = lang === 'si' ? (el.getAttribute('data-si') || el.getAttribute('data-en')) : el.getAttribute('data-en');
  });
}
</script>
</body>
</html>