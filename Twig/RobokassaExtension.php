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

    private $options = array();

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

    public function createFormView($orderId, $outSum, $options = array())
    {
        $this->resolveOptions($options);

        $template = $this->twig->loadTemplate($this->options['template']);
        $form = $this->provider->createForm($orderId, $outSum, $this->options);

        return $template->render(array('form' => $form->createView()));
    }

    protected function resolveOptions($options = array())
    {
        if (@$options['template']) {
           $this->options['template'] = $options['template'];
        } else {
            $this->options['template'] = "jh9RobokassaBundle:Twig:payForm.html.twig";
        }

        if (@$options['Encoding']) {
            $this->options['Encoding'] = $options['Encoding'];
        } else {
            $this->options['Encoding'] = 'utf-8';
        }

        if (@$options['IncCurrLabel']) {
            $this->options['IncCurrLabel'] = $options['IncCurrLabel'];
        }

        if (@$options['Desc']) {
            $this->options['Desc'] = $options['Desc'];
        }

    }
}