<?php 
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Login;
use Illuminate\Support\Facades\Redis;
use DB;
class ClientController extends Controller
{
    public function encrypt()
    {

    	$data=urldecode($_GET['data']);
        $data=base64_decode($data);
        //$data=urldecode($_GET['data']);
    	echo "原文".$data;echo '</br>';
    	$method='AES-256-CBC';
    	$key='1905api';
    	$iv='GXTXHWZRYNZDMhhh';
    	$enc_data=openssl_encrypt($data, $method,$key,OPENSSL_RAW_DATA,$iv);
    	echo "加密后密文:".$enc_data;echo '</br>';
    	echo '<hr>';
    	echo '解密:';echo '</br>';

    	//发送加密数据
  
    	$url="http://server.1905.com/decrypt?data=".base64_encode($enc_data);

    	echo $url;echo '</br>';
    	$response=file_get_contents($url);
    	echo $response;

    }

    public function encrypt2()
    {

        $data=urldecode($_GET['data']);
        $data=base64_decode($data);
        //$data=urldecode($_GET['data']);
        echo "原文".$data;echo '</br>';
        $method='AES-256-CBC';
        $key='1905api';
        $iv='GXTXHWZRYNZDMhhh';
        $enc_data=openssl_encrypt($json_str, $method,$key,OPENSSL_RAW_DATA,$iv);
        echo "加密后密文:".$enc_data;echo '</br>';
        // echo '<hr>';
        // echo '解密:';echo '</br>';
        $base64_str=base64_encode($enc_data);
        echo "base64_str:".$url_encode_str;echo '</br>';
        //发送加密数据
  
        $url="http://server.1905.com/decrypt2?data=".base64_encode($enc_data);

        echo $url;echo '</br>';
        $response=file_get_contents($url);
        echo $response;

    }

    public function rsa1()
    {
        $priv_key=file_get_contents(storage_path('keys/priv.key'));
        echo $priv_key;echo '<hr>';
        $data="helloword";
        echo "待加密数据:".$data;echo '</br>';
        openssl_private_encrypt($data,$enc_data,$priv_key);
        var_dump($enc_data);
        //解密
        
    }
    public function curl1()
    {
       $url="http://1905api.comcto.com/test/curl1?name=zhangsan&email=zhangsan@qq.com";
       //初始化
       $ch=curl_init();
       //设置参数
       curl_setopt($ch,CURLOPT_URL,$url);
       //开启会话 发送请求
       curl_exec($ch);
        //关闭会话
        curl_close($ch);
    }
    
    public function curl2()
    {
       $url="http://1905api.comcto.com/test/curl2";
       $data=[
              'name' => 'zhangsan',
              'email'=>'zhangsan@qq.com'
        ];
        //初始化
       $ch=curl_init();
       //设置参数
       curl_setopt($ch,CURLOPT_URL,$url);
       curl_setopt($ch,CURLOPT_POST,1);
       curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
       //开启会话 发送请求
       curl_exec($ch);
        //关闭会话
       curl_close($ch);
    }

    public function curl3()
    {
        //echo phpinfo()
        $url="http://1905api.comcto.com/test/curl3";

        $data=[
              'img1' => new \CURLFile('gsl.jpg')
        ];

        //初始化
        $ch=curl_init();
        //设置参数
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        //开启会话 发送请求
        curl_exec($ch);
        //关闭会话
        curl_close($ch);
    }

     public function curl4()
    {
        //echo phpinfo()
        $url="http://1905api.comcto.com/test/curl4";
        $token=Str::random(20);

        $data=[
              'name' => 'zhangsan',
              'email'=>'zhangsan@qq.com',
              'age'=>111
        ];
        //echo '<pre>';print_r($data);echo '</pre>';
        $json_str=json_encode($data);
        //echo "待发送数据 json:".$json_str;
        //初始化
        $ch=curl_init();
        //设置参数
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$jsom_str);
        curl_setopt($ch,CURLOPT_HTTPHEADER,[
           'content-type:text/plain',
           'token:'.$token
        ]);
        //开启会话 发送请求
        curl_exec($ch);
        //关闭会话
        curl_close($ch);
    }

    public function sign1()
    {
       echo '<pre>';print_r($_GET);echo '</pre>';
       $sign=$_GET['sign'];
       unset($_GET['sign']);
       ksort($_GET);
       echo '<pre>';print_r($_GET);echo '</pre>';
       $str="";
       foreach ($_GET as $k => $v) {
         $str.=$k.'='.$v.'&';
       }
       $str=rtrim($str,'&');
       echo $str;echo '<hr>';
       //使用公钥验签
       $pub_key=file_get_contents(storage_path('keys/priv.key'));
       $Status=openssl_verify($str,base64_decode($sign), $pub_key,OPENSSL_ALGO_SHA256);
       var_dump($status);
       if($status)
       {
        echo "success";
       }else{
        echo "验签失败";
       }
    }

}