<?php
namespace AlegoApiWrapper\Resource;

class Balance extends Resource
{
    private $balance;

    private $availableBalance;

    private $frozenBalance;

    public function __construct($resources = null)
    {
        parent::__construct($resources);
    } // end construct

    public function setBalance($balance)
    {
        $this->balance = $balance;
    }

    public function setAvailableBalance($balance)
    {
        $this->availableBalance = $balance;
    }

    public function setFrozenBalance($balance)
    {
        $this->frozenBalance = $balance;
    }

    public function getBalance()
    {
        return $this->balance;
    }

    public function getAvailableBalance()
    {
        return $this->availableBalance;
    }

    public function getFrozenBalance()
    {
        return $this->frozenBalance;
    }
} // end class
