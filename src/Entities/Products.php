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

    public function read($limit = 2, $variations = 0)
    {

        /*
query {
  shop {
    products(first: 2) {
      edges {
        node {
          id
          handle
          onlineStoreUrl
          productType
          title
          vendor
          description
          descriptionHtml
          tags
          images(first: 10) {
            edges {
              node {
                id
                altText
                src
              }
            }
          }
          variants(first: 10) {
            edges {
              node {
                id,
                availableForSale
                price
                title
                weight
                weightUnit
                selectedOptions {
                  name
                  value
                }
                image {
                  id
                  altText
                  src
                }
              }
            }
          }
          createdAt
          updatedAt
        }
      }
    }
  }
}         *
         */
        $products = $this
            ->shop
            ->products(['first' => $limit]);

        $node = $products
            ->edges
            ->node
            ->use('id', 'handle', 'onlineStoreUrl', 'productType', 'title', 'vendor', 'description', 'descriptionHtml', 'tags', 'createdAt', 'updatedAt');

        $node->images(['first' => 10])
            ->edges
            ->node
            ->use('id', 'altText', 'src');

        if ($variations) {
            $variation = $node->variants(['first' => $variations])
                ->edges
                ->node
                ->use('id', 'availableForSale', 'price', 'title', 'weight', 'weightUnit');

            $variation->selectedOptions->use('name', 'value');
            $variation->image->user('id', 'altText', 'src');
        }
        return $this->shop->query();
    }

    public function update()
    {

    }

    public function delete()
    {

    }
}