

<?php require_once './helper/const.php'; ?>
<?php include 'header.php'; ?>

<title>Admin - Create</title>
<style>
    .container1 {
        max-width: 500px;
        margin: 0 auto;
        padding: 20px;
    }
    h2{
        text-align: center;
    }
</style>
</head>
<body>
    <h2>Create New Account </h2>
    <div class="container1">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="avatar">Avatar:</label>
                <input type="file" class="form-control-file" id="avatar_value" name="avatar" onchange="updateHiddenInput(this)">
                <input type="hidden" name="avatar_value" id="avatar_value" >                
                <img style="max-width: 70px; max-height: 70px;" src="/views/pages/media/<?php echo isset($valid['avatar']) ? $valid['avatar'] : '' ?>"/>
                <div style="color: red"><?php echo isset($errorsImage['avatar']) ? $errorsImage['avatar'] : "" ?></div>
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name"  value="<?php echo isset($valid['name']) ? $valid['name'] : "" ?>"  >
                <div style="color: red"><?php echo isset($errors['name']) ? $errors['name'] : "" ?></div>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email"   value="<?php echo isset($valid['email']) ? $valid['email'] : "" ?>" >
                <div style="color: red"><?php echo isset($errors['email']) ? $errors['email'] : "" ?></div>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" >
                <div style="color: red"><?php echo isset($errors['password']) ? $errors['password'] : "" ?></div>
            </div>
            <div class="form-group">
                <label for="verifyPassword">Verify Password:</label>
                <input type="password" class="form-control" name="verifyPassword" >
                <div style="color: red"><?php echo isset($errors['verifyPassword']) ? $errors['verifyPassword'] : "" ?></div>
            </div>
            <div class="form-group">
                <label for="active">Role:</label>
                <div>
                    <?php
                    $superAdminChecked = (isset($valid['role_type']) && $valid['role_type'] == SUPER_ADMIN) ? 'checked' : '';
                    $adminChecked = (isset($valid['role_type']) && $valid['role_type'] == ADMIN) ? 'checked' : '';
                    ?>

                    <label class="radio-inline">
                        <input <?= $superAdminChecked ?> type="radio" name="role_type" value="<?php echo SUPER_ADMIN ?>">Super Admin
                    </label>
                    <label class="radio-inline">
                        <input <?= $adminChecked ?> type="radio" name="role_type" value="<?php echo ADMIN ?>">Admin
                    </label>

                    <div style = "color: red"><?php echo isset($errors['role_type']) ? $errors['role_type'] : ""
                    ?></div>

                </div>
            </div>
            <button type="reset" name = 'reset'class="btn btn-secondary">Reset</button>
            <button type="submit" name= 'submit' class="btn btn-primary">Create</button>
        </form>

</body>
<script src="../../assets/js/edit.js"></script>
</html>

