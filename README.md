# ⭐ ChaoxingSign | 超星学习通签到

PHP 版超星学习用自动签到，支持多用户签到，二次开发便捷！

`PHP 7.3` 测试通过，理应 `PHP 5.4` 及以上都能够使用

`PHP 8.0`网页方式测试没问题，但命令行似乎跑不起来，可能是因为我没安装`curl`扩展<del>（问了原作者，他这么说的，我还没测试）</del>

- 登录方式：

支持手机号码登录，暂时不支持学号登陆！！！

- 签到功能：

支持普通签到，手势签到，~~二维码签到~~，位置签到，~~拍照签到~~

# 🎨 更新日志

<details open>
  <summary>2021/05/8</summary>

- `index.html`中新增icp备案和公安网备案部分代码（已注释掉，根据需要自行取消注释并替换内容），部署到国内环境时需要先去备案才能用自己的域名访问


<details open>
  <summary>2021/05/1</summary>

- 新增`index.html`，采用`post`方式传值到`main.php`,让账号密码不显示在浏览器地址栏中；修改`main.php`的传值接收方式为`$_REQUEST`，使它同时可以接收`post`和`get`传值（定时任务仍采用`get`传值）。

</details>
<details open>
  <summary>2021/03/21</summary>

- <a href="https://github.com/PrintNow/ChaoxingSign/issues/6">#6</a> 升级为新版 Server 酱推送通道，原因：微信发布公告将在2021年4月底下线模板消息，故旧版推送通道将于 2021年4月 下线
  > 获取本源码后，请配置 `Config.php` 的相关配置
  >

</details>

<details open>
  <summary>2020/06/13</summary>

- 修复 <a href="https://github.com/PrintNow/ChaoxingSign/issues/2">#2</a> 的问题，配置了 Server酱但不推送的问题
- 更改 判断时间区间的方法
- 添加 获取课程列表失败，重试2次以判断是API错误

</details>

<details>
  <summary>2020/05/27</summary>

- 修复 <a href="https://github.com/PrintNow/ChaoxingSign/issues/1">#1</a>
- 更改 获取课程、签到 API
- 添加 手势、位置、二维码一键签到
- 添加 Server酱 微信推送，需要配置 `config.php` 文件

</details>

<details>
  <summary>2020/05/25</summary>

- 更改 登录接口，原接口已经失效

</details>

# 🎁 TODO

- [] 接入钉钉机器人 API

# 🧀 使用方法

1. 下载源码：

   直接下载：https://github.com/PrintNow/ChaoxingSign/archive/master.zip

   克隆源码：`git clone https://github.com/PrintNow/ChaoxingSign`
2. 🚀 运行

   1. 上传到**网站根目录**运行

      然后访问 `http://你的域名/main.php?account=你的超星账号&password=你的超星密码`
   2. 或者使用**命令行**运行

      ```
      php main.php -A "你的超星账号" -P "你的超星密码"
      ```
3. ⚙ 实现自动签到

   > 推荐大于等于 **10 分钟** 执行一次，避免出现异常
   >
   > 我已经硬编仅能在每天的 08:00 ~ 22:00 之间运行，
   > 如果要取消或修改这一限制，请删除或注释
   > `main.php` 第 7~9 行
   >

   1. 如果以**网页方式**运行，定时监控 `http://你的域名/main.php?account=你的超星账号&password=你的超星密码` 即可
   2. 如果使用**命令行方式**运行，添加 `crontab` 任务即可，具体添加 `crontab 任务` 方法可以网上搜。
      每天 早上8点到晚上22点之间，每10分钟签到一次 crontab 表达式：`0 */10 8-22 * * * *`

# √ 运行输出

签到成功：

```
正在签到：陈半仙@测试班级
[2020-06-13 11:44:14]签到成功

Server酱 消息推送成功
```

没有签到任务：

```
没有待签到的任务
```

# ❗ 注意

超星**可能**屏蔽了如 阿里云、腾讯云、百度云... 等 IDC IP 地址，故有可能出现未知的错误（我没测试，我仅在家庭宽带中测试成功）

# 🙇‍ 感谢

> 本项目的实现参考了以下文章

- https://www.z2blog.com/index.php/learn/423.html
- https://www.z2blog.com/index.php/default/459.html

> 本项目中使用到的 `Selector.php` 来自 [PHPSpider](https://github.com/owner888/phpspider)

# License

遵循 [MIT License](./LICENSE) 协议

## 其它版本签到脚本推荐

> 排名不分先后


| 项目地址                                                | 开发语言   | 备注                                           |
| --------------------------------------------------------- | ------------ | ------------------------------------------------ |
| https://github.com/mkdir700/chaoxing_auto_sign          | Python     | 超星学习通自动签到脚本&多用户多任务&API        |
| https://github.com/Wzb3422/auto-sign-chaoxing           | TypeScript | 超星学习通自动签到，梦中刷网课                 |
| https://github.com/aihuahua-522/chaoxing-testforAndroid | Java       | 学习通（超星）自动签到                         |
| https://github.com/yuban10703/chaoxingsign              | Python     | 超星学习通自动签到                             |
| https://github.com/Huangyan0804/AutoCheckin             | Python     | 学习通自动签到，支持手势，二维码，位置，拍照等 |
