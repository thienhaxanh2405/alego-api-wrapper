<?php

namespace AlegoApiWrapper\Connection;

use AlegoApiWrapper\Constant\Api;
use AlegoApiWrapper\Constant\ApiAction;
use AlegoApiWrapper\Contract\IApiRequest;
use AlegoApiWrapper\Contract\IAuth;
use AlegoApiWrapper\Contract\IHttpClient;
use AlegoApiWrapper\Message\Message;
use AlegoApiWrapper\Resource\ApiRequest;
use AlegoApiWrapper\Resource\ApiResponse;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client as GuzzleClient;

/**
 * Class HttpClient
 *
 * @package AlegoApiWrapper\Connection
 */
class HttpClient implements IHttpClient
{
    /** @var string $apiBaseUrl */
    private $apiBaseUrl;

    /** @var IApiRequest $apiRequest */
    private $apiRequest;

    /** @var array $sentData the data for api */
    private $sentData;

    private $isDebug;

    /**
     * Follow the action, validate service data passed
     *
     * @param string $action
     * @param array  $serviceData
     *
     * @return bool
     */
    private function validateData($action, $serviceData)
    {
        switch ($action) {
            case ApiAction::BUY_PREPAID_CARD :
                if (
                    isset($serviceData['ProductCode'])
                    && isset($serviceData['RefNumber'])
                    && isset($serviceData['Telco'])
                    && isset($serviceData['Type'])
                    && isset($serviceData['CardPrice'])
                    && isset($serviceData['CardQuantity'])
                ) {
                    return true;
                }
                break;
            case ApiAction::PREPAID_TOPUP :
            case ApiAction::POSTPAID_TOPUP :
                if (
                    isset($serviceData['ProductCode'])
                    && isset($serviceData['RefNumber'])
                    && isset($serviceData['Telco'])
                    && isset($serviceData['Type'])
                    && isset($serviceData['CardPrice'])
                    && isset($serviceData['CardQuantity'])
                    && isset($serviceData['CustMobile'])
                ) {
                    return true;
                }
                break;
            case ApiAction::CHECK_ORDER :
                if (
                    isset($serviceData['RefNumber'])
                ) {
                    return true;
                }
                break;
            case ApiAction::GET_BALANCE :
                return true;
            default :
        }

        return false;
    } // end validate data

    /**
     * Prepare and map data for api calls
     *
     * @param string $action
     * @param array  $serviceData
     *
     * @throws \Exception
     */
    private function prepareSentData($action, $serviceData = [])
    {
        // function
        switch ($action) {
            case ApiAction::BUY_PREPAID_CARD:
                $this->apiRequest->setFunction(Api::FUNCTION_BUY_PREPAID_CARD);
                break;
            case ApiAction::POSTPAID_TOPUP:
                $this->apiRequest->setFunction(Api::FUNCTION_POSTPAID_TOPUP);
                break;
            case ApiAction::PREPAID_TOPUP:
                $this->apiRequest->setFunction(Api::FUNCTION_PREPAID_TOPUP);
                break;
            case ApiAction::CHECK_ORDER:
                $this->apiRequest->setFunction(Api::FUNCTION_CHECK_ORDER);
                break;
            case ApiAction::GET_BALANCE:
                $this->apiRequest->setFunction(Api::FUNCTION_GET_BALANCE);
                break;
            default:
                throw new \Exception("Prepare data fail with wrong action");
        }

        // encrypt data
        $encryptData = RequestData::encrypt(json_encode($serviceData));
        $this->apiRequest->setEncryptData($encryptData);

        // check sum data
        $this->apiRequest->setCheckSum(
            md5 (
                $this->apiRequest->getFunction() .
                $this->apiRequest->getVersion() .
                $this->apiRequest->getAgentId() .
                $this->apiRequest->getAccountId() .
                $encryptData .
                $this->apiRequest->getKeyCheckSum()
            )
        );

        // map data and assign to sent data
        $this->sentData = $this->apiRequest->mapData();
    } // end prepare data

    /**
     *
     * @param array  $sentData
     *
     * @return string
     * @throws \Exception
     */
    private function send($sentData = [])
    {
        if ($sentData) {
            $this->sentData = $sentData;
        }

        $guzzleClient = new GuzzleClient(['base_uri' => $this->apiBaseUrl]);

        try {
            $response = $guzzleClient->request(
                "POST",
                "",
                ['json' => $this->sentData]
            );

            if ($response->getStatusCode() == 200) {
                return $response->getBody()->getContents();
            } else {
                throw new \Exception("Response with error. Code=".$response->getStatusCode());
            }
        } catch (RequestException $e) {
            throw new \Exception("Fail to call api: ".$e->getMessage());
        }
    } // end send

    /**
     * Call API use pure Curl
     *
     * @param array $sentData
     *
     * @return mixed
     */
    private function sendUseCURL($sentData = [])
    {
        if ($sentData) {
            $this->sentData = $sentData;
        }

        // request header
        $headers = ['Content-Type: application/json; charset=UTF-8'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiBaseUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->sentData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);

        return $result;
    } // end send use curl

    /**
     * @param string $url
     */
    public function setAPIBaseUrl($url)
    {
        $this->apiBaseUrl = $url;
    }

    /**
     * @param IApiRequest $apiRequest
     */
    public function setApiRequest(IApiRequest $apiRequest)
    {
        $this->apiRequest = $apiRequest;
    }

    /**
     * @return mixed
     */
    public function getIsDebug()
    {
        return $this->isDebug;
    }

    /**
     * @param mixed $isDebug
     */
    public function setIsDebug($isDebug)
    {
        $this->isDebug = $isDebug;
    }



    /**
     * @param string $action
     * @param array  $serviceData
     *
     * @return ApiResponse
     */
    public function request($action, $serviceData = [])
    {
        $res = new ApiResponse();
        if ($this->validateData($action, $serviceData)) {
            try {
                // prepare data
                $this->prepareSentData($action, $serviceData);

                // call api
                $raw = $this->sendUseCURL();

                // process response
                $res->processData($action, $raw);

                if ($this->isDebug === true) {
                    echo "<pre>";
                    print("Service data: ");
                    var_dump($serviceData);

                    print("\nAPI Data before sent: ");
                    var_dump($this->sentData);

                    print("\nRaw data: ");
                    var_dump($raw);
                    print("Het raw data");

                    print("\nAPI Response: ");
                    var_dump($res);

                    print("Message: ".$res->getMessage());
                }
            } catch (\Exception $e) {
                $res->setMessageCode(Message::CALL_API_WITH_ERROR);
                $res->setMessage(Message::getMessage(Message::CALL_API_WITH_ERROR).": ".$e->getMessage());
            }
        } else {
            $res->setMessageCode(Message::MISSING_PARAMS);
            $res->setMessage(Message::getMessage(Message::MISSING_PARAMS));
        }

        return $res;
    } // end response

    /**
     * HttpClient constructor.
     *
     * @param IAuth  $auth
     * @param string $apiBaseUrl
     */
    public function __construct(IAuth $auth, $apiBaseUrl = "")
    {
        if ($apiBaseUrl) {
            $this->apiBaseUrl = $apiBaseUrl;
        }

        // just get account info and set into api request
        $this->apiRequest = new ApiRequest(
            [
                'agentId' => $auth->getAgentId(),
                'accountId' => $auth->getAccountId(),
                'keyCheckSum' => $auth->getKeyMD5(),
                'version' => Api::VERSION,
            ]
        );

        $this->isDebug = true;
    } // end construct

} // end class
