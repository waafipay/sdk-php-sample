<?php 
require_once __DIR__ . '/sdk-php-main/vendor/autoload.php';
define('PROJECT','waafipaysdk');

use waafipay\pg\constants\LibraryConstants;
use waafipay\pg\constants\MerchantProperties;
use waafipay\pg\enums\EChannelId;
use waafipay\pg\enums\EMethod;
use waafipay\pg\models\PayerInfo;
use waafipay\pg\models\ServiceParams;
use waafipay\pg\models\ServiceParamsRefund;
use waafipay\pg\models\TransactionInfo;
use waafipay\merchant\models\PaymentCommitDetailBuilder;
use waafipay\merchant\models\PaymentDetailBuilder;
use waafipay\merchant\models\PaymentHppDetailBuilder;
use waafipay\merchant\models\SDKResponse;
use waafipay\pg\process\Payment;


// initialization

$merchantUid = "M0912255";
$apiUserId = "1000238";
$apiKey = "HPP-961814494";

$environment = LibraryConstants::STAGING_ENVIRONMENT;
MerchantProperties::initialize($environment, $apiUserId, $merchantUid, $apiKey);

$channelId = EChannelId::WEB;
$methodId = EMethod::CREDIT_CARD;

$requestId = "R17100517154428";

$payerInfo = new PayerInfo(); 
$payerInfo->setaccountNo("4111111111111111");
$payerInfo->setaccountPwd("123");
$payerInfo->setaccountExpDate("1228");
$payerInfo->setaccountHolder("Nad Test");

$transactionInfo = new TransactionInfo(); 
$transactionInfo->setreferenceId("REF987345972453452358");
$transactionInfo->setinvoiceId("INVOICE92478592");
$transactionInfo->setamount("1");
$transactionInfo->setcurrency("USD");
$transactionInfo->setdescription("test");






// ************************initiate preauthorize transaction

$failcallbackurl = "http://localhost/phpsdk/fail.php";
$succallbackurl = "http://localhost/phpsdk/pass.php";

$paymentDetailBuilder = new PaymentHppDetailBuilder($channelId, $methodId, $transactionInfo, $succallbackurl, $failcallbackurl);

$paymentDetail = $paymentDetailBuilder->build();

$response = Payment::CreateHppTxn($paymentDetail);

$jsonresponse = $response->getJsonResponse();
// decode in array
$decodedarr = json_decode($jsonresponse);


if(isset($decodedarr->hppRequestId)){
	$hppurl = $decodedarr->hppUrl.'?hppRequestId='.$decodedarr->hppRequestId.'&referenceId='.$decodedarr->referenceId;
	header('Location: '.$hppurl);
} else {
	echo '<pre>'; print_r($decodedarr);
	die();
	
}


//


?>
