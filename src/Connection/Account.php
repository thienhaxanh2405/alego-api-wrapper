<?php
namespace AlegoApiWrapper\Connection;

use AlegoApiWrapper\Contract\IAuth;
use AlegoApiWrapper\Resource\Resource;

class Account extends Resource implements IAuth
{
    private $agentId;

    private $accountId;

    private $keyMD5;

    private $tripleKey;

    /**
     * Account constructor.
     *
     * @param null $resources
     */
    public function __construct($resources = null)
    {
        parent::__construct($resources);
    } // end construct

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
    public function getKeyMD5()
    {
        return $this->keyMD5;
    }

    /**
     * @param mixed $keyMD5
     */
    public function setKeyMD5($keyMD5)
    {
        $this->keyMD5 = $keyMD5;
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

} // end class
