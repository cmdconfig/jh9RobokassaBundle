<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 31.10.13
 * Time: 15:51
 */

namespace jh9\RobokassaBundle\Model;


interface RobokassaFormProviderInterface
{
    /**
     * @return Form
     */
    function createForm($orderId, $outSum, $options);
} 