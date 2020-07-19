<?php

class Connection
{
    private $dbms = 'mysql';

    private $host = 'localhost';
    private $port = '3308';
    private $dbname = 'ATF';
    private $user = 'root';
    private $pass = '';

    protected $con;

    function __construct(){
        //DEVUELVE LA CONEXION LISTA PARA HACER LAS CONSULTAS
        $this->con = new PDO("$this->dbms:host=$this->host;port=$this->port;dbname=$this->dbname", $this->user, $this->pass);
    }
}