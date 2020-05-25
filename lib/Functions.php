<?php
//define("LOGIN_API", "http://i.chaoxing.com/vlogin?userName=%s&passWord=%s");//~~登录接口~~ 该接口目前失效
define("LOGIN_API", "https://passport2-api.chaoxing.com/v11/loginregister?uname=%s&code=%s");//登录接口
define("COURSE_LIST", "http://mooc1-2.chaoxing.com/visit/interaction");//获取课程 courseId、classId
define("TASK_ID", "http://mobilelearn.chaoxing.com/widget/pcpick/stu/index?courseId=%s&jclassId=%s");//获取任务 ID
define("SIGN", "http://mobilelearn.chaoxing.com/widget/sign/pcStuSignController/preSign?activeId=%s&classId=%s&courseId=%s");//获取任务 ID

/**
 * 判断是否为命令行模式
 * @return bool
 */
function is_cli(){
    return preg_match("/cli/i", php_sapi_name()) ? true : false;
}

/**
 * 返回课程列表
 * @author Chuwen<wenzhouchan@gmail.com>
 * @param $html
 * @return array
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
 * @author Chuwen<wenzhouchan@gmail.com>
 * @param $parameter
 * @param null $default
 * @param string $filter
 * @return null
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