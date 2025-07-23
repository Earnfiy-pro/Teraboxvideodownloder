<?php
header('Content-Type: application/json');

if (!isset($_GET['url'])) {
    echo json_encode(['success' => false, 'message' => 'No URL provided']);
    exit;
}

$url = $_GET['url'];
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0");

$response = curl_exec($ch);
curl_close($ch);

// Try to extract the video URL from the JavaScript blob
if (preg_match('/(https:\/\/.*?\.terabox\.com\/.*?download.*?)"/', $response, $matches)) {
    $video = htmlspecialchars_decode($matches[1]);
    echo json_encode(['success' => true, 'video' => $video]);
} else {
    echo json_encode(['success' => false, 'message' => 'Video not found']);
}
