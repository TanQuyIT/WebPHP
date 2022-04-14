<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">

    <link 
        rel="stylesheet"
        href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>

<?php
   $data = $_SESSION['account'];
   $str = $data['name'];
   $TTCN = (explode(' ',$str)[count(explode(' ',$str)) -1]);
 ?>
 <nav class="navbar navbar-expand-md bg-dark navbar-dark fixed-top">
   <div class="container">
     <a class="navbar-brand" href="/index.php"><i class="fas fa-user-circle"></i> <?=$TTCN?></a>
     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
       <span class="navbar-toggler-icon"></span>
     </button>
     <div class="collapse navbar-collapse" id="collapsibleNavbar">
       <ul class="navbar-nav">
           <li class="nav-item dropdown">
               <a class="nav-link" href="/Nhanvien/" id="navbardrop">
                  Nhiệm vụ 
               </a>
           </li>
           <li class="nav-item dropdown">
               <a class="nav-link" href="/nghiphep/" id="navbardrop">
                  Nghỉ phép
               </a>
           </li>
           
         
   
           
       </ul>
       <div class="nav navbar-nav flex-row justify-content-lg-between ml-auto">
           <a class="nav-item order-2 order-md-1 btn btn-outline-secondary" href="../logout.php">
             <i class="fas fa-sign-out-alt"></i>  
             logout
           </a>
       </div>
     </div>  
   </div>
 </nav>