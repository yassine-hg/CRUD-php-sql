<?php

require_once 'functions.php';

if (!empty($_POST)) {
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $address = $_POST['address'] ?? '';
    $tier_id = filter_input(INPUT_POST, 'tier_id', FILTER_SANITIZE_NUMBER_INT);

    $db = connect();

    if (empty($_POST['id'])) {
         try {
            $createMemberStmt = $db->prepare('INSERT INTO members (first_name, last_name, address, tier_id) VALUES (:first_name, :last_name, :address, :tier_id)');
            $createMemberStmt->execute(
              ['first_name'=>$first_name,
                'last_name'=>$last_name,
                'address'=>$address,
                'tier_id'=>$tier_id 
            ]);
            if ($createMemberStmt->rowCount()) {
                $type = 'success';
                $message = 'Member added';
            } else {
                $type = 'error';
                $message = 'Member not added';
            }
        } catch (Exception $e) {
            $type = 'error';
            $message = 'Member not added: ' . $e->getMessage();
        }
    } else {

        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

        try {
            $updateMemberStmt = $db->prepare('UPDATE members SET first_name = :first_name, last_name= :last_name, address= :address, tier_id= :tier_id WHERE id= :id');
            $updateMemberStmt->execute([
              'first_name'=>$first_name,
              'last_name'=>$last_name,
              'address'=>$address,
              'tier_id'=>$tier_id,
              'id'=>$id
              ]);
            if ($updateMemberStmt->rowCount()) {
                $type = 'success';
                $message = 'Member updated';
            } else {
                $type = 'error';
                $message = 'Member not updated';
            }
        } catch (Exception $e) {
            $type = 'error';
            $message = 'Member not updated: ' . $e->getMessage();
        }
    }

    $createMemberStmt = null;
    $updateMemberStmt = null;
    $db = null;

    header('location:' . 'members.php?type=' . $type . '&message=' . $message);
}
