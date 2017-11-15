<?php
namespace AlegoApiWrapper\Contract;

use AlegoApiWrapper\Resource\ApiResponse;

interface IHttpClient
{
    /**
     * @param string $action
     * @param array  $serviceData
     *
     * @return ApiResponse
     */
    public function request($action, $serviceData = []);
} // end class
