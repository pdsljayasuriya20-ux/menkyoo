<?php
/**
 * cart-add.php
 *
 * POST endpoint: adds a book to the session cart.
 * Expects POST: book_id (slug), quantity (optional, default 1).
 * Returns JSON: { ok, cart_count, message } on success, or { ok:false, error } on failure.
 */
session_start();
header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once __DIR__ . '/includes/shop-data.php';
require_once __DIR__ . '/includes/cart-helpers.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method.');
    }

    $bookId = $_POST['book_id'] ?? '';
    $qty    = max(1, min(CART_MAX_QTY_PER_BOOK, (int) ($_POST['quantity'] ?? 1)));

    if (!isset($books[$bookId])) {
        throw new Exception('Invalid book selection.');
    }

    cart_add($bookId, $qty);

    echo json_encode([
        'ok'         => true,
        'cart_count' => cart_count(),
        'message'    => 'Added to cart.',
    ]);
} catch (Throwable $e) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}