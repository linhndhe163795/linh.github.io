<?php require_once './helper/common.php'; ?>



<style>
    .container {
        max-width: 500px;
        margin: 0 auto;
        padding: 20px;
    }
</style>
<title>Admin_Edit</title>
<?php include 'header.php'; ?>

<div class="container">
    <form action="index.php?controller=edit&action=editAdmin&id=<?php echo isset($detail[0]['id']) ? $detail[0]['id'] : " " ?>"
          method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label for="id">ID:</label>
            <input type="text" class="form-control" name="id" readonly value='<?php echo isset($detail[0]['id']) ? $detail[0]['id'] : " " ?>'>
        </div>
        <div class="form-group">

            <input type="file" class="form-control-file" maxlength="128" name="avatar"  >
            <label for="avatar">Avatar:</label>
            <img  style="max-width: 70px; max-height: 70px;" src="/views/pages/media/<?php echo isset($detail[0]['avatar']) ? $detail[0]['avatar'] : "" ?>"/>
            <div style="color: red"><?php echo isset($errors['avatar']) ? $errors['avatar'] : " " ?></div>
        </div>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" maxlength="100" minlength="3" name="name" value="<?php echo isset($valid['name']) ? $valid['name'] : $detail[0]['name'] ?>" >
            <div style="color: red"><?php echo isset($errors['name']) ? $errors['name'] : " " ?></div>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control"  maxlength="100" minlength="3" name="email" value='<?php echo isset($valid['email']) ? $valid['email'] : $detail[0]['email'] ?>' >
            <div style="color: red"><?php echo isset($errors['email']) ? $errors['email'] : " " ?></div>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control"maxlength="100" minlength="3" name="password"  value=>
        </div>
        <div style="color: red"><?php echo isset($errors['password']) ? $errors['password'] : " " ?></div>
        <div class="form-group">
            <label for="verifyPassword">Verify Password:</label>
            <input type="password" class="form-control" maxlength="100" minlength="3" name="verifyPassword" value= >
            <div style="color: red"><?php echo isset($errors['verifyPassword']) ? $errors['verifyPassword'] : " " ?></div>

        </div>
        <div class="form-group">
            <label for="active">Status:</label>
            <div>
                <?php
                $superAdminChecked = (isset($detail[0]['role_type']) && $detail[0]['role_type'] == 1) ? 'checked' : '';
                $adminChecked = (isset($detail[0]['role_type']) && $detail[0]['role_type'] == 2) ? 'checked' : '';

                if (isset($valid['role_type']) && $valid['role_type'] == 1) {
                    $superAdminChecked = 'checked';
                }
                if (isset($valid['role_type']) && $valid['role_type'] == 2) {
                    $adminChecked = 'checked';
                }
                ?>

                <label class="radio-inline">
                    <input <?= $superAdminChecked ?> type="radio" name="role_type" value="1">Super Admin
                </label>
                <label class="radio-inline">
                    <input <?= $adminChecked ?> type="radio" name="role_type" value="2">Admin
                </label>
            </div>
        </div>
        <button type="reset" name = 'reset'class="btn btn-secondary">Reset</button>
        <button type="submit" name='submitEdit' class="btn btn-primary">Save</button>
    </form>

</div>
</body>
</html>

