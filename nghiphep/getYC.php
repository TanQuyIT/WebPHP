<?php
    session_start();

    if (!isset($_SESSION['account']) || empty($_GET['id'])) {
        header('Location: /login.php');
        die();
    }
    if ($_SESSION['account']['chucvu'] === 'Nhân viên'){
        header('Location: index.php');
    }
    $idYC = $_GET['id'];
    require_once('../conndb.php');
    $sql = 'SELECT * FROM nghiphep WHERE id = ?';

    $stm = $conn->prepare($sql);
    $stm->bind_param('i',$idYC);
    $stm->execute();
    
    $result = $stm->get_result();
    if ($result->num_rows != 1){
        header('Location: /login.php');
        die();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Duyệt đơn nghỉ phép</title>
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
    <script src="../main.js"></script>
</head>
<body>
<?php

    
    
    $YC = $result->fetch_assoc();
    $idNV = $YC['idNV'];
    $nhanvien = $YC['nhanvien'];
    $trangthai = $YC['trangthai'];
    $songaymuonnghi = $YC['songaymuonnghi'];
    $ngayBDnghi = $YC['ngayBDnghi'];
    $lydo = $YC['lydo'];
    $fi = $YC['file'];
    $fi_href = '#';
    if (!empty($fi)){
        $fi_href = '/Truongphong/downloadFile.php?name_down='.$fi;
    }
    if($_SESSION['account']['chucvu']==='Giám đốc'){
        require_once('../Account/navbar.php');
    }elseif($_SESSION['account']['chucvu']==='Trưởng phòng'){
        require_once('../Truongphong/navbar.php');
    }

?>    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col col-lg-8 border rounded my-5 p-4 mx-3">
                <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Đơn xin nghỉ phép</h3>
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3 class=" card-title"><?=$nhanvien?></h3>
                        <small class="badge badge-info badge-pill my-auto" id="sttYC">
                            <?=  $trangthai ?>
                        </small>
                    </div>
                    <div class="card-body">
                        <p class="card-text mt-2 mx-2">
                            Xin nghỉ phép: <b><?=$songaymuonnghi?></b> ngày
                        </p>
                        <p class="card-text mt-2 mx-2">
                            Kể từ ngày: <b><?=$ngayBDnghi?></b>
                        </p>
                        <p class="card-text mt-2 mx-2">
                        Với lý do: <?=$lydo?>
                        </p>
                        <p class="card-text mt-2 mx-2 mb-3">
                            Tệp đính kèm: <a href="<?=$f_href?>"><?=$fi?></a> 
                        </p>
                    </div>
                    <div class="card-footer">
                    <?php if ($trangthai === 'waiting'){ ?>
                        <div class="row justify-content-end" id="btn_duyet">
                            <button onclick="showDYmodal()" class="btn btn-success mr-2 px-4">Đồng ý</button>
                            <button onclick="showKDYmodal()" class="btn btn-warning mr-2 px-1">Không đồng ý</button>
                        </div>
                    <?php }
                    ?>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- modal -->
    <!-- Đồng ý -->
    <div class="modal fade" id="dongyYC">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text text-success">Đồng ý đơn xin nghỉ phép</h5>
                    <button type="button" class="close" data-dismiss='modal' aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn chắc chắn <b>đồng ý</b> với đơn xin nghỉ phép của <b><?=$nhanvien?></b>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                    <button onclick='duyetYC(<?=$idYC?>,<?=$idNV?>,<?=$songaymuonnghi?>,"approved")' type="button" class="btn btn-success">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Không Đồng ý -->
    <div class="modal fade" id="kdongyYC">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text text-warning">Không đồng ý đơn xin nghỉ phép</h5>
                    <button type="button" class="close" data-dismiss='modal' aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn chắc chắn <b>không đồng ý</b> với đơn xin nghỉ phép của <b><?=$nhanvien?></b>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                    <button onclick='duyetYC(<?=$idYC?>,<?=$idNV?>,0,"refused")' type="button" class="btn btn-warning">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>