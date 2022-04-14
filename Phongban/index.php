<?php
   session_start();
   if (!isset($_SESSION['account'])) {
       header('Location: /login.php');
       die();
   }
   if ($_SESSION['account']['chucvu'] != 'Giám đốc'){
       header('Location: /login.php');
       die();
   }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Danh sách phòng ban</title>
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
 
    require_once('../conndb.php');
    $sql = 'SELECT * FROM phongban';

    $result = $conn->query($sql);
    $phongbans = array();
    
    while ($row = $result->fetch_assoc()){
        $phongbans[] = $row;
    }
    require_once('../Account/navbar.php');
?>

<body>
    <br>
    <div class="container col col-xl-10 col-sm-11 mt-5" >
        <h2 class="text-center text-secondary mb-3">Danh sách các phòng ban</h2>
        <a href="addPhongban.php" class="btn btn-outline-primary mb-3"><i class="fas fa-plus-square"></i> Thêm phòng ban</a>
        <div class="table-responsive ">
            <table class="table table-bordered table-hover text-center">
                <thead class="thead-light">
                    <th>Số phòng</th>
                    <th>Tên Phòng</th>
                    <th>Trưởng phòng</th>
                    <th>Chỉnh sửa</th>
                </thead>
                <tbody>
                <?php
                    foreach ($phongbans as $row){
                        $id = $row['id'];
                        $sophong = $row['sophong'];
                        $name = $row['name'];
                        $truongphong = $row['truongphong'];
                        if (empty($truongphong)){
                            $truongphong = '---';
                        }
                ?>
                    <tr>
                        <td style="width: 10%"><?=$sophong?></td>
                        <td><a href="CTphong.php?id=<?=$id?>"><?=$name?></a></td>
                        <td class="">
                            <?=$truongphong?>
                        </td>
                    
                        <td style="width: 15%">
                            <a href="updatePhongban.php?id=<?=$id?>" class="btn btn-sm btn-outline-info" data-toggle="tooltip" title="Chỉnh sửa thông tin phòng ban"><i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                <?php } ?>    
                </tbody>
            </table>
            <div class="alert alert-warning" role="alert">
                <h4 class="alert-heading">Chú thích!</h4>
                <p>Click vào tên phòng ban để xem thông tin chi tiết phòng ban.</p>
                <p>Chức năng chọn/đổi trưởng phòng nằm trong chi tiết phòng ban.</p>
                <hr>
                <p>Nhân viên của phòng nào chỉ có thể làm trưởng phòng của phòng đó.</p>
                <p>Mỗi phòng chỉ có một và chỉ một trưởng phòng. Nếu phòng ban đã có trưởng phòng nhưng lại chọn một nhân viên khác làm trưởng phòng đồng nghĩa với việc cách chức trưởng phòng hiện tại.</p>
            </div>
        </div>
    </div>


</body>
</html>