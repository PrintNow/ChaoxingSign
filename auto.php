<?PHP
include 'connect.php';
$sql = "SELECT * FROM list";
$list = mysqli_query($connect,$sql);
while($run = mysqli_fetch_assoc($list)){
    $account = $run['tel'];
    $password = $run['password'];
    $name = $run['name'];
    $url = "https://这里换成你自己的部署地址/main.php?account=$account&password=$password";
    $single = file_get_contents($url);
    if($single){
        echo $single;
        echo "<br>";
        echo $name."尝试签到完成<br><hr>";
    }else{
        echo $name."尝试签到失败<br><hr>";
    }
}
?>