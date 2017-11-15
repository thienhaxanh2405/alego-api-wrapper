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
     * Convert array card after json decode from EncData to Array PrepaidCard object
     *
     * @param string $apiAction
     * @param array $arrayCard
     *
     * @return array
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
        } else {
            // do something
        }

        return $cards;
    } // end process card

    /**
     * @param string $apiAction refer to ApiAction
     * @param null $rawData
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
                $decryptData = json_decode(RequestData::decrypt($jsonDecodeRawData['EncData']), true);

                if ($decryptData) {
                    $this->result = new CardResult(
                        [
                            'referNumber' => $decryptData['RefNumber'],
                            'productCode' => $decryptData['ProductCode'],
                            'alegoTransactionId' => $decryptData['TransID'],
                            'time' => $this->convertToTimeStamp($decryptData['TransDate']),
                            'responseType' => $decryptData['ResType'],
                            'cardQuantity' => $decryptData['CardQuantity'],
                            'cards' => $this->processCards($apiAction, $decryptData['CardInfo']),
                        ]
                    );
                    $this->messageCode = Message::SUCCESS;
                    $this->message = Message::getMessage(Message::SUCCESS);
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
     * @param string $rawData
     */
    public function setRawData($rawData)
    {
        $this->rawData = $rawData;
    } // end set raw data

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
