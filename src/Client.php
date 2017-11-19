<?php
namespace AlegoApiWrapper;

use AlegoApiWrapper\Connection\HttpClient;
use AlegoApiWrapper\Constant\AlegoTransactionType;
use AlegoApiWrapper\Constant\Api;
use AlegoApiWrapper\Constant\ApiAction;
use AlegoApiWrapper\Contract\IAuth;
use AlegoApiWrapper\Contract\IClient;
use AlegoApiWrapper\Contract\IHttpClient;
use AlegoApiWrapper\Resource\Buy;

class Client implements IClient
{
    /** @var int $isDebug; 0 - none; 1 - dump data; */
    private $isDebug = 0;

    /**
     * @var IHttpClient $httpClient
     */
    private $httpClient;

    /**
     * Create new Client object
     *
     * @param IAuth $account
     * @param bool  $isDevelopment
     * @param int $isDebug
     *
     * @return Client
     */
    public static function createClient(IAuth $account, $isDevelopment = false, $isDebug = 0)
    {
        if ($isDevelopment) {
            return new self(new HttpClient($account, Api::DEVELOPMENT_BASE_URL, $isDebug));
        } else {
            return new self(new HttpClient($account, Api::BASE_URL, $isDebug));
        }

    } // end create client

    public function __construct(IHttpClient $httpRequest, $isDebug = 0)
    {
        $this->httpClient = $httpRequest;
        $this->isDebug = $isDebug;
    }

    /**
     * @return int
     */
    public function getIsDebug()
    {
        return $this->isDebug;
    }

    /**
     * @param int $isDebug
     */
    public function setIsDebug($isDebug)
    {
        $this->isDebug = $isDebug;
    }

    /**
     * @return IHttpClient
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * @param IHttpClient $httpClient
     */
    public function setHttpClient($httpClient)
    {
        $this->httpClient = $httpClient;
    } // end class

    /**
     * @param Buy $buy
     *
     * @return Resource\ApiResponse
     */
    public function buyPrepaidCard(Buy $buy)
    {
        $serviceData = [
            'ProductCode' => $buy->getProductCode(),
            'RefNumber' => $buy->getReferOrder(),
            'Telco' => $buy->getTelco(),
            'Type' => AlegoTransactionType::BUY_PREPAID_CARD,
            'CardPrice' => $buy->getCardPrice(),
            'CardQuantity' => $buy->getCardQuantity(),
        ];

        return $this->httpClient->request(ApiAction::BUY_PREPAID_CARD, $serviceData);
    } // end buy card

    /**
     * @param Buy $buy
     *
     * @return Resource\ApiResponse
     */
    public function prepaidTopUp(Buy $buy)
    {
        $serviceData = [
            'ProductCode' => $buy->getProductCode(),
            'RefNumber' => $buy->getReferOrder(),
            'Telco' => $buy->getTelco(),
            'Type' => AlegoTransactionType::TOPUP_PREPAID,
            'CardPrice' => $buy->getCardPrice(),
            'CardQuantity' => 1,
            'CustMobile' => $buy->getCustomerCellphone()
        ];

        return $this->httpClient->request(ApiAction::PREPAID_TOPUP, $serviceData);
    } // end prepaid top up

    /**
     * @param Buy $buy
     *
     * @return Resource\ApiResponse
     */
    public function postpaidTopUp(Buy $buy)
    {
        $serviceData = [
            'ProductCode' => $buy->getProductCode(),
            'RefNumber' => $buy->getReferOrder(),
            'Telco' => $buy->getTelco(),
            'Type' => AlegoTransactionType::TOPUP_POSTPAID,
            'CardPrice' => $buy->getCardPrice(),
            'CardQuantity' => 1,
            'CustMobile' => $buy->getCustomerCellphone()
        ];

        return $this->httpClient->request(ApiAction::POSTPAID_TOPUP, $serviceData);
    } // end postpaid top up

    /**
     * @param $myReferNumber
     *
     * @return Resource\ApiResponse
     */
    public function checkOrder($myReferNumber)
    {
        $serviceData = [
            'RefNumber' => $myReferNumber
        ];

        return $this->httpClient->request(ApiAction::CHECK_ORDER, $serviceData);
    } // end check order

    /**
     * @return Resource\ApiResponse
     */
    public function getBalance()
    {
        return $this->httpClient->request(ApiAction::GET_BALANCE, []);
    } // end get balance

} // end class
