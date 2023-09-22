<!DOCTYPE html>
<?php require_once './helper/const.php'; ?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--<title>Header Example</title>-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="./assets/header.css"
              <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="../../assets/css/dataTables.bootstrap.css">
        <link rel="stylesheet" href="../../assets/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="../../assets/css/jquery.dataTables.css">
        <!-- Theme style -->
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <!--<link rel="stylesheet" href="../../assets/css/_all-skins.min.css">-->
    </head>
    <body>
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">

    <!--<a class="navbar-brand" href="#"><img src="logo.png" alt="Logo"></a>-->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="/index.php?controller=home&action=homepage">Home Page</a>

                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Admin Management</a>
                            <?php
                            if (isset($_SESSION['role_type']) && $_SESSION['role_type'] == SUPER_ADMIN) {
                                echo '<div class="sub-menu">';
                                echo '<a href="/index.php?controller=create&action=createAdmin">Create</a>';
                                echo '<a href="/index.php?controller=search&action=searchAdmin">Search</a>';
                                echo '</div>';
                            } else {
                                echo '<div class="sub-menu">';
                                echo '<div style="color: red">Not Access</div>';
                                echo '</div>';
                            }
                            ?>

                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">User Management</a>
                            <div class="sub-menu">
                                <a href="/index.php?controller=search&action=searchUser">Search</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/index.php?controller=home&action=logout">Log out</a>
                        </li>

                    </ul>
                </div>

            </nav>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

