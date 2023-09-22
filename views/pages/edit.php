<?php require_once './helper/common.php'; ?>
<?php require_once './helper/const.php'; ?>


<link href="../../assets/css/edit.css">
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
            <label for="avatar">Avatar:</label>
            <input type="file" class="form-control-file" id="avatar_value" name="avatar" onchange="updateHiddenInput(this)">
            <input type="hidden" name="avatar_value" id="avatar_value" >
            <img style="max-width: 70px; max-height: 70px;" src="/views/pages/media/<?php echo isset($valid['avatar']) ? $valid['avatar'] : (isset($detail[0]['avatar']) ? $detail[0]['avatar'] : '') ?>"/>
            <div style="color: red"><?php echo isset($errors['avatar']) ? $errors['avatar'] : " " ?></div>
        </div>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control"  name="name" value="<?php echo isset($valid['name']) ? $valid['name'] : $detail[0]['name'] ?>" >
            <div style="color: red"><?php echo isset($errors['name']) ? $errors['name'] : " " ?></div>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" name="email" value='<?php echo isset($valid['email']) ? $valid['email'] : $detail[0]['email'] ?>' >
            <div style="color: red"><?php echo isset($errors['email']) ? $errors['email'] : " " ?></div>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" name="password"  
                   value="<?php echo isset($detail[0]['password']) ? $detail[0]['password'] : "" ?>">
        </div>
        <div style="color: red"><?php echo isset($errors['password']) ? $errors['password'] : " " ?></div>
        <div class="form-group">
            <label for="verifyPassword">Verify Password:</label>
            <input type="password" class="form-control" name="verifyPassword"
                   value="<?php echo isset($detail[0]['password']) ? $detail[0]['password'] : "" ?>" >
            <div style="color: red"><?php echo isset($errors['verifyPassword']) ? $errors['verifyPassword'] : " " ?></div>

        </div>
        <div class="form-group">
            <label for="active">Status:</label>
            <div>
                <?php
                $superAdminChecked = (isset($detail[0]['role_type']) && $detail[0]['role_type'] == SUPER_ADMIN) ? 'checked' : '';
                $adminChecked = (isset($detail[0]['role_type']) && $detail[0]['role_type'] == ADMIN) ? 'checked' : '';

                if (isset($valid['role_type']) && $valid['role_type'] == SUPER_ADMIN) {
                    $superAdminChecked = 'checked';
                }
                if (isset($valid['role_type']) && $valid['role_type'] == ADMIN) {
                    $adminChecked = 'checked';
                }
                ?>

                <label class="radio-inline">
                    <input <?= $superAdminChecked ?> type="radio" name="role_type" value="<?php echo SUPER_ADMIN ?>">Super Admin
                </label>
                <label class="radio-inline">
                    <input <?= $adminChecked ?> type="radio" name="role_type" value="<?php echo ADMIN ?>">Admin
                </label>
            </div>
        </div>
        <button type="reset" name = 'reset'class="btn btn-secondary">Reset</button>
        <button type="submit" name='submitEdit' class="btn btn-primary">Save</button>
    </form>

</div>
</body>
<script src="../../assets/js/edit.js"></script>

</html>

