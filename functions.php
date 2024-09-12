<?php

function connect() {
    $hostname = '/tmp';

    $dbname = 'ccuser';
    $username = 'ccuser';
    $password = 'pass';
    
    $dsn = "pgsql:host=$hostname;dbname=$dbname";

    try{
      $db = new PDO($dsn, $username, $password);
      return $db;
    }catch(Exception $e){
      echo $e->getMessage();
    }
}

function getTiers() {
    try {
        $db = connect();

        $tiersQuery = $db->query('SELECT * FROM tiers');
        $tiers = $tiersQuery->fetchAll(PDO::FETCH_ASSOC);
        return $tiers;
        
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
