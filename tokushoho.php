<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>特定商取引法に基づく表記 - Japan License Prep</title>
<meta name="robots" content="noindex, follow">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@600;700&family=Inter:wght@400;500;600;700&family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          ink: '#101A30',
          paper: '#F6F5F1',
          primary: { DEFAULT: '#0F2F6E', light: '#E7ECFA', dark: '#0A2050' },
          accent: { DEFAULT: '#F2A73B', light: '#FDF1DD' },
        },
        fontFamily: {
          display: ['"Space Grotesk"', 'sans-serif'],
          body: ['"Inter"', '"Noto Sans JP"', 'sans-serif'],
        },
      }
    }
  }
</script>
<style>
  body { font-family: 'Inter', 'Noto Sans JP', sans-serif; }
</style>
</head>
<body class="bg-paper text-ink font-body min-h-screen flex flex-col">

<header class="bg-primary text-white shadow-lg">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
    <a href="index.php" class="flex items-center gap-2">
      <span class="font-display font-bold text-sm sm:text-base">Japan License Prep</span>
    </a>
    <a href="index.php" class="text-xs text-white/80 hover:text-white">&larr; トップページに戻る</a>
  </div>
</header>

<main class="flex-grow max-w-4xl w-full mx-auto px-4 sm:px-6 py-10">
  <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-10 border border-black/5">
    <h1 class="font-display text-3xl font-bold text-ink mb-2">特定商取引法に基づく表記</h1>
    <p class="text-ink/60 text-sm mb-8">サービス提供に関する法 2 条に基づく表示</p>

    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse text-sm sm:text-base">
        <tbody class="divide-y divide-black/10">
          <tr>
            <th class="py-4 pr-4 font-semibold text-ink/80 w-1/3 align-top">販売業者 / 事業者名</th>
            <td class="py-4 pl-4 text-ink/90">Menkyoo.jp </td>
          </tr>
          <tr>
            <th class="py-4 pr-4 font-semibold text-ink/80 align-top">運営責任者</th>
            <td class="py-4 pl-4 text-ink/90"> Pembara Durage Sampath Lahiru Jayasuriya</td>
          </tr>
          <tr>
            <th class="py-4 pr-4 font-semibold text-ink/80 align-top">所在地</th>
            <td class="py-4 pl-4 text-ink/90"> 〒5550-0021
大阪府大阪市西区川口3丁目1番24-7A </td>
          </tr>
          <tr>
            <th class="py-4 pr-4 font-semibold text-ink/80 align-top">連絡先 / 電話番号</th>
            <td class="py-4 pl-4 text-ink/90">
              メールアドレス: mantech121@gmail.com<br>
              電話番号: 090-5029-5822]
            </td>
          </tr>
          <tr>
            <th class="py-4 pr-4 font-semibold text-ink/80 align-top">販売価格</th>
            <td class="py-4 pl-4 text-ink/90">各プラン購入ページに表示される価格（税込）に準じます。</td>
          </tr>
          <tr>
            <th class="py-4 pr-4 font-semibold text-ink/80 align-top">代金の支払方法</th>
            <td class="py-4 pl-4 text-ink/90">クレジットカード決済（PAYPAY）</td>
          </tr>
          <tr>
            <th class="py-4 pr-4 font-semibold text-ink/80 align-top">代金の支払時期</th>
            <td class="py-4 pl-4 text-ink/90">購入手続き完了時に即時決済されます。</td>
          </tr>
          <tr>
            <th class="py-4 pr-4 font-semibold text-ink/80 align-top">サービスの提供時期</th>
            <td class="py-4 pl-4 text-ink/90">決済完了後、直ちにご利用いただけます。</td>
          </tr>
          <tr>
            <th class="py-4 pr-4 font-semibold text-ink/80 align-top">返品・キャンセルについて</th>
            <td class="py-4 pl-4 text-ink/90">
              サービスの性質上、購入後の返品・返金はお受けしておりません。<br>
              サブスクリプションの解約はマイページよりいつでも行えます（次回更新日以降の請求が停止されます）。
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</main>

<footer class="text-center py-6 text-xs text-ink/40 border-t border-black/5 bg-white">
  Japan Driving License Practice System &copy; 2026
</footer>

</body>
</html>