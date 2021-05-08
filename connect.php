<?php
// 连接MySQL数据库
$connect = mysqli_connect('数据库连接地址，一般是localhost', '这里改成你自己连接数据库的用户名','数据库密码','数据库名');
mysqli_query($connect , "set names utf8");
?>