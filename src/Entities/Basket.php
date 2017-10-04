<?php
/**
 * Created by PhpStorm.
 * User: claudiopinto
 * Date: 03/10/2017
 * Time: 14:28
 */

namespace Shopify\Entities;


class Basket extends EntityInterface
{

    public function create()
    {

    }

    public function read($id = null)
    {
        if (!$id) {
            $id = $this->create()->basket->id;
        }

        $this->shop
            ->checkout(['id' => $id])
            ->use('id', 'webUrl')
            ->lineItems(['first'=>'20'])
                ->edges
                ->node
                ->use('title', 'quantity');

    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }
}