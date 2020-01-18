<?php
$database['host'] = 'localhost'; //Tên Hosting
$database['dbname'] = 'phan_quyen'; //Tên của Database
$database['username'] = 'root'; //Tên sử dụng Database
$database['password'] = ''; //Mật khẩu sử dụng Database
$connect=mysqli_connect("{$database['host']}","{$database['username']}","{$database['password']}"); // Tạo kết nối
mysqli_select_db($connect, "{$database['dbname']}") or die("Không thể chọn database"); // chọn bảng
mysqli_set_charset($connect, 'UTF8'); // set ngôn ngữ
?>