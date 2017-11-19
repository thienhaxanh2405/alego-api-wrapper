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

// create client
$client = \AlegoApiWrapper\Client::createClient($account, true);

var_dump($client->getBalance());