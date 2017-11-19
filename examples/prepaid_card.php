<?php
require_once "../vendor/autoload.php";

use AlegoApiWrapper\Constant\AlegoProduct;
use AlegoApiWrapper\Constant\Telco;
use AlegoApiWrapper\Constant\AlegoTransactionType;
use AlegoApiWrapper\Resource\BuyPrepaidCard;
use AlegoApiWrapper\Constant\PrepaidCardPrice;

if ($_POST) {
    // define an array contain Alego's product code
    $products = [
        AlegoTransactionType::BUY_PREPAID_CARD => [
            Telco::VIETTEL_CODE => AlegoProduct::PREPAID_CARD_VIETTEL,
            Telco::MOBIFONE_CODE => AlegoProduct::PREPAID_CARD_MOBIFONE,
            Telco::VINAPHONE_CODE => AlegoProduct::PREPAID_CARD_VINAPHONE,
            Telco::SFONE_CODE => AlegoProduct::PREPAID_CARD_SFONE,
            Telco::GMobile_CODE => AlegoProduct::PREPAID_CARD_GMOBILE,
            Telco::VIETNAMEMOBILE_CODE => AlegoProduct::PREPAID_CARD_VIETNAMEMOBILE,
        ]
    ];

    // input
    $telco = $_POST['telco'];
    $type = AlegoTransactionType::BUY_PREPAID_CARD;
    $cardPrice = $_POST['cardPrice'];
    $cardQuantity = $_POST['cardQuantity'];


    // api account
    // this below info is Alego account test, in production, use yours.
    $account = new \AlegoApiWrapper\Connection\Account(
        [
            'agentId' => 1,
            'accountId' => '571a01a0e4b0b96b6f950ad5',
            'keyMD5' => 'adrMjEJArHysrhwM',
            'tripleKey' => 'asdf'
        ]
    );

    // create a client
    $client = \AlegoApiWrapper\Client::createClient($account, true, 1);

    // create a buy card object
    $buyCard = new BuyPrepaidCard(
        [
            'referNumber' => uniqid(),
            'productCode' => $products[$type][$telco],
            'telco' => $telco,
            'type' => $type,
            'cardQuantity' => $cardQuantity,
            'cardPrice' => $cardPrice,
        ]
    );

    if ($type == AlegoTransactionType::BUY_PREPAID_CARD) {
        // buy prepaid card
        $res = $client->buyPrepaidCard($buyCard);
    } else {
        $res = null;
    }

    echo "<pre>";
    var_dump($res);

} else {
    $product = $telco = $type = $cellphone = $cardPrice = $cardQuantity = null;
}

?>
<form method="post">
    <table>
        <tr>
            <td colspan="2">Mua thẻ điện thoại</td>
        </tr>
        <tr>
            <td>Nhà mạng</td>
            <td>

                <select id="telco" name="telco">
                    <option <?=($telco == Telco::VIETTEL_CODE ? 'selected' : "")?> value="VTT">Viettel</option>
                    <option <?=($telco == Telco::MOBIFONE_CODE ? 'selected' : "")?> value="VMS">MobiFone</option>
                    <option <?=($telco == Telco::VINAPHONE_CODE ? 'selected' : "")?> value="VNP">VinaPhone</option>
                    <option <?=($telco == Telco::VIETNAMEMOBILE_CODE ? 'selected' : "")?> value="VNM">VietnamMobile</option>
                    <option <?=($telco == Telco::GMobile_CODE ? 'selected' : "")?> value="GTEL">Gmobile</option>
                    <option <?=($telco == Telco::SFONE_CODE ? 'selected' : "")?> value="SFONE">Sfone</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Mệnh giá</td>
            <td>
                <select name="cardPrice">
                    <option value="<?=PrepaidCardPrice::C_100?>" <?=($cardPrice == PrepaidCardPrice::C_100 ? "selectecd" : "")?>><?=number_format(PrepaidCardPrice::C_100, 0, ".", " ")?></option>
                    <option value="<?=PrepaidCardPrice::C_10?>" <?=($cardPrice == PrepaidCardPrice::C_10 ? "selectecd" : "")?>><?=number_format(PrepaidCardPrice::C_10, 0, ".", " ")?></option>
                    <option value="<?=PrepaidCardPrice::C_20?>" <?=($cardPrice == PrepaidCardPrice::C_20 ? "selectecd" : "")?>><?=number_format(PrepaidCardPrice::C_20, 0, ".", " ")?></option>
                    <option value="<?=PrepaidCardPrice::C_30?>" <?=($cardPrice == PrepaidCardPrice::C_30 ? "selectecd" : "")?>><?=number_format(PrepaidCardPrice::C_30, 0, ".", " ")?></option>
                    <option value="<?=PrepaidCardPrice::C_50?>" <?=($cardPrice == PrepaidCardPrice::C_50 ? "selectecd" : "")?>><?=number_format(PrepaidCardPrice::C_50, 0, ".", " ")?></option>
                    <option value="<?=PrepaidCardPrice::C_200?>" <?=($cardPrice == PrepaidCardPrice::C_200 ? "selectecd" : "")?>><?=number_format(PrepaidCardPrice::C_200, 0, ".", " ")?></option>
                    <option value="<?=PrepaidCardPrice::C_500?>" <?=($cardPrice == PrepaidCardPrice::C_500 ? "selectecd" : "")?>><?=number_format(PrepaidCardPrice::C_500, 0, ".", " ")?></option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Số lượng</td>
            <td><input type="text" name="cardQuantity" value="<?=$cardQuantity?>" /></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="submit" value="Thực hiện" /></td>
        </tr>
    </table>
</form>