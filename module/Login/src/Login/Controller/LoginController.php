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


        $error=false;
        $request = $this->getRequest();

        /**
         * @var \Login\Form\LoginForm $form
         */
        $form=$this->getServiceLocator()->get('FormElementManager')->get('LoginForm');

        if($request->isPost()){
            $form->setData($request->getPost());
            if($form->isValid()) {
                $user=$form->getObject();
                
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