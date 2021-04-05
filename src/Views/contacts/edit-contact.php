<?php
$this->layout('layout', [
    'title' => 'Edit Contact | Contact Book',
    'page' => 'edit-contact'
]);
?>

<a href="/dashboard" class="text-decoration-none">< Go Back</a>
<h1 class="mb-5">Edit Contact: <?= $this->e($fName) . ' ' . $this->e($lName) ?></h1>

<form class="w-75 ml-auto" action="/?action=editContact" method="post">
    <div class="mb-3">
        <label for="fName" class="form-label">First Name</label>
        <input type="text" class="form-control" id="fName" name="fName">
    </div>
    <div class="mb-3">
        <label for="lName" class="form-label">Last Name</label>
        <input type="text" class="form-control" id="lName" name="lName">
    </div>
    <input type="number" name="contactId" hidden value="<?= $this->e($id) ?>">
    <button type="submit" name="editContact" class="btn btn-primary">Edit</button>
</form>