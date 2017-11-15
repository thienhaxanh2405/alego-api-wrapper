<?php
namespace AlegoApiWrapper\Resource;

class CardResult extends Resource
{
    private $productCode;

    private $referNumber;

    private $alegoTransactionId;

    private $time;

    private $responseType;

    private $cardQuantity;

    private $cards;

    public function __construct($resources = null)
    {
        parent::__construct($resources);
    }

    /**
     * @return mixed
     */
    public function getProductCode()
    {
        return $this->productCode;
    }

    /**
     * @param mixed $productCode
     */
    public function setProductCode($productCode)
    {
        $this->productCode = $productCode;
    }

    /**
     * @return mixed
     */
    public function getReferNumber()
    {
        return $this->referNumber;
    }

    /**
     * @param mixed $referNumber
     */
    public function setReferNumber($referNumber)
    {
        $this->referNumber = $referNumber;
    }

    /**
     * @return mixed
     */
    public function getAlegoTransactionId()
    {
        return $this->alegoTransactionId;
    }

    /**
     * @param mixed $alegoTransactionId
     */
    public function setAlegoTransactionId($alegoTransactionId)
    {
        $this->alegoTransactionId = $alegoTransactionId;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @return mixed
     */
    public function getResponseType()
    {
        return $this->responseType;
    }

    /**
     * @param mixed $responseType
     */
    public function setResponseType($responseType)
    {
        $this->responseType = $responseType;
    }

    /**
     * @return mixed
     */
    public function getCardQuantity()
    {
        return $this->cardQuantity;
    }

    /**
     * @param mixed $cardQuantity
     */
    public function setCardQuantity($cardQuantity)
    {
        $this->cardQuantity = $cardQuantity;
    }

    /**
     * @return mixed
     */
    public function getCards()
    {
        return $this->cards;
    }

    /**
     * @param mixed $cards
     */
    public function setCards($cards)
    {
        $this->cards = $cards;
    }


} // end class
