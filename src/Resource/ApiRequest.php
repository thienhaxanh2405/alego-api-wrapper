<?php
namespace AlegoApiWrapper\Resource;

use AlegoApiWrapper\Contract\IApiRequest;

class ApiRequest extends Resource implements IApiRequest
{
    private $function;

    private $version;

    private $agentId;

    private $accountId;

    private $encryptData;

    private $checkSum;

    private $keyCheckSum;

    private $tripleKey;

    public function __construct($resources = null)
    {
        parent::__construct($resources);
    }

    /**
     * @return mixed
     */
    public function getFunction()
    {
        return $this->function;
    }

    /**
     * @param mixed $function
     */
    public function setFunction($function)
    {
        $this->function = $function;
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param mixed $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return mixed
     */
    public function getAgentId()
    {
        return $this->agentId;
    }

    /**
     * @param mixed $agentId
     */
    public function setAgentId($agentId)
    {
        $this->agentId = $agentId;
    }

    /**
     * @return mixed
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * @param mixed $accountId
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
    }

    /**
     * @return mixed
     */
    public function getEncryptData()
    {
        return $this->encryptData;
    }

    /**
     * @param mixed $encryptData
     */
    public function setEncryptData($encryptData)
    {
        $this->encryptData = $encryptData;
    }

    /**
     * @return mixed
     */
    public function getCheckSum()
    {
        return $this->checkSum;
    }

    /**
     * @param mixed $checkSum
     */
    public function setCheckSum($checkSum)
    {
        $this->checkSum = $checkSum;
    }

    /**
     * @return mixed
     */
    public function getKeyCheckSum()
    {
        return $this->keyCheckSum;
    }

    /**
     * @param mixed $keyCheckSum
     */
    public function setKeyCheckSum($keyCheckSum)
    {
        $this->keyCheckSum = $keyCheckSum;
    }

    /**
     * @return mixed
     */
    public function getTripleKey()
    {
        return $this->tripleKey;
    }

    /**
     * @param mixed $tripleKey
     */
    public function setTripleKey($tripleKey)
    {
        $this->tripleKey = $tripleKey;
    }

    public function mapData()
    {
        return [
            'Fnc' => $this->function,
            'Ver' => $this->version,
            'AgentID' => $this->agentId,
            'AccID' => $this->accountId,
            'EncData' => $this->encryptData,
            'Checksum' => $this->checkSum,
        ];
    } // end map data



} // end class
