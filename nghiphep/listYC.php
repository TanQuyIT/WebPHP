<?php
  session_start();
  if (!isset($_SESSION['account'])){
      header('Location: /login.php');
  }
  $data= $_SESSION['account'];

    $chucvu = $data['chucvu'];
    if ($chucvu === 'Nhân viên'){
        header('Location: /nghiphep/');
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Danh sách đơn xin nghỉ phép</title>
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

  
    

    if ($chucvu === 'Giám đốc'){
        //duyệt của giám đốc
        require_once('../conndb.php');
        $sql = 'SELECT * FROM nghiphep WHERE chucvu = "Trưởng phòng" ORDER BY ngaythaydoi DESC';
        $result = $conn->query($sql);
        $lists = array();
        while ($row = $result->fetch_assoc()){
            $lists[] = $row;
        }
        require_once('../Account/navbar.php');
    }else{
        // duyệt của trưởng phòng
        $idPhong = $data['idPhong'];
        $idTP = $data['id'];
        require_once('../conndb.php');
        $sql = 'SELECT * FROM nghiphep WHERE idPhong = ? AND idNV != ?  ORDER BY ngaythaydoi DESC';
        $stm = $conn->prepare($sql);
        $stm->bind_param('ii',$idPhong,$idTP);
        $stm->execute();

        $result = $stm->get_result();
        $lists = array();
        while ($row = $result->fetch_assoc()){
            $lists[] = $row;
        }
        require_once('../Truongphong/navbar.php');
    }
    
    
    ?>    
    <!-- // show list  -->
    <br><br>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-8 col-md-10 border rounded my5 p4 mx-3">
                <h2 class="text-center text-secondary mt-2 mb-3">Danh sách đơn xin nghỉ phép</h2>

                <?php
                    foreach ($lists as $row){
                    
                        $name = $row['nhanvien'];
                        $trangthai = $row['trangthai'];
                        $ngaythaydoi = $row['ngaythaydoi'];
                        $songaymuonnghi = $row['songaymuonnghi'];
                        $hrefYC = '/nghiphep/getYC.php?id=' . $row['id'];
                    ?>
                    <a href="<?=$hrefYC?>" class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-between">
                            <h4 class="mb-1"><?=$name?></h4>
                            <small class="badge badge-primary badge-pill my-auto"><?= $trangthai ?></small>
                        </div>
                        <p class="mb-1">Xin nghỉ phép <b><?= $songaymuonnghi ?></b> ngày</p>
                        <small>Ngày gửi đơn: <?= $ngaythaydoi?></small>
                    </a>
                    <?php
                    }
                ?>
                <br>

            </div>
        </div>
    </div>
</body>
</html>
