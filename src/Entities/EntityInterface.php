<?php
/**
 * Created by PhpStorm.
 * User: claudiopinto
 * Date: 02/10/2017
 * Time: 16:05
 */

namespace Shopify\Entities;


use Shopify\GraphQL\Shop;

abstract class EntityInterface
{
    protected $shop;

    final public function __construct()
    {
        $this->shop = new Shop();
    }

    abstract public function create();
    abstract public function read();
    abstract public function update();
    abstract public function delete();
}