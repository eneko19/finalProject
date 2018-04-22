<?php

class Connection {

    private static $con;
    private static $server = 'localhost';
    private static $username = 'user';
    private static $password = 'user';
    private static $database = 'gestor_incidencias';
    private static $instance = NULL;

    // Getters and  Setters

    static function getServer() {
        return self::$server;
    }

    static function getUsername() {
        return self::$username;
    }

    static function getDatabase() {
        return self::$database;
    }

    static function getPassword() {
        return self::$password;
    }

    static function setServer($server) {
        self::$server = "p:".$server;
    }

    static function setUsername($username) {
        self::$username = $username;
    }

    static function setDatabase($database) {
        self::$database = $database;
    }

    static function setPassword($password) {
        self::$password = $password;
    }

    // Constructor

    private function __construct() {

    }

    // Functions

    function getMysqliObject(){
        return self::$con;
    }

    public function doQuery($query){
        return self::$con->query($query);
    }


    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public static function connect() {

        try {
            $con = mysqli_connect(self::getInstance()->getServer(), self::getInstance()->getUsername(), self::getInstance()->getPassword(), self::getInstance()->getDatabase());
            $con->set_charset("UTF8");
            if ($con->connect_errno) {
                echo "Conexión fallida:" . $con->connect_error;
                exit();
            }
        } catch (Exception $e) {

            die("Error" . $e->getMessage());
            echo "Línea del error" . $e->getLine();
        }
        self::$con = $con;
        return $con;
    }

    public static function disconnect() {
        self::$con->close();
    }

}
