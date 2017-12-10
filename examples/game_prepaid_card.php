<?php
require_once "../vendor/autoload.php";

use AlegoApiWrapper\Constant\AlegoProduct;
use AlegoApiWrapper\Resource\Buy;
use AlegoApiWrapper\Constant\PrepaidCardPrice;
use AlegoApiWrapper\Constant\GamePublisher;

if ($_POST) {
    // define an array contain Alego's product code
    $products = [
        GamePublisher::VTC_VCOIN =>AlegoProduct::GAME_PREPAID_CARD_V_COIN,
        GamePublisher::FPT_GATE => AlegoProduct::GAME_PREPAID_CARD_GATE,
        GamePublisher::GARENA_SO => AlegoProduct::GAME_PREPAID_CARD_SO_GARENA,
        GamePublisher::VINAGAME_ZING => AlegoProduct::GAME_PREPAID_CARD_ZING,
        GamePublisher::VTC_ONLINE_GO_COIN => AlegoProduct::GAME_PREPAID_CARD_GO_COIN,
        GamePublisher::NET_2_E_ON_CASH => AlegoProduct::GAME_PREPAID_CARD_ON_CASH,
        GamePublisher::MEGA_CARD => AlegoProduct::GAME_PREPAID_CARD_MEGACARD,
        GamePublisher::V_CARD => AlegoProduct::GAME_PREPAID_CARD_VCARD,
    ];

    // input
    $cardPrice = $_POST['cardPrice'];
    $cardQuantity = $_POST['cardQuantity'];
    $publisher = $_POST['publisher'];


    // api account
    // this below info is Alego account test, in production, use yours.
    $account = new \AlegoApiWrapper\Connection\Account(
        [
            'agentId' => 1,
            'accountId' => '571a01a0e4b0b96b6f950ad5',
            'keyMD5' => 'adrMjEJArHysrhwM',
            'tripleKey' => '1234567890123'
        ]
    );

    // create a client
    $client = \AlegoApiWrapper\Client::createClient($account, true, 1);

    // create a buy card object
    $buyCard = new Buy(
        [
            'referOrder' => uniqid(),
            'productCode' => $products[$publisher],
            'cardQuantity' => $cardQuantity,
            'cardPrice' => $cardPrice,
        ]
    );

    // result
    $res = $client->buyGamePrepaidCard($buyCard);

    echo "<pre>";
    var_dump($res);

} else {
    $publisher = $cardPrice = $cardQuantity = null;
}

?>
<form method="post">
    <table>
        <tr>
            <td colspan="2">Mua thẻ game</td>
        </tr>
        <tr>
            <td>Game</td>
            <td>

                <select id="publisher" name="publisher">
                    <option <?=($publisher == GamePublisher::FPT_GATE ? 'selected' : "")?> value="<?=GamePublisher::FPT_GATE?>">
                        <?=GamePublisher::FPT_GATE?>
                    </option>
                    <option <?=($publisher == GamePublisher::VTC_VCOIN ? 'selected' : "")?> value="<?=GamePublisher::VTC_VCOIN?>">
                        <?=GamePublisher::VTC_VCOIN?>
                    </option>
                    <option <?=($publisher == GamePublisher::GARENA_SO ? 'selected' : "")?> value="<?=GamePublisher::GARENA_SO?>">
                        <?=GamePublisher::GARENA_SO?>
                    </option>
                    <option <?=($publisher == GamePublisher::VINAGAME_ZING ? 'selected' : "")?> value="<?=GamePublisher::VINAGAME_ZING?>">
                        <?=GamePublisher::VINAGAME_ZING?>
                    </option>
                    <option <?=($publisher == GamePublisher::VTC_ONLINE_GO_COIN ? 'selected' : "")?> value="<?=GamePublisher::VTC_ONLINE_GO_COIN?>">
                        <?=GamePublisher::VTC_ONLINE_GO_COIN?>
                    </option>
                    <option <?=($publisher == GamePublisher::NET_2_E_ON_CASH ? 'selected' : "")?> value="<?=GamePublisher::NET_2_E_ON_CASH?>">
                        <?=GamePublisher::NET_2_E_ON_CASH?>
                    </option>
                    <option <?=($publisher == GamePublisher::MEGA_CARD ? 'selected' : "")?> value="<?=GamePublisher::MEGA_CARD?>">
                        <?=GamePublisher::MEGA_CARD?>
                    </option>
                    <option <?=($publisher == GamePublisher::V_CARD ? 'selected' : "")?> value="<?=GamePublisher::V_CARD?>">
                        <?=GamePublisher::V_CARD?>
                    </option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Mệnh giá</td>
            <td>
                <select name="cardPrice">
                    <option value="<?=PrepaidCardPrice::C_50?>" <?=($cardPrice == PrepaidCardPrice::C_50 ? "selectecd" : "")?>><?=number_format(PrepaidCardPrice::C_50, 0, ".", " ")?> đ</option>
                    <option value="<?=PrepaidCardPrice::C_10?>" <?=($cardPrice == PrepaidCardPrice::C_10 ? "selectecd" : "")?>><?=number_format(PrepaidCardPrice::C_10, 0, ".", " ")?> đ</option>
                    <option value="<?=PrepaidCardPrice::C_20?>" <?=($cardPrice == PrepaidCardPrice::C_20 ? "selectecd" : "")?>><?=number_format(PrepaidCardPrice::C_20, 0, ".", " ")?> đ</option>
                    <option value="<?=PrepaidCardPrice::C_30?>" <?=($cardPrice == PrepaidCardPrice::C_30 ? "selectecd" : "")?>><?=number_format(PrepaidCardPrice::C_30, 0, ".", " ")?> đ</option>
                    <option value="<?=PrepaidCardPrice::C_100?>" <?=($cardPrice == PrepaidCardPrice::C_100 ? "selectecd" : "")?>><?=number_format(PrepaidCardPrice::C_100, 0, ".", " ")?> đ</option>
                    <option value="<?=PrepaidCardPrice::C_200?>" <?=($cardPrice == PrepaidCardPrice::C_200 ? "selectecd" : "")?>><?=number_format(PrepaidCardPrice::C_200, 0, ".", " ")?> đ</option>
                    <option value="<?=PrepaidCardPrice::C_500?>" <?=($cardPrice == PrepaidCardPrice::C_500 ? "selectecd" : "")?>><?=number_format(PrepaidCardPrice::C_500, 0, ".", " ")?> đ</option>
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