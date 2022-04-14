<?php
session_start();
if (!isset($_SESSION['account'])) {
    header('Location: /login.php');
    die();
}
if ($_SESSION['account']['chucvu'] != 'Trưởng phòng'){
    header('Location: /login.php');
    die();
  }

  require_once('../conndb.php');
    if (empty($_GET['id'])){
        header('Location: /login.php');
        die();
    }
    $id = $_GET['id'];
    $sql = 'SELECT * FROM task WHERE id = ?';

    $stm = $conn->prepare($sql);
    $stm->bind_param('i',$id);

    $stm->execute();

    $result = $stm->get_result();
    if ($result->num_rows != 1){
        header('Location: index');
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Chi tiết task</title>
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
<?php    

    $t = $result->fetch_assoc();
    //var_dump($t);

    $name = $t['name'];
    $nhanvien = $t['nhanvien'];
    $mota = $t['mota'];
    $trangthai = $t['trangthai'];
    $f = $t['file'];
    $src = $t['srcFile'];
    $f_href = '#';
    if (!empty($f)){
        $f_href = '/Truongphong/downloadFile.php?name_down='.$f;
    }
    $dealine = $t['dealine'];
    $ngaygiao = $t['ngaygiao'];
    $ngaythaydoi = $t['ngaythaydoi'];
    
    require_once('navbar.php');

    $dealine;

    if ($ngaythaydoi <= $dealine){
        $dungthoihan = 'đúng deadline';
    }else{
        $dungthoihan = 'trễ deadline';
    }

    //echo $dungthoihan;
  

?>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col col-lg-8 border rounded my-5 p-4 mx-3">
                <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Chi tiết công việc</h3>
                <a href="index.php" class = "btn btn-warning mb-2"><i class="fas fa-tasks"></i> Quay lại danh sách task</a>
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3 class="card-title"><?=$name?></h3>
                        <small class="badge badge-info badge-pill my-auto" id="sttTaskTP">
                            <?=  $trangthai ?>
                        </small>
                    </div>
                    <!-- <small></small> -->
                    <div class="card-body">
                        
                        <p class="card-text mt-2 mx-2">
                            Người thực hiện: <?=$nhanvien?>
                        </p>
                        <p class="card-text mt-2 mx-2">
                            Ngày giao: <?=$ngaygiao?>
                        </p>
                        <p class="card-text mt-2 mx-2">
                            <strong>Ngày hoàn tất: <?=$dealine?></strong> 
                        </p>
                        <p class="card-text mt-2 mx-2">
                            Yêu cầu cụ thể: <?=$mota?>
                        </p>
                        
                        <p class="card-text mt-2 mx-2 mb-3">
                            Tệp đính kèm: <a href="<?=$f_href?>"><?=$f?></a> 
                        </p>
                                             
                    </div>
                    <div class="card-footer">
                       
                        <?php
                            if ($trangthai === 'New'){
                            ?> 
                                <button onclick="btnTPhuyTaskMODAL('<?=$id?>')" id="btnTphuytask" class="btn btn-danger mr-1 px-2">Canceled</button> 
                            <?php

                            }elseif ($trangthai === 'Waiting'){
                            ?>   <button onclick="btnCompleted()" class="btn btn-success mr-1 px-2">Completed</button>
                                 <button onclick="btnRejected()" class="btn btn-warning mr-1 px-2">Rejected</button>
                            <?php
                            }
                        ?>
                    </div>
                </div>
              <!-- chi tiết task -->
              <div class="list-group mt-3">
            
            <?php
                require_once('../conndb.php');
    
                $sql = 'SELECT * FROM chitiettask WHERE idTask = ? ORDER BY timesubmit DESC';
                $stm = $conn->prepare($sql);
                $stm->bind_param('i',$id);
                $stm->execute();

                $result = $stm->get_result();

                $chitiet = array();
                while ($row = $result->fetch_assoc()){
                    $chitiet[] = $row;
                }
                foreach ($chitiet as $ct){
                    $time = $ct['timesubmit'];
                    $noidung = $ct['noidung'];
                    $dealineNew = $ct['dealine'];
                    $fi = $ct['file'];
                    $fi_href = '#';
                    if (!empty($fi)){
                        $fi_href = '/Truongphong/downloadFile.php?name_down='.$fi;
                    }
                    if ($ct['tp_nv'] === 1){
                        // trưởng phòng giao
                    ?>
                    <div class="list-group-item list-group-item-action flex-column">
                        <div class="d-flex w-100  justify-content-between">
                            <small><?=$time?></small>
                            <h6 class="mb-1">Trưởng phòng</h6>
                        </div>
                        
                        <p class="my-1 justify-content-end d-flex">Yêu cầu/nhận xét: <?=$noidung?></p>
                        <p class="mb-1 justify-content-end d-flex">Tập tin đính kèm: <a href="<?=$fi_href?>"><?=$fi?></a></p>
                        <small class="justify-content-end d-flex">Dealine:  <b> <?=$dealineNew?></b></small>
                    </div>
                    <?php
                    }else{
                        // Nhan viên gửi
                    ?>
                    <div class="list-group-item list-group-item-action flex-column">
                        <div class="d-flex w-100  justify-content-between">
                            <h6 class="mb-1"><?=$nhanvien?></h6>
                            <small><?=$time?></small>
                        </div>
                        <p class="my-1 ">Nội dung báo cáo: <?=$noidung?></p>
                        <p class="mb-1 ">Tập tin đính kèm: <a href="<?=$fi_href?>"><?=$fi?></a></p>
                        <small >Dealine:&nbsp;<b> <?=$dealineNew?></b></small>
                    </div>
                    <?php    
                    }
                    
                }                
            ?>    
            </div>   
            </div>
        </div>
    </div>
    <script src="/main.js"></script>
    <!-- Canceled -->
    <div class="modal fade" id="TpHuyTaskMODAL">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Huỷ task</h5>
                    <button type="button" class="close" data-dismiss='modal' aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Có chắc bạn muốn huỷ Task <b><?=$name?></b>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                    <button onclick="TpHuyTask('<?=$id?>')" type="button" class="btn btn-primary">Huỷ task</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- REJECTED -->
    <div class="modal fade" id="TpRejectedMODAL">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Rejected task</h5>
                    <button type="button" class="close" data-dismiss='modal' aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
               <form action="TP_rejectedTask.php" method="POST" novalidate enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="idTask" value="<?=$id?>">
                        <div class="form-group">
                            <label for="nhanxet">Nhận xét</label>
                            <textarea id="nhanxet" name="nhanxet" rows="6" class="form-control" placeholder="Nhận xét báo cáo"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="dealine">Thời điểm hoàn thành</label>
                            <input value="<?=$dealine?>" name="dealine" required class="form-control" type="date" id="dealine">
                        </div>
                        <input type="hidden" name="tp_nv" value="1">
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" name="TPfile" id="TPfile" class="custom-file-input">
                                <label for="TPfile" id="label_name_up" class="custom-file-label">Tập tin bổ sung</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                        <button type="submit" class="btn btn-primary">Rejected</button>
                    </div>
               </form>
            </div>
        </div>
    </div>

    <!-- Completed -->
    <div class="modal fade" id="TpCompletedTaskMODAL">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Completed task</h5>
                    <button type="button" class="close" data-dismiss='modal' aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="TP_CompletedTask.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="idTask" value="<?=$id?>">
                        <label for="danhgia">Đánh giá mức độ hoàn thành của nhân viên</label> 
                        <select name="danhgia" id="danhgia" required class="form-control">
                            <option value="-1" selected>---</option>
                            <option value="Bad">Bad</option>
                            <option value="Ok">Ok</option>
                            <?php 
                                if ($dungthoihan === 'trễ deadline'){
                                   // echo '<option value="Good" disabled>Good</option>';
                                }else{
                                    echo '<option value="Good">Good</option>';
                                }
                            ?>
                        </select>
                    </div>

                    <input type="hidden" name="dungthoihan" value="<?=$dungthoihan?>">
                    <input type="hidden" name="dealine" value="<?=$dealine?>">
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                        <button type="submit" class="btn btn-primary">Completed task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
