<?php
function send_sms($to, $message) {
    $api_key = '85ae268a';
    $api_secret = 'If79kFby5vFtYS5BQwH0yFOLhZYByxbtTuou29uFDodHdoSn5t';
    $from = 'VonageSMS';

    // 🔧 Local number ko international format mein convert karna
    // Agar number 0 se start ho raha ho aur 11 digits ka ho
    if (preg_match('/^0\d{10}$/', $to)) {
        $to = '92' . substr($to, 1);
    }

    $url = 'https://rest.nexmo.com/sms/json?' . http_build_query([
        'api_key' => $api_key,
        'api_secret' => $api_secret,
        'to' => $to,
        'from' => $from,
        'text' => $message
    ]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $decoded = json_decode($response, true);
    if ($decoded['messages'][0]['status'] == 0) {
        return "SMS Sent Successfully to $to!";
    } else {
        return "SMS Failed to $to: " . $decoded['messages'][0]['error-text'];
    }
}

// ✅ Example usage — chahe local ya formatted ho
echo send_sms('03001234567', 'Your parcel is now In Transit.');
?>
