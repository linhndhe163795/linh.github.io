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

            <input type="file" class="form-control-file" maxlength="128" name="avatar"  value='/views/pages/media/<?php echo isset($admin[4]) ? $admin[4] : "" ?>'>
            <label for="avatar">Avatar:</label>
            <img  style="max-width: 70px; max-height: 70px;" src="/views/pages/media/<?php echo isset($detail[0]['avatar']) ? $detail[0]['avatar'] : "" ?>"/>
            <div style="color: red"><?php echo isset($messUpload) ? $messUpload : " " ?></div>
        </div>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" maxlength="100" minlength="3" name="name" value="<?php echo isset($name) ? $name : $detail[0]['name'] ?>" >
            <div style="color: red"><?php echo isset($messName) ? $messName : " " ?></div>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control"  maxlength="100" minlength="3" name="email" value='<?php echo isset($email) ?  $email : $detail[0]['email'] ?>' >
            <div style="color: red"><?php echo isset($messEmail) ? $messEmail : " " ?></div>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control"maxlength="100" minlength="3" name="password"  value=>
        </div>
        <div style="color: red"><?php echo isset($messPassword) ? $messPassword : " " ?></div>
        <div class="form-group">
            <label for="verifyPassword">Verify Password:</label>
            <input type="password" class="form-control" maxlength="100" minlength="3" name="verifyPassword" value= >
            <div style="color: red"><?php echo isset($messVeriPassword) ? $messVeriPassword : " " ?></div>

        </div>
        <div class="form-group">
            <label for="active">Status:</label>
            <div>
                <?php
                if (isset($detail[0]['del_flag']))
                    if ($detail[0]['del_flag'] == 0) {
                        echo '<label class="radio-inline">
                                <input checked="" type="radio" name="active" value="0">Active
                                </label>
                                    <label class="radio-inline">
                                 <input type="radio" name="active" value="1">Banned
                                 </label>';
                    } else {
                        echo '<label class="radio-inline">
                                        <input type="radio" name="active" value="0">Active
                                      </label>
                                            <label class="radio-inline">
                                        <input checked="" type="radio" name="active" value="1">Banned
                                        </label>';
                    }
                ?>
            </div>
        </div>
        <button type="reset" name = 'reset'class="btn btn-secondary">Reset</button>
        <button type="submit" name='submitEdit' class="btn btn-primary">Save</button>
    </form>

</div>
</body>
</html>

