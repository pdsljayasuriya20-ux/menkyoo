<?php
// api/postal-lookup.php
// Server-side proxy for Japan postal code -> address lookup (zipcloud API).
// Doing this server-side avoids browser CORS issues with zipcloud.

header('Content-Type: application/json; charset=utf-8');

$zipcode = preg_replace('/[^0-9]/', '', $_GET['zipcode'] ?? '');

if (strlen($zipcode) !== 7) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Postal code must be 7 digits.']);
    exit;
}

$apiUrl = 'https://zipcloud.ibsnet.co.jp/api/search?zipcode=' . urlencode($zipcode);

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($response === false || $httpCode !== 200) {
    http_response_code(502);
    echo json_encode(['status' => 'error', 'message' => 'Lookup service unavailable.']);
    exit;
}

$data = json_decode($response, true);

// zipcloud returns status 200 on success (not 0!), and null/empty results when no match.
if (!$data || (int) $data['status'] !== 200 || empty($data['results'])) {
    echo json_encode(['status' => 'not_found', 'message' => 'No address found for this postal code.']);
    exit;
}

$result = $data['results'][0];

echo json_encode([
    'status'     => 'ok',
    'prefecture' => $result['address1'] ?? '', // e.g. 大阪府
    'city'       => $result['address2'] ?? '', // e.g. 大阪市西区
    'town'       => $result['address3'] ?? '', // e.g. 阿波座
]);