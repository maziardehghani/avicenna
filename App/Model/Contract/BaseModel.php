<?php

namespace App\Model\Contract;

abstract class BaseModel implements CrudInterface
{
    protected $connection;
    protected $table;
    protected $primaryKey = 'id';
    protected $attributes = [];

    protected function __construct()
    {

    }

    public function getAttribute($key)
    {
        if (!$key || !array_key_exists($key, $this->attributes)) {
            return null;
        }

        return $this->attributes[$key];
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function __get($key)
    {
        return $this->getAttribute($key);
    }

}