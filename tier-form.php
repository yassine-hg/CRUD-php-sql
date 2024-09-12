<?php

require_once 'functions.php';

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    try {
        $db = connect();

        $tierQuery = $db->prepare('SELECT * FROM tiers WHERE id = :id');
        $tierQuery->execute(['id'=> $id]);
        $tier = $tierQuery->fetch(PDO::FETCH_ASSOC);
        $db = null;
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    
}

$tiers = getTiers();

?>

<?php require_once '_header.php' ?>

<a href='index.php' class='btn btn-secondary m-2 active' role='button'>Home</a>
<a href='tiers.php' class='btn btn-secondary m-2 active' role='button'>Tiers</a>

<div class='row'>
    <h1 class='col-md-12 text-center border border-dark bg-primary text-white'>Tier Form</h1>
</div>
<div class='row'>
    <form method='post' action='add-edit-tier.php'>
        <input type='hidden' name='id' value='<?= $tier['id'] ?? '' ?>'>
        <div class='form-group my-3'>
            <label for='firstName'>Title</label>
            <input type='text' name='title' class='form-control' id='title' placeholder='Enter title' required autofocus value='<?= isset($tier['title']) ? htmlentities($tier['title']) : '' ?>'>
        </div>
        <div class='form-group my-3'>
            <label for='price'>Price</label>
            <input type='number' name='price' class='form-control' id='price' placeholder='Enter price' required value='<?= isset($tier['price']) ? htmlentities($tier['price'])  : '' ?>'>
        </div>
        <button type='submit' class='btn btn-primary my-3' name='submit'>Submit</button>
    </form>
</div>

<?php require_once '_footer.php' ?>
