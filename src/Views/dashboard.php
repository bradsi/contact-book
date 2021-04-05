<?php
$this->layout('layout', [
    'title' => 'Dashboard | Contact Book',
    'page' => 'dashboard'
]);
?>

<h1>Dashboard</h1>
<p>Welcome to your dashboard <?=$this->e($name)?></p>

<button type="button" class="btn btn-success mb-5">
    <a href="/new-contact" class="text-decoration-none text-white">Add Contact</a>
</button>