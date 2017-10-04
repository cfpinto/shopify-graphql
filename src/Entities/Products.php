<?php
/**
 * Created by PhpStorm.
 * User: claudiopinto
 * Date: 02/10/2017
 * Time: 16:03
 */

namespace Shopify\Entities;

use Shopify\GraphQL\Shop;

class Products extends EntityInterface
{
    protected $shop = null;

    /**
     * Products constructor.
     */
    public function __construct()
    {
        $this->shop = new Shop();
    }

    /**
     * TODO: implementation
     *
     * @return string
     */
    public function create(): string
    {

    }

    /**
     * Get products
     *
     * @param int $limit
     * @param int $variations
     * @param int $images
     *
     * @return string
     */
    public function read($limit = 2, $variations = 0, $images = 0): string
    {
        $this
            ->shop
                ->products(['first' => $limit])
                    ->edges
                        ->node
                            ->use('id', 'handle', 'onlineStoreUrl', 'productType', 'title', 'vendor', 'description', 'descriptionHtml', 'tags', 'createdAt', 'updatedAt')
                            ->images(['first' => $images])
                                ->edges
                                    ->node
                                        ->use('id', 'altText', 'src')
                                    ->prev()
                                ->prev()
                            ->prev()
                            ->variants(['first' => $variations])
                                ->edges
                                    ->node
                                        ->use('id', 'availableForSale', 'price', 'title', 'weight', 'weightUnit')
                                        ->selectedOptions
                                            ->use('name', 'value')
                                        ->prev()
                                        ->image
                                            ->use('id', 'altText', 'src');

        return $this->shop->query();
    }

    /**
     * TODO: implementation
     *
     * @return string
     */
    public function update(): string
    {

    }

    /**
     * TODO: implementation
     *
     * @return string
     */
    public function delete(): string
    {

    }
}