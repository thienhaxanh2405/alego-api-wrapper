<?php
namespace AlegoApiWrapper\Resource;

use AlegoApiWrapper\Constant\ApiAction;
use AlegoApiWrapper\Contract\IApiResponse;
use AlegoApiWrapper\Message\Message;
use AlegoApiWrapper\Connection\RequestData;

class ApiResponse extends Resource implements
    IApiResponse
{
    private $rawData;

    /** @var string $tripleKey use for decrypt return data */
    private $tripleKey;

    private $message;

    private $messageCode;

    /** @var mixed|CardResult|Balance.... $result card result or some needed objects in future - i guess */
    private $result;

    /**
     * @param $alegoTime
     *
     * @return false|int
     */
    private function convertToTimeStamp($alegoTime)
    {
        return strtotime($alegoTime);
    } // end convert to time stamp

    /**
     * Convert array card after json decode from EncData to Array needed card object
     *
     * @param string $apiAction
     * @param array $arrayCard card info after json decode from EncData
     *
     * @return array card object
     */
    private function processCards($apiAction, $arrayCard)
    {
        $cards = [];
        if ($apiAction == ApiAction::BUY_PREPAID_CARD) {
            if ($arrayCard) {
                foreach ($arrayCard as $one) {
                    $cards[] = new PrepaidCard(
                        [
                            'code' => $one['card_code'],
                            'serial' => $one['card_serial'],
                            'expirationDate' => $one['expiration_date']
                        ]
                    );
                }
            }
        } elseif ($apiAction == ApiAction::BUY_GAME_CARD) {
            // todo update on next versions
        } elseif ($apiAction == ApiAction::BUY_BATTLE_NET_CARD) {
            // todo update on next versions
        } else {
            // do nothing
        }

        return $cards;
    } // end process cards

    /**
     * Process result for $this->>result
     *
     * @param string $apiAction
     * @param array $decryptData
     *
     * @return mixed|CardResult|Balance
     * @throws \Exception
     */
    private function processResult($apiAction, $decryptData)
    {
        switch ($apiAction) {
            // todo update Buy prepaid visa; Buy battle net card; Buy game card on next version
            case ApiAction::BUY_PREPAID_CARD:
            case ApiAction::PREPAID_TOPUP:
            case ApiAction::POSTPAID_TOPUP:
            case ApiAction::BUY_GAME_CARD:
            case ApiAction::CHECK_ORDER:
                $result = new CardResult(
                    [
                        'referOrder' => $decryptData['RefNumber'],
                        'productCode' => $decryptData['ProductCode'],
                        'alegoTransactionId' => $decryptData['TransID'],
                        'time' => $this->convertToTimeStamp($decryptData['TransDate']),
                        'responseType' => $decryptData['ResType'],
                        'cardQuantity' => $decryptData['CardQuantity'],
                        'cards' => $this->processCards($apiAction, $decryptData['CardInfo']),
                    ]
                );
                break;
            case ApiAction::GET_BALANCE :
                $result = new Balance(
                    [
                        'balance' => $decryptData['balance'],
                        'availableBalance' => $decryptData['available_balance'],
                        'frozenBalance' => $decryptData['frozen_amount'],
                    ]
                );
                break;
            default:
                throw new \Exception("Api action invalid to process return result");
        } // end switch

        return $result;
    } // end process card

    /**
     * Unset triple key
     */
    private function unsetTripeKey()
    {
        unset($this->tripleKey);
    }

    /**
     * Process all properties of ApiResponse
     *
     * @param string $apiAction refer to ApiAction
     * @param null $rawData
     *
     */
    public function processData($apiAction, $rawData = null)
    {
        // assign if need
        if ($rawData !== null) {
            $this->rawData = $rawData;
        }

        $jsonDecodeRawData = json_decode($this->rawData, true);
        if ($jsonDecodeRawData) {
            if ($jsonDecodeRawData['RespCode'] == "00") {
                // decrypt
                $decryptData = json_decode(
                    RequestData::decrypt($jsonDecodeRawData['EncData'], $this->tripleKey),
                    true
                );

                if ($decryptData) {
                    try {
                        $this->result = $this->processResult($apiAction, $decryptData);

                        $this->messageCode = Message::SUCCESS;
                        $this->message = Message::getMessage(Message::SUCCESS);
                    } catch (\Exception $e) {
                        $this->messageCode = Message::ALEGO_RESPONSE_WITH_ERROR;
                        $this->message = "Prcess result fail: ".$e->getMessage();
                    }
                } else {
                    $this->messageCode = Message::INVALID_JSON;
                    $this->message = Message::getMessage(Message::INVALID_JSON).": Result card";
                }
            } else {
                $this->messageCode = Message::ALEGO_RESPONSE_WITH_ERROR;
                $this->message = Message::getMessage(Message::ALEGO_RESPONSE_WITH_ERROR)
                    .": "
                    .Message::getAlegoMessage($jsonDecodeRawData['RespCode']);
            }
        } else {
            $this->messageCode = Message::INVALID_JSON;
            $this->message = Message::getMessage(Message::INVALID_JSON).": Raw data";
        }

        // after this point, triple key no longer to be used
        $this->unsetTripeKey();
    } // end process raw data

    /**
     * ApiResponse constructor.
     *
     * @param string $rawData
     * @param null   $resources
     */
    public function __construct($rawData = "", $resources = null)
    {
        parent::__construct($resources);

        if ($rawData) {
            $this->setRawData($rawData);
        }
    } // end construct

    /**
     * ApiResponse destruct
     */
    public function __destruct()
    {
        // unset keyStripe
        $this->unsetTripeKey();
    } // end destruct

    /**
     * @param string $rawData
     */
    public function setRawData($rawData)
    {
        $this->rawData = $rawData;
    } // end set raw data

    public function getRawData()
    {
        return $this->rawData;
    } // end get raw data

    /**
     * @param string $keyTriple
     */
    public function setTripleKey($keyTriple)
    {
        $this->tripleKey = $keyTriple;
    } // end get raw data

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    } // end set message

    /**
     * @param int $code
     */
    public function setMessageCode($code)
    {
        $this->messageCode = $code;
    } // end set message code

    /**
     * @param $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    } // end set result

    public function getMessage()
    {
        return $this->message;
    }

    public function getMessageCode()
    {
        return $this->messageCode;
    }

    public function getResult()
    {
        return $this->result;
    }

} // end class
