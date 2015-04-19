<?php
/**
 * Created by PhpStorm.
 * User: gregor
 * Date: 18.04.15
 * Time: 09:38
 */

namespace Shop\Model;

use Zend\Http\Request;
use Zend\Http\Client;

class PackageTable {

    protected $packages;

    public function fetchAll(){

        if (!$this->packages) {
            $packages = array();
            $request = new Request();
            $request->getHeaders()->addHeaders(array(
                'Content-Type' => 'application/json',
                'Accept' => '*/*'
            ));
            $request->setUri("http://datawarehouse/package");
            $request->setMethod('GET');
            $client = new Client();
            $response = $client->dispatch($request);
            $data = json_decode($response->getBody(), true);

            foreach ($data["_embedded"]["package"] as $package) {
                $packageObj = new Package();
                $packageObj->exchangeArray($package);
                array_push($packages, $packageObj);
            }
            $this->packages=$packages;
        }
        return $this->packages;
    }

    public function fetch($id){
        $request = new Request();
        $request->getHeaders()->addHeaders(array(
            'Content-Type' => 'application/json',
            'Accept' => '*/*'
        ));
        $request->setUri("http://datawarehouse/package/".$id);
        $request->setMethod('GET');
        $client = new Client();
        $response = $client->dispatch($request);
        $data = json_decode($response->getBody(), true);

        $packageObj=new Package();
        $packageObj->exchangeArray($data);

        return $packageObj;
    }

}