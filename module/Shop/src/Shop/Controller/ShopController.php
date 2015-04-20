<?php
/**
 * Created by PhpStorm.
 * User: gmeyenberg
 * Date: 13.04.2015
 * Time: 17:43
 */

namespace Shop\Controller;


use Login\Model\User;
use Shop\Model\User as ShopUser;
use Shop\Model\PackageTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\Mvc\MvcEvent;


class ShopController extends AbstractActionController
{

    private $packageTable;



    public function onDispatch(MvcEvent $e){
        if(!User::isLogin()){
            $this->redirect()->toUrl("/");
        }
       return parent::onDispatch($e);
    }

    protected function getPackageTable(){
        if(!$this->packageTable){
            $this->packageTable=new PackageTable();
        }
        return $this->packageTable;
    }



    public function indexAction()
    {

        return new ViewModel(array(
            'packages' => $this->getPackageTable()->fetchAll(),
        ));
    }

    public function buyAction()
    {
        $package=$this->getPackageTable()->fetch($this->params("id"));
        if(ShopUser::currentUser()->addRevenue($package->price)) {
            $view = new ViewModel(array(
                'packages' => $this->getPackageTable()->fetchAll(),
                'buy' => true
            ));
            $view->setTemplate('shop/shop/index.phtml'); // path to phtml file under view folder
            return $view;
        }
        return "error";
    }



}