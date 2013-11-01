<?php
/**
 * Created by PhpStorm.
 * User: jh
 * Date: 31.10.13
 * Time: 11:43
 */

namespace jh9\RobokassaBundle\Twig;


use jh9\RobokassaBundle\Model\RobokassaFormProviderInterface;

class RobokassaExtension extends \Twig_Extension
{
    private $twig;

    private $provider;

    function __construct(\Twig_Environment $twig, RobokassaFormProviderInterface $formProvider)
    {
        $this->twig = $twig;
        $this->provider = $formProvider;
    }

    public function getName()
    {
        return "jh9_robokassa_extension";
    }

    public function getFunctions()
    {
        return array(
            'jh9_robokassa_form' => new \Twig_Function_Function(array($this, 'createFormView'), array('is_safe' => array('html')))
        );
    }

    public function createFormView($orderId, $outSum, $template = "jh9RobokassaBundle:Twig:payForm.html.twig")
    {
        $template = $this->twig->loadTemplate($template);
        $form = $this->provider->createForm($orderId, $outSum);
        return $template->render(array('form' => $form->createView()));
    }



}