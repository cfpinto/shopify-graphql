<?php
/**
 * Created by PhpStorm.
 * User: claudiopinto
 * Date: 02/10/2017
 * Time: 16:00
 */

namespace Shopify;


class Shop
{

    private $key;

    private $domain;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param $key
     *
     * @return Shop
     */
    public function setKey($key): Shop
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @param $domain
     *
     * @return Shop
     */
    public function setDomain($domain): Shop
    {
        $this->domain = $domain;
        return $this;
    }

    /**
     * Shop constructor.
     *
     * @param $domain
     * @param $key
     */
    public function __construct($domain, $key)
    {
        $this->setKey($key)
            ->setDomain($domain);
    }
}