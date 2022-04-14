<?php
  session_start();

  if (!isset($_SESSION['account'])) {
      header('Location: /login.php');
      die();
  }


  $data= $_SESSION['account'];
  if ($data['chucvu'] != 'Trưởng phòng'){
    header('Location: /login.php');
  }

  $idTP = $data['id'];
  $phongban = $data['phongban'];
  $idPhong = $data['idPhong'];

  require_once('../conndb.php');
  $sql = 'SELECT * FROM task WHERE idPhong = ? ORDER BY ngaythaydoi DESC';
  
  $stm = $conn->prepare($sql);
  $stm->bind_param('i',$idPhong);
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
  <link rel="stylesheet" href="/style.css">
</head>
<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-xl-9 col-lg-8 col-md-10 border rounded my-5 p4 mx-3" style="background-color: #ffffff">
        <h2 class="text-center text-secondary mt-2 mb-3">Danh sách công việc</h2>
        
        <a href="addTask.php" class = "btn btn-success mb-2"><i class="far fa-plus-square"></i> Thêm task</a>
        
        <?php
          if (count($tasks) > 0){
          foreach ($tasks as $row){
            $id = $row['id'];
            $nametask = $row['name'];
            $nhanvien = $row['nhanvien'];
            $trangthai = $row['trangthai'];
            $dealine= $row['dealine'];
            $hrefTask = '/Truongphong/getTaskTP.php?id=' . $id;
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
        ?>
          <a href="<?=$hrefTask?>" class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
              <h4 class="mb-1 text text-primary"><?= $nametask ?></h4>
              <small class="badge <?=$badge?> badge-pill my-auto"><?= $trangthai ?></small>
            </div>
            <p class="mb-1"><?= $nhanvien ?></p>
            <small>Đến hạn ngày: <?= $dealine?></small>
          </a>
        <?php
          } }
        ?>

        <br>
      </div>
    </div>
  </div>

</body>
</html>
