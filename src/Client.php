<?php
namespace AlegoApiWrapper;

use AlegoApiWrapper\Connection\HttpClient;
use AlegoApiWrapper\Constant\AlegoTransactionType;
use AlegoApiWrapper\Constant\Api;
use AlegoApiWrapper\Constant\ApiAction;
use AlegoApiWrapper\Contract\IAuth;
use AlegoApiWrapper\Contract\IClient;
use AlegoApiWrapper\Contract\IHttpClient;
use AlegoApiWrapper\Resource\BuyPrepaidCard;

class Client implements IClient
{
    private $httpClient;

    /**
     * Create new Client object
     *
     * @param IAuth $account
     * @param bool  $isDevelopment
     *
     * @return Client
     */
    public static function createClient(IAuth $account, $isDevelopment = false)
    {
        if ($isDevelopment) {
            return new self(new HttpClient($account, Api::DEVELOPMENT_BASE_URL));
        } else {
            return new self(new HttpClient($account, Api::BASE_URL));
        }

    } // end create client

    public function __construct(IHttpClient $httpRequest)
    {
        $this->httpClient = $httpRequest;

    } // end class

    /**
     * @param BuyPrepaidCard $card
     *
     * @return mixed
     */
    public function buyPrepaidCard(BuyPrepaidCard $card)
    {
        $serviceData = [
            'ProductCode' => $card->getProductCode(),
            'RefNumber' => $card->getReferNumber(),
            'Telco' => $card->getTelco(),
            'Type' => AlegoTransactionType::BUY_PREPAID_CARD,
            'CardPrice' => $card->getCardPrice(),
            'CardQuantity' => $card->getCardQuantity(),
        ];

        return $this->httpClient->request(ApiAction::BUY_PREPAID_CARD, $serviceData);
    } // end buy card

    public function prepaidTopUp(BuyPrepaidCard $card)
    {
        $serviceData = [
            'ProductCode' => $card->getProductCode(),
            'RefNumber' => $card->getReferNumber(),
            'Telco' => $card->getTelco(),
            'Type' => AlegoTransactionType::TOPUP_PREPAID,
            'CardPrice' => $card->getCardPrice(),
            'CardQuantity' => 1,
            'CustMobile' => $card->getCustomerCellphone()
        ];

        return $this->httpClient->request(ApiAction::PREPAID_TOPUP, $serviceData);
    } // end prepaid top up

    public function postpaidTopUp(BuyPrepaidCard $card)
    {
        $serviceData = [
            'ProductCode' => $card->getProductCode(),
            'RefNumber' => $card->getReferNumber(),
            'Telco' => $card->getTelco(),
            'Type' => AlegoTransactionType::TOPUP_POSTPAID,
            'CardPrice' => $card->getCardPrice(),
            'CardQuantity' => 1,
            'CustMobile' => $card->getCustomerCellphone()
        ];

        return $this->httpClient->request(ApiAction::POSTPAID_TOPUP, $serviceData);
    } // end postpaid top up

    public function checkOrder($myReferNumber)
    {
        $serviceData = [
            'RefNumber' => $myReferNumber
        ];

        return $this->httpClient->request(ApiAction::CHECK_ORDER, $serviceData);
    }

    public function getBalance()
    {

        return $this->httpClient->request(ApiAction::GET_BALANCE, []);
    }

} // end class
