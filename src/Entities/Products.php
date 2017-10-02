<?php
/**
 * Created by PhpStorm.
 * User: claudiopinto
 * Date: 02/10/2017
 * Time: 16:03
 */

namespace Shopify\Entities;

class Products extends EntityInterface
{
    public function create()
    {
        return $this->shop;
    }

    public function read()
    {
        $this
            ->shop
                ->products(['first' => '2'])
                    ->edges
                        ->node
                            ->use('id')
                                ->variants(['first' => '2'])
                                    ->edges
                                        ->node
                                            ->use('id');
        return $this->shop->query();
    }

    public function update()
    {

    }

    public function delete()
    {

    }
}