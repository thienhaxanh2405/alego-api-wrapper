<?php
namespace AlegoApiWrapper\Contract;

use AlegoApiWrapper\Resource\BuyPrepaidCard;

interface IClient
{
    public function buyPrepaidCard(BuyPrepaidCard $card);

    public function prepaidTopUp(BuyPrepaidCard $card);

    public function postpaidTopUp(BuyPrepaidCard $card);

    public function checkOrder($myReferNumber);

    public function getBalance();
} // end class
