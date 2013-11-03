<?php

/**
 * @author j Alex
 * Date: 31.10.13
 * Time: 15:48
 */

namespace jh9\RobokassaBundle\Manager;

use jh9\RobokassaBundle\Form\Type\RobokassaPayType;
use jh9\RobokassaBundle\Model\PayModel;
use jh9\RobokassaBundle\Model\PayResult;
use jh9\RobokassaBundle\Model\RobokassaConst;
use jh9\RobokassaBundle\Model\RobokassaFormProviderInterface;
use jh9\RobokassaBundle\Model\RobokassaResultProcessorInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class RobokassaManager implements RobokassaFormProviderInterface, RobokassaResultProcessorInterface
{
    const RequestTemplate  = "%mrh_login%:%out_summ%:%inv_id%:%mrh_pass1%";

    const ResponseTemplate =  "%out_summ%:%inv_id%:%mrh_pass2%";

    private $factory;

    private $test;

    private $login;

    private $password1;

    private $password2;

    public function __construct($login, $password1, $password2, $test, FormFactory $factory)
    {
        $this->login     = $login;
        $this->factory   = $factory;
        $this->test      = $test;
        $this->password1 = $password1;
        $this->password2 = $password2;
    }

    public function createForm($orderId, $outSum, $options)
    {
        $model = new PayModel();
        $model->setMrchLogin($this->login)
            ->setInvId((int) $orderId)
            ->setOutSum($outSum)
            ->setPassword1($this->password1)
        ;
        $this->generateRequestSignature($model);

        $form = $this->factory->create(new RobokassaPayType(), $model, array('action' => $this->_generateUrl()));

        $this->resolveOptions($form, $options, $model);

        return $form;
    }

    protected function resolveOptions(FormInterface $form, $options, PayModel $pm)
    {
        if (@$options['Encoding']) {
            $pm->setEncoding($options['Encoding']);
            $form->add('Encoding', 'hidden');
        }
        if (@$options['Desc']) {
            $pm->setDesc($options['Desc']);
            $form->add('Desc', 'hidden');
        }
        if (@ $options['IncCurrLabel']) {
            $pm->setIncCurrLabel($options['IncCurrLabel']);
            $form->add('IncCurrLabel', 'hidden');
        }
    }

    private function generateRequestSignature(PayModel $pm)
    {
        $pm->setSignatureValue(md5(preg_replace(
            array("/%mrh_login%/", "/%out_summ%/", "/%inv_id%/",  "/%mrh_pass1%/"),
            array($pm->getMrchLogin(), $pm->getOutSum(), $pm->getInvId(), $this->password1),
            static::RequestTemplate
        )));
    }

    private function generateResponseSignature(PayResult $pr)
    {
        if ($pr->getType() == PayResult::TYPE_REDIRECT ) {$pas = $this->password1;}
        else {$pas = $this->password2;}

        return strtoupper(md5(preg_replace(
            array("/%out_summ%/", "/%inv_id%/", "/%mrh_pass2%/"),
            array($pr->getOutSum(), $pr->getInvId(), $pas),
            static::ResponseTemplate
        )));
    }

    private function _generateUrl()
    {
        if ($this->test) {
            return RobokassaConst::testUrl;
        } else {
            return RobokassaConst::url;
        }
    }

    /**
     * @param Request $request
     * @return PayResult
     */
    function handleResult(Request $request)
    {
        return new PayResult($request->get('InvId'),
            $request->get('OutSum'),
            $request->get('SignatureValue'),
            PayResult::TYPE_RESULT,
            $this,
            $request->get('Culture')
        );
    }

    public function handleSuccess(Request $request)
    {
        return new PayResult($request->get('InvId'),
            $request->get('OutSum'),
            $request->get('SignatureValue'),
            PayResult::TYPE_REDIRECT,
            $this,
            $request->get('Culture')
        );
    }

    public function handleFail(Request $request)
    {
        return $this->handleSuccess($request);
    }

    public function isValid(PayResult $result)
    {
        return strtoupper($result->getSignatureValue()) == $this->generateResponseSignature($result);
    }
}