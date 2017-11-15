<?php
namespace AlegoApiWrapper\Contract;

interface IRequestData
{
    public function decryptReceivedData($string, $seed);

    public function encryptSentData($string, $seed);
} // end class
