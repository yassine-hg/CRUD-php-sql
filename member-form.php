<?php

require_once 'functions.php';

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    try {
        $db = connect();

        $memberQuery = $db->prepare('SELECT * FROM members WHERE id = :id');
        $memberQuery->execute(['id'=>$id]);
        $member = $memberQuery->fetch(PDO::FETCH_ASSOC);
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
    <h1 class='col-md-12 text-center border border-dark bg-primary text-white'>Member Form</h1>
</div>
<div class='row'>
    <form method='post' action='add-edit-member.php'>
        <input type='hidden' name='id' value='<?= $member['id'] ?? '' ?>'>
        <div class='form-group my-3'>
            <label for='firstName'>First name</label>
            <input type='text' name='first_name' class='form-control' id='firstName' placeholder='Enter first name' required autofocus value='<?= isset($member['first_name']) ? htmlentities($member['first_name']) : '' ?>'>
        </div>
        <div class='form-group my-3'>
            <label for='lastName'>Last name</label>
            <input type='text' name='last_name' class='form-control' id='lastName' placeholder='Enter last name' required value='<?= isset($member['last_name']) ? htmlentities($member['last_name'])  : '' ?>'>
        </div>
        <div class='form-group my-3'>
            <label for='address'>Address</label>
            <input type='text' name='address' class='form-control' id='address' placeholder='Enter address' required value='<?= isset($member['address']) ? htmlentities($member['address']) : '' ?>'>
        </div>
        <div class='form-group my-3'>
            <label for='address'>Membership Tier:</label>
            <select class='custom-select' name='tier_id'>
                <?php foreach ($tiers as $tier) : ?>
                    <option <?= (!empty($member['tier_id']) && $member['tier_id'] == $tier['id']) ? 'selected' : '' ?> value='<?= $tier['id'] ?>'>
                        <?= htmlentities($tier['title']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type='submit' class='btn btn-primary my-3' name='submit'>Submit</button>
    </form>
</div>

<?php require_once '_footer.php' ?>
