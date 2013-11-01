RobokassaBundle
===============

current version supports only POST methods

does not support currency...yet

does not support another properties

Installation
------------

```bash
php composer.phar require jh9/robokassa-bundle
```

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new jh9\RobokassaBundle\jh9RobokassaBundle(),

    );
}
```

```yaml
# app/config/config.yml
jh9_robokassa:
    login: %login%
    password1: %password1%
    password2: %password2%
    test: %test% # default to true
```


Usage
-----

in your template (to generate the "pay" button):

```jinja
#pay_order.html.twig
    {{ jh9_robokassa_form(order.id, order.price) }}
```

in your result action:

```php
    /**
     * @Route("/ResultUrl")
     * @Methods({"POST"})
     */
    public function resultAction(Request $request)
    {
        $manager = $this->get('jh9.robokassa.manager');
        $result = $manager->handleResult($request);

        if ($result->isValid()) {
            // ...

            // your success logic, such as set your order as paid
            /*
                $em = $this->get('doctrine.orm.default_entity_manager');
                $order = $em->find('jh9ShopProductBundle:Order', $result->getInvId());
                if (! $order) {
                    return $this->createNotFoundException();
                }
                $order->setStatus(OrderTypes::STATUS_PAYED);
             */
            return new Response();
        } else {
            return new Response('Not valid', 500);
        }
    }
```

in your success action you can do:

```php
    /**
     * @Route("/SuccessUrl")
     * @Methods({"POST"})
     */
    public function robokassaSuccessAction(Request $request)
    {
        $manager = $this->get('jh9.robokassa.manager');
        $payResult = $manager->handleSuccess($request);
        if (! $payResult->isValid()) {
            return new Response('not valid', 400);
        }
        return new Response(
            "Your order with id = " . $payResult->getInvId() . " is paid" .
             " , amount = " $payResult->getOutSum() .
            " your language is" . $payResult->getCulture()
        );
    }
```

in your fail action:

```php
    /**
     * @Route("/payment/fail")
     * @Methods({"POST"})
     */
    public function robokassaFailAction(Request $request)
    {
        $payResult = $this->get('jh9.robokassa.manager')->handleFail($request);

        return new Response(
            " Your order with id " . $payResult->getInvId() . " is not paid" .
            " amount: " . $payResult->getOutSum()
        );
    }
```


