<?php
namespace AlegoApiWrapper\Resource;

class CardResult extends Resource
{
    /** @var int $productCode Alego product code */
    private $productCode;

    /** @var string $referOrder refer transaction or order in your system */
    private $referOrder;

    /** @var string $alegoTransactionId Alego transaction id */
    private $alegoTransactionId;

    /** @var int $time transaction time on Alego, in timestamp */
    private $time;

    /** @var int $responseType Alego return result through 1 - email; 2 - directly in api */
    private $responseType;

    /** @var int $cardQuantity */
    private $cardQuantity;

    /** @var mixed|PrepaidCard[]|... array cards */
    private $cards;

    /**
     * CardResult constructor.
     *
     * @param null $resources
     */
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
    public function getReferOrder()
    {
        return $this->referOrder;
    }

    /**
     * @param mixed $referOrder
     */
    public function setReferOrder($referOrder)
    {
        $this->referOrder = $referOrder;
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
