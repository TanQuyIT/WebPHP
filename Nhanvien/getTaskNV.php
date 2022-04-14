<?php
 session_start();
 if (empty($_GET['id'])){
    header('Location: /login.php');
    die();
}

if (!isset($_SESSION['account'])) {
    header('Location: /login.php');
    die();
}
if ($_SESSION['account']['chucvu'] !='Nhân viên'){
    header('Location: /login.php');
    die();
  }
  require_once('../conndb.php');
    $id = $_GET["id"];
    
    $sql = 'SELECT * FROM task WHERE id = ?';

    $stm = $conn->prepare($sql);
    $stm->bind_param('i',$id);

    $stm->execute();

    $result = $stm->get_result();
    if ($result->num_rows !=1){
        header('Location: /login.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Chi tiết Task</title>
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
    $mota = $t['mota'];
    $trangthai = $t['trangthai'];
    $f = $t['file'];
    $src = $t['srcFile'];
    $dealine = $t['dealine'];
    $ngaygiao = $t['ngaygiao'];
    $f_href = '#';
    if (!empty($f)){
        $f_href = '/Truongphong/downloadFile.php?name_down='.$f;
    }
    $danhgia = $t['danhgia'];
    $dungthoihan = $t['dungthoihan'];
    require_once('navbar.php');
   
?>
<body style="background-color: lightcyan;">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col col-lg-8 border rounded my-5 p-4 mx-3" style="background-color: #ffffff;">
                <h3 class="text-center text-secondary mt-2 mb-3">Chi tiết công việc</h3>
                <a href="index.php" class = "btn btn-warning mb-2"><i class="fas fa-tasks"></i> Quay lại danh sách task</a>

                <!-- thông tin chung -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3 class=" card-title"><?=$name?></h3>
                        <small id="sttTaskNV" class="badge badge-dark badge-pill my-auto"><?=  $trangthai ?></small>
                    </div>
                    <!-- <small><?=$dealine?></small> -->
                    <div class="card-body">
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
                        <div class="row justify-content-end">
                        <?php
                        if ($trangthai === 'New'){
                            ?><button onclick="btn_NVtask(this,'<?=$trangthai?>','<?=$id?>')" id="nvbtn" class="btn btn-info px-5 mr-4 my-1">Start</button><?php

                        }elseif ($trangthai === 'In progress' || $trangthai === 'Rejected'){
                            
                            ?><button onclick="btn_NVtask(this,'<?=$trangthai?>','<?=$id?>')" id="nvbtn" class="btn btn-info px-5 mr-4 my-1">Báo cáo kết quả</button><?php
                        } if ($trangthai === 'Completed'){
                            ?> <h5 class="m-auto text text-success">Đánh giá từ trưởng phòng: <?=$danhgia?></h5> 
                                <h5 class="m-auto text text-success">Thực hiện <?=$dungthoihan?></h5>
                            <?php
                        }
            
                        ?>
                        </div>
                        <!-- <samp>Nhấn nút Start để bắt đầu thực hiện công việc</samp> -->

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
                            <h6 class="mb-1">Trưởng phòng</h6>
                            <small><?=$time?></small>
                        </div>
                        
                        <p class="my-1 ">Yêu cầu/nhận xét: <?=$noidung?></p>
                        <p class="mb-1 ">Tập tin đính kèm: <a href="<?=$fi_href?>"><?=$fi?></a></p>
                        <small >Dealine:  <b> <?=$dealineNew?></b></small>
                    </div>
                    <?php
                    }else{
                        // Nhan viên gửi
                    ?>
                    <div class="list-group-item list-group-item-action flex-column">
                        <div class="d-flex w-100  justify-content-between">
                            <small><?=$time?></small>
                            <h6 class="mb-1">Tên nhân viên</h6>
                        </div>
                        <p class="my-1 justify-content-end d-flex">Nội dung báo cáo: <?=$noidung?></p>
                        <p class="mb-1 justify-content-end d-flex">Tập tin đính kèm: <a href="<?=$fi_href?>"><?=$fi?></a></p>
                        <small class="justify-content-end d-flex">Dealine:&nbsp;<b> <?=$dealineNew?></b></small>
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
    <div class="modal fade" id="getTaskNV_MODAL">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nộp báo cáo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="" novalidate enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="noidung">Nội dung báo cáo</label>
                            <textarea id="noidungBC_nv" name="noidung" rows="8" class="form-control" placeholder="Nội dung báo cáo"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="custom-file">
                                <input name="NV_file" type="file" class="custom-file-input" id="NV_file">
                                <label class="custom-file-label" for="NVfile">Tập tin đính kèm</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div id="errNV_submit" class='alert alert-danger' style="display:none">Vui lòng điền kết quả báo cáo</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button onclick="NVsubmitTask('<?=$id?>','<?=$dealine?>')" type="button" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
