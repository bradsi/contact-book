<?php
$this->layout('layout', [
    'title' => 'Login | Contact Book',
    'page' => 'login'
]);
?>
<div class="w-50 mx-auto">
    <h1 class="mb-4">Login</h1>

    <?php if (isset($error)) :?>
    <div class="alert alert-danger">
        <?= $this->e($error); ?>
    </div>
    <?php endif ;?>

    <form action="/?action=loginUser" method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-success" name="login">Login</button>
    </form>
</div>