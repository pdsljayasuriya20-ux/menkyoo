<?php
/**
 * includes/cart-helpers.php
 *
 * Session-based shopping cart + bulk discount rule:
 *   Buy 2 or more books in one order → every unit gets an extra ¥500 off.
 *
 * $_SESSION['cart'] = [ 'slug' => quantity, 'slug2' => quantity, ... ]
 *
 * IMPORTANT: cart_totals() is the ONLY place that computes prices/discounts.
 * Both cart.php (what the user sees) and checkout/create-checkout-session.php
 * (what actually gets charged) call this same function, so display and
 * charge can never drift apart. Never duplicate this math elsewhere.
 *
 * NOTE: this file may be require_once'd from inside a try{} block (the
 * checkout script does that), so — same lesson as before — everything here
 * uses define(), never top-level `const`, and no code that would be illegal
 * inside a function/try scope.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!defined('BULK_DISCOUNT_THRESHOLD_QTY')) {
    // total quantity across the whole cart needed to unlock the discount
    define('BULK_DISCOUNT_THRESHOLD_QTY', 2);
}
if (!defined('BULK_DISCOUNT_PER_UNIT_JPY')) {
    // amount knocked off EACH unit once the threshold is met
    define('BULK_DISCOUNT_PER_UNIT_JPY', 500);
}
if (!defined('CART_MAX_QTY_PER_BOOK')) {
    define('CART_MAX_QTY_PER_BOOK', 20);
}

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/** Return the raw cart array: ['slug' => qty, ...] */
function cart_get(): array
{
    return $_SESSION['cart'] ?? [];
}

/** Add $qty of $slug to the cart (creates the line if it doesn't exist yet). */
function cart_add(string $slug, int $qty = 1): void
{
    $qty = max(1, min(CART_MAX_QTY_PER_BOOK, $qty));
    $current = $_SESSION['cart'][$slug] ?? 0;
    $_SESSION['cart'][$slug] = max(1, min(CART_MAX_QTY_PER_BOOK, $current + $qty));
}

/** Set the exact quantity for $slug. A quantity of 0 or less removes it. */
function cart_set_qty(string $slug, int $qty): void
{
    if ($qty <= 0) {
        cart_remove($slug);
        return;
    }
    $_SESSION['cart'][$slug] = min(CART_MAX_QTY_PER_BOOK, $qty);
}

function cart_remove(string $slug): void
{
    unset($_SESSION['cart'][$slug]);
}

function cart_clear(): void
{
    $_SESSION['cart'] = [];
}

/** Total number of books (sum of quantities) currently in the cart. */
function cart_count(): int
{
    return array_sum(cart_get());
}

/**
 * Compute full cart pricing, applying the bulk discount.
 *
 * $books must be the associative array from includes/shop-data.php
 * (slug => book data), so this function can look up each line's real,
 * server-side price — the cart array itself only ever stores slug => qty.
 *
 * Returns:
 * [
 *   'items' => [
 *       [
 *         'slug', 'book', 'qty',
 *         'baseUnit'        => per-unit price BEFORE bulk discount (already
 *                              includes the book's own discount_price_cents
 *                              if it has one),
 *         'bulkPerUnit'     => ¥ knocked off per unit by the bulk rule,
 *         'finalUnit'       => actual per-unit charge price,
 *         'lineSubtotal'    => baseUnit * qty,
 *         'lineBulkDiscount'=> bulkPerUnit * qty,
 *         'lineTotal'       => finalUnit * qty,
 *       ], ...
 *   ],
 *   'totalQty'          => int,
 *   'bulkEligible'      => bool,
 *   'subtotal'          => int (sum of lineSubtotal, before bulk discount),
 *   'bulkDiscountTotal' => int,
 *   'grandTotal'        => int (subtotal - bulkDiscountTotal; excludes shipping),
 * ]
 */
function cart_totals(array $books): array
{
    $cart      = cart_get();
    $totalQty  = array_sum($cart);
    $bulkEligible = $totalQty >= BULK_DISCOUNT_THRESHOLD_QTY;

    $items = [];
    $subtotal = 0;
    $bulkDiscountTotal = 0;

    foreach ($cart as $slug => $qty) {
        if (!isset($books[$slug])) {
            // Book was removed/deactivated since it was added to the cart —
            // drop it silently rather than charging for something invalid.
            continue;
        }
        $book = $books[$slug];
        $qty  = max(1, min(CART_MAX_QTY_PER_BOOK, (int) $qty));

        $hasOwnDiscount = !empty($book['discount_price_cents'])
            && (int) $book['discount_price_cents'] < (int) $book['price_cents'];
        $baseUnit = $hasOwnDiscount
            ? (int) $book['discount_price_cents']
            : (int) $book['price_cents'];

        $bulkPerUnit = $bulkEligible ? min(BULK_DISCOUNT_PER_UNIT_JPY, $baseUnit) : 0;
        $finalUnit   = $baseUnit - $bulkPerUnit;

        $lineSubtotal     = $baseUnit * $qty;
        $lineBulkDiscount = $bulkPerUnit * $qty;
        $lineTotal        = $finalUnit * $qty;

        $subtotal          += $lineSubtotal;
        $bulkDiscountTotal += $lineBulkDiscount;

        $items[] = [
            'slug'             => $slug,
            'book'             => $book,
            'qty'              => $qty,
            'baseUnit'         => $baseUnit,
            'bulkPerUnit'      => $bulkPerUnit,
            'finalUnit'        => $finalUnit,
            'lineSubtotal'     => $lineSubtotal,
            'lineBulkDiscount' => $lineBulkDiscount,
            'lineTotal'        => $lineTotal,
        ];
    }

    return [
        'items'             => $items,
        'totalQty'          => $totalQty,
        'bulkEligible'      => $bulkEligible,
        'subtotal'          => $subtotal,
        'bulkDiscountTotal' => $bulkDiscountTotal,
        'grandTotal'        => $subtotal - $bulkDiscountTotal,
    ];
}

/**
 * How many more books need to be added before the bulk discount kicks in.
 * Returns 0 if already eligible.
 */
function cart_units_until_bulk_discount(): int
{
    $remaining = BULK_DISCOUNT_THRESHOLD_QTY - cart_count();
    return max(0, $remaining);
}