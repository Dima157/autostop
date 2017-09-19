<?php
abstract class Model{
    protected $pdo;

    function __construct()
    {
        $this->pdo = DB::PDO();
    }
}