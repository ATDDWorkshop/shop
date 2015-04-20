<?php
/**
 * Created by PhpStorm.
 * User: gmeyenberg
 * Date: 13.04.2015
 * Time: 18:15
 */

namespace Shop\Model;


use Zend\Http\Request;
use Zend\Http\Client;
use Zend\Session\Container;


class User
{
    public $id;
    public $revenue;


    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->revenue = (!empty($data['revenue'])) ? $data['revenue'] : null;
    }


    public function addRevenue($price)
    {
        $this->revenue += $price;

        $request = new Request();
        $request->getHeaders()->addHeaders(array(
            'Content-Type' => 'application/json',
            'Accept' => '*/*'
        ));
        $request->setUri("http://datawarehouse/user/" . $this->id);
        $request->setMethod('PUT');
        $request->setContent(
            json_encode(
                array(
                    "revenue" => $this->revenue,
                )
            )
        );
        $client = new Client();
        $response = $client->dispatch($request);
        if ($response->getStatusCode() == 200) {
            return true;
        }
        return false;

    }

    //--- Service Method --
    public static function currentUser()
    {
        $userSession = new Container('user');

        $request = new Request();
        $request->getHeaders()->addHeaders(array(
            'Content-Type' => 'application/json',
            'Accept' => '*/*'
        ));
        $request->setUri("http://datawarehouse/user/" . $userSession->id);
        $request->setMethod('GET');
        $client = new Client();
        $response = $client->dispatch($request);
        $data = json_decode($response->getBody(), true);


        $userObj = new User();
        $userObj->exchangeArray($data);

        return $userObj;
    }

}