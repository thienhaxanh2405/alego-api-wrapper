<?php
namespace AlegoApiWrapper\Resource;

class BuyPrepaidCard extends Resource
{
    /** @var string $productCode ma dich vu */
    private $productCode;

    /** @var string $referNumber mã giao dịch trên hệ thông - alego transaction id */
    private $referNumber;

    /**
     * @var string $telco mã nhà mạng
     * VTT: Thẻ Viettel
     * VMS: Thẻ MobiFone
     * VNP: Thẻ VinaPhone
     * VNM: Thẻ VietnamMobile
     * GTEL: Thẻ Gmobile
     * SFONE: Thẻ Sfone */
    private $telco;

    /** @var string $type TOPUP, TOPUP_AFTER, PINCODE */
    private $type;

    /** @var string $customerCellphone số di dộng của khách hàng, số được nạp tiền */
    private $customerCellphone;

    /** @var int $cardPrice mệnh giá thẻ */
    private $cardPrice;

    /** @var int $cardQuantity số lượng thẻ mua */
    private $cardQuantity;

    public function __construct($params = null)
    {
        parent::__construct($params);
    }

    /**
     * @return string
     */
    public function getProductCode()
    {
        return $this->productCode;
    }

    /**
     * @param string $productCode
     */
    public function setProductCode($productCode)
    {
        $this->productCode = $productCode;
    }

    /**
     * @return string
     */
    public function getReferNumber()
    {
        return $this->referNumber;
    }

    /**
     * @param string $referNumber
     */
    public function setReferNumber($referNumber)
    {
        $this->referNumber = $referNumber;
    }

    /**
     * @return string
     */
    public function getTelco()
    {
        return $this->telco;
    }

    /**
     * @param string $telco
     */
    public function setTelco($telco)
    {
        $this->telco = $telco;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getCustomerCellphone()
    {
        return $this->customerCellphone;
    }

    /**
     * @param string $customerCellphone
     */
    public function setCustomerCellphone($customerCellphone)
    {
        $this->customerCellphone = $customerCellphone;
    }

    /**
     * @return int
     */
    public function getCardPrice()
    {
        return $this->cardPrice;
    }

    /**
     * @param int $cardPrice
     */
    public function setCardPrice($cardPrice)
    {
        $this->cardPrice = $cardPrice;
    }

    /**
     * @return int
     */
    public function getCardQuantity()
    {
        return $this->cardQuantity;
    }

    /**
     * @param int $cardQuantity
     */
    public function setCardQuantity($cardQuantity)
    {
        $this->cardQuantity = $cardQuantity;
    }

} // end class
