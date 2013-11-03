<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 31.10.13
 * Time: 11:44
 */

namespace jh9\RobokassaBundle\Model;


class PayModel
{
    protected $MrchLogin;

    protected $OutSum;

    protected $InvId;

    protected $Desc;

    protected $SignatureValue;

    protected $Encoding;

    protected $password1;

    protected $password2;

    protected $IncCurrLabel;

    /**
     * @param mixed $Desc
     */
    public function setDesc($Desc)
    {
        $this->Desc = $Desc;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDesc()
    {
        return $this->Desc;
    }

    /**
     * @param string $Encoding
     */
    public function setEncoding($Encoding)
    {
        $this->Encoding = $Encoding;
        return $this;
    }

    /**
     * @return string
     */
    public function getEncoding()
    {
        return $this->Encoding;
    }

    /**
     * @param mixed $InvId
     */
    public function setInvId($InvId)
    {
        $this->InvId = $InvId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInvId()
    {
        return $this->InvId;
    }

    /**
     * @param mixed $MrchLogin
     */
    public function setMrchLogin($MrchLogin)
    {
        $this->MrchLogin = $MrchLogin;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMrchLogin()
    {
        return $this->MrchLogin;
    }

    /**
     * @param mixed $OutSum
     */
    public function setOutSum($OutSum)
    {
        $this->OutSum = number_format($OutSum, 2);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOutSum()
    {
        return $this->OutSum;
    }

    /**
     * @param mixed $SignatureValue
     */
    public function setSignatureValue($SignatureValue)
    {
        $this->SignatureValue = $SignatureValue;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSignatureValue()
    {
        return $this->SignatureValue;
    }

    /**
     * @param mixed $password1
     */
    public function setPassword1($password1)
    {
        $this->password1 = $password1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword1()
    {
        return $this->password1;
    }

    /**
     * @param mixed $password2
     */
    public function setPassword2($password2)
    {
        $this->password2 = $password2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword2()
    {
        return $this->password2;
    }

    /**
     * @param mixed $IncCurrLabel
     */
    public function setIncCurrLabel($IncCurrLabel)
    {
        $this->IncCurrLabel = $IncCurrLabel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIncCurrLabel()
    {
        return $this->IncCurrLabel;
    }


} 