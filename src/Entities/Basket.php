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
        $this->testIsValidItemArrayForAdd($items);

        $basket = new Mutation('checkoutCreate', ['input' => [
            'lineItems' => $items
        ]]);

        // @formatter:off
        $basket
            ->userErrors
                ->use('field', 'message')
            ->prev()
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
                        ->use('id', 'quantity')
                            ->variant
                            ->use('id');
        // @formatter:on

        return $node->query();
    }

    /**
     * Add items to basket
     *
     * @param null  $id
     * @param array $items
     *
     * @return string
     */
    public function add($id = null, $items = []): string
    {
        $this->testNotEmpty('$id', $id);
        $this->testIsValidItemArrayForAdd($items);

        $params = [
            'lineItems' => $items,
            'checkoutId' => $id,
        ];

        $basket = new Mutation('checkoutLineItemsAdd', $params);

        // @formatter:off
        $basket
            ->userErrors
                ->use('field', 'message')
            ->prev()
            ->checkout
                ->use('id', 'webUrl')
                ->lineItems(['first'=>50])
                    ->edges
                        ->node
                        ->use('id', 'quantity')
                            ->variant
                            ->use('id');
        // @formatter:on
        return $basket->query();
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
        $this->testIsValidItemArrayForUpdate($items);

        $params = [
            'lineItems' => $items,
            'checkoutId' => $id,
        ];

        $basket = new Mutation('checkoutLineItemsUpdate', $params);

        // @formatter:off
        $basket
            ->userErrors
                ->use('field', 'message')
            ->prev()
            ->checkout
                ->use('id', 'webUrl')
                ->lineItems(['first'=>50])
                    ->edges
                        ->node
                        ->use('id', 'quantity')
                            ->variant
                            ->use('id');
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
        $this->testNotEmpty('$id', $id);
        
        $basket = new Mutation('checkoutLineItemsRemove', [
            'checkoutId' => $id,
            'lineItemIds' => $itemIDs
        ]);

        // @formatter:off
        $basket
            ->userErrors
                ->use('field', 'message')
            ->prev()
            ->checkout
                    ->use('id', 'webUrl')
                    ->lineItems(['first'=>50])
                        ->edges
                            ->node
                            ->use('id', 'quantity')
                                ->variant
                                ->use('id');

        // @formatter:on

        return $basket->query();
    }

    /**
     * Test if a array of variants is valid for add submission
     *
     * @param array $items
     *
     * @throws Exception
     */
    private function testIsValidItemArrayForAdd(array $items)
    {
        return $this->testIsValidItemArray($items, ['variantId', 'quantity']);
    }

    /**
     * Test if a array of variants is valid for update submission
     *
     * @param array $items
     *
     * @throws Exception
     */
    private function testIsValidItemArrayForUpdate(array $items)
    {
        return $this->testIsValidItemArray($items, ['id', 'quantity']);
    }

    /**
     * Test if a array of variants is valid for submission
     *
     * @param array $items
     * @param array $allowed
     *
     * @throws Exception
     */
    private function testIsValidItemArray(array $items, array $allowed)
    {
        foreach ($items as $item) {
            if (! empty(array_diff(array_keys($item), $allowed))) {
                throw new Exception('Invalid item object ' . json_encode($item));
            }
        }
    }

}
