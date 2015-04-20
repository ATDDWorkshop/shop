<?php
/**
 * Created by PhpStorm.
 * User: gmeyenberg
 * Date: 13.04.2015
 * Time: 18:15
 */

namespace Login\Model;


use Zend\Http\Request;
use Zend\Http\Client;
use Zend\Stdlib\Parameters;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

use Zend\Session\Container; // We need this when using sessions

class User implements InputFilterAwareInterface
{
    private $id;

    private $name;
    private $password;

    protected $inputFilter;

   public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id=$id;
    }


    public function getPassword(){
        return $this->password;
    }


    public function setPassword($password){
        $this->password=$password;
    }

    public function getName(){
        return $this->name;
    }


    public function setName($name){
       $this->name=$name;
    }



    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function exists(){
        $request = new Request();
        $request->getHeaders()->addHeaders(array(
            'Content-Type' => 'application/json',
            'Accept'=>'*/*'
        ));
        $request->setUri("http://datawarehouse/user?name=".$this->name."&password=".$this->password);
        $request->setMethod('GET');
        $client = new Client();
        $response = $client->dispatch($request);
        $data = json_decode($response->getBody(), true);

        if($data["total_items"]==1){
            $this->id=$data["_embedded"]["user"][0]["id"];
            return true;
        }

        return false;
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name'     => 'name',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'not_empty')
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'password',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'not_empty')
                ),
            ));

            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }

    public function login(){
        $userSession = new Container('user');
        $userSession->id=$this->id;
    }


    //------ service methods -----
    public static function isLogin(){
        $userSession = new Container('user');
        if($userSession->id){
            return true;
        }else{
            return false;
        }
    }



}