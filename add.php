<?PHP
// 获取从HTML传过来的数据
$name = $_REQUEST['name'];
$account = $_REQUEST['account'];
$password = $_REQUEST['password'];
if ($account == null || $password == null){
    die("<script>alert('账号或密码不能为空！');location='index.html'</script>");
}
include 'connect.php';
// 查询自动签到列表中是否已存在该账号
$find = "SELECT * FROM list WHERE tel = '$account'";
$find1 = mysqli_query($connect,$find);
if(!$find1){
    die('查询失败' . mysqli_error($connect));
}
$find2 = mysqli_num_rows($find1);
if ($find2 == 0){
    echo "正在添加账号信息到自动签到列表中。。。。。。<br>";
    if ($name == null){
        die("<script>alert('回去给个名字用于备注吧');location='index.html'</script>");
    }
    $add = "INSERT INTO list(name,tel,password) values ('$name','$account','$password')";
    $add1 = mysqli_query($connect,$add);
    if(!$add1){
        die('添加账号到列表失败'. mysqli_error($connect));
    }else{
        die("<script>alert('".$name."，你的账号".$account."已成功添加账号到签到列表，请返回手动执行登录');location='login.html'</script>");
    }
}else{
    die("<script>alert('".$name."，你的账号".$account."已经在签到列表了，正在跳转到手动执行自动签到页面');location='login.html'</script>");
}

?>