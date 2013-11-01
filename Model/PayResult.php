<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 31.10.13
 * Time: 16:12
 */

namespace jh9\RobokassaBundle\Model;


use jh9\RobokassaBundle\Manager\RobokassaManager;

class PayResult
{
    const TYPE_RESULT   = 1;

    const TYPE_REDIRECT  = 2;

    protected $OutSum = 0;

    protected $InvId = 0;

    protected $SignatureValue = 0;

    protected $type;

    /** @var RobokassaManager */
    protected $manager;

    protected $culture;

    function __construct($InvId, $OutSum, $SignatureValue, $type, $manager, $Culture)
    {
        $this->InvId = $InvId;
        $this->OutSum = $OutSum;
        $this->SignatureValue = $SignatureValue;
        $this->type = $type;
        $this->manager = $manager;
        $this->culture = $Culture;
    }

    /**
     * @return int
     */
    public function getInvId()
    {
        return $this->InvId;
    }

    /**
     * @return int
     */
    public function getOutSum()
    {
        return $this->OutSum;
    }

    /**
     * @return int
     */
    public function getSignatureValue()
    {
        return $this->SignatureValue;
    }

    public function isValid()
    {
        return $this->manager->isValid($this);
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getCulture()
    {
        return $this->culture;
    }





}