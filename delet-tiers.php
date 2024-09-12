<?php
require_once 'functions.php';

if (isset($_GET['id'])) {

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    try {

        $db = connect();

        $tierQuery = $db->prepare('SELECT * FROM members WHERE tier_id = :id');
        $tierQuery->execute(['id' => $id]);
        $tier = $tierQuery->fetch(PDO::FETCH_ASSOC);
        if ($tier) {
            $type = 'error';
            $message = 'Tier cannot be deleted because a user is on the tier';
        } else {

            $deleteTierStmt = $db->prepare('DELETE FROM tiers WHERE id = :id');
            $deleteTierStmt->execute(['id'=>$id]);
            if ($deleteTierStmt->rowCount()) {
                $type = 'success';
                $message = 'Tier deleted';
            } else {
                $type = 'error';
                $message = 'Tier not deleted';
            }
        }
    } catch (Exception $e) {
        $type = 'error';
        $message = 'Exception message: ' . $e->getMessage();
    }
    $tierQuery = null;
    $deleteTierStmt = null;
    $db = null;

    header('location:' . 'tiers.php?type=' . $type . '&message=' . $message);
} else {
    header('location:' . 'index.php');
}
