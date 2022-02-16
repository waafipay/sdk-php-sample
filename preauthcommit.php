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
use waafipay\merchant\models\PaymentCommitDetailBuilder;
use waafipay\merchant\models\PaymentRefundlBuilder;
use waafipay\merchant\models\PaymentDetailBuilder;
use waafipay\merchant\models\SDKResponse;
use waafipay\pg\process\Payment;


// initialization

$merchantUid = "M0912255";
$apiUserId = "1000312";
$apiKey = "API-669892958AHX";


$environment = LibraryConstants::STAGING_ENVIRONMENT;
MerchantProperties::initialize($environment, $apiUserId, $merchantUid, $apiKey);

$channelId = EChannelId::WEB;
$methodId = EMethod::CREDIT_CARD;

$requestId = "R17100517154423";

$transactionId = "";
$referenceId = "";


// *********************** set service parameter for preauthorize commit


$serviceParams = new ServiceParams(); 
$serviceParams->settransactionId($transactionId);
$serviceParams->setdescription("Test");
$serviceParams->setreferenceId($referenceId);

// *************************** Preauthorize commit


$PaymentCommitDetailBuilder = new PaymentCommitDetailBuilder($channelId, $requestId, $serviceParams);
$paymentDetailCommit = $PaymentCommitDetailBuilder->build();

$response = Payment::createCommitTxn($paymentDetailCommit); 

echo '<pre>'; print_r($response);

//


?>