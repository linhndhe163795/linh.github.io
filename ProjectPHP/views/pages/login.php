<?php ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Admin</title>
        <!-- Thêm các liên kết Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <!-- Tùy chỉnh CSS -->
        <style>
            body {
                background-color: #f8f9fa;
            }
            .login-container {
                margin-top: 100px;
            }
        </style>
    </head>
    <body>
        <div class="container login-container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Đăng nhập Admin</div>
                        <div class="card-body">
                            <form method="POST" action="/index.php?controller=login&action=dangnhap">
                                <div class="form-group">
                                    <label for="username">Tên đăng nhập</label>
                                    <input type="email" class="form-control" id="username" name="email" value="<?php echo isset($email) ? $email : "" ?>" >
                                    <div style="color: red"><?php echo isset($messErrorEamil) ? $messErrorEamil : " " ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Mật khẩu</label>
                                        <input type="password" class="form-control" id="password" name="password" value="">
                                        <div style="color: red"><?php echo isset($messErrorPassword) ? $messErrorPassword : " " ?>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary"name="submit">Đăng nhập</button>
                                        </div>
                                        <div  style="color: red"> <?php echo isset($list) ? $list : "" ?></div>
                                    </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Thêm liên kết Bootstrap JavaScript và jQuery (đặt ở cuối trang) -->
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.0/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>

