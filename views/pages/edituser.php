

<?php include 'header.php'; ?>
<link href="../../assets/css/edit.css">
<?php require_once './helper/const.php'; ?>
<div class="container">
    <form action="index.php?controller=edit&action=editUser&id=<?php echo $detail[0]['id']; ?>"
          method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label for="id">ID:</label>
            <input type="text" class="form-control" name="id" readonly value="<?php echo isset($_GET['id']) ? $_GET['id'] : " " ?>">
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
            <input type="text" class="form-control"  name="name" value="<?php echo isset($valid['name']) ? $valid['name'] : $detail[0]['name'] ?>"  >
            <div style="color: red"><?php echo isset($errors['name']) ? $errors['name'] : " " ?></div>

        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" name="email" value="<?php echo isset($valid['email']) ? $valid['email'] : $detail[0]['email'] ?>" >
            <div style="color: red"><?php echo isset($errors['email']) ? $errors['email'] : " " ?></div>

        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control"  name="password"
                   value="<?php echo isset($detail[0]['password']) ? $detail[0]['password'] : "" ?>">
            <div style="color: red"><?php echo isset($errors['password']) ? $errors['password'] : " " ?></div>

        </div>
        <div class="form-group">
            <label for="verifyPassword">Verify Password:</label>
            <input type="password" class="form-control" maxlength="100" minlength="3" name="verifyPassword" 
                   value="<?php echo isset($detail[0]['password']) ? $detail[0]['password'] : "" ?>">
            <div style="color: red"><?php echo isset($errors['verifyPassword']) ? $errors['verifyPassword'] : " " ?></div>

        </div>
        <input type="hidden" class="form-control" maxlength="100" minlength="3" name="role_type" value="<?php echo ADMIN ?>">
        <div class="form-group">
            <label for="active">Status:</label>
            <div>
                <?php
                $activeChecked = (isset($detail[0]['status']) && $detail[0]['status'] == ACTIVE) ? 'checked' : '';
                $bannedChecked = (isset($detail[0]['status']) && $detail[0]['status'] == BAN) ? 'checked' : '';

                if (isset($valid['active']) && $valid['active'] == ACTIVE) {
                    $activeChecked = 'checked';
                }
                if (isset($valid['active']) && $valid['active'] == BAN) {
                    $bannedChecked = 'checked';
                }
                ?>

                <label class="radio-inline">
                    <input <?= $activeChecked ?> type="radio" name="active" value="<?php echo ACTIVE ?>">Active
                </label>
                <label class="radio-inline">
                    <input <?= $bannedChecked ?> type="radio" name="active" value="<?php echo BAN ?>">Banned
                </label>
                <div style="color: red"><?php echo isset($errors['verifyPassword']) ? $errors['verifyPassword'] : " " ?></div>
            </div>
        </div>
        <button type="reset" name = 'reset'class="btn btn-secondary">Reset</button>
        <button type="submit" name='submitEdit' class="btn btn-primary">Save</button>
    </form>
</div>
</body>
<script src="../../assets/js/edit.js"></script>
</html>

