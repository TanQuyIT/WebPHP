<?php
    $input = json_decode(file_get_contents('php://input'));
    
    if (is_null($input)){
        header('Location: /login.php');
    }

    if (empty($input->id) || empty($input->trangthai)){
        header('Locaiton: /login.php');
    }
    
    $id = $input->id;
    $trangthai = $input->trangthai;
    // die($id.'  ' .'   '.$trangthai);

    require_once('../conndb.php');
    $sql = 'UPDATE task SET trangthai = ? WHERE id = ?';

    $stm = $conn->prepare($sql);
    $stm->bind_param('si',$trangthai,$id);

    if ($stm->execute()){
        die ('Oke');
    }
    
?>