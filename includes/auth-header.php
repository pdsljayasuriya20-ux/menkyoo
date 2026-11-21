<?php
// Set these two variables before including this file to customize the
// top-right link. Falls back to a plain Home link if not set.
$headerLinkHref = $headerLinkHref ?? 'index.php';
$headerLinkText = $headerLinkText ?? '← Home';
?>
<header class="bg-primary text-white shadow-lg">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
    <a href="index.php" class="flex items-center gap-2">
      <svg width="28" height="28" viewBox="0 0 48 48" fill="none" aria-hidden="true"><circle cx="24" cy="24" r="21" stroke="#F2A73B" stroke-width="3"/><circle cx="24" cy="24" r="5.5" fill="#F2A73B"/><path d="M24 3v10M24 35v10M3 24h10M35 24h10M9.5 9.5l7 7M31.5 31.5l7 7M9.5 38.5l7-7M31.5 16.5l7-7" stroke="#F2A73B" stroke-width="2.5" stroke-linecap="round"/></svg>
      <span class="font-display font-bold text-sm sm:text-base">MENKYOO.JP</span>
    </a>
    <?php if ($headerLinkHref): ?>
      <a href="<?= htmlspecialchars($headerLinkHref) ?>" class="text-xs sm:text-sm font-semibold bg-white/10 hover:bg-white/20 text-white px-3 sm:px-4 py-2 rounded-lg transition"><?= htmlspecialchars($headerLinkText) ?></a>
    <?php endif; ?>
  </div>
</header>