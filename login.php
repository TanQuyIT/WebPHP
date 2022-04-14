<?php
    session_start();
    if (isset($_SESSION['account'])) {
        header('Location: index.php');
        exit();
    }

    $error = '';
    $user = '';
    $pass = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['user']) && isset($_POST['pass'])) {
            $user = $_POST['user'];
            $pass = $_POST['pass'];
            if (empty($user)) {
                $error = 'Vui lòng nhập tên đăng nhập';
            }
            else if (empty($pass)) {
                $error = 'Vui lòng nhập mật khẩu';
            }else{
                require_once('conndb.php');
                $sql = 'SELECT * FROM account WHERE  user= ?';
        
                $stm = $conn->prepare($sql);
                $stm->bind_param('s',$user);
                $stm->execute();

                $result = $stm->get_result();

                if ($result->num_rows === 0 || $result->num_rows > 1){
                    $error = 'Tài khoản không tồn tài';
                }else{
                    $data = $result->fetch_assoc();
                    if (($data['active'] === 0) && $data['pass'] === $pass){
                        $_SESSION['account'] = $data;
                        header('Location: Account/activeAccount.php');
                    } elseif (($data['active'] === 1) && password_verify($pass,$data['pass'])){
                        if (isset($_POST['remember'])){
                            setcookie('CookieUser',$user,time() + (60*60*24*5));
                            setcookie('Cookiepass',$pass,time() + (60*60*24*5));
                        }
                        $_SESSION['account'] = $data;
                        if ($data['chucvu']==='Nhân viên'){
                            header('Location: Nhanvien/index.php');
                            die();
                        }elseif ($data['chucvu'] ==='Trưởng phòng'){
                            header('Location: Truongphong/index.php');
                            die();
                        }else{
                            header('Location: index.php');
                            die();
                        }
                    }else{
                        $error = 'Mật khẩu không chính xác';
                    }
                }
            } 
            
        }
    }
    if (isset($_COOKIE['CookieUser'])){
        $user = $_COOKIE['CookieUser'];
        $pass = $_COOKIE['CookiePass'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Đăng nhập</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/style.css">
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <h3 class="text-center text-secondary mt-5 mb-3">Đăng nhập hệ thống</h3>
            <form method="post" action="login.php" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                <div class="form-group">
                    <label for="username">Tên đăng nhập</label>
                    <input value="<?=$user?>" name="user" id="user" type="text" class="form-control" placeholder="Tên đăng nhập">
                    <div class="invalid-feedback">
                        Vui lòng điền tên đăng nhập
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input name="pass" value="<?=$pass?>" id="password" type="password" class="form-control" placeholder="Mật khẩu">
                    <div class="invalid-feedback">
                        Vui lòng điền mật khẩu
                    </div>
                </div>
                <div class="form-group form-check">
                    <label class="form-check-label">
                        <input <?= isset($_POST['remember']) ? 'checked' : '' ?> name="remember" type="checkbox" class="form-check-input" id="remember">
                        Ghi nhớ đăng nhập
                    </label>
                </div>
                <div class="form-group">
                    <?php
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    ?>
                    <button type="submit" class="btn btn-success" style="width:48.5%">Đăng nhập</button>
                    <button type="reset" class="btn btn-outline-success" style="width:48.5%">Nhập lại</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
