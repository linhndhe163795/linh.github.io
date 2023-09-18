


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
                <input type="file" class="form-control-file" name="avatar">
                <label for="avatar">Avatar:</label>
                <div style="color: red"><?php echo isset($messUpload) ? $messUpload : " " ?></div>
                <img  style="max-width: 70px; max-height: 70px;"/>
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name" maxlength="128" value="<?php echo isset($name) ? $name: "" ?>"  >
                <div style="color: red"><?php echo isset($messName) ? $messName : " " ?></div>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email"  maxlength="128" value='<?php echo isset($email) ? $email : "" ?>' >
                <div style="color: red"><?php echo isset($messEmail) ? $messEmail : " " ?></div>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" maxlength="100" minlength="3" name="password" >
                <div style="color: red"><?php echo isset($messPassword) ? $messPassword : " " ?></div>
            </div>
            <div class="form-group">
                <label for="verifyPassword">Verify Password:</label>
                <input type="password" class="form-control" maxlength="100" minlength="3" name="verifyPassword" >
                <div style="color: red"><?php echo isset($messVeriPass) ? $messVeriPass : " " ?> </div>
            </div>
            <div class="form-group">
                <label for="active">Role:</label>
                <div>
                    <label class="radio-inline">
                        <input type="radio" name="role_type" value="1">Super Admin
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="role_type" value="2">Admin
                    </label>
                    <div style="color: red"><?php echo isset($messRadio) ? $messRadio : " " ?> </div>
                </div>
            </div>
            <button type="reset" name = 'reset'class="btn btn-secondary">Reset</button>
            <button type="submit" name= 'submit' class="btn btn-primary">Create</button>
        </form>

</body>
</html>

