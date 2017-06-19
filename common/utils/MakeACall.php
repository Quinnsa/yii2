<?php
namespace common\utils;
/**
 * 拨打电话
 * Created by PhpStorm.
 * User: guoxiaoqiang
 * Date: 2017/6/19
 * Time: 上午11:33
 */
class MakeACall
{

    private static $config;

    public static function init(){
        self::$config = Yii::$app->params['callInfo'];
    }


    public static function by253Voice($mobile,$params,$tpl_id){
        if(empty($mobile)){
            return false;
        }
        $skey = self::$config['253voice']['skey'];
        $account_pwd = self::$config['253voice']['account_pwd'];
        $is_post = 1;
        $timestamp = date("YmdHis");
        //接口参数
        $data = array();
        $data['company'] = "YM1026409"; //必填
        $data['teltemp'] = $tpl_id; //必填
        $contextparm = '';
        foreach($params as $key=>$value){
            $contextparm.= $key.":".$value.",";
        }
        $data['contextparm'] = trim($contextparm,",");

        $data['telno'] = '95213176';
        $data['callingline'] = $mobile;
        $data['keytime'] = $timestamp; //选填
        $data['key'] = md5($skey.$account_pwd.$timestamp); //必填
        $data['sex'] = 2;
        $bodyArr['userinfo'] = $data;
        $body = urlencode(json_encode($bodyArr));
        //发起请求
        $url = "http://audio.253.com/noticeapi/noticeapi_api";
        if($is_post){
            $post_data = 'userinfo='.$body;
            $result = http::post($url,$post_data);
        }else{
            $result = http::get($url."?userinfo=".$body);
        }

        $result = iconv('GBK','UTF-8',$result);
        $resultArr = json_decode($result,true);
        if($resultArr['code'] == 1){
            return true;
        }else{
            BqLogger::error('电话提醒失败', 0, ['return' => $result, 'phone' => $mobile]);
            return false;
        }
    }

    public static function byZhiyu($mobile,$content){
        if(empty($mobile)){
            return false;
        }
        $config = self::$config['zhiyu'];
        $apiAccount = $config['apiAccount'];
        $apiKey = $config['apiKey'];
        $ts = time();
        $data['apiAccount'] = $apiAccount;
        $data['appId'] = "APPffceb12038a447959d339065a67eaa34";
        $data['requestId'] = uniqid().$mobile;
        $data['userData'] = "";
        $data['callee'] = $mobile;
        //$data['calleeDisplay'] = "";
        $data['contentType'] = 0;
        $data['content'] = $content;
        $data['playTimes'] = 3;
        $data['voicemailFlag'] = 0;
        $data['dtmfFlag'] = 0;
        $data['timeStamp'] = "$ts";
        $data['sign'] = md5($apiAccount.$apiKey.$ts);
        $url = $config['restUrl']."/Account/".$apiAccount."/voiceNotice/call";
        $header = ['Content-Type: application/json; charset=UTF-8'];
        $result = http::post($url,$data,$header);
        $arr = json_decode($result,true);
        if($arr['status'] == 0){
            return true;
        }else{
            BqLogger::error('电话提醒失败zhiyu', 0, ['return' => $result, 'phone' => $mobile]);
            return false;
        }
    }
}