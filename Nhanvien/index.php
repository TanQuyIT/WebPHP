<?php

  session_start();
  if (!isset($_SESSION['account'])) {
      header('Location: /login.php');
      die();
  }
  $data= $_SESSION['account'];
  if ($data['chucvu'] !='Nhân viên'){
    header('Location: /login.php');
    die();
  }


  $idTP = $data['id'];
  $phongban = $data['phongban'];
  $idPhong = $data['idPhong'];

  require_once('../conndb.php');
  $sql = 'SELECT * FROM task WHERE idNV = ? ORDER BY ngaythaydoi DESC';
  
  $stm = $conn->prepare($sql);
  $stm->bind_param('i',$idTP);
  $stm->execute();
  $result = $stm->get_result();

  $tasks = array();
  while ($row = $result->fetch_assoc()){
    $tasks[] = $row;
  }

  require_once('navbar.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Danh sách task</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- <link rel="stylesheet" href="/style.css"> -->
</head>
<body style="background-color: lightcyan;">
  <br>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-xl-8 col-lg-8 col-md-10 border rounded my5 p4 mx-3" style="background-color: #ffffff;">
        <h2 class="text-center text-secondary mt-2 mb-3">Danh sách công việc</h2>

        <?php
          foreach ($tasks as $row){
            $id = $row['id'];
            $nametask = $row['name'];
            $mota = $row['mota'];
            $trangthai = $row['trangthai'];
            $dealine= $row['dealine'];
            $hrefTask = '/Nhanvien/getTaskNV.php?id=' . $id;
            switch ($trangthai){
              case 'New':
                $badge = 'badge-danger';
                break;
              case 'In progress':
                $badge = 'badge-primary';
                break;
              case "Canceled":
                $badge = 'badge-dark';
                break;
              case "Waiting":
                $badge = 'badge-info';
                break;
              case "Rejected":
                $badge = 'badge-warning';
                break;
              case "Completed":
                $badge = 'badge-success';
                break;          
            }
            if ($trangthai != 'Canceled'){
              
            ?>
              <a href="<?=$hrefTask?>" class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                  <h4 class="mb-1 text text-primary"><?= $nametask ?></h4>
                  <small class="badge <?=$badge?> badge-pill my-auto"><?= $trangthai ?></small>
                </div>
                <p class="mb-1"><?= $mota ?></p>
                <small class="text text-dark">Đến hạn ngày: <?= $dealine?></small>
              </a>
            <?php
            }
          }
        ?>

        <br>
      </div>
    </div>
  </div>

</body>
</html>
