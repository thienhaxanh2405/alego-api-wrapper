<?php
namespace AlegoApiWrapper\Contract;

use AlegoApiWrapper\Resource\Buy;

interface IClient
{
    public function buyPrepaidCard(Buy $card);

    public function prepaidTopUp(Buy $card);

    public function postpaidTopUp(Buy $card);

    public function buyGamePrepaidCard(Buy $card);

    public function checkOrder($myReferNumber);

    public function getBalance();
} // end class
