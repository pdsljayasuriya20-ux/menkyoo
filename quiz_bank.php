<?php
// 1. Error reporting
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

// 2. Database Connection
require_once __DIR__ . '/includes/config.php';

// 3. Image Folder Path
$image_folder_path = 'uploads/';

// 4. Image Filter Condition
$allowed_filters = ['all', 'with_img', 'no_img'];

$img_filter = isset($_GET['img_filter'])
    && in_array($_GET['img_filter'], $allowed_filters, true)
        ? $_GET['img_filter']
        : 'all';

$where_clause = '';

if ($img_filter === 'with_img') {
    $where_clause = "WHERE `img` IS NOT NULL AND `img` != ''";
} elseif ($img_filter === 'no_img') {
    $where_clause = "WHERE `img` IS NULL OR `img` = ''";
}

// 5. Pagination Logic
$limit = 100;

$page = isset($_GET['page']) && is_numeric($_GET['page'])
    ? max(1, (int) $_GET['page'])
    : 1;

$offset = ($page - 1) * $limit;

$total_rows = 0;
$total_pages = 0;
$questions = [];

try {
    // Get Total Rows
    $total_stmt = $pdo->query(
        "SELECT COUNT(*) FROM `questions` $where_clause"
    );

    $total_rows = (int) $total_stmt->fetchColumn();

    $total_pages = (int) ceil($total_rows / $limit);

    // Prevent invalid page numbers
    if ($total_pages > 0 && $page > $total_pages) {
        $page = $total_pages;
        $offset = ($page - 1) * $limit;
    }

    // Fetch Questions
    $stmt = $pdo->prepare(
        "SELECT * FROM `questions`
         $where_clause
         ORDER BY id ASC
         LIMIT :limit OFFSET :offset"
    );

    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

    $stmt->execute();

    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log('Quiz Bank Database Error: ' . $e->getMessage());

    http_response_code(500);
    exit('Unable to load quiz bank data. Please try again later.');
}
?>

<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Menkyoo Quiz Bank - Multi-Language</title>

    <style>
        * { box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 1450px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            color: #1a252f;
            margin-bottom: 5px;
        }

        .filter-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            flex-wrap: wrap;
            gap: 10px;
        }

        .meta-info {
            font-size: 14px;
            color: #555;
        }

        .filter-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 8px 16px;
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            color: #334155;
            text-decoration: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .filter-btn:hover {
            background-color: #e2e8f0;
        }

        .filter-btn.active {
            background-color: #2c3e50;
            color: white;
            border-color: #2c3e50;
        }

        .table-wrapper {
            overflow-x: auto;
            border-radius: 8px;
        }

        table {
            width: 100%;
            min-width: 900px;
            border-collapse: collapse;
            background: #ffffff;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #eef2f5;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #2c3e50;
            color: #ffffff;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tr:nth-child(even) {
            background-color: #f9fbfd;
        }

        tr:hover {
            background-color: #f1f5f9;
        }

        .img-cell {
            text-align: center;
            width: 160px;
            background-color: #fafafa;
        }

        .img-cell img {
            max-width: 130px;
            max-height: 120px;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            object-fit: contain;
            background: #fff;
            padding: 4px;
        }

        .img-name {
            font-size: 11px;
            color: #d97706;
            margin-top: 6px;
            display: block;
            word-break: break-all;
            font-family: monospace;
            font-weight: bold;
        }

        .lang-block {
            margin-bottom: 6px;
        }

        .lang-block:last-child {
            margin-bottom: 0;
        }

        .lang-tag {
            display: inline-block;
            font-size: 10px;
            font-weight: bold;
            padding: 2px 5px;
            border-radius: 3px;
            margin-right: 4px;
            text-transform: uppercase;
        }

        .tag-si {
            background-color: #e0f2fe;
            color: #0369a1;
        }

        .tag-ja {
            background-color: #fef3c7;
            color: #92400e;
        }

        .tag-ro {
            background-color: #f3e8ff;
            color: #6b21a8;
        }

        .ans-badge {
            display: inline-block;
            font-size: 13px;
            font-weight: bold;
            padding: 8px 12px;
            border-radius: 6px;
            text-align: center;
            line-height: 1.4;
            min-width: 110px;
        }

        .correct {
            background-color: #10b981;
            color: white;
        }

        .wrong {
            background-color: #ef4444;
            color: white;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 25px;
            gap: 6px;
            flex-wrap: wrap;
        }

        .pagination a {
            padding: 8px 14px;
            border: 1px solid #cbd5e1;
            background: #fff;
            text-decoration: none;
            color: #334155;
            border-radius: 4px;
            font-size: 14px;
        }

        .pagination a:hover {
            background-color: #2c3e50;
            color: white;
            border-color: #2c3e50;
        }

        .pagination a.active {
            background-color: #2c3e50;
            color: white;
            border-color: #2c3e50;
            font-weight: bold;
        }

        .sin-text {
            font-family: 'Abhaya Libre', 'Sinhala', sans-serif;
            line-height: 1.5;
            font-size: 14px;
        }

        @media (max-width: 600px) {
            body {
                padding: 10px;
            }

            .filter-container {
                padding: 12px;
            }

            .filter-buttons {
                width: 100%;
            }

            .filter-btn {
                flex: 1;
                text-align: center;
                padding: 8px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Menkyoo Quiz Bank</h1>

    <!-- Filter Controls -->
    <div class="filter-container">

        <div class="meta-info">
            මුළු ප්‍රශ්න ගණන:
            <strong><?= number_format($total_rows) ?></strong>
            |
            පිටුව:
            <strong><?= $page ?></strong>
            /
            <strong><?= $total_pages ?></strong>
        </div>

        <div class="filter-buttons">

            <a href="?img_filter=all"
               class="filter-btn <?= $img_filter === 'all' ? 'active' : '' ?>">
                සියල්ල (All)
            </a>

            <a href="?img_filter=with_img"
               class="filter-btn <?= $img_filter === 'with_img' ? 'active' : '' ?>">
                පින්තූර ඇති (With Image)
            </a>

            <a href="?img_filter=no_img"
               class="filter-btn <?= $img_filter === 'no_img' ? 'active' : '' ?>">
                පින්තූර නැති (No Image)
            </a>

        </div>
    </div>

    <div class="table-wrapper">

        <table>

            <thead>
                <tr>
                    <th style="width: 50px;">ID</th>

                    <?php if ($img_filter !== 'no_img'): ?>
                        <th style="width: 170px; text-align: center;">
                            පින්තූරය (Image)
                        </th>
                    <?php endif; ?>

                    <th>ප්‍රශ්නය (Question)</th>

                    <th style="width: 140px; text-align: center;">
                        නිවැරදි පිළිතුර
                    </th>

                    <th style="width: 35%;">
                        පැහැදිලි කිරීම (Explanation)
                    </th>
                </tr>
            </thead>

            <tbody>

                <?php if (empty($questions)): ?>

                    <tr>
                        <td colspan="<?= $img_filter === 'no_img' ? '4' : '5' ?>"
                            style="text-align:center; padding: 30px; color: #888;">
                            ප්‍රශ්න හමු වූයේ නැත.
                        </td>
                    </tr>

                <?php else: ?>

                    <?php foreach ($questions as $q): ?>

                        <tr>

                            <td>
                                <strong>#<?= htmlspecialchars((string)$q['id'], ENT_QUOTES, 'UTF-8') ?></strong>
                            </td>

                            <?php if ($img_filter !== 'no_img'): ?>

                                <td class="img-cell">

                                    <?php if (!empty($q['img'])): ?>

                                        <img
                                            src="<?= htmlspecialchars($image_folder_path . $q['img'], ENT_QUOTES, 'UTF-8') ?>"
                                            alt="Quiz Image"
                                            onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.innerHTML += ' (File missing)';"
                                        >

                                        <span class="img-name">
                                            <?= htmlspecialchars((string)$q['img'], ENT_QUOTES, 'UTF-8') ?>
                                        </span>

                                    <?php else: ?>

                                        <span style="color:#94a3b8; font-size: 12px; font-style: italic;">
                                            පින්තූරයක් නොමැත
                                        </span>

                                    <?php endif; ?>

                                </td>

                            <?php endif; ?>

                            <!-- Question -->
                            <td>

                                <?php if (!empty($q['question_si'])): ?>
                                    <div class="lang-block sin-text">
                                        <span class="lang-tag tag-si">SI</span>
                                        <?= htmlspecialchars((string)$q['question_si'], ENT_QUOTES, 'UTF-8') ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($q['question_ja'])): ?>
                                    <div class="lang-block" style="font-size: 14px;">
                                        <span class="lang-tag tag-ja">JA</span>
                                        <?= htmlspecialchars((string)$q['question_ja'], ENT_QUOTES, 'UTF-8') ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($q['question_ro'])): ?>
                                    <div class="lang-block" style="font-size: 13px; color: #64748b;">
                                        <span class="lang-tag tag-ro">RO</span>
                                        <?= htmlspecialchars((string)$q['question_ro'], ENT_QUOTES, 'UTF-8') ?>
                                    </div>
                                <?php endif; ?>

                            </td>

                            <!-- Correct Answer -->
                            <td style="text-align: center;">

                                <?php if ((string)$q['correct_answer'] === '1'): ?>

                                    <span class="ans-badge correct">
                                        ◯ නිවැරදියි
                                        <br>
                                        <span style="font-size: 12px; font-weight: normal;">
                                            (正しい)
                                        </span>
                                    </span>

                                <?php else: ?>

                                    <span class="ans-badge wrong">
                                        ✕ වැරදියි
                                        <br>
                                        <span style="font-size: 12px; font-weight: normal;">
                                            (誤り)
                                        </span>
                                    </span>

                                <?php endif; ?>

                            </td>

                            <!-- Explanation -->
                            <td>

                                <?php if (!empty($q['explanation_si'])): ?>
                                    <div class="lang-block sin-text" style="color: #475569;">
                                        <span class="lang-tag tag-si">SI</span>
                                        <?= htmlspecialchars((string)$q['explanation_si'], ENT_QUOTES, 'UTF-8') ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($q['explanation_ja'])): ?>
                                    <div class="lang-block" style="font-size: 13px; color: #334155;">
                                        <span class="lang-tag tag-ja">JA</span>
                                        <?= htmlspecialchars((string)$q['explanation_ja'], ENT_QUOTES, 'UTF-8') ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($q['explanation_ro'])): ?>
                                    <div class="lang-block" style="font-size: 12px; color: #64748b;">
                                        <span class="lang-tag tag-ro">RO</span>
                                        <?= htmlspecialchars((string)$q['explanation_ro'], ENT_QUOTES, 'UTF-8') ?>
                                    </div>
                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

    <!-- Pagination -->
    <?php if ($total_pages > 1): ?>

        <div class="pagination">

            <?php if ($page > 1): ?>

                <a href="?page=1&img_filter=<?= urlencode($img_filter) ?>">
                    &laquo; මුලට
                </a>

                <a href="?page=<?= $page - 1 ?>&img_filter=<?= urlencode($img_filter) ?>">
                    &lt; කලින්
                </a>

            <?php endif; ?>

            <?php

            $start = max(1, $page - 2);
            $end = min($total_pages, $page + 2);

            for ($i = $start; $i <= $end; $i++):
            ?>

                <a
                    href="?page=<?= $i ?>&img_filter=<?= urlencode($img_filter) ?>"
                    class="<?= ($i == $page) ? 'active' : '' ?>"
                >
                    <?= $i ?>
                </a>

            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>

                <a href="?page=<?= $page + 1 ?>&img_filter=<?= urlencode($img_filter) ?>">
                    ඊළඟ &gt;
                </a>

                <a href="?page=<?= $total_pages ?>&img_filter=<?= urlencode($img_filter) ?>">
                    අගට &raquo;
                </a>

            <?php endif; ?>

        </div>

    <?php endif; ?>

</div>

</body>
</html>
