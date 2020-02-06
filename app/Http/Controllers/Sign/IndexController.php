<?php
namespace App\Http\Controllers\Sign;
use App\Http\Controllers\Controller;
use App\Model\UserPubKeyModel;
use App\Model\Sign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class IndexController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * 在线验签
     */
    public function signOnline()
    {
        return view('sign.online');
    }
    /**
     * 在线验签
     */
    public function signOnline1()
    {
        unset($_POST['_token']);
        echo '<pre>';print_r($_POST);echo '</pre>';
        //接收 POST参数
        $sign = base64_decode($_POST['sign']);
        unset($_POST['sign']);
        $params = [];
        foreach ($_POST['k'] as $k=>$v)
        {
            if(empty($v)){
                continue;       //跳过空字段
            }
            $params[$v] = $_POST['v'][$k];
        }
        echo '<pre>';print_r($params);echo '</pre>';
        //拼接参数
        $str = "";
        foreach($params as $k=>$v){
            $str .= $k . '=' . $v . '&';
        }
        $str = trim($str,'&');
        //验签
        $uid = Auth::id();      //获取登录用户 uid
        $u = UserPubKeyModel::where(['uid'=>$uid])->first();
        $status = openssl_verify($str,$sign,$u->pubkey,OPENSSL_ALGO_SHA256);
        if($status){
            echo '验签成功!';
        }else{
            echo '验签失败!';
        }
    }
    /**
     * 验签测试
     */
    public function sign1()
    {
        $sign = base64_decode($_GET['sign']);
        //字典序排序
        unset($_GET['sign']);
        $params = $_GET;
        ksort($params);
        //拼接参数
        $str = "";
        foreach($params as $k=>$v){
            $str .= $k . '=' . $v . '&';
        }
        $str = trim($str,'&');
        //验签
        $uid = Auth::id();      //获取登录用户 uid
        $u = UserPubKeyModel::where(['uid'=>$uid])->first();
        $status = openssl_verify($str,$sign,$u->pubkey,OPENSSL_ALGO_SHA256);
        if($status){
            echo '验签成功!';
        }else{
            echo '验签失败!';
        }
    }
    /**
     * 验签测试
     */
    public function sign2()
    {
        //接收 POST参数
        $sign = base64_decode($_POST['sign']);
        unset($_POST['sign']);
        $params = $_POST;
        //拼接参数
        $str = "";
        foreach($params as $k=>$v){
            $str .= $k . '=' . $v . '&';
        }
        $str = trim($str,'&');
        //验签
        $uid = Auth::id();      //获取登录用户 uid
        $u = UserPubKeyModel::where(['uid'=>$uid])->first();
        $status = openssl_verify($str,$sign,$u->pubkey,OPENSSL_ALGO_SHA256);
        if($status){
            echo '验签成功!';
        }else{
            echo '验签失败!';
        }
    }

    public function ymsign1(){
        $url="http://client.1905.com/sign/ymsign2";
        $t_name="荣聪";
        $t_age="21";
        //var_dump($t_age);
        $sign=md5("php").md5(md5($t_name.$t_age));
        $url.="?t_name={$t_name}&t_age={$t_age}&sign={$sign}";
        $data=file_get_contents($url);
        var_dump($data);
    }

    public function ymsign2(Request $request){
        //echo 444;die;
        $t_name=$request->input('t_name');
        $t_age=$request->input('t_age');
        $sign=$request->input('sign');
        $tmpstr=md5("php").md5(md5($t_name.$t_age));
        if(empty($t_name)||empty($t_age)){
            return json_encode(['ret'=>0,'msg'=>'没参数啊,俺滴大哥,大姐们!!!'],JSON_UNESCAPED_UNICODE);
        }
        if($tmpstr!=$sign){
            return json_encode(['ret'=>0,'msg'=>'签名都写不对,别玩互联网了！！！'],JSON_UNESCAPED_UNICODE);
        }
        if(empty($t_name)||empty($t_age)){
            return json_encode(['ret'=>201,'msg'=>"用户名字或年龄不能不写啊~啊~~~"],JSON_UNESCAPED_UNICODE);
        }
        //添加入库
        $res=Sign::create([
           't_name'=>$t_name,
           't_age'=>$t_age,
           'sign'=>$sign,
        ]);
        //返回状态值
        return json_encode([
            'ret'=>200,
            'msg'=>"靠,老表,你可算成功了!"
        ],JSON_UNESCAPED_UNICODE);
    }
}