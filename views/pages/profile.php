<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User_Profile</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="./assets/header.css"

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
                    <ul class="navbar-nav" style="padding-left: 900px">
                        <li class="nav-item">
                            <a class="nav-link" href="/index.php?controller=home&action=logoutuser">Log out</a>
                        </li>
                    </ul>
                </div>

            </nav>
        </div>

        <table class="table" style="height: 700px; width: 700px; margin-left: 500px">
            <thead>
                <tr>
                    <th colspan="3">My Profile</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="col">ID</th>
                    <td scope="col"><?php echo $infor[0]['id'] ?></td>
                </tr>
                <tr>
                    <th scope="col">Avatar</th>
                    <td scope="col"><img  style="max-width: 200px; max-height: 100px;" src="/views/pages/media/<?php echo $infor[0]['avatar'] ?>"/></td>

                </tr>
                <tr>
                    <th scope="col">Name</th>
                    <td scope="col" colspan="3"><?php echo $infor[0]['name'] ?></td>
                </tr>
                <tr>
                    <th scope="col">Email</th>
                    <td scope="col"><?php echo $infor[0]['email'] ?></td>
                </tr>
            </tbody>
        </table>

    </body>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</html>