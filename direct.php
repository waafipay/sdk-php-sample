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

$payerInfo = new PayerInfo(); 
$payerInfo->setaccountNo("4111111111111111");
$payerInfo->setaccountPwd("123");
$payerInfo->setaccountExpDate("1228");
$payerInfo->setaccountHolder("Nad Test");

$transactionInfo = new TransactionInfo(); 
$transactionInfo->setreferenceId("REF987345972453452345");
$transactionInfo->setinvoiceId("INVOICE92478592");
$transactionInfo->setamount("1");
$transactionInfo->setcurrency("USD");
$transactionInfo->setdescription("test");






// ************************initiate preauthorize transaction

$paymentDetailBuilder = new PaymentDetailBuilder($channelId, $methodId, $requestId, $transactionInfo, $payerInfo);
$paymentDetail = $paymentDetailBuilder->build();

$response = Payment::createTxn($paymentDetail);

$jsonresponse = $response->getJsonResponse();
// decode in array
$decodedarr = json_decode($jsonresponse);

$transactionId = $decodedarr->transactionId;
$referenceId = $decodedarr->referenceId;




// *********************** set service parameter for preauthorize commit


$serviceParams = new ServiceParams(); 
$serviceParams->settransactionId($transactionId);
$serviceParams->setdescription("Test");
$serviceParams->setreferenceId($referenceId);






// *************************** Preauthorize commit

/*
$PaymentCommitDetailBuilder = new PaymentCommitDetailBuilder($channelId, $requestId, $serviceParams);
$paymentDetailCommit = $PaymentCommitDetailBuilder->build();

$response = Payment::createCommitTxn($paymentDetailCommit); */











// *****************************   Preauthorize Cancel

/*
 $PaymentCommitDetailBuilder = new PaymentCommitDetailBuilder($channelId, $requestId, $serviceParams);
 $paymentDetailCommit = $PaymentCommitDetailBuilder->build();

 $response = Payment::createCancelCommitTxn($paymentDetailCommit); */
 
 
 
  
 


// *****************************   Purchase Cancelation

/*
$PaymentCommitDetailBuilder = new PaymentCommitDetailBuilder($channelId, $requestId, $serviceParams);
$paymentDetailCommit = $PaymentCommitDetailBuilder->build();

$response = Payment::createPurchaseCancelTxn($paymentDetailCommit); */


















// *****************************  Refund Transaction

/*
$transactionId = '1238657';
$referenceId = "REF987345972453452345";

$serviceParams = new ServiceParamsRefund(); 
$serviceParams->settransactionId($transactionId);
$serviceParams->setdescription("Test");
$serviceParams->setreferenceId($referenceId);
$serviceParams->setamount('5');

$PaymentRefundlBuilder = new PaymentRefundlBuilder($channelId, $requestId, $serviceParams);
$PaymentRefundlBuilder = $PaymentRefundlBuilder->build();

$response = Payment::createRefundTxn($PaymentRefundlBuilder); 
*/


echo '<pre>'; print_r($response);

//


?>