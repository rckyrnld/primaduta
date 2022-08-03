<!DOCTYPE html>
<html>
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Primaniyarta <?php echo date("Y"); ?></title>

<!-- CSS-->
<link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/jquery-ui-themes/themes/base/jquery-ui.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/akun.css'); ?>">   

<!-- Javascript -->
<script src="<?php echo base_url('assets/js/jquery-3.4.1.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/popper.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/jquery-ui/jquery-ui.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.validate.min.js'); ?>"></script>

<!-- Fontawesome -->
<script src="https://kit.fontawesome.com/ba229b614c.js" crossorigin="anonymous"></script>

<!-- google font -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Assistant&display=swap" rel="stylesheet">

<script src="https://cdn.tiny.cloud/1/o8z1jxlgvsxh24fmz3k9cqv615rpaomwjt5cwaedgd9n4ztc/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script src="https://cdn.tiny.cloud/1/o8z1jxlgvsxh24fmz3k9cqv615rpaomwjt5cwaedgd9n4ztc/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
  tinymce.init({
    selector: 'textarea#editor',
    skin: 'bootstrap',
    plugins: 'lists, link, image, media',
    toolbar: 'h1 h2 bold italic strikethrough blockquote bullist numlist backcolor | link image media | removeformat help',
    menubar: false,
    });
</script>
</head>

<body>

<!-- header -->
<header>
    <nav class="navbar navbar-expand-sm fixed-top navbar-light bg-light">
    <div class="container-fluid">
        <a href="<?php echo base_url('main/dashboard'); ?>" class="navbar-brand">PENDAFTARAN PRIMADUTA <?php echo date("Y"); ?></a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="nav-item">
                    <a href="<?php echo base_url('main'); ?>" class="nav-link"><i class="fa-solid fa-globe"></i> Website Primaduta</a>
                </li>
            </ul>
            <ul class="nav navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><?php echo $nmuser; ?></a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="#" class="dropdown-item">Profil</a>
                        <a href="#" class="dropdown-item">Ganti Password</a>
                        <div class="dropdown-divider"></div>
                        <a href="<?php echo base_url('main/logout'); ?>" class="dropdown-item">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
</header>
<!-- header end -->