<?php
//define("LOGIN_API", "http://i.chaoxing.com/vlogin?userName=%s&passWord=%s");//~~登录接口~~ 该接口目前失效
define("LOGIN_API", "https://passport2-api.chaoxing.com/v11/loginregister?uname=%s&code=%s");//登录接口

define("COURSE_LIST", "http://mooc1-api.chaoxing.com/mycourse/backclazzdata");//获取课程 courseId、classId
define("COURSE_LIST_OLD", "http://mooc1-2.chaoxing.com/visit/interaction");//<旧方法>获取课程 courseId、classId

define("TASK_ID", "http://mobilelearn.chaoxing.com/widget/pcpick/stu/index?courseId=%s&jclassId=%s");//获取任务 ID

define("SIGN_API", "https://mobilelearn.chaoxing.com/pptSign/stuSignajax?activeId=%s");//获取任务 ID
define("SIGN_API_OLD", "http://mobilelearn.chaoxing.com/widget/sign/pcStuSignController/preSign?activeId=%s&classId=%s&courseId=%s");//<旧方法>获取任务 ID

/**
 * SERVER CHAN 微信推送
 * @param string $text         消息标题，最长为256，必填。
 * @param string $desp         消息内容，最长64Kb，可空，支持MarkDown。
 * @param string $key          获取方式：http://sc.ftqq.com/?c=code
 * @return false|string
 */
function sc_send($text='', $desp = '', $key = '')
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

    $result = json_decode(@file_get_contents('https://sc.ftqq.com/' . $key . '.send', false, $context), true);
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
function curl_get($url, $cookie_jar)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);//登陆后要从哪个页面获取信息
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    //取消 SSL 证书验证
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

    curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4121.0 Safari/537.36 Edg/84.0.495.2");
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_jar); //保存返回的Cookie
    curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie_jar); //读取现有Cookie
    $content = curl_exec($curl);
    curl_close($curl);

    return $content;
}