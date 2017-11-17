<?php
require_once "../vendor/autoload.php";

use AlegoApiWrapper\Constant\AlegoProduct;
use AlegoApiWrapper\Constant\Telco;
use AlegoApiWrapper\Constant\AlegoTransactionType;
use AlegoApiWrapper\Resource\BuyPrepaidCard;
use AlegoApiWrapper\Constant\PrepaidCardPrice;

if ($_POST) {
    $telco = $_POST['telco'];
    $type = AlegoTransactionType::BUY_PREPAID_CARD;
    $cardPrice = $_POST['cardPrice'];
    $cardQuantity = $_POST['cardQuantity'];

    $products = [
        AlegoTransactionType::BUY_PREPAID_CARD => [
            Telco::VIETTEL_CODE => AlegoProduct::PREPAID_CARD_VIETTEL,
            Telco::MOBIFONE_CODE => 501,
            Telco::VINAPHONE_CODE => 502,
            Telco::SFONE_CODE => 503,
            Telco::GMobile_CODE => 504,
            Telco::VIETNAMEMOBILE_CODE => 505,
        ]
    ];

    $account = new \AlegoApiWrapper\Connection\Account(
        [
            'agentId' => 1,
            'accountId' => '571a01a0e4b0b96b6f950ad5',
            'keyMD5' => 'adrMjEJArHysrhwM',
            'tripleKey' => 'asdf'
        ]
    );

    $client = \AlegoApiWrapper\Client::createClient($account);

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
        $res = $client->buyPrepaidCard($buyCard);
    } else {
        $res = null;
    }

    //var_dump($res);

} else {
    $product = $telco = $type = $cellphone = $cardPrice = $cardQuantity = null;
}

?>
<form method="post">
    <table>
        <tr>
            <td>Nhà mạng</td>
            <td>

                <select id="telco" name="telco">
                    <option <?=($telco = Telco::VIETTEL_CODE ? 'selected' : "")?> value="VTT">Thẻ Viettel</option>
                    <option <?=($telco = Telco::MOBIFONE_CODE ? 'selected' : "")?> value="VMS">Thẻ MobiFone</option>
                    <option <?=($telco = Telco::VINAPHONE_CODE ? 'selected' : "")?> value="VNP">Thẻ VinaPhone</option>
                    <option <?=($telco = Telco::VIETNAMEMOBILE_CODE ? 'selected' : "")?> value="VNM">Thẻ VietnamMobile</option>
                    <option <?=($telco = Telco::GMobile_CODE ? 'selected' : "")?> value="GTEL">Thẻ Gmobile</option>
                    <option <?=($telco = Telco::SFONE_CODE ? 'selected' : "")?> value="SFONE">Thẻ Sfone</option>
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