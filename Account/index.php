<?php
    session_start();
    if (!isset($_SESSION['account'])) {
        header('Location: /login.php');
        die();
    }

    if ($_SESSION['account']['chucvu'] !='Giám đốc'){
        header('Location: /login.php');
        die();
    }
    require_once('navbar.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Danh sách tài khoản</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link 
        rel="stylesheet"
        href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>

    <br>
    <div class="container mt-5">
        <h2 class="text-center text-secondary mb-3 mb-3">Danh sách tài khoản</h2>
        <a href="/Account/addAccount.php" class="btn btn-outline-success mb-2"> <i class="fas fa-user-plus"></i> Thêm tài nhân viên</a>
        <div class="row justify-content-center">
            <?php
                require_once('../conndb.php');
                $sql = 'SELECT * FROM account';

                $result = $conn->query($sql);
                $accounts = array();
                
                while ($row = $result->fetch_assoc()){
                    $accounts[] = $row;
                }
                foreach ($accounts as $row){
                    $id = $row['id'];
                    $name = $row['name'];
                    $chucvu = $row['chucvu'];
                    $phongban = $row['phongban'];
                    $avata = $row['avata'];
                    if (empty($avata)){
                        if ($row['gioitinh'] ==='Nam'){
                            $avata = '/img/img_avatar.png';
                        }else{
                            $avata = '/img/avatar.png';
                        }
                    }
                    $srcHref = '/Account/profile.php?id='.$id;
                ?>
                    <div class="col-sm-12 col-lg-4 col-xl-4 py-1">
                        <div class="card h-100">
                            <!-- $avata -->
                            <img src="<?=$avata?>" alt="avatar" class="img-fluid img-card-top h-75">
                            <div class="card-body">
                                <h4 class="card-title"><a href="<?=$srcHref?>"><?= $name ?></a></h4>
                                <p class="card-text">
                                    Phòng ban: <?= $phongban ?> <br>
                                    Chức vụ: <?= $chucvu ?>
                                </p>
                                <a href="<?=$srcHref?>" class="btn btn-info">Chi tiết</a>
                            </div>
                        </div>
                    </div>
                <?php
                }
            ?>
        </div>
    </div>
    <br>
    <br>
</body>