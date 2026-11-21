<?php
// visitor.php - Track visitors (device, country, page, referrer)
// Included from public pages: require_once __DIR__ . '/visitor.php';
// Counts once per browser session (not on every reload) so numbers reflect
// visits, not page-view spam.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['visitor_counted'])) {

    /* ---- 1. Lifetime total counter (cheap, unbounded — read by admin.php's Overview tab) ---- */
    $counterFile = __DIR__ . '/visitor_count.txt';
    $fp = @fopen($counterFile, 'c+');
    if ($fp) {
        flock($fp, LOCK_EX);
        $count = (int) fread($fp, 1024);
        $count++;
        ftruncate($fp, 0);
        rewind($fp);
        fwrite($fp, (string) $count);
        flock($fp, LOCK_UN);
        fclose($fp);
    }

    /* ---- 2. Detailed rolling log (last 1000 visits — read by admin.php's Analytics tab) ---- */
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $isMobile = (bool) preg_match('/Mobile|Android|iPhone|iPad|iPod|BlackBerry|Opera Mini|IEMobile/i', $userAgent);
    $deviceType = $isMobile ? 'Mobile' : 'Desktop';

    // Country is only reliable if the host sits behind Cloudflare (which adds
    // this header) — otherwise there's no free, dependable geo source without
    // an external API call, so we don't fabricate one. No fake "prefecture"
    // either; a real one would need an actual geo-IP lookup.
    $country = $_SERVER['HTTP_CF_IPCOUNTRY'] ?? 'Unknown';

    $logEntry = [
        'time'     => date('Y-m-d H:i:s'),
        'ip'       => $ip,
        'device'   => $deviceType,
        'country'  => $country,
        'page'     => $_SERVER['REQUEST_URI'] ?? '/',
        'referrer' => $_SERVER['HTTP_REFERER'] ?? '',
    ];

    $logFile = __DIR__ . '/visitor_logs.json';
    $fp2 = @fopen($logFile, 'c+');
    if ($fp2) {
        flock($fp2, LOCK_EX);
        $raw = stream_get_contents($fp2);
        $logs = json_decode($raw, true);
        if (!is_array($logs)) {
            $logs = [];
        }
        array_unshift($logs, $logEntry);
        $logs = array_slice($logs, 0, 1000);

        ftruncate($fp2, 0);
        rewind($fp2);
        fwrite($fp2, json_encode($logs, JSON_PRETTY_PRINT));
        flock($fp2, LOCK_UN);
        fclose($fp2);
    }

    $_SESSION['visitor_counted'] = true;
}