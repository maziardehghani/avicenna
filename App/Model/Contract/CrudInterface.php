<?php

namespace App\Model\Contract;

interface CrudInterface
{
    public function create(array $data):array;

    public function update(array $data, array $where):int;

    public function find($id):object;

    public function get(array $columns, array $where):array;

    public function delete(array $where):int;
}