<?php
require_once 'functions.php';

if (isset($_GET['id'])) {

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    try {
        $db = connect();

        $deleteMemberStmt = $db->prepare('DELETE FROM members WHERE id= :id');
        $deleteMemberStmt->execute(['id'=>$id]);
    
        if ($deleteMemberStmt->rowCount()) {
            $type = 'success';
            $message = 'Member deleted';
        } else {
            $type = 'error';
            $message = 'Member not deleted';
        }

    } catch (Exception $e) {
        $type = 'error';
        $message = 'Exception message: ' . $e->getMessage();
    }
    $deleteMemberStmt = null;
    $db = null;

    header('location:' . 'members.php?type=' . $type . '&message=' . $message);
} else {

  header('location:'. 'index.php');
}
