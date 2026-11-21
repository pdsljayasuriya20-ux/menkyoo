<?php
session_start();
require_once __DIR__ . '/visitor.php';
require_once __DIR__ . '/includes/config.php';

if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId     = $_SESSION['user_id'];
$purchaseId = (int) ($_GET['purchase_id'] ?? 0);
$sessionId  = $_GET['session_id'] ?? '';

$order = null;
$errorMsg = null;

if ($purchaseId > 0 && $sessionId !== '' && defined('STRIPE_LIVE_MODE') && STRIPE_LIVE_MODE) {
    try {
        // Only ever act on an order that belongs to the logged-in user.
        $stmt = $pdo->prepare("SELECT bp.*, b.title_en, b.title_si, b.cover_image
                                FROM book_purchases bp
                                JOIN books b ON b.id = bp.book_id
                                WHERE bp.id = ? AND bp.user_id = ? AND bp.stripe_session_id = ?
                                LIMIT 1");
        $stmt->execute([$purchaseId, $userId, $sessionId]);
        $order = $stmt->fetch();

        if ($order) {
            require_once __DIR__ . '/vendor/autoload.php';
            \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

            $checkoutSession = \Stripe\Checkout\Session::retrieve($sessionId);

            // Confirm Stripe actually says this was paid before trusting the redirect.
            if ($checkoutSession->payment_status === 'paid' && $order['order_status'] === 'pending') {
                $amountPaid = (int) ($checkoutSession->amount_total ?? $order['amount_paid']);
                $stmt = $pdo->prepare("UPDATE book_purchases SET order_status = 'paid', amount_paid = ? WHERE id = ?");
                $stmt->execute([$amountPaid, $purchaseId]);
                $order['order_status'] = 'paid';
                $order['amount_paid']  = $amountPaid;
            }
        }
    } catch (\Throwable $e) {
        $errorMsg = 'We could not confirm your payment automatically. Don\'t worry — if you were charged, we\'ll verify it manually and reach out.';
    }
} else {
    $errorMsg = 'Missing or invalid checkout session.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>Order Confirmed | Menkyoo.jp</title>
<meta name="robots" content="noindex, nofollow">
<meta name="theme-color" content="#0F2F6E">
<?php include __DIR__ . '/includes/theme.php'; ?>
</head>
<body class="bg-paper text-ink font-body min-h-screen flex flex-col">

<header class="sticky top-0 z-40 bg-primary text-white shadow-lg shadow-primary/10">
  <div class="max-w-5xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-3">
    <a href="index.php" class="flex items-center gap-2 shrink-0">
      <svg width="30" height="30" viewBox="0 0 48 48" fill="none" aria-hidden="true"><circle cx="24" cy="24" r="21" stroke="#F2A73B" stroke-width="3"/><circle cx="24" cy="24" r="5.5" fill="#F2A73B"/><path d="M24 3v10M24 35v10M3 24h10M35 24h10M9.5 9.5l7 7M31.5 31.5l7 7M9.5 38.5l7-7M31.5 16.5l7-7" stroke="#F2A73B" stroke-width="2.5" stroke-linecap="round"/></svg>
      <span class="font-display font-bold leading-tight text-sm sm:text-base">Menkyoo.jp</span>
    </a>
    <div class="flex items-center gap-2 sm:gap-3">
      <a href="dashboard.php" class="text-xs sm:text-sm font-semibold px-3 py-2 rounded-lg hover:bg-white/10 transition">Dashboard</a>
    </div>
  </div>
</header>

<main class="flex-grow w-full grid-texture">
  <div class="max-w-2xl mx-auto px-4 sm:px-6 py-10 sm:py-14">

    <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 border border-black/5 text-center rise-in">
      <?php if ($order && $order['order_status'] === 'paid'): ?>
        <div class="inline-flex items-center justify-center w-16 h-16 bg-go/10 text-go rounded-full text-2xl mb-4">✅</div>
        <h1 class="text-2xl font-bold text-ink mb-2 font-display">Payment Successful!</h1>
        <p class="text-sm text-ink/60 mb-6">
          Thanks — your payment for <strong><?= htmlspecialchars($order['title_en']) ?></strong> went through.
          We'll pack and post your book to the address you gave us.
        </p>

        <div class="bg-paper rounded-xl border border-black/5 p-4 text-left text-sm text-ink/70 mb-6 space-y-1">
          <p><strong>Book:</strong> <?= htmlspecialchars($order['title_en']) ?></p>
          <p><strong>Amount paid:</strong> ¥<?= number_format($order['amount_paid']) ?></p>
          <p><strong>Ship to:</strong> <?= htmlspecialchars($order['recipient_name']) ?>, <?= htmlspecialchars($order['address_line1']) ?><?= $order['address_line2'] ? ', ' . htmlspecialchars($order['address_line2']) : '' ?>, <?= htmlspecialchars($order['city']) ?><?= $order['prefecture'] ? ', ' . htmlspecialchars($order['prefecture']) : '' ?> <?= htmlspecialchars($order['postal_code']) ?></p>
          <p><strong>Status:</strong> <span class="text-go font-semibold">Paid — preparing to ship</span></p>
        </div>

      <?php elseif ($order): ?>
        <div class="inline-flex items-center justify-center w-16 h-16 bg-accent-light text-accent-dark rounded-full text-2xl mb-4">⏳</div>
        <h1 class="text-2xl font-bold text-ink mb-2 font-display">Payment Processing</h1>
        <p class="text-sm text-ink/60 mb-6">
          We've got your order for <strong><?= htmlspecialchars($order['title_en']) ?></strong>, but Stripe hasn't confirmed payment yet.
          This page will usually update within a minute — refresh, or check your dashboard shortly.
        </p>

      <?php else: ?>
        <div class="inline-flex items-center justify-center w-16 h-16 bg-stop/10 text-stop rounded-full text-2xl mb-4">⚠️</div>
        <h1 class="text-2xl font-bold text-ink mb-2 font-display">Couldn't Confirm Order</h1>
        <p class="text-sm text-ink/60 mb-6"><?= htmlspecialchars($errorMsg ?? 'Something went wrong loading this order.') ?></p>
      <?php endif; ?>

      <a href="dashboard.php" class="inline-block bg-primary hover:bg-primary-dark text-white font-semibold px-5 py-2.5 rounded-xl text-sm shadow-md transition">Go to My Dashboard</a>
    </div>

  </div>
</main>

<?php include __DIR__ . '/includes/site-footer.php'; ?>
</body>
</html>