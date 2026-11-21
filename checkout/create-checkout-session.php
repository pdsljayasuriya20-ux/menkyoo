<?php
/**
 * checkout/create-checkout-session.php
 *
 * Cart-based checkout. Expects a JSON body:
 * {
 *   "items": [ { "book_id": "n5-vocab", "quantity": 2 }, ... ],
 *   "full_name": "...", "phone": "...", "email": "...",
 *   "address_line": "...", "city": "...", "postal_code": "...",
 *   "country": "Japan" | "Sri Lanka"
 * }
 *
 * Pricing and the bulk discount (¥500 off per unit once total qty >= 2)
 * are computed here from cart_totals(), using ONLY the server-side
 * $books data. Nothing about price or quantity is ever trusted from the
 * request body except which book_ids/quantities the customer wants —
 * same rule as before, just extended to multiple line items.
 */
ob_start();
header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', 0);
error_reporting(E_ALL);
set_exception_handler(function ($e) {
    ob_end_clean();
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
    exit;
});

try {
    $rawInput = file_get_contents('php://input');
    $data = json_decode($rawInput, true);
    if (!$data) {
        throw new Exception('Invalid JSON request body.');
    }

    define('SHOP_BOOTSTRAP', true);
    // Root public_html folder එකේ තියෙන config.php සහ includes call කිරීම
    require_once __DIR__ . '/../config.php';
    require_once __DIR__ . '/../includes/shop-data.php';
    require_once __DIR__ . '/../includes/cart-helpers.php';

    if (!defined('STRIPE_SECRET_KEY') || empty(STRIPE_SECRET_KEY)) {
        throw new Exception('Stripe Secret Key is not configured in config.php.');
    }

    // --- Shipping config (server is the source of truth — never trust a
    // fee amount sent by the client) --------------------------------------
    // NOTE: const cannot be declared inside a try/function block in PHP —
    // must use define() here instead, or it's a fatal parse error.
    if (!defined('ALLOWED_COUNTRIES_LIST')) {
        define('ALLOWED_COUNTRIES_LIST', ['Japan', 'Sri Lanka']);
    }
    if (!defined('SRI_LANKA_SHIPPING_JPY')) {
        define('SRI_LANKA_SHIPPING_JPY', 1900);
    }

    // --- Build a temporary cart from the request items --------------------
    // We deliberately do NOT trust $_SESSION['cart'] here in case the
    // session and the page the user checked out from ever drift apart —
    // instead we take the { book_id, quantity } pairs the client sent,
    // validate them against $books, and price them with the exact same
    // cart_totals() helper that cart.php uses for display. This keeps
    // "what the user saw" and "what gets charged" mathematically identical.
    $requestedItems = $data['items'] ?? null;
    if (!is_array($requestedItems) || count($requestedItems) === 0) {
        throw new Exception('Your cart is empty.');
    }

    $tempCart = [];
    foreach ($requestedItems as $item) {
        $bookId = $item['book_id'] ?? '';
        $qty    = max(1, min(CART_MAX_QTY_PER_BOOK, (int) ($item['quantity'] ?? 1)));

        if (!isset($books[$bookId])) {
            throw new Exception('Invalid book selection.');
        }
        // If the same book_id appears twice in the request, combine it —
        // mirrors how cart_add() would have behaved.
        $tempCart[$bookId] = min(CART_MAX_QTY_PER_BOOK, ($tempCart[$bookId] ?? 0) + $qty);
    }

    // Temporarily swap $_SESSION['cart'] so we can reuse cart_totals()
    // without duplicating its pricing logic here.
    $originalSessionCart   = $_SESSION['cart'] ?? [];
    $_SESSION['cart']      = $tempCart;
    $totals                = cart_totals($books);
    $_SESSION['cart']      = $originalSessionCart; // restore — this endpoint doesn't mutate the real cart

    if (empty($totals['items'])) {
        throw new Exception('Your cart is empty.');
    }

    // --- Validate shipping details (mirrors the "required" fields on the
    // frontend form so the check can't be bypassed by calling this
    // endpoint directly) ----------------------------------------------------
    $requiredFields = ['full_name', 'phone', 'email', 'address_line', 'city', 'postal_code'];
    foreach ($requiredFields as $field) {
        if (empty(trim((string) ($data[$field] ?? '')))) {
            throw new Exception('Missing required field: ' . $field);
        }
    }
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email address.');
    }

    $country = $data['country'] ?? '';
    if (!in_array($country, ALLOWED_COUNTRIES_LIST, true)) {
        throw new Exception('Invalid shipping country.');
    }

    // Vendor Composer Autoload Path එක
    if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
        require_once __DIR__ . '/../vendor/autoload.php';
    } else {
        throw new Exception('Stripe SDK vendor directory not found.');
    }
    \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

    $currency = $shopCurrency ?? 'jpy';

    // --- Build one Stripe line item per book in the cart -------------------
    // The bulk discount is applied by charging the already-discounted
    // finalUnit price directly (Stripe Checkout line items can't carry a
    // negative amount, so there's no separate "discount" line — the per-unit
    // price itself is simply lower once the cart qualifies).
    $lineItems = [];
    $orderLinesForMetadata = [];

    foreach ($totals['items'] as $line) {
        $book = $line['book'];
        $lineItems[] = [
            'price_data' => [
                'currency' => $currency,
                'product_data' => [
                    'name' => $book['title']['en'] ?? 'Japanese Learning Book',
                ],
                'unit_amount' => (int) $line['finalUnit'],
            ],
            'quantity' => (int) $line['qty'],
        ];
        $orderLinesForMetadata[] = $line['slug'] . ':' . $line['qty'] . '@' . $line['finalUnit'];
    }

    // Server-computed shipping fee — flat per order, never read from $data.
    if ($country === 'Sri Lanka') {
        $lineItems[] = [
            'price_data' => [
                'currency' => $currency,
                'product_data' => [
                    'name' => 'Shipping to Sri Lanka',
                ],
                'unit_amount' => SRI_LANKA_SHIPPING_JPY,
            ],
            'quantity' => 1,
        ];
    }

    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => $lineItems,
        'mode' => 'payment',
        'customer_email' => $data['email'] ?? null,
        'metadata' => [
            'order_lines'          => implode(',', $orderLinesForMetadata),
            'total_qty'            => $totals['totalQty'],
            'bulk_discount_applied'=> $totals['bulkEligible'] ? 'yes' : 'no',
            'bulk_discount_total'  => $totals['bulkDiscountTotal'],
            'subtotal_before_bulk' => $totals['subtotal'],
            'full_name'   => $data['full_name'] ?? '',
            'phone'       => $data['phone'] ?? '',
            'address_line'=> $data['address_line'] ?? '',
            'city'        => $data['city'] ?? '',
            'postal_code' => $data['postal_code'] ?? '',
            'country'     => $country,
            'shipping_fee_jpy' => $country === 'Sri Lanka' ? SRI_LANKA_SHIPPING_JPY : 0,
        ],
        'success_url' => 'https://learnjapanese.jp/success.php?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url'  => 'https://learnjapanese.jp/cart.php',
    ]);

    // Order placed — now it's safe to actually clear the customer's real cart.
    cart_clear();

    ob_end_clean();
    echo json_encode(['url' => $session->url]);
    exit;
} catch (Throwable $e) {
    ob_end_clean();
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}