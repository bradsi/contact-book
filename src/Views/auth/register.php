<?php
$this->layout('layout', [
    'title' => 'Register | Contact Book',
    'page' => 'register'
]);
?>
<div class="w-50 mx-auto">
    <h1 class="mb-4">Register</h1>

    <?php if (isset($error)) :?>
        <div class="alert alert-danger">
            <?= $this->e($error); ?>
        </div>
    <?php endif ;?>

    <form action="/?action=registerNewUser" method="post">
        <div class="mb-3">
            <label for="fName" class="form-label">First Name</label>
            <input type="text" class="form-control" id="fName" name="fName">
        </div>
        <div class="mb-3">
            <label for="lName" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="lName" name="lName">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="mb-3">
            <label for="passwordConfirmation" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="passwordConfirmation" name="passwordConfirmation">
        </div>
        <button type="submit" class="btn btn-success" name="register">Register</button>
    </form>
</div>