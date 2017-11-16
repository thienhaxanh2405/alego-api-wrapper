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
/*$buyCard = new \AlegoApiWrapper\Resource\BuyPrepaidCard(
    [
        'referNumber' => uniqid(),
        'productCode' => \AlegoApiWrapper\Constant\AlegoProduct::PREPAID_CARD_VIETTEL,
        'telco' => \AlegoApiWrapper\Constant\Telco::VIETTEL_CODE,
        'cardPrice' => \AlegoApiWrapper\Constant\PrepaidCardPrice::C_100,
        'cardQuantity' => 1
    ]
);

$res = $client->buyPrepaidCard($buyCard);

echo "<pre>";
*/

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


$res = $client->getBalance();

// var dump result
var_dump($res);
