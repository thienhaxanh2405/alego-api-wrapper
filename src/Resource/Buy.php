<?php
namespace AlegoApiWrapper\Resource;

class Buy extends Resource
{
    /** @var string $productCode Alego product code */
    private $productCode;

    /** @var string $referOrder The unique string or id of your system refer to Alego transaction */
    private $referOrder;

    /**
     * In case buy prepaid card or topup
     *
     * @var string $telco The carrier code, refer to \AlegoAPIWrapper\Constant\Telco
     * VTT: Viettel
     * VMS: MobiFone
     * VNP: VinaPhone
     * VNM: VietnamMobile
     * GTEL: Gmobile
     * SFONE: Sfone */
    private $telco;

    /** @var string $type TOPUP, TOPUP_AFTER, PINCODE; in case buy prepaid card or topup */
    private $type;

    /** @var int $cardPrice prepaid mobile, visa, game card */
    private $cardPrice;

    /** @var int $cardQuantity quantity of card need to buy */
    private $cardQuantity;

    /** @var string $customerCellphone customer cellphone */
    private $customerCellphone;

    /** @var string $customerName In case buy prepaid visa card */
    private $customerName;

    /** @var string $customerBirthday customer date of birth in Y-m-d */
    private $customerBirthday;

    /** @var string $customerId Personal identify or passport number */
    private $customerId;

    /** @var string $customerAddress customer address */
    private $customerAddress;

    /** @var string $customerEmail customer email */
    private $customerEmail;

    /** @var string $customerIpAddress IPv4 address */
    private $customerIpAddress;

    /** @var int $customerGender 1 - male; 2 - female */
    private $customerGender;

    /**
     * Buy constructor.
     *
     * @param null $params
     */
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
     * @return string
     */
    public function getReferOrder()
    {
        return $this->referOrder;
    }

    /**
     * @param string $referOrder
     */
    public function setReferOrder($referOrder)
    {
        $this->referOrder = $referOrder;
    }

    /**
     * @return string
     */
    public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * @param string $customerName
     */
    public function setCustomerName($customerName)
    {
        $this->customerName = $customerName;
    }

    /**
     * @return string
     */
    public function getCustomerBirthday()
    {
        return $this->customerBirthday;
    }

    /**
     * @param string $customerBirthday
     */
    public function setCustomerBirthday($customerBirthday)
    {
        $this->customerBirthday = $customerBirthday;
    }

    /**
     * @return string
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @param string $customerId
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
    }

    /**
     * @return string
     */
    public function getCustomerAddress()
    {
        return $this->customerAddress;
    }

    /**
     * @param string $customerAddress
     */
    public function setCustomerAddress($customerAddress)
    {
        $this->customerAddress = $customerAddress;
    }

    /**
     * @return string
     */
    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

    /**
     * @param string $customerEmail
     */
    public function setCustomerEmail($customerEmail)
    {
        $this->customerEmail = $customerEmail;
    }

    /**
     * @return string
     */
    public function getCustomerIpAddress()
    {
        return $this->customerIpAddress;
    }

    /**
     * @param string $customerIpAddress
     */
    public function setCustomerIpAddress($customerIpAddress)
    {
        $this->customerIpAddress = $customerIpAddress;
    }

    /**
     * @return int
     */
    public function getCustomerGender()
    {
        return $this->customerGender;
    }

    /**
     * @param int $customerGender
     */
    public function setCustomerGender($customerGender)
    {
        $this->customerGender = $customerGender;
    }

} // end class
