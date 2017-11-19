<?php
require_once "../vendor/autoload.php";

use AlegoApiWrapper\Constant\Telco;
use AlegoApiWrapper\Constant\AlegoTransactionType;
use AlegoApiWrapper\Resource\BuyPrepaidCard;
use AlegoApiWrapper\Constant\PrepaidCardPrice;

if ($_POST) {
    // define an array contain Alego's product code
    $products = [
        AlegoTransactionType::TOPUP_PREPAID => [
            Telco::VIETTEL_CODE => 600,
            Telco::MOBIFONE_CODE => 601,
            Telco::VINAPHONE_CODE => 602,
            Telco::SFONE_CODE => 603,
            Telco::GMobile_CODE => 604,
            Telco::VIETNAMEMOBILE_CODE => 605,
        ],
        AlegoTransactionType::TOPUP_POSTPAID => [
            Telco::VIETTEL_CODE => 630,
            Telco::MOBIFONE_CODE => 631,
            Telco::VINAPHONE_CODE => 632,
            Telco::SFONE_CODE => 633,
            Telco::GMobile_CODE => 634,
            Telco::VIETNAMEMOBILE_CODE => 635,
        ]
    ];

    // input
    $telco = $_POST['telco'];
    $type = $_POST['type'];
    $cellphone = $_POST['cellphone'];
    $cardPrice = $_POST['cardPrice'];

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

    // create client
    $client = \AlegoApiWrapper\Client::createClient($account, true, 1);

    // create a buy card object
    $buyCard = new BuyPrepaidCard(
        [
            'referNumber' => uniqid(),
            'productCode' => $products[$type][$telco],
            'telco' => $telco,
            'type' => $type,
            'customerCellphone' => $cellphone,
            'cardPrice' => $cardPrice,
        ]
    );

    if ($type == AlegoTransactionType::TOPUP_PREPAID) {
        // prepaid topup
        $res = $client->prepaidTopUp($buyCard);
    } elseif ($type == AlegoTransactionType::TOPUP_POSTPAID) {
        // post paid topup
        $res = $client->postpaidTopUp($buyCard);
    } else {
        $res = null;
    }

    echo "<pre>";
    var_dump($res);

} else {
    $product = $telco = $type = $cellphone = $cardPrice = null;
}

?>
<form method="post">
    <table>
        <tr align="center">
            <td colspan="2">Nạp tiền điện thoại</td>
        </tr>
        <tr>
            <td>Dịch vụ</td>
            <td>
                <select id="type" name="type">
                    <option <?=($type == AlegoTransactionType::TOPUP_PREPAID ? 'selected' : "")?> value="TELCO_TOPUP">Nạp tiền thuê bao trả trước (TOPUP)</option>
                    <option <?=($type == AlegoTransactionType::TOPUP_POSTPAID ? 'selected' : "")?> value="TELCO_TOPUP_AFTER">Nạp tiền thuê bao trả sau (TOPUP_AFTER)</option>
                </select>
                <select id="" name="telco">
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
            <td>Điện thoại đi động</td>
            <td><input type="text" name="cellphone" value="<?=$cellphone?>" /></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="submit" value="Thực hiện" /></td>
        </tr>
    </table>
</form>