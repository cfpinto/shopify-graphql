<?php
/**
 * Created by PhpStorm.
 * User: claudiopinto
 * Date: 03/10/2017
 * Time: 14:28
 */

namespace Shopify\Entities;


use GraphQL\Exception;
use GraphQL\Mutation;
use Shopify\GraphQL\Node;

class Basket extends EntityInterface
{

    /**
     * Create a new shopping basket
     *
     * @param array $items
     *
     * @return string
     */
    public function create($items = []): string
    {
        $this->testIsValidItemArray($items);

        $basket = new Mutation('checkoutCreate', ['input' => [
            'lineItems' => $items
        ]]);

        // @formatter:off
        $basket
                ->checkout
                    ->use('id', 'webUrl')
                    ->lineItems(['first'=>50])
                        ->edges
                            ->node
                            ->use('id', 'title', 'quantity');

        // @formatter:on
        return $basket->query();
    }

    /**
     * Retrieve a basket by id
     *
     * @param null $id
     *
     * @return string
     */
    public function read($id = null): string
    {
        $this->testNotEmpty('$id', $id);

        $node = new Node(['id' => $id]);

        // @formatter:off
        $node->use('id')
            ->on('Checkout')
                ->use('id', 'webUrl')
                ->lineItems(['first'=>50])
                    ->edges
                        ->node
                        ->use('title', 'quantity');
        // @formatter:on

        return $node->query();
    }

    /**
     * Add items to basket
     *
     * @param null  $id
     * @param array $items
     *
     * @return $this
     */
    public function add($id = null, $items = []): string
    {

        $this->testNotEmpty('$id', $id);
        $this->testIsValidItemArray($items);

        $params = [
            'lineItems' => $items,
            'checkoutId' => $id,
        ];

        $basket = new Mutation('checkoutLineItemsAdd', $params);

        // @formatter:off
        $basket->checkout
                ->use('id', 'webUrl')
                ->lineItems(['first'=>50])
                    ->edges
                        ->node
                        ->use('id', 'title', 'quantity');
        // @formatter:on
        return $this->query();
    }

    /**
     * Update basket items
     *
     * @param null  $id
     * @param array $items
     *
     * @return $this
     */
    public function update($id = null, $items = []): string
    {
        $this->testNotEmpty('$id', $id);
        $this->testNotEmpty('$items', $items);
        $this->testIsValidItemArray($items);

        $params = [
            'lineItems' => $items,
            'checkoutId' => $id,
        ];

        $basket = new Mutation('checkoutLineItemsUpdate', $params);

        // @formatter:off
        $basket->checkout
                ->use('id', 'webUrl')
                ->lineItems(['first'=>50])
                    ->edges
                        ->node
                        ->use('id', 'title', 'quantity');
        // @formatter:on
        return $basket->query();
    }

    /**
     * Remove items from basket
     *
     * @param null  $id
     * @param array $itemIDs
     *
     * @return string
     */
    public function delete($id = null, $itemIDs = []): string
    {
        $this->testNotEmpty('$itemIds', $itemIDs);
        $this->testNotEmpty('$id');

        $basket = new Mutation('checkoutLineItemsRemove', [
            'checkoutId' => $id,
            'lineItemIds' => $itemIDs
        ]);

        // @formatter:off
        $basket
                ->checkout
                    ->use('id', 'webUrl')
                    ->lineItems(['first'=>50])
                        ->edges
                            ->node
                            ->use('id', 'title', 'quantity');

        // @formatter:on

        return $basket->query();
    }

    /**
     * Test if a array of variants is valid for submission
     *
     * @param $items
     *
     * @throws Exception
     */
    private function testIsValidItemArray($items)
    {
        foreach ($items as $item) {
            if (array_keys($item) != ['variantId', 'quantity']) {
                throw new Exception('Invalid item object ' . json_encode($item) . ' item should only contain keys variantId and quantity');
            }
        }
    }

}