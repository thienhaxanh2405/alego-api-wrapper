<?php
require_once "../vendor/autoload.php";

$account = new \AlegoApiWrapper\Connection\Account(
    [
        'agentId' => 1,
        'accountId' => '571a01a0e4b0b96b6f950ad5',
        'keyMD5' => 'adrMjEJArHysrhwM',
        'tripleKey' => 'asdf'
    ]
);
$client = \AlegoApiWrapper\Client::createClient($account, true);

// buy prepaid card
$buyCard = new \AlegoApiWrapper\Resource\Buy(
    [
        'referNumber' => uniqid(),
        'productCode' => \AlegoApiWrapper\Constant\AlegoProduct::PREPAID_CARD_VIETTEL,
        'telco' => \AlegoApiWrapper\Constant\Telco::VIETTEL_CODE,
        'cardPrice' => \AlegoApiWrapper\Constant\PrepaidCardPrice::C_100,
        'cardQuantity' => 1
    ]
);

//$res = $client->buyPrepaidCard($buyCard);



// prepaid top
/*$topUpPrepaid = new \AlegoApiWrapper\Resource\BuyPrepaidCard(
    [
        'referNumber' => uniqid(),
        'productCode' => \AlegoApiWrapper\Constant\AlegoProduct::TOPUP_PREPAID_VIETTEL,
        'telco' => \AlegoApiWrapper\Constant\Telco::VIETTEL_CODE,
        'cardPrice' => \AlegoApiWrapper\Constant\PrepaidCardPrice::C_100,
        'customerCellphone' => "0987802175"
    ]
);
$res = $client->prepaidTopUp($topUpPrepaid);
echo "<pre>";
var_dump($res);*/


//$res = $client->getBalance();

// var dump result
//echo "<pre>";
//var_dump($res);

var_dump(\AlegoApiWrapper\Connection\RequestData::decrypt("Vh0P3sraRCegk4Kh1vFMwyFt0aAF76ol7J3/9+17fT3LEZpvWHnQTGF/azpWlQWu3miQ5L5CDJkreCC0RNR+fxflwJdWn/p1jFYlSWeMpPS0LcfoKmeQFt9TLisIn430mZLOynp9ffdIEIughIrAnnSrwEKCYqLH3RJo5dYfGOgaKgofIUBO20RkFWsr9zs4aXG9Lp7r7k8="));
