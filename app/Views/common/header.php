<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- FONT AWESOME -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />

  <!-- JQUERY -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.3.js"></script>

  <!-- BOOTSTRAP 5 -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

  <!-- AJAX -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

  <!-- SELECT2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <!-- SWAL2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>

  <!-- OWN CSS AND JS -->
  <link rel="stylesheet" href="/assets/css/style.css">
  <script type="text/javascript" src="/assets/js/script_header.js"></script>
</head>

<body>

  <?php
  $uri = service('uri');
  ?>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/">
      <img src="/assets/SS-LOGO.png" alt="" width="120" height="auto" class="d-inline-block align-text-top">
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse collapse" id="navbarSupportedContent">
      <?php if (session()->get('isLoggedIn')) : ?>
        <ul class="navbar-nav mr-auto">
          <li class="nav-item <?= ($uri->getSegment(1) == 'dashboard' ? 'active' : null) ?>">
            <a class="nav-link" href="/dashboard">Dashboard</a>
          </li>
          <li class="nav-item <?= ($uri->getSegment(1) == 'profile' ? 'active' : null) ?>">
            <a class="nav-link" href="/profile">Profile</a>
          </li>
          <li class="nav-item <?= ($uri->getSegment(1) == 'staff' ? 'active' : null) ?>">
            <a class="nav-link" href="/staff">Staff List</a>
          </li>
          <li class="nav-item <?= ($uri->getSegment(1) == 'appointment' ? 'active' : null) ?>">
            <a class="nav-link" href="/appointment">Appointment List</a>
          </li>
          <li class="nav-item <?= ($uri->getSegment(1) == 'division' ? 'active' : null) ?>">
            <a class="nav-link" href="/division">Division List</a>
          </li>
          <li class="nav-item <?= ($uri->getSegment(1) == 'campus' ? 'active' : null) ?>">
            <a class="nav-link" href="/campus">Campus List</a>
          </li>
        </ul>
        <ul class="navbar-nav my-2 my-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="/logout">Logout</a>
          </li>
        </ul>

      <?php else : ?>
        <ul class="navbar-nav mr-auto">
          <li class="nav-item <?= ($uri->getSegment(1) == '' ? 'active' : null) ?>">
            <a class="nav-link" href="/">Search</a>
          </li>
          <li class="nav-item <?= ($uri->getSegment(1) == 'login' ? 'active' : null) ?>">
            <a class="nav-link" href="/login">Login</a>
          </li>
          <li class="nav-item <?= ($uri->getSegment(1) == 'register' ? 'active' : null) ?>">
            <a class="nav-link" href="/register">Register</a>
          </li>
        </ul>
      <?php endif; ?>
    </div>
  </nav>

  <!-- For Content -->
  <div class="container">
    <div class="mt-4 mb-4 p-3 bg-white rounded">