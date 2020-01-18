<?php include 'database.php' ?>
<nav class="navbar navbar-default">
<div class="container">
 <ul class="nav navbar-nav">
 <li>
 <a href="index.php">Trang chủ</a>
 </li>
 <?php if(in_array('Phân quyền',$_SESSION['auth_user']['permission_name'])) { ?>
 <li class="active">
 <a href="users.php">Quản lý User</a>
 </li>
 <li>
 <a href="roles.php">Quản lý vai trò</a>
 </li>
<li>
 <a href="permission.php">Quản lý quyền</a>
 </li>
 <?php  } ?>
 <li>
 <a href="logout.php">Đăng Xuất</a>
 </li>
 </ul>
 </div>
</nav>
