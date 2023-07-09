<?php
require_once('../vendor/autoload.php');
function pushNotification($title, $content){
	$client = new \GuzzleHttp\Client();
    $response = $client->request('POST', 'https://onesignal.com/api/v1/notifications', [
        'body' => '{"app_id": "0b0d49dd-8df1-4997-8e19-289e52dbf784","included_segments":["Subscribed Users"],"contents":{"en":"'.$content.'"},"headings":{"en":"'.$title.'"},"name":"SM Plays Notification"}',
        'headers' => [
            'Authorization' => 'Basic NzdhM2ExYmItYTUzOS00NmUyLWIzZGQtZWM2ODE5MWE0OGFm',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ],
    ]);
    // $response->getBody();
    echo json_encode(array("error"=>false, "message"=>"Notification executed Successfully", "serverResponse"=> $response->getBody()));
}

?>