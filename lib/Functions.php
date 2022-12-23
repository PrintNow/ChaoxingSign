<?php
//define("LOGIN_API", "http://i.chaoxing.com/vlogin?userName=%s&passWord=%s");//~~登录接口~~ 该接口目前失效
define("LOGIN_API", "https://passport2-api.chaoxing.com/v11/loginregister?uname=%s&code=%s");//登录接口

define("COURSE_LIST", "http://mooc1-api.chaoxing.com/mycourse/backclazzdata");//获取课程 courseId、classId
define("COURSE_LIST_OLD", "http://mooc1-2.chaoxing.com/visit/interaction");//<旧方法>获取课程 courseId、classId

define("TASK_ID", "https://mobilelearn.chaoxing.com/ppt/activeAPI/taskactivelist?courseId=%s&classId=%s");//获取任务 ID
define("TASK_ID_OLD", "http://mobilelearn.chaoxing.com/widget/pcpick/stu/index?courseId=%s&jclassId=%s");//获取任务 ID

define("PRE_SIGN_API", "https://mobilelearn.chaoxing.com/newsign/preSign?courseId=%s&classId=%s&activePrimaryId=%s&general=1&sys=1&ls=1&appType=15&&tid=&ut=s");//预签到API
define("SIGN_API", "https://mobilelearn.chaoxing.com/pptSign/stuSignajax?activeId=%s");//获取任务 ID
define("SIGN_API_WITH_GPS", "https://mobilelearn.chaoxing.com/pptSign/stuSignajax?activeId=%s&latitude_gd=%s&longitude_gd=%s&longitude=%s&latitude=%s&address=%s"); //签到(位置)
define("SIGN_API_OLD", "http://mobilelearn.chaoxing.com/widget/sign/pcStuSignController/preSign?activeId=%s&classId=%s&courseId=%s");//<旧方法>获取任务 ID

/**
 * 判断某时间是否在某个区间内
 * @param int $time 传入秒级时间戳 time()
 * @param array $timeBetween 传入区间，如 ['08:00:00', '18:00:00']
 * @return bool true: 在时间区间内，false：不在时间区间内
 */
function timeInterval(int $time, array $timeBetween)
{
    $checkDayStr = date('Y-m-d', time());
    $timeBegin = strtotime($checkDayStr . $timeBetween[0]);
    $timeEnd = strtotime($checkDayStr . $timeBetween[1]);

    if ($time > $timeBegin && $time < $timeEnd) {
        return true;
    }

    return false;//不在时间区间内
}

/**
 * SERVER CHAN 微信推送
 * @param string $text 消息标题，最长为256，必填。
 * @param string $desp 消息内容，最长64Kb，可空，支持MarkDown。
 * @param string $key 获取方式：http://sc.ftqq.com/?c=code
 * @return false|string
 */
function sc_send($text = '', $desp = '', $key = '')
{
    $postdata = http_build_query(
        array(
            'text' => $text,
            'desp' => $desp
        )
    );

    $opts = array('http' =>
        array(
            'method' => 'POST',
            'timeout' => 5,//超时时间 5秒
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata
        )
    );
    $context = stream_context_create($opts);

    return json_decode(@file_get_contents('https://sctapi.ftqq.com/' . $key . '.send', false, $context), true);
}

/**
 * Telegram 推送
 */
function tg_send($chatID, $message, $token)
{
    $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chatID;
    $url = $url . "&text=" . urlencode($message);
    $ch = curl_init();
    $optArray = array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true
    );
    curl_setopt_array($ch, $optArray);
    $result = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($result, true);
    return $result;
}

/**
 * Bark 推送
 */
function bark_send($title, $content, $api)
{
    $url = $api."/".urlencode($title)."/".urlencode($content)."/?icon=https://s3.missuo.me/images/azB3Ba.jpg";
    $res = curl_get($url);
    $result = json_decode($res, true);
    return $result;
}

/**
 * Go-cqhttp 推送
 */
function Go_cqhttp_send($QQ, $message, $API, $access_token = null)
{
    $postdata = array();
    if(!empty(preg_match('#send_private_msg#i',$API)))
    {
        $postdata['user_id'] = $QQ;
    }
    else
    {
        $postdata['group_id'] = $QQ;
    }
    $postdata['message'] = $message;
    $postdata['auto_escape'] = true;
    $ch = curl_init();
    $optArray = array(
        CURLOPT_URL => $API,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($postdata),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array('Content-Type: application/json','Authorization: Bearer '.$access_token)
    );
    curl_setopt_array($ch, $optArray);
    $result = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($result, true);
    return $result;
}

/**
 * 判断是否为命令行模式
 * @return bool
 */
function is_cli()
{
    return preg_match("/cli/i", php_sapi_name()) ? true : false;
}


/**
 * 获取课程列表 <旧方法，保留备用>
 * @param $html
 * @return array
 * @author Chuwen<wenzhouchan@gmail.com>
 */
function get_course_list($html)
{
    $data = selector::select($html, 'li[style="position:relative"]', 'css');

    if ($data === NULL) return [];

    $class_list = [];
    foreach ($data as $k => $v) {
        $class_list[] = [
            'courseId' => selector::select($v, '@<input type="hidden" name="courseId" value="(.*?)" />@', 'regex'),
            'classId' => selector::select($v, '@<input type="hidden" name="classId" value="(.*?)" />@', 'regex'),
            'title' => selector::select($v, '.clearfix > a', 'css'),
        ];
    }

    return $class_list;
}


function get($parameter, $default = null, $filter = 'trim')
{
    return isset($_GET[$parameter]) ? $filter($_GET[$parameter]) : $default;
}

/**
 * @param $parameter
 * @param null $default
 * @param string $filter
 * @return null
 * @author Chuwen<wenzhouchan@gmail.com>
 */
function post($parameter, $default = null, $filter = 'trim')
{
    return isset($_POST[$parameter]) ? $filter($_POST[$parameter]) : $default;
}


/**
 *curl get请求
 */
function curl_get($url, $cookie_jar = '', $header_type="PC")
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);//登陆后要从哪个页面获取信息
    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    //取消 SSL 证书验证
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

    if($header_type == "PC"){
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36");
    }else{
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (iPhone; CPU iPhone OS 15_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 (device:iPhone13,2) Language/zh-Hans com.ssreader.ChaoXingStudy/ChaoXingStudy_3_5.2.1_ios_phone_202204211530_81 (@Kalimdor)_14895834084271104281");
    }

    curl_setopt($curl, CURLOPT_TIMEOUT, 10);

    // $streamVerboseHandle = fopen("out.txt", 'a+');
	// curl_setopt($curl, CURLOPT_VERBOSE, 1);
	// curl_setopt($curl, CURLOPT_STDERR, $streamVerboseHandle);
  
    if (!empty($cookie_jar)) {
        curl_setopt($curl, CURLOPT_COOKIEFILE, realpath($cookie_jar)); //读取现有Cookie
        curl_setopt($curl, CURLOPT_COOKIEJAR, realpath($cookie_jar)); //保存返回的Cookie
    }

    $content = curl_exec($curl);
    list($header, $body) = explode("\r\n\r\n", $content, 2);

    curl_close($curl);
	// fclose($streamVerboseHandle);
    return $body;
}
