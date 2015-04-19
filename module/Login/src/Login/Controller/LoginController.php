<?php
/**
 * Created by PhpStorm.
 * User: gmeyenberg
 * Date: 13.04.2015
 * Time: 17:43
 */

namespace Login\Controller;


use Login\Model\User;
use Zend\Mvc\Controller\AbstractActionController;
use Login\Form\LoginForm;



class LoginController extends AbstractActionController
{

    public function loginAction()
    {

        if(User::isLogin()){
            return $this->redirect()->toRoute('shop');
        }

        $form = new LoginForm();
        $error=false;

        $request = $this->getRequest();
        if($request->isPost()){
            $user = new User();
            $form->setInputFilter($user->getInputFilter());
            $form->setData($request->getPost());
            if($form->isValid()) {
                $user->exchangeArray($form->getData());
                if ($user->exists()) {
                    $user->login();
                    return $this->redirect()->toRoute('shop');
                }
                $error=true;
            }
        }
        return array('form' => $form,'error'=> $error);

    }
}