


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
                <input type="file" class="form-control-file" name="avatar" value="<?php echo isset($valid['avatar']) ? $valid['avatar'] : "" ?>" >
                <label for="avatar">Avatar:</label>
                <div style="color: red"><?php echo isset($errors['avatar']) ? $errors['avatar'] : "" ?></div>
                <img  style="max-width: 70px; max-height: 70px;"/>
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name" maxlength="128" value="<?php echo isset($valid['name']) ? $valid['name'] : "" ?>"  >
                <div style="color: red"><?php echo isset($errors['name']) ? $errors['name'] : "" ?></div>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email"  maxlength="128" value="<?php echo isset($valid['email']) ? $valid['email'] : "" ?>" >
                <div style="color: red"><?php echo isset($errors['email']) ? $errors['email'] : "" ?></div>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" maxlength="100" minlength="3" name="password" >
                <div style="color: red"><?php echo isset($errors['password']) ? $errors['password'] : "" ?></div>
            </div>
            <div class="form-group">
                <label for="verifyPassword">Verify Password:</label>
                <input type="password" class="form-control" maxlength="100" minlength="3" name="verifyPassword" >
                <div style="color: red"><?php echo isset($errors['verifyPassword']) ? $errors['verifyPassword'] : "" ?></div>
            </div>
            <div class="form-group">
                <label for="active">Role:</label>
                <div>
                    
                    <label class = "radio-inline">
                    <input type = "radio" name = "role_type" value = "1" 
                        <?php echo (isset($valid['role_type']) && $valid['role_type'] == 1) ? 'checked' : '';?>>Super Admin
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="role_type" value="2" <?php echo (isset($valid['role_type']) && $valid['role_type'] == 2) ? 'checked' : ''; ?>>Admin
                    </label>
                    <div style = "color: red"><?php echo isset($errors['role_type']) ? $errors['role_type'] : ""?></div>
                </div>
            </div>
            <button type="reset" name = 'reset'class="btn btn-secondary">Reset</button>
            <button type="submit" name= 'submit' class="btn btn-primary">Create</button>
        </form>

</body>
</html>

