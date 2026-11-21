<?php
/**
 * cart-update.php
 *
 * POST endpoint used from cart.php to change a line's quantity or remove it.
 * Expects POST: book_id (slug), action ('set' | 'remove'), quantity (for 'set').
 * Returns JSON with the freshly recomputed cart totals so the page can
 * repaint without a full reload.
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
    $action = $_POST['action'] ?? 'set';

    if ($action === 'remove') {
        cart_remove($bookId);
    } elseif ($action === 'set') {
        $qty = (int) ($_POST['quantity'] ?? 1);
        cart_set_qty($bookId, $qty);
    } else {
        throw new Exception('Unknown action.');
    }

    $totals = cart_totals($books);

    echo json_encode([
        'ok'         => true,
        'cart_count' => cart_count(),
        'totals'     => $totals,
        'currency'   => $shopCurrency,
    ]);
} catch (Throwable $e) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}