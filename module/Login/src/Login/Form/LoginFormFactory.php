<?php
/**
 * Created by PhpStorm.
 * User: gregor
 * Date: 20.04.15
 * Time: 12:26
 */

namespace Login\Form;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Login\Model\User;
use Zend\Stdlib\Hydrator\ClassMethods;

class LoginFormFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new LoginForm();
        $user = new User();
        $form->setHydrator(new ClassMethods());
        $form->setInputFilter($user->getInputFilter());
        $form->setObject($user);


        return $form;
    }

}