<?php
session_start();
require_once __DIR__ . '/../visitor.php';
require_once __DIR__ . '/../includes/config.php';

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
<title>Chapter 1: Common Rules for Pedestrians and Drivers | Japan Driving License Guide (Sinhala/English)</title>
<meta name="description" content="Chapter 1 of Japan's Rules of the Road: basic traffic rules, the Road User's Code, traffic lights and signs, following police instructions, and prohibited actions on the road — in English and Sinhala.">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://menkyoo.jp/lessons/chapter-1-common-rules.php">
<meta name="theme-color" content="#0F2F6E">
<?php include __DIR__ . '/../includes/theme.php'; ?>
<style>
  .img-slot{
    text-align:center; margin:1.25rem 0; padding:2rem 1rem;
    background:#F1F0EC; border:2px dashed #C9C6BC; border-radius:.75rem;
    color:#8A8676; font-size:.8rem;
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

<main class="flex-grow w-full max-w-4xl mx-auto px-4 sm:px-6 py-10">
  <div class="bg-white rounded-2xl shadow-sm border border-black/5 p-6 sm:p-10 space-y-8">

    <!-- Title -->
    <div class="border-b border-black/10 pb-6">
      <span class="bg-primary-light text-primary text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider" data-en="Chapter 1" data-si="1 වන පරිච්ඡේදය">Chapter 1</span>
      <h1 class="text-2xl sm:text-3xl font-display font-bold text-ink mt-3" data-en="Common Rules for Pedestrians and Drivers" data-si="පාගමනින් ගමන් කරන්නන් සහ රියදුරන් සඳහා වන පොදු නීති">Common Rules for Pedestrians and Drivers</h1>
      <p class="text-sm text-ink/70 mt-4 leading-relaxed" data-en="The motor vehicle has become an indispensable part of our modern life. At the same time, however, if we fail to use it properly, it can become a lethal weapon, capable of causing serious traffic accidents, or a source of noise or disturbance, having a significant effect on roadside neighborhoods. Moreover, selfish driving can sometimes cause trouble for others." data-si="මෝටර් රථ නූතන ජීවිතයට අත්‍යවශ්‍ය වී තිබුණද, ඒවා අවිචාරවත් ලෙස භාවිත කිරීමෙන් බරපතල අනතුරු, ඝෝෂාකාරී පරිසරයක් සහ මහජන පීඩා ඇතිවිය හැක. එබැවින් පාගමනින් ගමන් කරන්නන් සහ රියදුරන් යන දෙපිරිසම මාර්ග නීති පිළිපදිමින් අන් අයගේ ආරක්ෂාව සහ සුබසිද්ධිය උදෙසා කටයුතු කිරීම අත්‍යවශ්‍ය වේ.">
        The motor vehicle has become an indispensable part of our modern life. At the same time, however, if we fail to use it properly, it can become a lethal weapon, capable of causing serious traffic accidents, or a source of noise or disturbance, having a significant effect on roadside neighborhoods. Moreover, selfish driving can sometimes cause trouble for others.
      </p>
    </div>

    <!-- ============ SECTION 1 ============ -->
    <section class="space-y-5">
      <h2 class="font-display font-bold text-lg text-primary bg-primary-light px-4 py-2.5 rounded-lg" data-en="1. Basic Rules" data-si="1. මූලික නීති">1. Basic Rules</h2>

      <div>
        <h3 class="font-semibold text-ink mb-2" data-en="1-1 Follow the traffic rules" data-si="1-1 මාර්ග නීති අනුගමනය කිරීම">1-1 Follow the traffic rules</h3>
        <p class="text-sm text-ink/70 leading-relaxed mb-3" data-en="A tremendous volume of pedestrian and vehicular traffic moves on the road. The failure of a single driver or pedestrian to consider others, by moving in a selfish or thoughtless manner, may disturb the traffic pattern or cause accidents, or cause trouble for others or put them at risk." data-si="මාර්ග රථවාහන ගමනාගමනය සාර්ථක වන්නේ සැවොම නීතිගරුකව කටයුතු කළහොත් පමණි. ආත්මාර්ථකාමී සහ නොසැලකිලිමත් ලෙස කටයුතු කිරීම අනතුරුවලට මෙන්ම ගමනාගමනය අඩාල වීමටද හේතුවේ.">
          A tremendous volume of pedestrian and vehicular traffic moves on the road. The failure of a single driver or pedestrian to consider others, by moving in a selfish or thoughtless manner, may disturb the traffic pattern or cause accidents, or cause trouble for others or put them at risk.
        </p>
        <p class="text-sm text-ink/70 leading-relaxed" data-en="Traffic rules have been laid down as a systematic set of commitments that must be observed by everyone to ensure safe and smooth road traffic. In other words, it is the fundamental responsibility of each citizen as a member of society to observe the traffic rules." data-si="ආරක්ෂිත සහ සුමට මාර්ග ගමනාගමනයක් තහවුරු කිරීම සඳහා නීති පද්ධතියක් සකසා ඇති අතර, එම මාර්ග නීති පිළිපැදීම සෑම පුරවැසියෙකුගේම මූලික වගකීමකි.">
          Traffic rules have been laid down as a systematic set of commitments that must be observed by everyone to ensure safe and smooth road traffic. In other words, it is the fundamental responsibility of each citizen as a member of society to observe the traffic rules.
        </p>
      </div>

      <!-- IMAGE PLACEHOLDER: photo/illustration showing pedestrians and vehicles sharing a busy road -->
      <div class="img-slot overflow-hidden rounded-xl">
  <img src="/lessons/img/pedestriansvehiclessharingabusyroad.png" alt="Pedestrians and vehicles sharing a busy road" class="w-full h-auto" />
</div>
      <div>
        <h3 class="font-semibold text-ink mb-2" data-en="1-2 The Road User's Code" data-si="1-2 මාර්ග පරිශීලක සංග්‍රහය">1-2 The Road User's Code</h3>
        <p class="text-sm text-ink/70 leading-relaxed mb-4" data-en="It goes without saying that we must follow the rules of the road when traveling on the road. We must take utmost care and precaution, in accordance with road and traffic conditions. While on the road, keep the following in mind:" data-si="මාර්ගයේ ගමන් කිරීමේදී පහත සඳහන් මූලික කරුණු පිළිබඳව නිරන්තරයෙන් අවධානය යොමු කළ යුතුය:">
          It goes without saying that we must follow the rules of the road when traveling on the road. We must take utmost care and precaution, in accordance with road and traffic conditions. While on the road, keep the following in mind:
        </p>
        <ul class="space-y-3">
          <li class="bg-paper p-3.5 rounded-lg border border-black/5">
            <p class="text-sm font-semibold text-ink" data-en="(1) Pay close attention to pedestrians and vehicles around you. Move in a manner considerate to others." data-si="(1) වටපිටාවේ සිටින පදිකයින් සහ අනෙකුත් වාහන කෙරෙහි නිරන්තර අවධානය යොමු කරමින්, අන් අයට බාධාවක් නොවන සේ කටයුතු කරන්න.">(1) Pay close attention to pedestrians and vehicles around you. Move in a manner considerate to others.</p>
          </li>
          <li class="bg-paper p-3.5 rounded-lg border border-black/5">
            <p class="text-sm font-semibold text-ink" data-en="(2) Do not always put your own traffic convenience ahead of the well-being of the residents along the road. Take care not to cause unpleasant noises or other nuisance." data-si="(2) තමාගේ පහසුව පමණක් නොසිතා, පාර දෙපස පදිංචිකරුවන්ට හිරිහැරයක් නොවන සේ අධික ශබ්ද නැගීමෙන් සහ පීඩාකාරී ලෙස කටයුතු කිරීමෙන් වළකින්න.">(2) Do not always put your own traffic convenience ahead of the well-being of the residents along the road. Take care not to cause unpleasant noises or other nuisance.</p>
          </li>
          <li class="bg-paper p-3.5 rounded-lg border border-black/5">
            <p class="text-sm font-semibold text-ink" data-en="(3) Be prepared for the worst. Make sure you have automobile insurance, learn about emergency aid, and keep a first-aid kit in your car." data-si="(3) අනපේක්ෂිත අනතුරුවලට මුහුණදීම සඳහා සුදුසු වාහන රක්ෂණයක් ලබාගෙන තිබීම, ප්‍රථමාධාර ලබාදෙන ආකාරය දැන සිටීම සහ වාහනය තුළ ප්‍රථමාධාර කට්ටලයක් තබා ගැනීම අත්‍යවශ්‍ය වේ.">(3) Be prepared for the worst. Make sure you have automobile insurance, learn about emergency aid, and keep a first-aid kit in your car.</p>
          </li>
          <li class="bg-paper p-3.5 rounded-lg border border-black/5">
            <p class="text-sm font-semibold text-ink" data-en="(4) If you come across someone involved in a traffic accident or a breakdown, call the police and/or ambulance, and give assistance in any way you can." data-si="(4) මාර්ග අනතුරක් හෝ වාහන පළුදු වීමක් දුටුවහොත් වහාම පොලිසියට හෝ ගිලන්රථ සේවයට දැනුම් දී හැකි උපරිමයෙන් උපකාර කරන්න.">(4) If you come across someone involved in a traffic accident or a breakdown, call the police and/or ambulance, and give assistance in any way you can.</p>
          </li>
          <li class="bg-paper p-3.5 rounded-lg border border-black/5">
            <p class="text-sm font-semibold text-ink" data-en="(5) Have good understanding of the physical characteristics of vehicles, such as dead angles, turning radius differences, and so on." data-si="(5) වාහනවල ඇති නොපෙනෙන කලාප (dead angles) සහ වංගු ගැනීමේදී සිදුවන වෙනස්කම් පිළිබඳව රියදුරන් මෙන්ම පදිකයින්ද දැනුවත් විය යුතුය.">(5) Have good understanding of the physical characteristics of vehicles, such as dead angles, turning radius differences, and so on.</p>
          </li>
          <li class="bg-paper p-3.5 rounded-lg border border-black/5">
            <p class="text-sm font-semibold text-ink" data-en="(6) Do not litter or place any object on the road without permission. Do not do anything that would obstruct passage, or cause nuisance to others." data-si="(6) පාරට කුණු කසළ දැමීමෙන් හෝ අවසරයකින් තොරව බාධාකාරී ද්‍රව්‍ය තැබීමෙන් වළකින්න.">(6) Do not litter or place any object on the road without permission. Do not do anything that would obstruct passage, or cause nuisance to others.</p>
          </li>
        </ul>
      </div>

      <!-- IMAGE PLACEHOLDER: diagram illustrating a vehicle's "dead angle" (blind spot) -->
        <div class="img-slot overflow-hidden rounded-xl">
  <img src="/lessons/img/blindspot.png" alt="diagram of a vehicle's dead angle / blind spot" class="w-full h-auto" />
</div>

    </section>

    <!-- ============ SECTION 2 ============ -->
    <section class="space-y-5">
      <h2 class="font-display font-bold text-lg text-primary bg-primary-light px-4 py-2.5 rounded-lg" data-en="2. Follow traffic lights, traffic signs and markings" data-si="2. මාර්ග සංඥා එළි, මාර්ග සලකුණු සහ සලකුණු කිරීම් අනුගමනය කිරීම">2. Follow traffic lights, traffic signs and markings</h2>

      <div>
        <h3 class="font-semibold text-ink mb-2" data-en="2-1 Meaning of traffic lights" data-si="2-1 මාර්ග සංඥා එළිවල අර්ථයන්">2-1 Meaning of traffic lights</h3>

        <!-- IMAGE PLACEHOLDER: photo of an actual Japanese traffic light (red/yellow/green stack) -->
               <div class="img-slot overflow-hidden rounded-xl">
  <img src="/lessons/img/apanesetrafficsignal.png" alt="Japanese traffic signal" class="w-full h-auto" />
</div>
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse text-xs sm:text-sm">
            <thead>
              <tr class="bg-primary text-white">
                <th class="p-3 rounded-tl-lg" data-en="Signal Light" data-si="සංඥා එළිය">Signal Light</th>
                <th class="p-3" data-en="Rules for Vehicles" data-si="වාහන සඳහා නීති">Rules for Vehicles</th>
                <th class="p-3 rounded-tr-lg" data-en="Rules for Pedestrians" data-si="පදිකයින් සඳහා නීති">Rules for Pedestrians</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-black/10 bg-white">
              <tr>
                <td class="p-3 font-bold text-go" data-en="Green Light" data-si="කොළ එළිය">Green Light</td>
                <td class="p-3" data-en="Vehicles may go straight or turn right/left. Lightweight vehicles/moped drivers making a two-step right turn must proceed to the point of making a right turn, stop and wait." data-si="වාහනවලට කෙළින් ගමන් කිරීමට හෝ හැරවීමට හැක. (දෙපියවරක් ඔස්සේ දකුණට හරවන සැහැල්ලු වාහන නියමිත ස්ථානය දක්වා ගොස් නැවතී සිටිය යුතුය.)">Vehicles may go straight or turn right/left. Lightweight vehicles/moped drivers making a two-step right turn must proceed to the point of making a right turn, stop and wait.</td>
                <td class="p-3" data-en="Pedestrians may proceed and cross." data-si="පදිකයින්ට පාර මාරු විය හැක.">Pedestrians may proceed and cross.</td>
              </tr>
              <tr>
                <td class="p-3 font-bold" style="color:#D9A400" data-en="Yellow Light" data-si="කහ එළිය">Yellow Light</td>
                <td class="p-3" data-en="Vehicles must not move further than the stopping point. If unable to stop safely, it may continue to proceed." data-si="නැවැත්වීමේ රේඛාවට පෙර නැවැත්විය යුතුය. (ආරක්ෂිතව නැවැත්වීමට නොහැකි තරම් ආසන්නව සිටී නම් පමණක් ඉදිරියට යා හැක.)">Vehicles must not move further than the stopping point. If unable to stop safely, it may continue to proceed.</td>
                <td class="p-3" data-en="Pedestrians must not start to cross. A pedestrian who is already crossing must finish crossing quickly." data-si="පාර මාරු වීම ආරම්භ නොකළ යුතුය. දැනටමත් පාර මැද සිටී නම් වහාම මාරු වී අවසන් කළ යුතුය.">Pedestrians must not start to cross. A pedestrian who is already crossing must finish crossing quickly.</td>
              </tr>
              <tr>
                <td class="p-3 font-bold text-stop" data-en="Red Light" data-si="රතු එළිය">Red Light</td>
                <td class="p-3" data-en="Vehicles must not proceed past the stopping point." data-si="වාහන නැවැත්වීමේ රේඛාව පස්සෙන් නතර විය යුතු අතර ඉදිරියට නොයා යුතුය.">Vehicles must not proceed past the stopping point.</td>
                <td class="p-3" data-en="Pedestrians must not cross." data-si="පදිකයින්ට පාර මාරු වීම සම්පූර්ණයෙන් තහනම්ය.">Pedestrians must not cross.</td>
              </tr>
              <tr>
                <td class="p-3 font-bold text-go" data-en="Green Arrow Light" data-si="කොළ පැහැති ඊතල සංඥාව">Green Arrow Light</td>
                <td class="p-3" data-en="Vehicles may proceed in the direction indicated by the arrow even if the signal light is yellow or red." data-si="ප්‍රධාන එළිය රතු හෝ කහ වුවද ඊතලයෙන් දක්වා ඇති දිශාවට පමණක් ගමන් කළ හැක.">Vehicles may proceed in the direction indicated by the arrow even if the signal light is yellow or red.</td>
                <td class="p-3" data-en="Follow general signals." data-si="සාමාන්‍ය පදික සංඥා බලන්න.">Follow general signals.</td>
              </tr>
              <tr>
                <td class="p-3 font-bold" style="color:#D9A400" data-en="Flashing Yellow" data-si="දැල්වෙමින් නිවෙන කහ එළිය">Flashing Yellow</td>
                <td class="p-3" data-en="Pedestrians, vehicles, and streetcars may proceed carefully, paying attention to other traffic." data-si="අනෙකුත් වාහන සහ පදිකයින් ගැන සැලකිලිමත් වෙමින් ප්‍රවේශමෙන් ගමන් කරන්න.">Pedestrians, vehicles, and streetcars may proceed carefully, paying attention to other traffic.</td>
                <td class="p-3" data-en="Proceed carefully." data-si="ප්‍රවේශමෙන් පාර මාරු වන්න.">Proceed carefully.</td>
              </tr>
              <tr>
                <td class="p-3 font-bold text-stop" data-en="Flashing Red" data-si="දැල්වෙමින් නිවෙන රතු එළිය">Flashing Red</td>
                <td class="p-3" data-en="Vehicles must stop at the stopping point before proceeding." data-si="නැවැත්වීමේ රේඛාව අසල සම්පූර්ණයෙන්ම නතර වී, ආරක්ෂිත බව බලමින් ඉදිරියට යා යුතුය.">Vehicles must stop at the stopping point before proceeding.</td>
                <td class="p-3" data-en="Pedestrians may proceed carefully." data-si="ප්‍රවේශමෙන් බලමින් පාර මාරු වන්න.">Pedestrians may proceed carefully.</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div>
        <h3 class="font-semibold text-ink mb-2" data-en="2-2 How to read signs" data-si="2-2 මාර්ග සංඥා පුවරු කියවන ආකාරය">2-2 How to read signs</h3>
        <ul class="space-y-3">
          <li class="bg-paper p-3.5 rounded-lg border border-black/5">
            <p class="text-sm text-ink"><strong data-en="Regulatory signs:" data-si="නියාමන සංඥා:">Regulatory signs:</strong> <span data-en="Prohibit a specific mode of traffic, or provide a specific traffic instruction (e.g., Road closed to all vehicles, No U-turn, Maximum speed)." data-si="විශේෂිත ක්‍රියාවන් තහනම් කිරීම හෝ අනිවාර්යය දිශාවන් නියම කරයි (උදා: ඇතුළුවීම තහනම්, U-Turn තහනම්, වේග සීමා).">Prohibit a specific mode of traffic, or provide a specific traffic instruction (e.g., Road closed to all vehicles, No U-turn, Maximum speed).</span></p>
            <!-- IMAGE PLACEHOLDER: examples of regulatory signs -->
                <div class="img-slot overflow-hidden rounded-xl">
  <img src="/lessons/img/regulatorysignexamples.png" alt="regulatory sign examples" class="w-full h-auto" />
</div>

          </li>
          <li class="bg-paper p-3.5 rounded-lg border border-black/5">
            <p class="text-sm text-ink"><strong data-en="Designation signs:" data-si="නියමිත කලාප සංඥා:">Designation signs:</strong> <span data-en="Indicate that vehicles may proceed in a specific manner, or indicate designated zones (e.g., Parking permitted, Crosswalk, Safety zone)." data-si="පදික මාරු, වාහන නැවැත්වීමේ ස්ථාන හෝ විශේෂිත කලාප පෙන්වා දෙයි.">Indicate that vehicles may proceed in a specific manner, or indicate designated zones (e.g., Parking permitted, Crosswalk, Safety zone).</span></p>
            <!-- IMAGE PLACEHOLDER: examples of designation signs -->
                            <div class="img-slot overflow-hidden rounded-xl">
  <img src="/lessons/img/designationsignexample.png" alt="designation sign examples" class="w-full h-auto" />
</div>
          </li>
          <li class="bg-paper p-3.5 rounded-lg border border-black/5">
            <p class="text-sm text-ink"><strong data-en="Warning signs:" data-si="අවවාදාත්මක සංඥා:">Warning signs:</strong> <span data-en="Inform road users in advance of possible danger or adverse road conditions (e.g., Railroad crossing, Road under construction). All warning signs have a yellow background." data-si="ඉදිරියෙන් ඇති අනතුරුදායක ස්ථාන හෝ පාරේ අලුත්වැඩියාවන් පිළිබඳව කල්තියා දැනුවත් කරයි (කහ පැහැති පසුබිම සහිතයි).">Inform road users in advance of possible danger or adverse road conditions (e.g., Railroad crossing, Road under construction). All warning signs have a yellow background.</span></p>
            <!-- IMAGE PLACEHOLDER: examples of warning signs -->
                      <div class="img-slot overflow-hidden rounded-xl">
  <img src="/lessons/img/warningsignexamples.png" alt="warning sign examples" class="w-full h-auto" />
</div>

          </li>
          <li class="bg-paper p-3.5 rounded-lg border border-black/5">
            <p class="text-sm text-ink"><strong data-en="Guidance signs:" data-si="මගපෙන්වීමේ සංඥා:">Guidance signs:</strong> <span data-en="Provide geographical information, such as place names, directions, and distances." data-si="ස්ථාන, දිශාවන් සහ දුර ප්‍රමාණයන් පිළිබඳ තොරතුරු ලබාදෙයි.">Provide geographical information, such as place names, directions, and distances.</span></p>
            <!-- IMAGE PLACEHOLDER: examples of guidance signs -->
                  <div class="img-slot overflow-hidden rounded-xl">
  <img src="/lessons/img/guidancesignexamples.png" alt="guidance sign examples" class="w-full h-auto" />
</div>

          </li>
          <li class="bg-paper p-3.5 rounded-lg border border-black/5">
            <p class="text-sm text-ink"><strong data-en="Auxiliary signs:" data-si="අතිරේක සංඥා:">Auxiliary signs:</strong> <span data-en="Placed below main signs to provide supplementary information about the meaning of regulatory or other main signs (e.g., start points, time limits, vehicle types)." data-si="ප්‍රධාන සංඥා පුවරුවට යටින් සවි කර ඇති අතර, අදාළ නීතිය බලපාන වේලාවන් හෝ වාහන වර්ග වර්ග කර පෙන්වයි.">Placed below main signs to provide supplementary information about the meaning of regulatory or other main signs (e.g., start points, time limits, vehicle types).</span></p>
            <!-- IMAGE PLACEHOLDER: examples of auxiliary signs -->
                 <div class="img-slot overflow-hidden rounded-xl">
  <img src="/lessons/img/auxiliarysignexamples.png" alt="auxiliary sign examples" class="w-full h-auto" />
</div>


          </li>
        </ul>
      </div>

      <div>
        <h3 class="font-semibold text-ink mb-2" data-en="2-3 How to read traffic markings" data-si="2-3 මාර්ග සලකුණු කියවන ආකාරය">2-3 How to read traffic markings</h3>
        <p class="text-sm text-ink/70 leading-relaxed mb-3" data-en="Traffic markings refer to lines, codes, and letters painted on the road or raised markers." data-si="මාර්ග සලකුණු යනු පාර මතුපිට ඇඳ ඇති රේඛා, කේත සහ අකුරු වේ.">
          Traffic markings refer to lines, codes, and letters painted on the road or raised markers.
        </p>
        <ul class="space-y-2 text-sm text-ink/80">
          <li>• <strong data-en="Regulatory markings:" data-si="නියාමන සලකුණු:">Regulatory markings:</strong> <span data-en="Prohibit a specific mode of traffic (e.g., Yellow marking indicating No Parking/Stopping, No Entry Zone)." data-si="විශේෂිත ක්‍රියාවන් තහනම් කරයි (උදා: No Parking/Stopping කහ සලකුණු).">Prohibit a specific mode of traffic (e.g., Yellow marking indicating No Parking/Stopping, No Entry Zone).</span></li>
          <li>• <strong data-en="Designation markings:" data-si="නියමිත සලකුණු:">Designation markings:</strong> <span data-en="Indicate directions for each lane or crosswalk/pedestrian crossing ahead." data-si="මංතීරු එකක දිශාව හෝ ඉදිරියේ ඇති පදික මාරුව පෙන්වයි.">Indicate directions for each lane or crosswalk/pedestrian crossing ahead.</span></li>
        </ul>
        <!-- IMAGE PLACEHOLDER: photo of road surface markings (lane lines, crosswalk) -->
          </div>
              <div class="img-slot overflow-hidden rounded-xl">
  <img src="/lessons/img/roadmarkingexamples.png" alt="police officer's hand signal" class="w-full h-auto" />
</div>
    </section>

    <!-- ============ SECTION 3 ============ -->
    <section class="space-y-4">
      <h2 class="font-display font-bold text-lg text-primary bg-primary-light px-4 py-2.5 rounded-lg" data-en="3. Follow the instructions of police" data-si="3. පොලිස් නිලධාරීන්ගේ උපදෙස් අනුගමනය කිරීම">3. Follow the instructions of police</h2>
      <p class="text-sm text-ink/70 leading-relaxed" data-en="When a police officer or traffic warden is on the spot directing traffic by hand or flashlight signals, you must follow those signals. The instructions given by the officer/warden should take priority even if these contradict the applicable traffic regulations indicated by traffic signs or markings." data-si="මාර්ගයේ රාජකාරියේ නියුතු පොලිස් නිලධාරීන් හෝ මාර්ග නියාමකයින් ලබාදෙන සංඥා, පවතින මාර්ග සංඥා එළි සහ පුවරුවලට වඩා ඉහළින් බලපායි. එම නිසා සෑම විටම ඔවුන්ගේ නියෝගවලට ප්‍රමුඛතාව ලබාදිය යුතුය.">
        When a police officer or traffic warden is on the spot directing traffic by hand or flashlight signals, you must follow those signals. The instructions given by the officer/warden should take priority even if these contradict the applicable traffic regulations indicated by traffic signs or markings.
      </p>
      <!-- IMAGE PLACEHOLDER: police officer directing traffic with hand signal -->
           <div class="img-slot overflow-hidden rounded-xl">
  <img src="/lessons/img/policeofficershandsignal.png" alt="police officer's hand signal" class="w-full h-auto" />
</div>
    </section>

    <!-- ============ SECTION 4 ============ -->
    <section class="space-y-4">
      <h2 class="font-display font-bold text-lg text-primary bg-primary-light px-4 py-2.5 rounded-lg" data-en="4. Prohibited actions on the road" data-si="4. පාරේ තහනම් කර ඇති ක්‍රියා">4. Prohibited actions on the road</h2>
      <p class="text-sm text-ink/70 leading-relaxed mb-2" data-en="The following dangerous actions are strictly prohibited on the road:" data-si="පහත සඳහන් ක්‍රියාවන් මාර්ගයේදී කිරීම සම්පූර්ණයෙන් තහනම් වේ:">The following dangerous actions are strictly prohibited on the road:</p>
      <ul class="space-y-2 text-sm text-ink/80">
        <li class="flex gap-2"><span class="text-stop shrink-0">✕</span><span data-en="Interfering with road traffic by staggering drunkenly, talking, sitting, lying, etc., on the road." data-si="මද්‍යසාර භාවිත කර මාර්ගයේ හැසිරීම, පාරේ වාඩිවීම, ලැග සිටීම.">Interfering with road traffic by staggering drunkenly, talking, sitting, lying, etc., on the road.</span></li>
        <li class="flex gap-2"><span class="text-stop shrink-0">✕</span><span data-en="Playing catch, roller-skating, etc., in a place where there is busy traffic." data-si="වාහන තදබදය සහිත ස්ථානවල සෙල්ලම් කිරීම.">Playing catch, roller-skating, etc., in a place where there is busy traffic.</span></li>
        <li class="flex gap-2"><span class="text-stop shrink-0">✕</span><span data-en="Throwing or shooting anything toward the road." data-si="පාරට විවිධ දේ විසි කිරීම.">Throwing or shooting anything toward the road.</span></li>
        <li class="flex gap-2"><span class="text-stop shrink-0">✕</span><span data-en="Damaging the road, littering, or scattering wastewater, garbage, nails, broken glass, etc." data-si="පාරට කුණු, වීදුරු, ඇණ හෝ අපිරිසිදු ජලය දැමීම.">Damaging the road, littering, or scattering wastewater, garbage, nails, broken glass, etc.</span></li>
        <li class="flex gap-2"><span class="text-stop shrink-0">✕</span><span data-en="Throwing cigarette butts, wastepaper, empty cans from the car window, or leaning out of the car window." data-si="වාහන ජනේලයෙන් පිටතට සිගරට් කොට, බෝතල් විසි කිරීම හෝ ඇඟ එලියට දැමීම.">Throwing cigarette butts, wastepaper, empty cans from the car window, or leaning out of the car window.</span></li>
        <li class="flex gap-2"><span class="text-stop shrink-0">✕</span><span data-en="Directing a light beam toward the road in a way that could dazzle an approaching vehicle's driver." data-si="එන වාහනවල රියදුරන්ගේ ඇස් කූරුම්බල වන සේ ආලෝකය එල්ල කිරීම.">Directing a light beam toward the road in a way that could dazzle an approaching vehicle's driver.</span></li>
        <li class="flex gap-2"><span class="text-stop shrink-0">✕</span><span data-en="Sprinkling water over the road when it is likely to make the road icy." data-si="පාර හිම බවට පත්වී ලිස්සා යන සුළු තත්ත්වයන්හිදී ජලය ඉසීම.">Sprinkling water over the road when it is likely to make the road icy.</span></li>
        <li class="flex gap-2"><span class="text-stop shrink-0">✕</span><span data-en="Do not display goods or place sand, lumber, or other objects on the road in a manner likely to obstruct traffic." data-si="පාරට බාධා වන සේ බඩු බාහිරාදිය, වැලි හෝ ලී ගොඩගැසීම.">Do not display goods or place sand, lumber, or other objects on the road in a manner likely to obstruct traffic.</span></li>
        <li class="flex gap-2"><span class="text-stop shrink-0">✕</span><span data-en="Do not ask a non-licensed person or a drunken person to drive a car." data-si="බලපත්‍ර නොමැති හෝ මද්‍යසාර භාවිත කළ අයට රිය පැදවීමට දීම.">Do not ask a non-licensed person or a drunken person to drive a car.</span></li>
        <li class="flex gap-2"><span class="text-stop shrink-0">✕</span><span data-en="Do not offer or serve alcohol to a person who will be driving." data-si="රිය පැදවීමට සිටින පුද්ගලයෙකුට මද්‍යසාර ලබාදීම.">Do not offer or serve alcohol to a person who will be driving.</span></li>
        <li class="flex gap-2"><span class="text-stop shrink-0">✕</span><span data-en="Do not require a driver to drive an overloaded vehicle." data-si="නීතිමය බර ප්‍රමාණයට වඩා වාහනයට බර පටවා පැදවීමට සැලැස්වීම.">Do not require a driver to drive an overloaded vehicle.</span></li>
      </ul>
    </section>

    <!-- Important Advice callout -->
    <div class="bg-primary-light border border-primary/20 rounded-xl p-5">
      <p class="text-xs font-bold text-primary uppercase tracking-wide mb-2" data-en="Important Advice" data-si="විශේෂ උපදෙස">Important Advice</p>
      <p class="text-sm text-ink font-medium italic" data-en="&quot;You shouldn't do things that will cause trouble for other people on the road.&quot;" data-si="&quot;මාර්ගයේ ගමන් කරන වෙනත් කිසිම කෙනෙකුට පීඩාවක් හෝ බාධාවක් වන කිසිවක් ඔබ නොකළ යුතුය.&quot;">"You shouldn't do things that will cause trouble for other people on the road."</p>
    </div>

    <!-- Footer Actions -->
    <div class="pt-6 border-t border-black/10 flex flex-col sm:flex-row items-center justify-between gap-4">
      <a href="../lessons.php" class="text-sm font-semibold text-primary hover:underline" data-en="← Back to All Lessons" data-si="← සියලුම පාඩම් වෙත යන්න">← Back to All Lessons</a>
      <a href="../index.php" class="bg-primary hover:bg-primary-dark text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition shadow-md" data-en="Test Yourself — Start Quiz →" data-si="දැන් ඔබම පරීක්ෂා කරගන්න →">Test Yourself — Start Quiz →</a>
    </div>

  </div>
</main>

<?php include __DIR__ . '/../includes/site-footer.php'; ?>

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