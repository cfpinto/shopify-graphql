<?php
/**
 * Created by PhpStorm.
 * User: claudiopinto
 * Date: 04/10/2017
 * Time: 18:01
 */

namespace Shopify\GraphQL;

use GraphQL\Graph;

class Node extends Graph
{
    /**
     * Node constructor.
     *
     * @param array|null $properties
     */
    public function __construct(array $properties = null)
    {
        parent::__construct('node', $properties);
    }
}