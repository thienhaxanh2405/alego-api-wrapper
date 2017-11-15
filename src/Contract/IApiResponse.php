<?php
namespace AlegoApiWrapper\Contract;

interface IApiResponse
{
    public function processData($returnCardType, $rawData = null);
} // end class
