<?php

$currentPage = $this->e($page);

$isLoggedIn = false;
if (isset($_SESSION["isLoggedIn"])) $isLoggedIn = $_SESSION["isLoggedIn"];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$this->e($title)?></title>
    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</head>
<body>

<!-- header -->
<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-5">
    <div class="container-fluid px-5">
        <a class="navbar-brand" href="/">Contact Book</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= ($currentPage == 'index') ? 'active' : ''; ?>"
                       aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($currentPage == 'about') ? 'active' : ''; ?>" href="/about">About</a>
                </li>
            </ul>
            <div>
                <?= ($isLoggedIn) ?
                    '<a href="/dashboard" class="px-4 btn btn-dark">Dashboard</a>
                    <a href="/logout" class="btn btn-danger px-4">Logout</a>'
                    :
                    '<a href="/register" class="px-4 btn btn-dark">Register</a>
                    <a href="/login" class="btn btn-success px-4">Login</a>'
                ; ?>

            </div>
        </div>
    </div>
</nav>

<div class="container">
    <?=$this->section('content')?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>