<!DOCTYPE html>
<html lang="en">
<head>
<link 
        rel="stylesheet"
        href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>
<body>
  
</body>
</html>
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
              <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                Quản lý tài khoản
              </a>
              <div class="dropdown-menu">
                  <a class="dropdown-item" href="/Account/index.php">Danh sách nhân viên</a>
                  <a class="dropdown-item" href="/Account/addAccount.php">Thêm nhân viên</a>
                  <!-- <a class="dropdown-item" href="#">Link 3</a> -->
              </div>
          </li>
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                Quản lý phòng ban
              </a>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="/Phongban/index.php">Danh sách phòng ban</a>
                <a class="dropdown-item" href="/Phongban/addPhongban.php">Thêm phòng ban</a>
              </div>
          </li>
        <li class="nav-item">
          <a class="nav-link" href="/nghiphep/listYC.php">Quản lý nghỉ phép</a>
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