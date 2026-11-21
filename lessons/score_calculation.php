<?php
// Scoring System Guide - Bilingual PHP Page
$lang = isset($_GET['lang']) && $_GET['lang'] === 'si' ? 'si' : 'en';
$alt_lang = $lang === 'en' ? 'si' : 'en';
$current_url = strtok($_SERVER["URI"], '?') ?: 'score_calculation.php';
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><<?= $lang === 'en' ? 'Japanese Driving License Exam Scoring System — Karimen, Honmen & Gentsuki' : 'ජපන් රියදුරු බලපත්‍ර විභාග ලකුණු ක්‍රමය — කරිමන්, හොන්මන් සහ ගෙන්ට්සුකි' ?></title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="<?= $lang === 'en' ? 'Detailed breakdown of scoring and passing marks for Japanese driving license exams, including Karimen, Honmen, and 50cc moped tests.' : 'კරිමන්, හොන්මන් සහ 50cc මොපෙඩ් පරීක්ෂණ ඇතුළුව ජපන් රියදුරු බලපත්‍ර විභාග වල ලකුණු ලබා දෙන ආකාරය සහ සමත් ලකුණු පිළිබඳ විස්තරය.' ?>">
    <meta name="robots" content="index, follow">

    <!-- Tailwind CSS & Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = { theme: { extend: {
        colors: { ink:'#101A30', paper:'#F6F5F1', primary:{DEFAULT:'#0F2F6E',light:'#E7ECFA',dark:'#0A2050'}, accent:{DEFAULT:'#F2A73B',light:'#FDF1DD'}, go:'#1C8F5A', stop:'#D5432E' },
        fontFamily: { display:['"Space Grotesk"','sans-serif'], body:['"Inter"','sans-serif'] }
      }}}
    </script>
    <style>body{font-family:'Inter',sans-serif;}</style>
</head>
<body class="bg-paper text-ink antialiased">

    <!-- Top Navigation / Language Toggle Bar -->
    <header class="bg-white border-b border-black/5 sticky top-0 z-50">
        <div class="max-w-4xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="index.php" class="font-display font-bold text-lg text-primary flex items-center gap-2">
                <span class="bg-primary text-white p-1.5 rounded-lg text-xs">JP</span> License Prep
            </a>
            <div class="flex items-center gap-3">
                <a href="?lang=<?= $alt_lang ?>" class="bg-paper border border-black/10 px-3 py-1.5 rounded-xl text-xs font-semibold hover:bg-primary hover:text-white transition">
                    <?= $lang === 'en' ? 'සිංහලට මාරු වන්න (SI)' : 'Switch to English (EN)' ?>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Wrapper -->
    <main class="max-w-4xl mx-auto px-4 py-8">

        <article class="bg-white rounded-3xl shadow-sm border border-black/5 overflow-hidden p-6 sm:p-10 mb-8">
            <div class="mb-6">
                <span class="bg-primary/10 text-primary font-semibold text-xs px-3 py-1.5 rounded-full uppercase tracking-wider">
                    <?= $lang === 'en' ? 'Exam Scoring Guide' : 'විභාග ලකුණු ක්‍රමවේදය' ?>
                </span>
                <h1 class="font-display text-2xl sm:text-4xl font-bold text-ink mt-3 leading-tight">
                    <?= $lang === 'en' ? 'Japanese Driving License Exam Scoring Systems' : 'ජපන් රියදුරු බලපත්‍ර විභාග ලකුණු ක්‍රමවේදය' ?>
                </h1>
                <p class="text-ink/60 text-sm mt-2">
                    <?= $lang === 'en' ? 'Understand how each exam is graded, the point distribution per question, and the exact passing score required.' : 'සෑම විභාගයක්ම ශ්‍රේණිගත කරන්නේ කෙසේද, ප්‍රශ්නයකට හිමි ලකුණු ප්‍රමාණය සහ අවශ්‍ය වන අවම සමත් ලකුණු මොනවාදැයි දැනಿಕೊಳ್ಳන්න.' ?>
                </p>
            </div>

            <!-- Content Sections -->
            <div class="space-y-10 text-ink/80 text-sm sm:text-base leading-relaxed">

                <!-- Karimen Exam Scoring -->
                <section class="space-y-4">
                    <h2 class="font-display text-xl font-bold text-primary">
                        <?= $lang === 'en' ? 'Scoring for the Karimen Car License Exam' : 'కරිමන් කාර් බලපත්‍ර විභාගයේ ලකුණු ක්‍රමය (Karimen)' ?>
                    </h2>
                    <p>
                        <?= $lang === 'en' ? 'The Karimen exam (provisional driving license) consists of 50 true/false questions. Each question is worth 2 points, with a total of 100 points. You need at least 90 points to pass.' : 'కරිමන් විභාගය (තාවකාලික රියදුරු බලපත්‍රය) සත්‍ය/අසත්‍ය ප්‍රශ්න 50 කින් සමන්විත වේ. එක් ප්‍රශ්නයක් සඳහා ලකුණු 2 බැගින් මුළු ලකුණු 100 කි. සමත්වීමට අවම වශයෙන් ලකුණු 90 ක් අවශ්‍ය වේ.' ?>
                    </p>

                    <div class="overflow-x-auto border border-black/10 rounded-2xl">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-paper border-b border-black/10 text-xs uppercase font-display text-primary">
                                    <th class="p-3">Category</th>
                                    <th class="p-3">Details</th>
                                    <th class="p-3">Score</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-black/5 text-sm">
                                <tr>
                                    <td class="p-3 font-medium"><?= $lang === 'en' ? 'Number of Questions' : 'ප්‍රශ්න සංඛ්‍යාව' ?></td>
                                    <td class="p-3"><?= $lang === 'en' ? '50 true/false questions' : 'සත්‍ය/අසත්‍ය ප්‍රශ්න 50යි' ?></td>
                                    <td class="p-3 text-ink/60">-</td>
                                </tr>
                                <tr>
                                    <td class="p-3 font-medium"><?= $lang === 'en' ? 'Points per Question' : 'ප්‍රශ්නයකට ලකුණු' ?></td>
                                    <td class="p-3"><?= $lang === 'en' ? '2 points per correct answer' : 'නිවැරදි පිළිතුරකට ලකුණු 2යි' ?></td>
                                    <td class="p-3"><?= $lang === 'en' ? 'Maximum 100 points' : 'උපරිමය ලකුණු 100යි' ?></td>
                                </tr>
                                <tr>
                                    <td class="p-3 font-medium"><?= $lang === 'en' ? 'Total Score' : 'මුළු ලකුණු' ?></td>
                                    <td class="p-3">100 points</td>
                                    <td class="p-3 text-ink/60">-</td>
                                </tr>
                                <tr class="bg-primary/5 font-semibold">
                                    <td class="p-3 text-primary"><?= $lang === 'en' ? 'Passing Score' : 'සමත් ලකුණු සීමාව' ?></td>
                                    <td class="p-3 text-primary" colspan="2"><?= $lang === 'en' ? '90 points or higher (45 correct answers)' : 'ලකුණු 90 හෝ වැඩි (නිවැරදි පිළිතුරු 45ක්)' ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <blockquote class="bg-paper p-4 rounded-xl border-l-4 border-primary text-xs sm:text-sm text-ink/70">
                        <strong><?= $lang === 'en' ? 'Example:' : 'උදාහරණය:' ?></strong>
                        <?= $lang === 'en' ? 'If you answer 46/50 questions correctly, you get 46 × 2 = 92 points — enough to pass the Karimen exam.' : 'ඔබ ප්‍රශ්න 46/50ක් නිවැරදි කළහොත්, ඔබට 46 × 2 = 92ක් ලැබේ — එය කරිමන් විභාගය සමත් වීමට საკافිය.' ?>
                    </blockquote>
                </section>

                <hr class="border-black/5">

                <!-- Honmen Exam Scoring -->
                <section class="space-y-4">
                    <h2 class="font-display text-xl font-bold text-primary">
                        <?= $lang === 'en' ? 'Scoring for the Honmen Car License Exam' : 'ਹොන්මන් (Honmen) කාර් බලපත්‍ර විභාගයේ ලකුණු ක්‍රමය' ?>
                    </h2>
                    <p>
                        <?= $lang === 'en' ? 'Below is the scoring method for the Japanese Honmen car license exam. To pass, you need at least 90 points out of a total of 100 points.' : 'පහත දැක්වෙන්නේ ජපානයේ හොන්මන් කාර් බලපත්‍ර විභාගයේ ලකුණු ක්‍රමයයි. සමත්වීමට මුළු ලකුණු 100න් අවම වශයෙන් ලකුණු 90ක් අවශ්‍ය වේ.' ?>
                    </p>

                    <div class="overflow-x-auto border border-black/10 rounded-2xl">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-paper border-b border-black/10 text-xs uppercase font-display text-primary">
                                    <th class="p-3">Category</th>
                                    <th class="p-3">Details</th>
                                    <th class="p-3">Score</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-black/5 text-sm">
                                <tr>
                                    <td class="p-3 font-medium"><?= $lang === 'en' ? 'Number of Questions' : 'ප්‍රශ්න සංඛ්‍යාව' ?></td>
                                    <td class="p-3"><?= $lang === 'en' ? '95 questions (90 true/false + 5 situational)' : 'ප්‍රශ්න 95යි (සත්‍ය/අසත්‍ය 90 + අනතුරු අපේක්ෂා 5)' ?></td>
                                    <td class="p-3 text-ink/60">-</td>
                                </tr>
                                <tr>
                                    <td class="p-3 font-medium"><?= $lang === 'en' ? 'True/False Questions' : 'සත්‍ය/අසත්‍ය ප්‍රශ්න' ?></td>
                                    <td class="p-3">90 questions</td>
                                    <td class="p-3"><?= $lang === 'en' ? '1 point per question' : 'ප්‍රශ්නයකට ලකුණු 1යි' ?></td>
                                </tr>
                                <tr>
                                    <td class="p-3 font-medium"><?= $lang === 'en' ? 'Situational Questions' : 'අනතුරු අපේක්ෂා ප්‍රශ්න' ?></td>
                                    <td class="p-3"><?= $lang === 'en' ? '5 multiple-choice questions' : 'බහු තේරීම් ප්‍රශ්න 5යි' ?></td>
                                    <td class="p-3"><?= $lang === 'en' ? '2 points per question' : 'ප්‍රශ්නයකට ලකුණු 2යි' ?></td>
                                </tr>
                                <tr class="bg-primary/5 font-semibold">
                                    <td class="p-3 text-primary"><?= $lang === 'en' ? 'Passing Score' : 'සමත් ලකුණු සීමාව' ?></td>
                                    <td class="p-3 text-primary" colspan="2"><?= $lang === 'en' ? '90 points or higher out of 100' : 'මුළු ලකුණු 100න් 90ක් හෝ වැඩි' ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <blockquote class="bg-paper p-4 rounded-xl border-l-4 border-primary text-xs sm:text-sm text-ink/70">
                        <strong><?= $lang === 'en' ? 'Example:' : 'උදාහරණය:' ?></strong>
                        <?= $lang === 'en' ? 'If you answer 85/90 true-false questions and 4/5 situational questions correctly, you get 85 + 4×2 = 93 points, enough to pass the exam.' : 'ඔබ සත්‍ය/අසත්‍ය ප්‍රශ්න 90න් 85ක් සහ අනතුරු අපේක්ෂා ප්‍රශ්න 5න් 4ක් නිවැරදි කළහොත්, 85 + 4×2 = 93ක් ලැබේ.' ?>
                    </blockquote>
                </section>

                <hr class="border-black/5">

                <!-- 50cc Motorcycle Exam Scoring -->
                <section class="space-y-4">
                    <h2 class="font-display text-xl font-bold text-primary">
                        <?= $lang === 'en' ? 'Scoring for the 50cc Motorcycle License Exam (Gentsuki)' : '50cc මෝටර් රථ / මොපෙඩ් බලපත්‍ර විභාග ලකුණු ක්‍රමය (原付)' ?>
                    </h2>
                    <p>
                        <?= $lang === 'en' ? 'The 50cc motorcycle license exam (原付免許) in Japan consists of 50 true/false questions. Each correct answer is worth 2 points, with a maximum total of 100 points. You need at least 90 points to pass.' : 'ජපානයේ 50cc මෝටර් රථ බලපත්‍ර විභාගය (原付免許) සත්‍ය/අසත්‍ය ප්‍රශ්න 50 කින් සමන්විත වේ. එක් නිවැරදි පිළිතුරකට ලකුණු 2 බැගින් උපරිම ලකුණු 100 කි.' ?>
                    </p>

                    <div class="overflow-x-auto border border-black/10 rounded-2xl">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-paper border-b border-black/10 text-xs uppercase font-display text-primary">
                                    <th class="p-3">Category</th>
                                    <th class="p-3">Details</th>
                                    <th class="p-3">Score</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-black/5 text-sm">
                                <tr>
                                    <td class="p-3 font-medium"><?= $lang === 'en' ? 'Number of Questions' : 'ප්‍රශ්න සංඛ්‍යාව' ?></td>
                                    <td class="p-3"><?= $lang === 'en' ? '50 true/false questions' : 'සත්‍ය/අසත්‍ය ප්‍රශ්න 50යි' ?></td>
                                    <td class="p-3 text-ink/60">-</td>
                                </tr>
                                <tr>
                                    <td class="p-3 font-medium"><?= $lang === 'en' ? 'Points per Question' : 'ප්‍රශ්නයකට ලකුණු' ?></td>
                                    <td class="p-3"><?= $lang === 'en' ? '2 points per correct answer' : 'නිවැරදි පිළිතුරකට ලකුණු 2යි' ?></td>
                                    <td class="p-3"><?= $lang === 'en' ? 'Maximum 100 points' : 'උපරිමය ලකුණු 100යි' ?></td>
                                </tr>
                                <tr class="bg-primary/5 font-semibold">
                                    <td class="p-3 text-primary"><?= $lang === 'en' ? 'Passing Score' : 'සමත් ලකුණු සීමාව' ?></td>
                                    <td class="p-3 text-primary" colspan="2"><?= $lang === 'en' ? '90 points or higher (46+ correct answers)' : 'ලකුණු 90 හෝ වැඩි (නිවැරදි පිළිතුරු 46ක් හෝ වැඩි)' ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <blockquote class="bg-paper p-4 rounded-xl border-l-4 border-primary text-xs sm:text-sm text-ink/70">
                        <strong><?= $lang === 'en' ? 'Example:' : 'උදාහරණය:' ?></strong>
                        <?= $lang === 'en' ? 'If you answer 46/50 questions correctly, you get 46 × 2 = 92 points — enough to pass the 50cc moped exam.' : 'ඔබ ප්‍රශ්න 46/50ක් නිවැරදි කළහොත්, ඔබට 46 × 2 = 92ක් ලැබේ — එය 50cc මොපෙඩ් විභාගය සමත් වීමට ප්‍රමාණවත් වේ.' ?>
                    </blockquote>
                </section>

            </div>

        </article>

    </main>

    <!-- Footer -->
    <footer class="bg-primary text-white py-6 text-center text-xs">
        <p>&copy; <?= date('Y') ?> Japan License Prep. All rights reserved.</p>
    </footer>

</body>
</html>