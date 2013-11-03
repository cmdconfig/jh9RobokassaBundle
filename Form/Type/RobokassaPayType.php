<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 31.10.13
 * Time: 9:55
 */

namespace jh9\RobokassaBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RobokassaPayType extends AbstractType
{
    public function getName()
    {
        return '';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('MrchLogin', 'hidden')
            ->add('OutSum', 'hidden')
            ->add('InvId', 'hidden')
            ->add('SignatureValue', 'hidden')
        ;
    }


} 