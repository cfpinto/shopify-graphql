<?php
/**
 * Created by PhpStorm.
 * User: claudiopinto
 * Date: 02/10/2017
 * Time: 16:05
 */

namespace Shopify\Entities;

use GraphQL\Exception;

abstract class EntityInterface
{
    /**
     * Generates query to create a new instance in the remote GraphQL
     *
     * @return string
     */
    abstract public function create(): string ;

    /**
     * Generates query to retrieve entities from remote GraphQL
     *
     * @return string
     */
    abstract public function read(): string ;

    /**
     * Generates query to update an instance in the remote GraphQL
     *
     * @return string
     */
    abstract public function update(): string ;

    /**
     * Generates query to delete an instance from the remote GraphQL
     *
     * @return string
     */
    abstract public function delete(): string ;

    /**
     * Test if a given value is not empty.
     * Exception thrown uses $key in message.
     *
     * @param      $key
     * @param null $value
     *
     * @throws Exception
     */
    protected function testNotEmpty($key, $value = null)
    {
        if (empty($value)) {
            throw new Exception("Value of {$key} must be provided");
        }
    }
}