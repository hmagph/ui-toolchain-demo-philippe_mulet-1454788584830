<?php

$data = file_get_contents('php://input');
$application = getenv("VCAP_APPLICATION");
$application_json = json_decode($application, true);
$applicationURI = $application_json["application_uris"][0];
$ordersHost = str_replace("-ui-", "-orders-api-", $applicationURI);
echo "\r\nordersHost:" . $ordersHost;
$ordersRoute = "http://" . $ordersHost;
echo "\r\nordersRoute:" . $ordersRoute;
$ordersURL = $ordersRoute . "/rest/orders";
echo "\r\nordersURL:" . $ordersURL;

function httpPost($data,$url)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_POST, true);  
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	$output = curl_exec ($ch);
	$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close ($ch);
	return $code;
}

echo json_encode(array("httpCode" => httpPost($data,$ordersURL), "ordersURL" => $ordersURL));

?>
