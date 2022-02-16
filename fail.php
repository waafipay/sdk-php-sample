<?php 
require_once __DIR__ . '/waafipaysdk/vendor/autoload.php';
define('PROJECT','waafipaysdk');

use waafipay\pg\constants\LibraryConstants;
use waafipay\pg\constants\MerchantProperties;
use waafipay\pg\enums\EChannelId;
use waafipay\pg\enums\EMethod;
use waafipay\pg\models\PayerInfo;
use waafipay\pg\models\ServiceParams;
use waafipay\pg\models\ServiceParamsRefund;
use waafipay\pg\models\TransactionInfo;
use waafipay\merchant\models\PaymentHppResponseDetail;
use waafipay\merchant\models\PaymentDetailHppResponseBuilder;
use waafipay\merchant\models\SDKResponse;
use waafipay\pg\process\Payment;


// initialization

$merchantUid = "M0910002";
$apiUserId = "1000011";
$apiKey = "HPP-554757642";
$environment = LibraryConstants::STAGING_ENVIRONMENT;
MerchantProperties::initialize($environment, $apiUserId, $merchantUid, $apiKey);

$channelId = EChannelId::WEB;
$methodId = EMethod::CREDIT_CARD;

$requestId = "R17100517154428";

$hppResultToken = $_REQUEST['hppResultToken'];

$paymentDetailBuilder = new PaymentDetailHppResponseBuilder($channelId, $hppResultToken);

$paymentDetail = $paymentDetailBuilder->build();

$response = Payment::CreateHppResultTxn($paymentDetail);

$jsonresponse = $response->getJsonResponse();
// decode in array
$decodedarr = json_decode($jsonresponse);

//
echo '<pre>'; print_r($_REQUEST);
echo '<pre>'; print_r($response);

?>