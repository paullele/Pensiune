<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 02/05/17
 * Time: 18:00
 */

class ConnectionController {

    private static $db = null;

    private static function createConnection() {

        if(self::$db == null) {
            self::$db = mysqli_connect('localhost', 'root', '', 'pension_database');
        }

        return self::$db;
    }

    public static function getConnection() {
        return self::createConnection();
    }
} 