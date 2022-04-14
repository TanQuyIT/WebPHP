<?php
     header('Content-Type: application/json');
     header('Access-Control-Allow-Origin: *');
     header('Access-Control-Allow-Methods: POST');
     header('Access-Control-Allow-Headers: Content-Type');
     $input = json_decode(file_get_contents('php://input'));
     if (is_null($input)){
         //error_response(3, 'API chỉ hỗ trợ Json');
         header('Location: index.php');
     }
     require_once('updateChucVu.php');

     function error_response($code, $message){
        $res = array();
        $res['code'] = $code;
        $res['message'] = $message;
        die(json_encode($res));
    }

    function success_response($data, $message){
        $res = array();
        $res['code'] = 0;
        $res['message'] = $message;
        $res['data'] = $data;
        die(json_encode($res));
    }

 

    if (!property_exists($input,'id_phongban') || !property_exists($input,'id') || !property_exists($input,'name')){
        error_response(1,'Thiếu thông tin đầu vào');
    }

    if (empty($input->id_phongban) || empty($input->id) || empty($input->name)){
        error_response(2,'Thông tin đầu vào không đúng tiêu chuẩn');
    }


    $id_phongban = $input->id_phongban;
    $id = $input->id;
    $name = $input->name;

    $result = thangchuc($id_phongban,$id,$name);

    if ($result){
        success_response($id,'Đã thăng chức');
    }else{
        error_response(4,'Trưởng phòng vẫn chưa được thay đổi');
    }

?>

