<?php


function postJSONdataAPI($URL, $JSON_STRING)
{
	$ch = curl_init($URL);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $JSON_STRING);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Content-Length: ' . strlen($JSON_STRING))
	);

	return curl_exec($ch);
}
$access_token = 'tPROSmwb3NreedHXLbUN3c3mEVoJg3zI6BonkWxGBQUYZiz+4vZGHIoTnSJ0XsZeF9eRfpLL4R59Xat41unaUMBXJ3H7tbwMeorABfztCSmgf9xvxZFhZgvolBXxYr2I428eI3q4VOYQV1on4fgrpgdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// echo $access_token;
// Validate parsed JSON data
if (!is_null($events['events'])) {
    // Loop through each event
	foreach ($events['events'] as $event) {
        // Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
            // Get text sent
			$text = $event['message']['text'];
            // Get replyToken
			$replyToken = $event['replyToken'];

            // Build message to reply back
			$messages = [
			'type' => 'text',
			// 'text' => $text
			];

// 			$stringInput = 'กชรุณาช่วยค้นหาrdc0200018411และ RDC0200018410ด้วยครับ';
// 			$lineSession = 'testBot';
// 			$data = array("DATA" => $stringInput, "CREATE" => $lineSession);
// 			$data_string = json_encode($data);
// // echo $data_string;
// //          /// call API Main
// 			$urlBWAPI = "http://122.155.180.139/SERVICETRACK/service_linebot_track_temp.php" ;
// 			$result = postJSONdataAPI($urlBWAPI, $data_string);
// 			echo $result;

            // Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
			'replyToken' => $replyToken,
			'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}
	}
}
echo "OK";