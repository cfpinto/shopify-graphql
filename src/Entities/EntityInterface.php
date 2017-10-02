<?php
/**
 * Created by PhpStorm.
 * User: claudiopinto
 * Date: 02/10/2017
 * Time: 16:05
 */

namespace Shopify\Entities;


interface EntityInterface
{
    public function create();
    public function read();
    public function update();
    public function delete();
}