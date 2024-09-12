<?php

require_once 'functions.php';

if (!empty($_POST)) {
    $title = $_POST['title'] ?? '';
    $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_INT);

    $db = connect();

    if (empty($_POST['id'])) {
        try {
            $createTierStmt = $db->prepare('INSERT INTO tiers (title,price) VALUES (:title, :price)');
            $createTierStmt->execute(['title'=>$title , 'price'=>$price]);
            if ($createTierStmt->rowCount()) {
                $type = 'success';
                $message = 'Tier added';
            } else {
                $type = 'error';
                $message = 'Tier not added';
            }
        } catch (Exception $e) {
            $type = 'error';
            $message = 'Exception message: ' . $e->getMessage();
        }
    } else {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

        try {
            $updateTierStmt = $db->prepare('UPDATE tiers SET title= :title, price = :price WHERE id = :id');
           $updateTierStmt->execute(['title'=>$title, 'price'=>$price, 'id'=>$id]);
            if ($updateTierStmt->rowCount()) {
                $type = 'success';
                $message = 'Tier updated';
            } else {
                $type = 'error';
                $message = 'Tier not updated';
            }
        } catch (Exception $e) {
            $type = 'error';
            $message = 'Tier not updated: ' . $e->getMessage();
        }
    }
    $createTierStmt = null;
    $updateTierStmt = null;
    $db = null;

    header('location:' . 'tiers.php?type=' . $type . '&message=' . $message);
}
