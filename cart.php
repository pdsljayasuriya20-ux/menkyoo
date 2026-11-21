<?php
session_start();
ini_set('display_errors', 0);
error_reporting(E_ALL);

if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'ja', 'si'])) {
    $_SESSION['lang'] = $_GET['lang'];
}
$currentLang  = $_SESSION['lang'] ?? 'en';
$current_page = basename($_SERVER['PHP_SELF']);

require_once __DIR__ . '/includes/shop-data.php';
require_once __DIR__ . '/includes/cart-helpers.php';

$shopCurrency = $shopCurrency ?? 'jpy';
$st = $st ?? [
    'books_nav' => 'Books',
    'full_name' => 'Full Name',
    'phone' => 'Phone Number',
    'email' => 'Email Address',
    'address_line' => 'Address Line',
    'city' => 'City',
    'postal_code' => 'Postal Code',
    'country' => 'Country',
    'shipping_fee_label' => 'Shipping',
    'total' => 'Total',
    'continue_to_payment' => 'Continue to Payment',
    'secure_note' => 'Secure Payment via Stripe',
];

define('SHOP_BOOTSTRAP', true);
if (file_exists(__DIR__ . '/checkout/config.php')) {
    require_once __DIR__ . '/checkout/config.php';
}
if (!defined('SRI_LANKA_SHIPPING_JPY')) {
    define('SRI_LANKA_SHIPPING_JPY', 1900);
}
if (!defined('JPY_TO_LKR_RATE')) {
    define('JPY_TO_LKR_RATE', 2.10);
}

if (!function_exists('format_price')) {
    function format_price($amount, $curr) {
        if (strtolower($curr) === 'jpy') return '¥' . number_format($amount);
        $symbols = ['usd' => '$', 'lkr' => 'Rs. '];
        $symbol = $symbols[strtolower($curr)] ?? strtoupper($curr) . ' ';
        return $symbol . number_format($amount / 100, 2);
    }
}

$cartLabels = [
    'en' => [
        'title' => 'Your Cart',
        'empty' => 'Your cart is empty.',
        'browse' => 'Browse Books',
        'promo_locked'   => 'Add {n} more book(s) and get ¥500 off every book in your cart!',
        'promo_unlocked' => "You've unlocked ¥500 off every book — nice!",
        'qty' => 'Qty',
        'remove' => 'Remove',
        'subtotal' => 'Subtotal',
        'bulk_discount' => 'Bulk discount',
        'order_summary' => 'Order Summary',
        'shipping_title' => 'Shipping Details',
        'shipping_sub' => 'Please fill in your shipping details below.',
        'select_country' => 'Select shipping country',
        'cart_nav' => 'Cart',
    ],
    'ja' => [
        'title' => 'カート',
        'empty' => 'カートは空です。',
        'browse' => '本を見る',
        'promo_locked'   => 'あと{n}冊追加すると、カート内のすべての本が¥500引きになります！',
        'promo_unlocked' => 'すべての本が¥500引きになりました！',
        'qty' => '数量',
        'remove' => '削除',
        'subtotal' => '小計',
        'bulk_discount' => 'まとめ買い割引',
        'order_summary' => '注文内容',
        'shipping_title' => '配送先情報',
        'shipping_sub' => '配送先情報を入力してください。',
        'select_country' => '配送先の国を選択',
        'cart_nav' => 'カート',
    ],
    'si' => [
        'title' => 'ඔබේ කරත්තය',
        'empty' => 'ඔබේ කරත්තය හිස්ය.',
        'browse' => 'පොත් බලන්න',
        'promo_locked'   => 'තවත් පොත් {n} ක් එකතු කරන්න, කරත්තයේ සෑම පොතකටම ¥500ක් අඩුවෙන් ගන්න!',
        'promo_unlocked' => 'සුභ පැතුම්! ඔබේ කරත්තයේ සෑම පොතකටම ¥500ක වට්ටමක් දැන් ලැබී ඇත.',
        'qty' => 'ප්‍රමාණය',
        'remove' => 'ඉවත් කරන්න',
        'subtotal' => 'උප එකතුව',
        'bulk_discount' => 'තොග වට්ටම',
        'order_summary' => 'ඇණවුම් සාරාංශය',
        'shipping_title' => 'නැව්ගත කිරීමේ විස්තර',
        'shipping_sub' => 'කරුණාකර ඔබේ නැව්ගත කිරීමේ විස්තර පහත පුරවන්න.',
        'select_country' => 'නැව්ගත කිරීමේ රට තෝරන්න',
        'cart_nav' => 'කරත්තය',
    ],
][$currentLang];

$navLabels = [
    'en' => ['home' => 'Home', 'vocab' => 'Vocabulary'],
    'ja' => ['home' => 'ホーム', 'vocab' => '語彙'],
    'si' => ['home' => 'මුල් පිටුව', 'vocab' => 'වචන මාලාව'],
][$currentLang];

$navItems = [
    ['href' => 'index.php',      'key' => 'index.php',      'label' => $navLabels['home']],
    ['href' => 'n5.php',         'key' => 'n5.php',          'label' => 'N5'],
    ['href' => 'n4.php',         'key' => 'n4.php',          'label' => 'N4'],
    ['href' => 'n3.php',         'key' => 'n3.php',          'label' => 'N3'],
    ['href' => 'comingsoon.php', 'key' => 'n2.php',          'label' => 'N2'],
    ['href' => 'comingsoon.php', 'key' => 'n1.php',          'label' => 'N1'],
    ['href' => 'vocabulary.php', 'key' => 'vocabulary.php',  'label' => $navLabels['vocab']],
    ['href' => 'books.php',      'key' => 'books.php',       'label' => $st['books_nav']],
];

$languages = ['en' => 'English', 'ja' => '日本語', 'si' => 'සිංහල'];

$totals    = cart_totals($books);
$cartCount = cart_count();
$unitsUntilDiscount = cart_units_until_bulk_discount();
?>
<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($currentLang); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#4f46e5">
    <title><?php echo htmlspecialchars($cartLabels['title']); ?> | learnjapanese.jp</title>
    <link rel="icon" type="image/png" href="/assets/favicon.png"/>

    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Noto+Sans+JP:wght@400;700&family=Noto+Sans+Sinhala:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>

    <style>
        :root {
            --brand-primary: #4f46e5;
            --brand-primary-hover: #4338ca;
            --bg-surface: #f8fafc;
            --card-bg: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-soft: #e2e8f0;
            --radius-lg: 20px;
            --radius-md: 14px;
        }
        * { -webkit-tap-highlight-color: transparent; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Plus Jakarta Sans', <?php echo $currentLang === 'ja' ? "'Noto Sans JP'," : ($currentLang === 'si' ? "'Noto Sans Sinhala'," : ''); ?> sans-serif;
            background-color: var(--bg-surface);
            color: var(--text-main);
            min-height: 100vh;
        }
        .app-header { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); position: sticky; top: 0; z-index: 1000; border-bottom: 1px solid var(--border-soft); padding-top: env(safe-area-inset-top, 0); }
        .logo { font-weight: 800; font-size: 1.15rem; color: var(--text-main); text-decoration: none; white-space: nowrap; }
        .logo span { color: var(--brand-primary); }
        .nav-links { display: flex; align-items: center; gap: 4px; flex-wrap: wrap; }
        .nav-link-item { padding: 7px 14px; border-radius: 30px; font-size: 0.85rem; font-weight: 600; color: var(--text-muted); text-decoration: none; }
        .nav-link-item:hover { background: #f1f5f9; color: var(--text-main); }
        .nav-link-item.active { background: var(--brand-primary); color: #fff; }
        .lang-pill { padding: 6px 14px; border-radius: 30px; font-size: 0.85rem; font-weight: 600; color: var(--text-muted); text-decoration: none; background: #f1f5f9; }
        .lang-pill:hover { background: #e2e8f0; color: var(--text-main); }
        .lang-pill.active { background: var(--brand-primary); color: #ffffff; }
        .mobile-menu-toggle { display: none; background: #f1f5f9; border: none; border-radius: 10px; width: 38px; height: 38px; color: var(--text-main); font-size: 1.05rem; cursor: pointer; }
        .mobile-nav { display: none; border-top: 1px solid var(--border-soft); background: #ffffff; }
        .mobile-nav.show { display: block; }
        .mobile-nav .nav-link-item { display: block; width: 100%; text-align: left; padding: 12px 8px; border-radius: 10px; }
        @media (max-width: 991px) { .nav-links.desktop-only { display: none; } .mobile-menu-toggle { display: inline-flex; align-items: center; justify-content: center; } }
        @media (min-width: 992px) { .mobile-menu-toggle, .mobile-nav { display: none !important; } }

        .cart-icon-link { position: relative; width: 38px; height: 38px; border-radius: 10px; background: #f1f5f9; display: inline-flex; align-items: center; justify-content: center; color: var(--text-main); text-decoration: none; font-size: 1.05rem; }
        .cart-icon-link:hover { background: #eef2ff; color: var(--brand-primary); }
        .cart-badge { position: absolute; top: -6px; right: -6px; background: #ef4444; color: #fff; font-size: 0.68rem; font-weight: 800; min-width: 18px; height: 18px; border-radius: 999px; display: flex; align-items: center; justify-content: center; padding: 0 4px; }

        .promo-banner { border-radius: var(--radius-md); padding: 0.9rem 1.2rem; font-weight: 700; font-size: 0.92rem; display: flex; align-items: center; gap: 10px; margin-bottom: 1.5rem; }
        .promo-banner.locked { background: #eef2ff; color: var(--brand-primary); }
        .promo-banner.unlocked { background: #dcfce7; color: #16a34a; }

        .cart-layout { display: grid; grid-template-columns: 1fr 360px; gap: 2rem; align-items: start; }
        @media (max-width: 900px) { .cart-layout { grid-template-columns: 1fr; } }

        .cart-item { display: flex; gap: 1rem; background: var(--card-bg); border: 1px solid var(--border-soft); border-radius: var(--radius-md); padding: 1rem; margin-bottom: 1rem; align-items: center; }
        .cart-item img { width: 68px; height: 90px; object-fit: cover; border-radius: 8px; background: #eef2ff; flex-shrink: 0; }
        .cart-item-info { flex: 1; min-width: 0; }
        .cart-item-title { font-weight: 700; font-size: 0.95rem; margin-bottom: 2px; }
        .cart-item-level { font-size: 0.78rem; color: var(--text-muted); }
        .cart-item-price-row { display: flex; align-items: baseline; gap: 8px; margin-top: 6px; flex-wrap: wrap; }
        .cart-item-price { font-weight: 800; color: var(--brand-primary); }
        .cart-item-oldprice { font-size: 0.8rem; color: var(--text-muted); text-decoration: line-through; }
        .cart-item-discount-tag { font-size: 0.72rem; font-weight: 800; color: #16a34a; background: #dcfce7; padding: 2px 8px; border-radius: 30px; }

        .qty-control { display: inline-flex; align-items: center; border: 1px solid var(--border-soft); border-radius: 10px; overflow: hidden; }
        .qty-control button { background: #f8fafc; border: none; width: 32px; height: 32px; font-size: 1rem; font-weight: 700; color: var(--text-main); cursor: pointer; }
        .qty-control button:hover { background: #eef2ff; color: var(--brand-primary); }
        .qty-control input { width: 38px; text-align: center; border: none; border-left: 1px solid var(--border-soft); border-right: 1px solid var(--border-soft); height: 32px; font-weight: 700; }
        .qty-control input:focus { outline: none; }
        .cart-item-remove { background: none; border: none; color: #dc2626; font-size: 0.8rem; font-weight: 600; margin-top: 6px; padding: 0; }
        .cart-item-remove:hover { text-decoration: underline; }

        .summary-card { background: var(--card-bg); border: 1px solid var(--border-soft); border-radius: var(--radius-lg); padding: 1.25rem; position: sticky; top: 90px; }
        .summary-row { display: flex; justify-content: space-between; font-size: 0.9rem; margin-bottom: 0.5rem; }
        .summary-row.discount { color: #16a34a; font-weight: 700; }
        .summary-row.total { font-weight: 800; font-size: 1.05rem; border-top: 1px solid var(--border-soft); padding-top: 0.75rem; margin-top: 0.5rem; }

        .form-label { font-weight: 600; font-size: 0.85rem; }
        .form-label .req-mark { color: #dc2626; margin-left: 2px; }
        .form-control, .form-select { border-radius: 10px; border: 1px solid var(--border-soft); padding: 0.6rem 0.85rem; }
        .form-control:focus, .form-select:focus { border-color: var(--brand-primary); box-shadow: 0 0 0 3px rgba(79,70,229,0.12); }
        .btn-buy { background: var(--brand-primary); color: #fff; font-weight: 700; border-radius: var(--radius-md); padding: 13px 22px; border: none; font-size: 1rem; width: 100%; }
        .btn-buy:hover { background: var(--brand-primary-hover); color: #fff; }
        .btn-buy:disabled { opacity: 0.65; cursor: wait; }
        .secure-note { font-size: 0.78rem; color: var(--text-muted); text-align: center; margin-top: 0.75rem; }
        .form-error { color: #dc2626; font-size: 0.85rem; display: none; margin-top: 0.75rem; }

        .empty-cart { text-align: center; padding: 3rem 1rem; }
        .empty-cart i { font-size: 2.5rem; color: var(--border-soft); margin-bottom: 1rem; }

        .site-footer { margin-top: 3rem; padding-bottom: 2.5rem; }
        .footer-note { text-align: center; color: var(--text-muted); font-size: 0.85rem; }
    </style>
</head>
<body>
    <header class="app-header py-2 mb-4">
        <div class="container d-flex align-items-center justify-content-between gap-2">
            <a href="/" class="logo">Learn<span>Japanese</span></a>
            <nav class="nav-links desktop-only" aria-label="Main navigation">
                <?php foreach ($navItems as $item): ?>
                    <a href="<?php echo htmlspecialchars($item['href']); ?>" class="nav-link-item <?php echo $current_page === $item['key'] ? 'active' : ''; ?>"><?php echo htmlspecialchars($item['label']); ?></a>
                <?php endforeach; ?>
            </nav>
            <div class="d-flex align-items-center gap-2">
                <nav class="d-flex gap-1" aria-label="Language selection">
                    <?php foreach ($languages as $code => $label): ?>
                        <a href="?lang=<?php echo $code; ?>" class="lang-pill <?php echo $currentLang === $code ? 'active' : ''; ?>"><?php echo $label; ?></a>
                    <?php endforeach; ?>
                </nav>
                <a href="cart.php" class="cart-icon-link" aria-label="<?php echo htmlspecialchars($cartLabels['cart_nav']); ?>">
                    <i class="fa-solid fa-bag-shopping"></i>
                    <span class="cart-badge" id="cartBadge" style="<?php echo $cartCount > 0 ? '' : 'display:none;'; ?>"><?php echo $cartCount; ?></span>
                </a>
                <button class="mobile-menu-toggle" onclick="toggleMobileMenu()" aria-label="Toggle menu" aria-expanded="false"><i class="fas fa-bars" id="menuIcon"></i></button>
            </div>
        </div>
        <div class="mobile-nav" id="mobileNav">
            <div class="container py-2">
                <?php foreach ($navItems as $item): ?>
                    <a href="<?php echo htmlspecialchars($item['href']); ?>" class="nav-link-item <?php echo $current_page === $item['key'] ? 'active' : ''; ?>"><?php echo htmlspecialchars($item['label']); ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </header>

    <main class="container pb-5">
        <h1 class="fw-bold fs-3 mb-3"><?php echo htmlspecialchars($cartLabels['title']); ?></h1>

        <div class="promo-banner <?php echo $totals['bulkEligible'] ? 'unlocked' : 'locked'; ?>" id="promoBanner">
            <i class="fa-solid <?php echo $totals['bulkEligible'] ? 'fa-circle-check' : 'fa-gift'; ?>"></i>
            <span id="promoBannerText">
                <?php if ($totals['bulkEligible']): ?>
                    <?php echo htmlspecialchars($cartLabels['promo_unlocked']); ?>
                <?php else: ?>
                    <?php echo htmlspecialchars(str_replace('{n}', (string) $unitsUntilDiscount, $cartLabels['promo_locked'])); ?>
                <?php endif; ?>
            </span>
        </div>

        <?php if (empty($totals['items'])): ?>
            <div class="empty-cart">
                <i class="fa-solid fa-bag-shopping"></i>
                <p class="fw-semibold mb-3"><?php echo htmlspecialchars($cartLabels['empty']); ?></p>
                <a href="books.php" class="btn-buy" style="max-width:240px;display:inline-block;text-decoration:none;text-align:center;"><?php echo htmlspecialchars($cartLabels['browse']); ?></a>
            </div>
        <?php else: ?>
        <div class="cart-layout">
            <div id="cartItemsList">
                <?php foreach ($totals['items'] as $line):
                    $book = $line['book'];
                    $coverSrc = $book['cover'] ?: 'https://placehold.co/150x200/eef2ff/4f46e5?text=' . urlencode($book['level']);
                    $hasOwnDiscount = !empty($book['discount_price_cents']) && $book['discount_price_cents'] < $book['price_cents'];
                ?>
                <div class="cart-item" data-slug="<?php echo htmlspecialchars($line['slug']); ?>">
                    <img src="<?php echo htmlspecialchars($coverSrc); ?>" alt="<?php echo htmlspecialchars($book['title'][$currentLang] ?? $book['title']['en']); ?>">
                    <div class="cart-item-info">
                        <div class="cart-item-title"><?php echo htmlspecialchars($book['title'][$currentLang] ?? $book['title']['en']); ?></div>
                        <div class="cart-item-level">JLPT <?php echo htmlspecialchars($book['level']); ?></div>
                        <div class="cart-item-price-row">
                            <?php if ($line['bulkPerUnit'] > 0 || $hasOwnDiscount): ?>
                                <span class="cart-item-oldprice"><?php echo format_price($book['price_cents'], $shopCurrency); ?></span>
                            <?php endif; ?>
                            <span class="cart-item-price line-unit-price"><?php echo format_price($line['finalUnit'], $shopCurrency); ?></span>
                            <?php if ($line['bulkPerUnit'] > 0): ?>
                                <span class="cart-item-discount-tag">-¥<?php echo number_format($line['bulkPerUnit']); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="d-flex align-items-center gap-3 mt-2">
                            <div class="qty-control">
                                <button type="button" class="qty-minus" aria-label="Decrease quantity">&minus;</button>
                                <input type="text" class="qty-input" value="<?php echo (int) $line['qty']; ?>" inputmode="numeric" readonly>
                                <button type="button" class="qty-plus" aria-label="Increase quantity">&plus;</button>
                            </div>
                            <button type="button" class="cart-item-remove"><?php echo htmlspecialchars($cartLabels['remove']); ?></button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="summary-card">
                <h2 class="fw-bold fs-6 mb-3"><?php echo htmlspecialchars($cartLabels['order_summary']); ?></h2>
                <div class="summary-row">
                    <span><?php echo htmlspecialchars($cartLabels['subtotal']); ?></span>
                    <span id="sumSubtotal"><?php echo format_price($totals['subtotal'], $shopCurrency); ?></span>
                </div>
                <div class="summary-row discount" id="sumDiscountRow" style="<?php echo $totals['bulkDiscountTotal'] > 0 ? '' : 'display:none;'; ?>">
                    <span><?php echo htmlspecialchars($cartLabels['bulk_discount']); ?></span>
                    <span id="sumDiscount">&minus;<?php echo format_price($totals['bulkDiscountTotal'], $shopCurrency); ?></span>
                </div>
                <div class="summary-row" id="sumShippingRow" style="display:none;">
                    <span><?php echo htmlspecialchars($st['shipping_fee_label']); ?></span>
                    <span id="sumShipping"></span>
                </div>
                <div class="summary-row total">
                    <span><?php echo htmlspecialchars($st['total']); ?></span>
                    <span id="sumTotal"><?php echo format_price($totals['grandTotal'], $shopCurrency); ?></span>
                </div>

                <hr>

                <h3 class="fw-bold fs-6 mb-1"><?php echo htmlspecialchars($cartLabels['shipping_title']); ?></h3>
                <p class="text-muted small mb-3"><?php echo htmlspecialchars($cartLabels['shipping_sub']); ?></p>

                <form id="checkoutForm" novalidate>
                    <div class="row g-2">
                        <div class="col-12">
                            <label class="form-label" for="full_name"><?php echo htmlspecialchars($st['full_name']); ?><span class="req-mark">*</span></label>
                            <input type="text" class="form-control" id="full_name" name="full_name" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="phone"><?php echo htmlspecialchars($st['phone']); ?><span class="req-mark">*</span></label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="email"><?php echo htmlspecialchars($st['email']); ?><span class="req-mark">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="address_line"><?php echo htmlspecialchars($st['address_line']); ?><span class="req-mark">*</span></label>
                            <input type="text" class="form-control" id="address_line" name="address_line" required minlength="5">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="city"><?php echo htmlspecialchars($st['city']); ?><span class="req-mark">*</span></label>
                            <input type="text" class="form-control" id="city" name="city" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="postal_code"><?php echo htmlspecialchars($st['postal_code']); ?><span class="req-mark">*</span></label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="country"><?php echo htmlspecialchars($st['country']); ?><span class="req-mark">*</span></label>
                            <select class="form-select" id="country" name="country" required>
                                <option value="Japan">🇯🇵 Japan</option>
                                <option value="Sri Lanka">🇱🇰 Sri Lanka</option>
                            </select>
                        </div>
                    </div>

                    <p class="form-error" id="formError"></p>

                    <button type="submit" class="btn-buy mt-3" id="submitPayBtn">
                        <?php echo htmlspecialchars($st['continue_to_payment']); ?>
                    </button>
                    <p class="secure-note"><i class="fa-solid fa-lock me-1"></i><?php echo htmlspecialchars($st['secure_note']); ?></p>
                </form>
            </div>
        </div>
        <?php endif; ?>
    </main>

    <footer class="site-footer">
        <p class="footer-note">&copy; <?php echo date('Y'); ?> learnjapanese.jp</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
    <script>
        function toggleMobileMenu() {
            const nav = document.getElementById('mobileNav');
            const icon = document.getElementById('menuIcon');
            const isOpen = nav.classList.toggle('show');
            icon.classList.toggle('fa-bars', !isOpen);
            icon.classList.toggle('fa-times', isOpen);
        }

        const CURRENCY = <?php echo json_encode($shopCurrency); ?>;
        const SRI_LANKA_SHIPPING = <?php echo (int) SRI_LANKA_SHIPPING_JPY; ?>;
        const PROMO_LOCKED_TEMPLATE = <?php echo json_encode($cartLabels['promo_locked']); ?>;
        const PROMO_UNLOCKED_TEXT = <?php echo json_encode($cartLabels['promo_unlocked']); ?>;

        function formatPrice(amount) {
            if (String(CURRENCY).toLowerCase() === 'jpy') {
                return '¥' + Math.round(amount).toLocaleString();
            }
            const symbols = { usd: '$', lkr: 'Rs. ' };
            const symbol = symbols[String(CURRENCY).toLowerCase()] || (String(CURRENCY).toUpperCase() + ' ');
            return symbol + (amount / 100).toFixed(2);
        }

        const countrySelect = document.getElementById('country');
        const sumShippingRow = document.getElementById('sumShippingRow');
        const sumShipping = document.getElementById('sumShipping');
        const sumTotalEl = document.getElementById('sumTotal');
        const cartBadge = document.getElementById('cartBadge');

        // grandTotal (items only, post-discount) is re-read from the DOM
        // each time so it always matches whatever cart-update.php last sent.
        let currentGrandTotal = <?php echo (int) $totals['grandTotal']; ?>;

        function currentShipping() {
            return (countrySelect && countrySelect.value === 'Sri Lanka') ? SRI_LANKA_SHIPPING : 0;
        }

        function refreshShippingAndTotal() {
            const shipping = currentShipping();
            if (shipping > 0) {
                sumShippingRow.style.display = 'flex';
                sumShipping.textContent = formatPrice(shipping);
            } else {
                sumShippingRow.style.display = 'none';
            }
            sumTotalEl.textContent = formatPrice(currentGrandTotal + shipping);
        }
        if (countrySelect) {
            countrySelect.addEventListener('change', refreshShippingAndTotal);
            refreshShippingAndTotal();
        }

        function updatePromoBanner(bulkEligible, unitsUntil) {
            const banner = document.getElementById('promoBanner');
            const text = document.getElementById('promoBannerText');
            if (!banner) return;
            banner.classList.toggle('unlocked', bulkEligible);
            banner.classList.toggle('locked', !bulkEligible);
            banner.querySelector('i').className = 'fa-solid ' + (bulkEligible ? 'fa-circle-check' : 'fa-gift');
            text.textContent = bulkEligible ? PROMO_UNLOCKED_TEXT : PROMO_LOCKED_TEMPLATE.replace('{n}', unitsUntil);
        }

        function repaintFromTotals(totals) {
            document.getElementById('sumSubtotal').textContent = formatPrice(totals.subtotal);
            const discountRow = document.getElementById('sumDiscountRow');
            if (totals.bulkDiscountTotal > 0) {
                discountRow.style.display = 'flex';
                document.getElementById('sumDiscount').textContent = '\u2212' + formatPrice(totals.bulkDiscountTotal);
            } else {
                discountRow.style.display = 'none';
            }
            currentGrandTotal = totals.grandTotal;
            refreshShippingAndTotal();

            const unitsUntil = Math.max(0, 2 - totals.totalQty);
            updatePromoBanner(totals.bulkEligible, unitsUntil);

            // Update each line's shown unit price / discount tag from server truth
            totals.items.forEach(function (line) {
                const row = document.querySelector('.cart-item[data-slug="' + line.slug + '"]');
                if (!row) return;
                const priceEl = row.querySelector('.line-unit-price');
                if (priceEl) priceEl.textContent = formatPrice(line.finalUnit);
                const qtyInput = row.querySelector('.qty-input');
                if (qtyInput) qtyInput.value = line.qty;
            });
        }

        async function sendCartUpdate(slug, action, quantity) {
            const body = new URLSearchParams({ book_id: slug, action: action });
            if (quantity !== undefined) body.set('quantity', quantity);
            const res = await fetch('cart-update.php', { method: 'POST', body });
            const data = await res.json();
            if (!data.ok) throw new Error(data.error || 'Could not update cart.');
            if (cartBadge) {
                cartBadge.textContent = data.cart_count;
                cartBadge.style.display = data.cart_count > 0 ? 'flex' : 'none';
            }
            if (data.cart_count === 0) {
                window.location.reload(); // show the empty-cart state cleanly
                return;
            }
            repaintFromTotals(data.totals);
        }

        document.getElementById('cartItemsList')?.addEventListener('click', function (e) {
            const row = e.target.closest('.cart-item');
            if (!row) return;
            const slug = row.dataset.slug;
            const qtyInput = row.querySelector('.qty-input');

            if (e.target.classList.contains('qty-plus')) {
                const next = Math.min(20, parseInt(qtyInput.value, 10) + 1);
                sendCartUpdate(slug, 'set', next).catch(err => alert(err.message));
            } else if (e.target.classList.contains('qty-minus')) {
                const next = Math.max(1, parseInt(qtyInput.value, 10) - 1);
                sendCartUpdate(slug, 'set', next).catch(err => alert(err.message));
            } else if (e.target.classList.contains('cart-item-remove')) {
                sendCartUpdate(slug, 'remove').catch(err => alert(err.message));
            }
        });

        const form = document.getElementById('checkoutForm');
        if (form) {
            const submitBtn = document.getElementById('submitPayBtn');
            const formError = document.getElementById('formError');

            form.addEventListener('submit', async function (e) {
                e.preventDefault();
                formError.style.display = 'none';

                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                // Read the current cart straight from the DOM (slug + qty),
                // so what's charged always matches what's on screen.
                const items = Array.from(document.querySelectorAll('.cart-item')).map(row => ({
                    book_id: row.dataset.slug,
                    quantity: parseInt(row.querySelector('.qty-input').value, 10) || 1,
                }));

                const payload = {
                    items: items,
                    full_name: document.getElementById('full_name').value.trim(),
                    phone: document.getElementById('phone').value.trim(),
                    email: document.getElementById('email').value.trim(),
                    address_line: document.getElementById('address_line').value.trim(),
                    city: document.getElementById('city').value.trim(),
                    postal_code: document.getElementById('postal_code').value.trim(),
                    country: countrySelect.value,
                };

                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Processing...';

                try {
                    const res = await fetch('checkout/create-checkout-session.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(payload),
                    });
                    const data = await res.json();
                    if (!res.ok || !data.url) {
                        throw new Error(data.error || 'Something went wrong.');
                    }
                    window.location.href = data.url;
                } catch (err) {
                    formError.textContent = err.message;
                    formError.style.display = 'block';
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = <?php echo json_encode($st['continue_to_payment']); ?>;
                }
            });
        }
    </script>
</body>
</html>