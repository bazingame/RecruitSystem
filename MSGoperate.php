<<<<<<< HEAD
<?php
class MSGoperate
{
    //验证apikey是否可用
    public function checkApiKey($apikey){
        $url = 'https://sms.yunpian.com/v2/user/get.json';
        $data = array('apikey'=>$apikey);
        $res = $this->curlTool($url,$data);
        if(isset($res['nick'])){
            return 1;
        }else{
            return 0;
        }
    }
    //获取模板
    public function getMsgModel($apikey,$model_id){
        $url = "https://sms.yunpian.com/v2/tpl/get.json";
        $data = array("apikey"=>$apikey,'tpl_id'=>$model_id);
        $res = $this->curlTool($url,$data);
        return $res;
    }
    //删除模板
    public function delModel($apikey,$tpl_id){
        $url = 'https://sms.yunpian.com/v2/tpl/del.json';
        $data = array('apikey'=>$apikey,'tpl_id'=>$tpl_id);
        $res = $this->curlTool($url,$data);
        return $res;
    }
    //添加模板
    public function addModel($apikey,$model){
        $url = 'https://sms.yunpian.com/v2/tpl/add.json';
        $data = array('apikey'=>$apikey,'tpl_content'=>$model);
        $res = $this->curlTool($url,$data);
        return $res;
    }

    //批量发送信息
    public function sendMessage1($apikey,$mobile,$text){
        $url = 'https://sms.yunpian.com/v2/sms/batch_send.json';
        $data = array('apikey'=>$apikey,'mobile'=>$mobile);
        $res = $this->curlTool($url,$data);
        return $res;
    }

    //单条发送
    public function sendMessage($apikey,$mobile,$text){
        $url = 'https://sms.yunpian.com/v2/sms/single_send.json';
        $data = array('apikey'=>$apikey,'mobile'=>$mobile,'text'=>$text);
        $res = $this->curlTool($url,$data);
        return $res;
    }

    public function curlTool($url,$data){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8', 'Content-Type:application/x-www-form-urlencoded','charset=utf-8'));
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,  http_build_query($data));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //跳过证书检查
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res,true);
        return $res;
    }
=======
<?php
class MSGoperate
{
    //验证apikey是否可用
    public function checkApiKey($apikey){
        $url = 'https://sms.yunpian.com/v2/user/get.json';
        $data = array('apikey'=>$apikey);
        $res = $this->curlTool($url,$data);
        if(isset($res['nick'])){
            return 1;
        }else{
            return 0;
        }
    }
    //获取模板
    public function getMsgModel($apikey,$model_id){
        $url = "https://sms.yunpian.com/v2/tpl/get.json";
        $data = array("apikey"=>$apikey,'tpl_id'=>$model_id);
        $res = $this->curlTool($url,$data);
        return $res;
    }
    //删除模板
    public function delModel($apikey,$tpl_id){
        $url = 'https://sms.yunpian.com/v2/tpl/del.json';
        $data = array('apikey'=>$apikey,'tpl_id'=>$tpl_id);
        $res = $this->curlTool($url,$data);
        return $res;
    }
    //添加模板
    public function addModel($apikey,$model){
        $url = 'https://sms.yunpian.com/v2/tpl/add.json';
        $data = array('apikey'=>$apikey,'tpl_content'=>$model);
        $res = $this->curlTool($url,$data);
        return $res;
    }

    //批量发送信息
    public function sendMessage1($apikey,$mobile,$text){
        $url = 'https://sms.yunpian.com/v2/sms/batch_send.json';
        $data = array('apikey'=>$apikey,'mobile'=>$mobile);
        $res = $this->curlTool($url,$data);
        return $res;
    }

    //单条发送
    public function sendMessage($apikey,$mobile,$text){
        $url = 'https://sms.yunpian.com/v2/sms/single_send.json';
        $data = array('apikey'=>$apikey,'mobile'=>$mobile,'text'=>$text);
        $res = $this->curlTool($url,$data);
        return $res;
    }

    public function curlTool($url,$data){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8', 'Content-Type:application/x-www-form-urlencoded','charset=utf-8'));
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,  http_build_query($data));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //跳过证书检查
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res,true);
        return $res;
    }
>>>>>>> 36f4b30d1a443197074ebbf8fbe213ec596b9cd3
}