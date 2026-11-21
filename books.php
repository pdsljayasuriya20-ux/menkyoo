<?php
session_start();
require_once __DIR__ . '/visitor.php';
require_once __DIR__ . '/includes/config.php';

$sessionUser = null;
if (!empty($_SESSION['user_id'])) {
    $sessionUser = [
        'id'    => $_SESSION['user_id'],
        'name'  => $_SESSION['user_name'] ?? '',
        'email' => $_SESSION['user_email'] ?? '',
    ];
}

$books = [];
try {
    $books = $pdo->query("SELECT * FROM books WHERE is_active = 1 ORDER BY sort_order ASC, id DESC")->fetchAll();
} catch (\Throwable $e) {
    // Table might not exist yet — page still renders, just empty.
}

// Which of these (if any) has the logged-in user already purchased?
$purchasedIds = [];
if ($sessionUser && !empty($books)) {
    try {
        $ids = array_column($books, 'id');
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $pdo->prepare("SELECT book_id FROM book_purchases WHERE user_id = ? AND book_id IN ($placeholders)");
        $stmt->execute(array_merge([$sessionUser['id']], $ids));
        $purchasedIds = array_map('intval', $stmt->fetchAll(PDO::FETCH_COLUMN));
    } catch (\Throwable $e) {}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>Study Guides & PDF Books | Menkyoo.jp</title>
<meta name="description" content="Downloadable bilingual (English/Sinhala) PDF guides to help you pass Japan's driving license theory test.">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://menkyoo.jp/books.php">
<meta name="theme-color" content="#0F2F6E">
<?php include __DIR__ . '/includes/theme.php'; ?>
</head>
<body class="bg-paper text-ink font-body min-h-screen flex flex-col">
<script>window.__USER__ = <?php echo $sessionUser ? json_encode($sessionUser, JSON_UNESCAPED_UNICODE) : 'null'; ?>;</script>

<header class="sticky top-0 z-40 bg-primary text-white shadow-lg shadow-primary/10">
  <div class="max-w-5xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-3">
    <a href="index.php" class="flex items-center gap-2 shrink-0">
      <svg width="30" height="30" viewBox="0 0 48 48" fill="none" aria-hidden="true"><circle cx="24" cy="24" r="21" stroke="#F2A73B" stroke-width="3"/><circle cx="24" cy="24" r="5.5" fill="#F2A73B"/><path d="M24 3v10M24 35v10M3 24h10M35 24h10M9.5 9.5l7 7M31.5 31.5l7 7M9.5 38.5l7-7M31.5 16.5l7-7" stroke="#F2A73B" stroke-width="2.5" stroke-linecap="round"/></svg>
      <span class="font-display font-bold leading-tight text-sm sm:text-base">Menkyoo.jp</span>
    </a>
    <div class="flex items-center gap-2 sm:gap-3">
      <a href="lessons.php" class="hidden sm:inline-flex text-xs sm:text-sm font-semibold px-3 py-2 rounded-lg hover:bg-white/10 transition">Lessons</a>
      <?php if ($sessionUser): ?>
        <a href="dashboard.php" class="text-xs sm:text-sm font-semibold px-3 py-2 rounded-lg hover:bg-white/10 transition">Dashboard</a>
      <?php else: ?>
        <a href="login.php?redirect=books.php" class="text-xs sm:text-sm font-semibold bg-accent text-ink px-3 sm:px-4 py-2 rounded-lg hover:brightness-95 transition">Log in</a>
      <?php endif; ?>
    </div>
  </div>
</header>

<main class="flex-grow w-full grid-texture">
  <div class="max-w-5xl mx-auto px-4 sm:px-6 py-10 sm:py-14">

    <div class="text-center mb-10 rise-in">
      <span class="inline-block text-[11px] font-bold tracking-widest uppercase bg-accent-light text-primary px-3 py-1 rounded-full border border-accent/40 mb-3">Downloadable Guides</span>
      <h1 class="font-display font-bold text-2xl sm:text-3xl text-ink">Study Guides &amp; PDF Books</h1>
      <p class="text-sm text-ink/60 mt-2 max-w-xl mx-auto">Bilingual English/Sinhala PDF guides you can read offline, print, or keep on your phone while you study.</p>
    </div>

    <?php if (empty($books)): ?>
      <div class="bg-white rounded-2xl border border-black/5 shadow-sm p-10 text-center text-ink/40 max-w-md mx-auto">
        No books available yet — check back soon.
      </div>
    <?php else: ?>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($books as $b): $owned = in_array((int)$b['id'], $purchasedIds); ?>
        <a href="book_details.php?id=<?= (int) $b['id'] ?>" class="group bg-white rounded-2xl border border-black/5 shadow-sm hover:shadow-lg transition overflow-hidden flex flex-col rise-in">
          <div class="aspect-[3/4] bg-primary-light overflow-hidden relative">
            <?php if (!empty($b['cover_image'])): ?>
              <img src="<?= htmlspecialchars($b['cover_image'] ?? '') ?>" alt="<?= htmlspecialchars($b['title_en'] ?? '') ?> cover" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" loading="lazy">
            <?php else: ?>
              <div class="w-full h-full flex items-center justify-center text-5xl">📘</div>
            <?php endif; ?>
            <?php if ($owned): ?>
              <span class="absolute top-2 right-2 bg-go text-white text-[10px] font-bold px-2 py-1 rounded-full shadow">OWNED</span>
            <?php endif; ?>
          </div>
          <div class="p-4 flex-1 flex flex-col">
            <h2 class="font-display font-bold text-sm text-ink leading-snug"><?= htmlspecialchars($b['title_en'] ?? '') ?></h2>
            <?php if (!empty($b['title_si'])): ?>
              <p class="text-xs text-ink/50 font-si mt-1 line-clamp-2"><?= htmlspecialchars($b['title_si']) ?></p>
            <?php endif; ?>
            <?php if (!empty($b['subtitle_en'])): ?>
              <p class="text-xs text-ink/60 mt-2 leading-relaxed"><?= htmlspecialchars($b['subtitle_en']) ?></p>
            <?php endif; ?>
            <div class="mt-auto pt-4 flex items-center justify-between">
              <span class="font-mono font-bold text-primary text-lg">¥<?= number_format((int) ($b['price'] ?? 0)) ?></span>
              <span class="text-xs font-bold text-primary group-hover:underline"><?= $owned ? 'Download →' : 'View Details →' ?></span>
            </div>
          </div>
        </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  </div>
</main>

<?php include __DIR__ . '/includes/site-footer.php'; ?>
</body>
</html>
