<?php
  session_start();
  if (!isset($_SESSION['account'])) {
      header('Location: /login.php');
      die();
  }
  if ($_SESSION['account']['chucvu'] === 'Giám đốc'){
      header('Location: listYC.php');
      die();
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Quản lý nghỉ phép</title>
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
  
    if ($_SESSION['account']['chucvu'] === 'Trưởng phòng'){
        require_once('../Truongphong/navbar.php');
    }else{
        require_once('../Nhanvien/navbar.php');
    }
    $data= $_SESSION['account'];
    $name = $data['name'];
    $idNV = $data['id'];
    $idPhong = $data['idPhong'];
    $phongban = $data['phongban'];
    $chucvu = $data['chucvu'];
    $songaydanghi = $data['songaynghi'];
    $sumngaynghi = 12;
    if ($chucvu === 'Trưởng phòng'){
        $sumngaynghi = 15;
    }
    $songayconlai = $sumngaynghi - $songaydanghi;
    $ngaygannhat = $data['ngayxinphep'];
    $today = date('Y-m-d');
    $countdays = ((strtotime($today) - strtotime($ngaygannhat))/86400);

    require_once('../conndb.php');
    $sql = 'SELECT * FROM nghiphep WHERE idNV = ? ORDER BY ngaythaydoi DESC';
    $stm = $conn->prepare($sql);
    $stm->bind_param('i',$idNV);
    $stm->execute();

    // biến kiêm tra có yêu cầu nào đang waiting;
    $wait = 0;
    $result = $stm->get_result();
    $chitiet = array();
    while ($row = $result->fetch_assoc()){
        $chitiet[] = $row;
        if ($row['trangthai'] === 'waiting'){
            $wait +=1;
        }
    }

?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col col-lg-8 border rounded my-5 p-4 mx-3">
                <h3 class="text-center text-secondary mt-2 mb-3">Quản lý ngày phép</h3>
                <!-- thông tin ngày phép -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3 class=" card-title"><?=$name?></h3>
                    </div>
                    <div class="card-body">
                        <p class="card-text mt-2 mx-2">
                            Chức vụ: <?=$chucvu?>                           
                        </p>
                        <hr>
                        <p class="card-text mt-2 mx-2">
                            Phòng ban: <?=$phongban?>                           
                        </p>
                        <hr>
                        <p class="card-text mt-2 mx-2">
                           Tổng số ngày nghỉ trong năm: <b><?=$sumngaynghi?></b> ngày                           
                        </p>
                        <hr>
                        <p class="card-text mt-2 mx-2">
                           Số ngày đã nghỉ: <b><?=$songaydanghi?></b> ngày                           
                        </p>
                        <hr>
                        <p class="card-text mt-2 mx-2">
                           Số ngày còn lại: <b><?=$songayconlai?></b> ngày                           
                        </p>
                    </div>
                    <div class="card-footer">
                    <?php 
                        if ($songayconlai <=0){
                            echo '<samp class="text-danger">Bạn đã sử dụng hết toàn bộ ngày phép trong năm</samp>';
                        }elseif ($countdays <7){
                           echo'<samp class="text-danger">Lần xét đơn gần nhất của bạn chưa qua 7 ngày! Hãy quay lại sau</samp>';
                        }elseif ($wait != 0){
                           echo'<samp class="text-danger">Bạn có 1 đơn xin phép đang chờ duyệt.</samp>';
                        }
                        else{ ?>
                        <div class="row justify-content-end">
                            <a href="creatYC.php" class="btn btn-info px-5 mr-4 my-1">Gửi đơn xin phép</a>
                        </div>
                        <?php
                        }
                    ?>
                        
                    </div>
                </div>
                <h5 class="text text-secondary mt-3">Lịch sử nghỉ phép</h5>
                <!-- chi tiết từng đơn -->
                <div class="list-group mt-1">
                <?php
                 
                    foreach ($chitiet as $row){
                        $ngaythaydoi = $row['ngaythaydoi'];
                        $trangthai = $row['trangthai'];
                        $songaymuonnghi = $row['songaymuonnghi'];
                        $ngayBDnghi = $row['ngayBDnghi'];
                        $lydo = $row['lydo'];
                        $fi = $row['file'];
                        $fi_href = '#';
                        if (!empty($fi)){
                            $fi_href = '/Truongphong/downloadFile.php?name_down='.$fi;
                        }
                    ?>
                        <div class="list-group-item list-group-item-action flex-column">
                            <div class="d-flex w-100  justify-content-between">
                                <small><?=$ngaygannhat?></small>
                                <h6 class="border rounded p-1 bg-info text-white">Trạng thái: <?=$trangthai?></h6>
                            </div>
                            <hr>
                            
                            <p class="my-1 ">Xin nghỉ phép: <b><?=$songaymuonnghi?></b> ngày</p>
                            <p class="my-1 ">Kể từ ngày: <b><?=$ngayBDnghi?></b></p>
                            <p class="my-1 ">Với lý do: <?=$lydo?></p>
                            <p class="mb-1 ">Tập tin đính kèm: <a href="<?=$fi_href?>"><?=$fi?></a></p>
                        </div>
                    <?php
                    }
                ?>
                </div>
                
            </div>
        </div>
    </div>    
</body>
</html>