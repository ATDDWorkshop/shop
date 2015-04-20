<?php
/**
 * Created by PhpStorm.
 * User: gmeyenberg
 * Date: 13.04.2015
 * Time: 18:15
 */

namespace Shop\Model;


class Package
{
    public $id;
    public $name;
    public $price;


    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
        $this->price = (!empty($data['price'])) ? $data['price'] : null;
    }


}