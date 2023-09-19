

<style>
    .container {
        max-width: 500px;
        margin: 0 auto;
        padding: 20px;
    }
</style>
<?php include 'header.php'; ?>
<div class="container">
    <form action="index.php?controller=edit&action=editUser&id=<?php echo $detail[0]['id']; ?>"
          method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label for="id">ID:</label>
            <input type="text" class="form-control" name="id" readonly value="<?php echo isset($_GET['id']) ? $_GET['id'] : " " ?>">
        </div>
        <div class="form-group">
            <input type="file" class="form-control-file" name="avatar">
            <label for="avatar">Avatar:</label>
            <img  style="max-width: 70px; max-height: 70px;" src="/views/pages/media/<?php echo $detail[0]['avatar']; ?>"/>
            <div style="color: red"><?php echo isset($errors['avatar']) ? $errors['avatar'] : " " ?></div>
        </div>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" maxlength="128" name="name" value="<?php echo isset($valid['name']) ? $valid['name'] : $detail[0]['name'] ?>"  >
            <div style="color: red"><?php echo isset($errors['name']) ? $errors['name'] : " " ?></div>

        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" name="email" value="<?php echo isset($valid['email']) ? $valid['email'] : $detail[0]['email'] ?>" >
            <div style="color: red"><?php echo isset($errors['email']) ? $errors['email'] : " " ?></div>

        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" maxlength="100" minlength="3" name="password" value="" >
            <div style="color: red"><?php echo isset($errors['password']) ? $errors['password'] : " " ?></div>

        </div>
        <div class="form-group">
            <label for="verifyPassword">Verify Password:</label>
            <input type="password" class="form-control" maxlength="100" minlength="3" name="verifyPassword" value="" >
            <div style="color: red"><?php echo isset($errors['verifyPassword']) ? $errors['verifyPassword'] : " " ?></div>

        </div>
        <div class="form-group">
            <label for="active">Status:</label>
            <div>
                <?php
                $activeChecked = (isset($detail[0]['status']) && $detail[0]['status'] == 1) ? 'checked' : '';
                $bannedChecked = (isset($detail[0]['status']) && $detail[0]['status'] == 0) ? 'checked' : '';

                if (isset($valid['active']) && $valid['active'] == 1) {
                    $activeChecked = 'checked';
                }
                if (isset($valid['active']) && $valid['active'] == 0) {
                    $bannedChecked = 'checked';
                }
                ?>

                <label class="radio-inline">
                    <input <?= $activeChecked ?> type="radio" name="active" value="1">Active
                </label>
                <label class="radio-inline">
                    <input <?= $bannedChecked ?> type="radio" name="active" value="0">Banned
                </label>

            </div>
        </div>
        <button type="reset" name = 'reset'class="btn btn-secondary">Reset</button>
        <button type="submit" name='submitEdit' class="btn btn-primary">Save</button>
    </form>
</div>
</body>
</html>

