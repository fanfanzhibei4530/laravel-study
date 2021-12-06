<div>
    <includetail>
        <div align="center">
            <div class="open_email" style="margin-left: 8px; margin-top: 8px; margin-bottom: 8px; margin-right: 8px;">
                <div>
                    <br>
                    <span class="genEmailContent">
                        <div id="cTMail-Wrap"
                             style="word-break: break-all;box-sizing:border-box;text-align:center;min-width:320px; max-width:660px; border:1px solid #f6f6f6; background-color:#f7f8fa; margin:auto; padding:20px 0 30px; font-family:'helvetica neue',PingFangSC-Light,arial,'hiragino sans gb','microsoft yahei ui','microsoft yahei',simsun,sans-serif">
                            <div class="main-content" style="">
                                <table style="width:100%;font-weight:300;margin-bottom:10px;border-collapse:collapse">
                                    <tbody>
                                    <tr style="font-weight:300">
                                        <td style="width:3%;max-width:30px;"></td>
                                        <td style="max-width:600px;">
                                            {{--   LOGO  --}}
                                            <div id="cTMail-logo" style="width:92px; height:25px;">
                                                {{--   替换跳转链接  --}}
                                                <a href="">
                                                    {{--   替换LOGO图片  --}}
                                                    <img border="0" src="https://imgcache.qq.com/open_proj/proj_qcloud_v2/mc_2014/cdn/css/img/mail/logo-pc.png"
                                                         style="width:92px; height:25px;display:block">
                                                </a>
                                            </div>
                                            {{--   页面上边的蓝色分割线  --}}
                                            <p style="height:2px;background-color: #00a4ff;border: 0;font-size:0;padding:0;width:100%;margin-top:20px;"></p>

                                            <div id="cTMail-inner" style="background-color:#fff; padding:23px 0 20px;box-shadow: 0px 1px 1px 0px rgba(122, 55, 55, 0.2);text-align:left;">
                                                <table style="width:100%;font-weight:300;margin-bottom:10px;border-collapse:collapse;text-align:left;">
                                                    <tbody>
                                                    {{--   第一个单元格  --}}
                                                    <tr style="font-weight:300">
                                                        {{--   左侧表格，设置左边距用的  --}}
                                                        <td style="width:3.2%;max-width:30px;"></td>
                                                        {{--   中间表格，正文使用  --}}
                                                        <td style="max-width:480px;text-align:left;">
                                                            {{--   以下是正文 --}}
                                                            {{--   可以是标题  --}}
                                                            <h1 id="cTMail-title" style="font-size: 20px; line-height: 36px; margin: 0px 0px 22px;">
                                                                【XX平台】欢迎注册XXXXXX
                                                            </h1>

                                                            <p id="cTMail-userName" style="font-size:14px;color:#333; line-height:24px; margin:0;">
                                                                尊敬的XXX用户，您好！
                                                            </p>

                                                            <p class="cTMail-content" style="line-height: 24px; margin: 6px 0px 0px; overflow-wrap: break-word; word-break: break-all;">
                                                                <span style="color: rgb(51, 51, 51); font-size: 14px;">
                                                                    欢迎注册巴拉巴拉一大堆话。
                                                                </span>
                                                            </p>

                                                            <p class="cTMail-content" style="line-height: 24px; margin: 6px 0px 0px; overflow-wrap: break-word; word-break: break-all;">
                                                                <span style="color: rgb(51, 51, 51); font-size: 14px;">完成注册，请点击下面按钮验证邮箱。
                                                                    <span style="font-weight: bold;">非本人操作可忽略。</span>
                                                                </span>
                                                            </p>

                                                            {{--   按钮  --}}
                                                            <p class="cTMail-content"
                                                               style="font-size: 14px; color: rgb(51, 51, 51); line-height: 24px; margin: 6px 0px 0px; word-wrap: break-word; word-break: break-all;">
                                                                {{--   下面替换成自己的链接  --}}
<!--                                                                 <a id="cTMail-btn" href="" title=""
                                                                   style="font-size: 16px; line-height: 45px; display: block; background-color: rgb(0, 164, 255); color: rgb(255, 255, 255); text-align: center; text-decoration: none; margin-top: 20px; border-radius: 3px;">
                                                                    点击此处验证邮箱
                                                                </a> -->
                                                                <span id="cTMail-btn" href="" title=""
                                                                   style="font-size: 16px; line-height: 45px; display: block; background-color: rgb(0, 164, 255); color: rgb(255, 255, 255); text-align: center; text-decoration: none; margin-top: 20px; border-radius: 3px;">
                                                                    验证码：{{$data['code']}}
                                                                </span>
                                                            </p>

                                                            <p class="cTMail-content" style="line-height: 24px; margin: 6px 0px 0px; overflow-wrap: break-word; word-break: break-all;">
                                                                <span style="color: rgb(51, 51, 51); font-size: 14px;">
                                                                    <br>
                                                                    无法正常显示？请复制以下链接至浏览器打开：
                                                                    <br>
                                                                    <a href="" title=""
                                                                       style="color: rgb(0, 164, 255); text-decoration: none; word-break: break-all; overflow-wrap: normal; font-size: 14px;">
                                                                        这里是激活账号的链接
                                                                    </a>
                                                                </span>
                                                            </p>

                                                            {{--   来个署名  --}}
                                                            <dl style="font-size: 14px; color: rgb(51, 51, 51); line-height: 18px;">
                                                                <dd style="margin: 0px 0px 6px; padding: 0px; font-size: 12px; line-height: 22px;">
                                                                    <p id="cTMail-sender" style="font-size: 14px; line-height: 26px; word-wrap: break-word; word-break: break-all; margin-top: 32px;">
                                                                        此致
                                                                        <br>
                                                                        <strong>XXX团队</strong>
                                                                    </p>
                                                                </dd>
                                                            </dl>
                                                        </td>
                                                        {{--   右侧表格，设置右边距用的  --}}
                                                        <td style="width:3.2%;max-width:30px;"></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            {{--   页面底部的推广  --}}
                                            <div id="cTMail-copy" style="text-align:center; font-size:12px; line-height:18px; color:#999">
                                                <table style="width:100%;font-weight:300;margin-bottom:10px;border-collapse:collapse">
                                                    <tbody>
                                                    <tr style="font-weight:300">
                                                        {{--   左，左边距  --}}
                                                        <td style="width:3.2%;max-width:30px;"></td>
                                                        {{--   中，正文  --}}
                                                        <td style="max-width:540px;">

                                                            <p style="text-align:center; margin:20px auto 14px auto;font-size:12px;color:#999;">
                                                                此为系统邮件，请勿回复。
                                                                {{--   可以加个链接  --}}
                                                                <a href=""
                                                                   style="text-decoration:none;word-break:break-all;word-wrap:normal; color: #333;" target="_blank">
                                                                    取消订阅
                                                                </a>
                                                            </p>

                                                            {{--   可以加个图片，公众号二维码之类的  --}}
                                                            <p id="cTMail-rights" style="max-width: 100%; margin:auto;font-size:12px;color:#999;text-align:center;line-height:22px;">
                                                                <img border="0" src="http://imgcache.qq.com/open_proj/proj_qcloud_v2/tools/edm/css/img/wechat-qrcode-2x.jpg"
                                                                     style="width:64px; height:64px; margin:0 auto;">
                                                                <br>
                                                                关注服务号，移动管理云资源
                                                                <br>
                                                                <img src="https://imgcache.qq.com/open_proj/proj_qcloud_v2/gateway/mail/cr.svg" style="margin-top: 10px;">
                                                            </p>
                                                        </td>
                                                        {{--   右，右边距  --}}
                                                        <td style="width:3.2%;max-width:30px;"></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                        <td style="width:3%;max-width:30px;"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </span>
{{--                    <br>--}}
                </div>
            </div>
        </div>
    </includetail>
</div>
