<?php
header('Content-Type: application/json');

function check($uid) {
    $url = "https://ff.garena.com/api/antihack/check_banned?lang=vi&uid=" . urlencode($uid);
    
    $headers = array(
        'User-Agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36',
        'Accept: application/json, text/plain, */*',
        'authority: ff.garena.com',
        'accept-language: en-GB,en-US;q=0.9,en;q=0.8',
        'referer: https://ff.garena.com/en/support/',
        'sec-ch-ua: "Not_A Brand";v="8", "Chromium";v="120"',
        'sec-ch-ua-mobile: ?1',
        'sec-ch-ua-platform: "Android"',
        'sec-fetch-dest: empty',
        'sec-fetch-mode: cors',
        'sec-fetch-site: same-origin',
        'x-requested-with: B6FksShzIgjfrYImLpTsadjS86sddhFH'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    curl_close($ch);

    if ($http_code == 200) {
        $data = json_decode($response, true);
        $data = isset($data['data']) ? $data['data'] : array();
        $is_banned = isset($data['is_banned']) ? $data['is_banned'] : 0;
        
        if ($is_banned) {
            return "Account Has Been Permanently Banned💀";
        } else {
            return "Account Not Banned";
        }
    } else {
        return "error";
    }
}

if (isset($_GET['uid'])) {
    $uid = $_GET['uid'];
    $result = check($uid);
    echo json_encode(array('message' => $result));
} else {
    echo json_encode(array('error' => 'Missing uid parameter'));
}
?>
