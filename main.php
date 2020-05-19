<?php
include_once __DIR__ . "/lib/Functions.php";
include_once __DIR__ . "/lib/Selector.php";

$now = date('Hi');

if($now >= '0800' && $now <= '2200'){}else{
    die("仅能在 每天 早上8点到晚上22点之间 签到".PHP_EOL);
}

if (is_cli() && isset($argv)) {
    $param = getopt('A:P:');
    if(!isset($param['A']) || !isset($param['P'])){
        die("使用方法：php main.php -A 你的账号 -P 你的密码".PHP_EOL.PHP_EOL
            ."例如：php main.php -A 1008611 -P zgyd1008611".PHP_EOL
            ."或者(如果你的账号含有特殊字符，建议使用双引号)：php main.php -A \"1008611\" -P \"zgyd1008611\"".PHP_EOL);
    }
    $account = $param['A'];
    $password = $param['P'];
}else{
    $account = get('account');
    $password = get('password');
}

$jar_path = __DIR__ . "/cookie/{$account}.cookie";//保存 Cookie


//如果存在 cookie 文件，先判断 cookie 是否过期
if (file_get_contents($jar_path)) {
    goto getCourseList;
}else{
    //不存在 cookie 文件，则新建一个
    file_put_contents($jar_path, "#新建一个保存cookie文件");
}
goto takeLogin;//去执行登录操作




//获取课程列表
getCourseList:
$html = curl_get(COURSE_LIST, $jar_path);
$course_list = get_course_list($html);//获取课程列表

if (isset($course_list[0])) {
    goto getTaskID;//获取任务ID
}
goto takeLogin;//去执行登录操作




//获取任务ID
getTaskID:
$taskID = [];
foreach ($course_list as $val) {
    $html = curl_get(sprintf(TASK_ID, $val['courseId'], $val['classId']), $jar_path);
    $res = selector::select($html, '#startList > div', 'css');

    if (isset($res[0])) {
        if (!is_array($res)) continue;
        foreach ($res as $k => $v) {
            $d = selector::select($v, '@activeDetail(.*?)"@', 'regex');
            $d = str_replace(['(', ')', ''], '', $d);
            $d = explode(",", $d);

            if (intval($d[1]) === 2) {
                $taskID[] = [
                    $val['courseId'],//课程ID
                    $val['classId'],//班级ID
                    $d[0],//签到任务ID
                    $val['title']
                ];
            }
        }
    }
}

if (count($taskID) > 0) {
    goto doTask;
}

//preg_match("/进行中(\d+)/", str_replace(['(', ')', "\n", "\t"], '', $html), $matches);
//if(isset($matches[1])){
//    if(intval($matches[1]) > 0){
//        echo '有任务';
//    }
//}
echo "没有待签到的任务".PHP_EOL;
die;


//执行任务
doTask:
foreach ($taskID as $k => $v) {
    echo "正在签到：{$v[3]}...";
    curl_get(sprintf(SIGN, $v[2], $v[1], $v[0]), $jar_path);
    echo "应该签到成功".PHP_EOL.PHP_EOL;
}
die;


//登陆账号
takeLogin:
$login_data = json_decode(curl_get(sprintf(LOGIN_API, $account, $password), $jar_path), true);

if ($login_data === null) {
    echo "登陆失败，超星 API 错误".PHP_EOL;
    unlink($jar_path);//删除文件，避免产生大量的垃圾文件
    die;
}

if (!isset($login_data['success'])) {
    echo "登陆失败，超星 API 错误".PHP_EOL;
    unlink($jar_path);//删除文件，避免产生大量的垃圾文件
    die;
}

if (!$login_data['success']) {
    echo $login_data['errorMsg'].PHP_EOL;
    unlink($jar_path);//删除文件，避免产生大量的垃圾文件
    die;
}

echo "登陆成功".PHP_EOL;
goto getCourseList;