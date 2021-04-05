<?php
$this->layout('layout', [
    'title' => 'New Contact | Contact Book',
    'page' => 'new-contact'
]);
?>

<a href="/dashboard" class="text-decoration-none">< Go Back</a>
<h1 class="mb-5">Add New Contact</h1>

<form class="w-75 ml-auto" action="/?action=newContact" method="post">
    <div class="mb-3">
        <label for="fName" class="form-label">First Name</label>
        <input type="text" class="form-control" id="fName" name="fName">
    </div>
    <div class="mb-3">
        <label for="lName" class="form-label">Last Name</label>
        <input type="text" class="form-control" id="lName" name="lName">
    </div>
    <button type="submit" name="newContact" class="btn btn-success">Create</button>
</form>