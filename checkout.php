<?php
session_start();
require_once __DIR__ . '/visitor.php';
require_once __DIR__ . '/includes/config.php';

// Logged in? Great, we'll link the order to the account. Not logged in? That's fine too — guest checkout.
$sessionUser = null;
if (!empty($_SESSION['user_id'])) {
    $sessionUser = [
        'id'    => $_SESSION['user_id'],
        'name'  => $_SESSION['user_name'] ?? '',
        'email' => $_SESSION['user_email'] ?? '',
    ];
}

$bookId    = isset($_GET['book_id']) ? (int) $_GET['book_id'] : (int) ($_POST['book_id'] ?? 0);
$cancelled = isset($_GET['cancelled']);
$book      = null;
$errors    = [];

if ($bookId > 0) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM books WHERE id = ? AND is_active = 1 LIMIT 1");
        $stmt->execute([$bookId]);
        $book = $stmt->fetch();
    } catch (\Throwable $e) {}
}

if (!$book) {
    header('Location: books.php');
    exit;
}

// Coming Soon books can't be purchased — bounce back to the book page.
if (!empty($book['is_coming_soon'])) {
    header('Location: book_details.php?id=' . $book['id'] . '&coming_soon=1');
    exit;
}

/* ---------------- Handle form submission ---------------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipientName = trim($_POST['recipient_name'] ?? '');
    $email         = trim($_POST['email'] ?? '');
    $phone         = trim($_POST['phone'] ?? '');
    $addressLine1  = trim($_POST['address_line1'] ?? '');
    $addressLine2  = trim($_POST['address_line2'] ?? '');
    $city          = trim($_POST['city'] ?? '');
    $prefecture    = trim($_POST['prefecture'] ?? '');
    $postalCode    = trim($_POST['postal_code'] ?? '');
    $orderNotes    = trim($_POST['order_notes'] ?? '');

    if ($recipientName === '') $errors[] = 'Recipient name is required.';
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'A valid email is required.';
    if ($phone === '')         $errors[] = 'Phone number is required.';
    if ($addressLine1 === '')  $errors[] = 'Address Line 1 is required.';
    if ($addressLine2 === '')  $errors[] = 'Address Line 2 is required.';
    if ($city === '')          $errors[] = 'City is required.';
    if ($prefecture === '')    $errors[] = 'Prefecture is required.';
    if ($postalCode === '')    $errors[] = 'Postal code is required.';

    if (empty($errors)) {
        try {
            // 1) Save the order as 'pending' first — always keep the shipping
            //    address on file even if the user abandons Stripe's page.
            //    user_id is NULL for guest orders; guest_email lets us find/contact them.
            $stmt = $pdo->prepare("INSERT INTO book_purchases
                (user_id, guest_email, book_id, recipient_name, phone, address_line1, address_line2, city, prefecture, postal_code, order_notes, amount_paid, order_status, purchased_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW())");
            $stmt->execute([
                $sessionUser['id'] ?? null,
                $sessionUser ? null : $email, // only store guest_email when there's no account
                $book['id'], $recipientName, $phone,
                $addressLine1, $addressLine2, $city, $prefecture, $postalCode,
                $orderNotes, (int) $book['price'],
            ]);
            $purchaseId = (int) $pdo->lastInsertId();

            // 2) If Stripe is live, create a Checkout Session and send the user there.
            //    If not live yet, fall back to the manual "we'll call you" flow.
            if (defined('STRIPE_LIVE_MODE') && STRIPE_LIVE_MODE) {
                require_once __DIR__ . '/vendor/autoload.php';
                \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

                try {
                    $checkoutSession = \Stripe\Checkout\Session::create([
                        'mode' => 'payment',
                        'payment_method_types' => ['card'],
                        'customer_email' => $email,
                        'line_items' => [[
                            'price_data' => [
                                'currency' => 'jpy', // zero-decimal currency — unit_amount is whole yen, no *100
                                'product_data' => [
                                    'name'        => $book['title_en'],
                                    'description' => $book['subtitle_en'] ?? 'Menkyoo.jp study guide (physical book)',
                                    'images'      => !empty($book['cover_image']) ? [$book['cover_image']] : [],
                                ],
                                'unit_amount' => (int) $book['price'],
                            ],
                            'quantity' => 1,
                        ]],
                        'shipping_address_collection' => [
                            'allowed_countries' => ['JP'],
                        ],
                        'metadata' => [
                            'purchase_id' => $purchaseId,
                            'book_id'     => $book['id'],
                            'user_id'     => $sessionUser['id'] ?? '',
                        ],
                        'success_url' => 'https://menkyoo.jp/checkout_success.php?purchase_id=' . $purchaseId . '&session_id={CHECKOUT_SESSION_ID}',
                        'cancel_url'  => 'https://menkyoo.jp/checkout.php?book_id=' . $book['id'] . '&cancelled=1',
                    ]);

                    // Save the Stripe session id against the pending order so
                    // checkout_success.php / the webhook can find it later.
                    $stmt = $pdo->prepare("UPDATE book_purchases SET stripe_session_id = ? WHERE id = ?");
                    $stmt->execute([$checkoutSession->id, $purchaseId]);

                    header('Location: ' . $checkoutSession->url);
                    exit;

                } catch (\Stripe\Exception\ApiErrorException $e) {
                    error_log('Stripe session create failed: ' . $e->getMessage());
                    $errors[] = 'Payment could not be started: ' . $e->getMessage();
                    // Order stays 'pending' in the DB — safe to retry.
                }
            } else {
                // Stripe not live yet — keep the old manual-confirmation flow.
                header('Location: checkout.php?book_id=' . $book['id'] . '&manual_ok=1');
                exit;
            }
        } catch (\Throwable $e) {
            error_log('Checkout insert failed: ' . $e->getMessage());
            $errors[] = 'Something went wrong saving your order. Please try again. [' . $e->getMessage() . ']';
        }
    }
}

$manualOk = isset($_GET['manual_ok']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>Checkout — <?= htmlspecialchars($book['title_en']) ?> | Menkyoo.jp</title>
<meta name="robots" content="noindex, nofollow">
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
      <?php if ($sessionUser): ?>
        <a href="dashboard.php" class="text-xs sm:text-sm font-semibold px-3 py-2 rounded-lg hover:bg-white/10 transition">Dashboard</a>
      <?php else: ?>
        <a href="login.php?redirect=<?= urlencode('checkout.php?book_id=' . $book['id']) ?>" class="text-xs sm:text-sm font-semibold px-3 py-2 rounded-lg hover:bg-white/10 transition">Log in</a>
      <?php endif; ?>
    </div>
  </div>
</header>

<main class="flex-grow w-full grid-texture">
  <div class="max-w-2xl mx-auto px-4 sm:px-6 py-8 sm:py-12">

    <?php if ($manualOk): ?>
      <!-- ===== Manual-confirmation order placed (Stripe not live) ===== -->
      <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 border border-black/5 text-center rise-in">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-go/10 text-go rounded-full text-2xl mb-4">✅</div>
        <h1 class="text-2xl font-bold text-ink mb-2 font-display">Order Received!</h1>
        <p class="text-sm text-ink/60 mb-6">
          Thanks — we've received your order for <strong><?= htmlspecialchars($book['title_en']) ?></strong>.
          We'll contact you by phone to confirm payment and delivery.
        </p>
        <a href="<?= $sessionUser ? 'dashboard.php' : 'books.php' ?>" class="inline-block bg-primary hover:bg-primary-dark text-white font-semibold px-5 py-2.5 rounded-xl text-sm shadow-md transition"><?= $sessionUser ? 'Go to My Dashboard' : 'Back to Books' ?></a>
      </div>

    <?php else: ?>
      <!-- ===== Checkout form ===== -->
      <div class="mb-6 rise-in">
        <a href="book_details.php?id=<?= (int) $book['id'] ?>" class="text-sm font-semibold text-primary hover:underline">← Back to book</a>
        <h1 class="font-display font-bold text-2xl text-ink mt-2">Checkout</h1>
        <p class="text-sm text-ink/60 mt-1">This is a physical book — we'll post it to the address below. Payment is handled securely by Stripe on the next step.</p>
        <?php if (!$sessionUser): ?>
          <p class="text-xs text-ink/40 mt-2">No account needed — you can check out as a guest. Already have an account? <a href="login.php?redirect=<?= urlencode('checkout.php?book_id=' . $book['id']) ?>" class="text-primary hover:underline font-semibold">Log in</a> to track this order from your dashboard.</p>
        <?php endif; ?>
      </div>

      <?php if ($cancelled): ?>
        <div class="bg-accent-light border border-accent/40 text-ink text-sm rounded-xl p-4 mb-6 rise-in">
          Payment was cancelled — your details below are saved, just submit again when you're ready.
        </div>
      <?php endif; ?>

      <!-- Order summary -->
      <div class="bg-white rounded-2xl border border-black/5 shadow-sm p-4 flex items-center gap-4 mb-6 rise-in">
        <div class="w-16 h-20 shrink-0 bg-primary-light rounded-lg overflow-hidden">
          <?php if (!empty($book['cover_image'])): ?>
            <img src="<?= htmlspecialchars($book['cover_image']) ?>" alt="" class="w-full h-full object-cover">
          <?php else: ?>
            <div class="w-full h-full flex items-center justify-center text-2xl">📘</div>
          <?php endif; ?>
        </div>
        <div class="flex-1 min-w-0">
          <p class="font-display font-bold text-sm text-ink truncate"><?= htmlspecialchars($book['title_en']) ?></p>
          <p class="text-xs text-ink/50 font-si truncate"><?= htmlspecialchars($book['title_si'] ?? '') ?></p>
        </div>
        <p class="font-mono font-bold text-primary text-lg shrink-0">¥<?= number_format($book['price']) ?></p>
      </div>

      <?php if (!empty($errors)): ?>
        <div class="bg-stop/5 border border-stop/30 text-stop text-sm rounded-xl p-4 mb-6 rise-in">
          <ul class="list-disc list-inside space-y-1">
            <?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <!-- Shipping form -->
      <form method="POST" action="checkout.php" class="bg-white rounded-2xl border border-black/5 shadow-sm p-5 sm:p-6 space-y-4 rise-in">
        <input type="hidden" name="book_id" value="<?= (int) $book['id'] ?>">

        <h2 class="text-xs font-bold text-ink/40 uppercase tracking-wide">Contact &amp; Shipping Details</h2>

        <div>
          <label class="block text-sm font-semibold text-ink/70 mb-1.5">Full Name *</label>
          <input type="text" name="recipient_name" required
                 value="<?= htmlspecialchars($_POST['recipient_name'] ?? $sessionUser['name'] ?? '') ?>"
                 class="w-full p-3 bg-paper border border-black/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary font-medium text-ink">
        </div>

        <div>
          <label class="block text-sm font-semibold text-ink/70 mb-1.5">Email *</label>
          <input type="email" name="email" required placeholder="you@example.com"
                 value="<?= htmlspecialchars($_POST['email'] ?? $sessionUser['email'] ?? '') ?>"
                 class="w-full p-3 bg-paper border border-black/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary font-medium text-ink">
          <p class="text-[11px] text-ink/40 mt-1">We'll send your order confirmation and payment receipt here.</p>
        </div>

        <div>
          <label class="block text-sm font-semibold text-ink/70 mb-1.5">Phone Number *</label>
          <input type="tel" name="phone" required placeholder="080-1234-5678"
                 value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                 class="w-full p-3 bg-paper border border-black/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary font-medium text-ink">
        </div>

        <div>
          <label class="block text-sm font-semibold text-ink/70 mb-1.5">Postal Code *</label>
          <input type="text" id="postal_code" name="postal_code" required placeholder="123-4567" inputmode="numeric" maxlength="8"
                 value="<?= htmlspecialchars($_POST['postal_code'] ?? '') ?>"
                 class="w-full sm:w-1/2 p-3 bg-paper border border-black/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary font-medium text-ink">
          <p id="postal_status" class="text-[11px] text-ink/40 mt-1">Type your 7-digit postal code — we'll fill in the prefecture &amp; city for you.</p>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-semibold text-ink/70 mb-1.5">Prefecture *</label>
            <input type="text" id="prefecture" name="prefecture" required placeholder="e.g. Osaka / 大阪府"
                   value="<?= htmlspecialchars($_POST['prefecture'] ?? '') ?>"
                   class="w-full p-3 bg-paper border border-black/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary font-medium text-ink">
          </div>
          <div>
            <label class="block text-sm font-semibold text-ink/70 mb-1.5">City / Town *</label>
            <input type="text" id="city" name="city" required
                   value="<?= htmlspecialchars($_POST['city'] ?? '') ?>"
                   class="w-full p-3 bg-paper border border-black/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary font-medium text-ink">
          </div>
        </div>

        <div>
          <label class="block text-sm font-semibold text-ink/70 mb-1.5">Address Line 1 *</label>
          <input type="text" id="address_line1" name="address_line1" required placeholder="Town area, chome, banchi, building"
                 value="<?= htmlspecialchars($_POST['address_line1'] ?? '') ?>"
                 class="w-full p-3 bg-paper border border-black/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary font-medium text-ink">
        </div>

        <div>
          <label class="block text-sm font-semibold text-ink/70 mb-1.5">Address Line 2 *</label>
          <input type="text" name="address_line2" required placeholder="Apartment, room no., unit"
                 value="<?= htmlspecialchars($_POST['address_line2'] ?? '') ?>"
                 class="w-full p-3 bg-paper border border-black/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary font-medium text-ink">
        </div>

        <div>
          <label class="block text-sm font-semibold text-ink/70 mb-1.5">Delivery Notes</label>
          <textarea name="order_notes" rows="2" placeholder="Any delivery instructions (optional)"
                    class="w-full p-3 bg-paper border border-black/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary font-medium text-ink"><?= htmlspecialchars($_POST['order_notes'] ?? '') ?></textarea>
        </div>

        <button type="submit" class="w-full bg-accent hover:brightness-95 text-ink font-bold py-3.5 rounded-xl transition shadow-md text-sm">
          Continue to Payment — ¥<?= number_format($book['price']) ?>
        </button>
        <p class="text-[11px] text-ink/40 text-center">You'll be taken to Stripe's secure payment page next.</p>
      </form>

      <script>
      (function () {
        const postalInput    = document.getElementById('postal_code');
        const prefectureEl   = document.getElementById('prefecture');
        const cityEl         = document.getElementById('city');
        const addressLine1El = document.getElementById('address_line1');
        const statusEl       = document.getElementById('postal_status');
        let lookupTimer = null;

        async function lookupPostalCode() {
          const digits = postalInput.value.replace(/[^0-9]/g, '');
          if (digits.length !== 7) return;

          statusEl.textContent = 'Looking up address…';
          statusEl.className = 'text-[11px] text-ink/40 mt-1';

          try {
            const res = await fetch('api/postal-lookup.php?zipcode=' + digits);
            const data = await res.json();

            if (data.status === 'ok') {
              prefectureEl.value = data.prefecture;
              cityEl.value = data.city;
              // Only prefill address line 1 if the user hasn't typed anything yet,
              // so we never overwrite what they've already entered.
              if (!addressLine1El.value.trim()) {
                addressLine1El.value = data.town || '';
              }
              statusEl.textContent = 'Address filled in — please add building/room details below.';
              statusEl.className = 'text-[11px] text-go mt-1';
            } else if (data.status === 'not_found') {
              statusEl.textContent = 'No address found for that postal code — please enter manually.';
              statusEl.className = 'text-[11px] text-stop mt-1';
            } else {
              statusEl.textContent = 'Could not look up address — please enter manually.';
              statusEl.className = 'text-[11px] text-stop mt-1';
            }
          } catch (e) {
            statusEl.textContent = 'Could not look up address — please enter manually.';
            statusEl.className = 'text-[11px] text-stop mt-1';
          }
        }

        postalInput.addEventListener('input', function () {
          clearTimeout(lookupTimer);
          lookupTimer = setTimeout(lookupPostalCode, 500);
        });
        postalInput.addEventListener('blur', lookupPostalCode);
      })();
      </script>
    <?php endif; ?>

  </div>
</main>

<?php include __DIR__ . '/includes/site-footer.php'; ?>
</body>
</html>