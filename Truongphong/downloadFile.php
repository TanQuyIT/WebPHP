<?php
    session_start();
    if (!isset($_SESSION['account'])) {
        header('Location: /login.php');
        die();
    }
    if (!empty($_GET['name_down'])){
        $f = basename($_GET['name_down']);
        $pathdown = $_SERVER['DOCUMENT_ROOT'] . '/Truongphong/UploadFile/'.$f;
        //echo $pathdown;
        if (!empty($f) ){
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$f");
            header("Content-Type: application/zip");
            header("Content-Transfer-Emcoding: binary");

            readfile($pathdown);
            die();
        }
    }else{
        header('Location: /login.php');
    }
?>