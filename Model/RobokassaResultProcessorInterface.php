<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 31.10.13
 * Time: 16:06
 */

namespace jh9\RobokassaBundle\Model;


use jh9\RobokassaBundle\Model\PayResult;
use Symfony\Component\HttpFoundation\Request;

interface RobokassaResultProcessorInterface
{
    /**
     * @param Request $request
     * @return PayResult
     */
    function handleResult(Request $request);

    function isValid(PayResult $result);

    function handleSuccess(Request $request);

    function handleFail(Request $request);
} 