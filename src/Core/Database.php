<?php

namespace Snowdog\DevTest\Core;

class Database
{
    /** @var \PDO */
    protected $pdo = null;

    public function __call($name, array $arguments)
    {
        if (!$this->pdo) {
            $this->init();
        }
        return call_user_func_array([$this->pdo, $name], $arguments);
    }

    private function init()
    {
        if (file_exists(__DIR__ . '/../../conf.ini')) {
            $config = parse_ini_file(__DIR__ . '/../../conf.ini');
            $hostName = isset($config['hostname']) ? $config['hostname'] : 'localhost';
            $dbName = isset($config['db_name']) ? $config['db_name'] : 'dev_test';
            $user = isset($config['user']) ? $config['user'] : 'root';
            $password = isset($config['password']) ? $config['password'] : '';
            $pdo = new \PDO('mysql:host=' . $hostName . ';dbname=' . $dbName . ';charset=utf8mb4', $user, $password);
            $this->pdo = $pdo;
        } else {
            throw new \PDOException('Database connection not configured, check conf.ini file');
        }
    }

    public function persistConnectionSettings($hostName, $dbName, $user, $password)
    {
        $data = [
            'hostname=' . $hostName,
            'db_name=' . $dbName,
            'user=' . $user,
            'password=' . $password
        ];
        $data = implode("\n", $data);
        file_put_contents(__DIR__ . '/../../conf.ini', $data);
        $this->init();
    }

}