<?php

class mysqlAction extends baseAction
{
    public function Get()
    {
        $pdo = @new PDO("mysql:host=172.17.0.10;dbname=chxRoute_dev;port=3306","developer","developer_online",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",PDO::ATTR_PERSISTENT=>false));

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $pdo->query("select * from admin_user where username='wangmeng' limit 1");
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        var_dump($data);
    }
}
