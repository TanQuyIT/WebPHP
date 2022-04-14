<?php

    if (!empty($_POST['user'])){
        $user = $_POST['user'];
        require_once('../conndb.php');
        $sql = 'UPDATE account SET pass = ?, active = ? WHERE user = ?';
        $stm = $conn->prepare($sql);
        $active = 0;
        $stm->bind_param('sis',$user,$active,$user);
        $stm->execute();
        die('đã đặt lại mật khẩu');
    }else{
       header('Location: /login.php');
    }
?>

