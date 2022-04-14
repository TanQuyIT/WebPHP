<?php
    $host = 'mysql-server';
    $username = 'root';
    $password = 'root';
    $database = 'database';

    $conn = new mysqli($host,$username,$password,$database);
    //header('Location: login.php');
    return
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Web không tồn tại</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container m-auto" style="padding-top: 50px;" >

        <h3>Trang web không thể truy cập được</h3>
        <a href="/index.php" class="btn btn-primary">Quay lại</a>
    </div>
</body>
</html>