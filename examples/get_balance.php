<?php
require_once "../vendor/autoload.php";

// api account
// this below info is Alego account test, in production, use yours.
$account = new \AlegoApiWrapper\Connection\Account(
    [
        'agentId' => 20170623114701,
        'accountId' => '594c9d45e4b01f4ae890ab02',
        'keyMD5' => 'sw20FaMFtlfqkeEdtu',
        'tripleKey' => 's3Fz2MS3KgGb89Ha9mlW2Phh'
    ]
);

// create client
$client = \AlegoApiWrapper\Client::createClient($account, true, 1);

echo "<pre>";
var_dump($client->getBalance());