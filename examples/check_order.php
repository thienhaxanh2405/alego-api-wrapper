<?php
require_once "../vendor/autoload.php";

if ($_GET) {
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

    // create client
    $client = \AlegoApiWrapper\Client::createClient($account, true, 1);


    echo "<pre>";
    var_dump($client->checkOrder($_GET['referOrder']));
}

?>

<form action="" method="get">
    <input name="referOrder" type="text" value="<?=@$_GET['referOrder']?>" placeholder="Mã tham chiếu" />
    <input type="submit" value="Kiểm tra giao dịch" />
</form>
