<?php
class stermapi{
	const apiurl='http://api.steampowered.com/';
	public $service;
	public $interfaces;
	public $userkey;
	public $version;
	protected $quest;
	public $method;
	public $quest_spec;
	public $url_spec;
	//protected $cookies_spec;
	public $ck_steamMachineAuth;
	public $ck_steamuid;
	public $ck_steamRememberLogin;
	public $ck_sessionid;
	public $ck_steamLogin;
	public $ck_steamLoginSecure;
	public $ck_webTradeEligibility;
	public $head_spec;
	private $ip_spec="steamCC_121_40_174_189=CN; ";//最后一定有空格
	public $steamlang_spec="schinese";
	public $url_ref_spec = 'http://steamcommunity.com';
	public function SetIPSpec($var1){
		$error['success']=0;
		$error['info']='Your IP setting as a string of \''.$var1.'\' is invalid.IPSetup must obay the format as "steamCC_121_40_174_189=CN; ",the last letter follows a SPACE charecter; the numbers are your service ip address.The \'CN\' is your Country\'s Short Spelling.This string is case-sensitive';
		$errback= json_encode($error);
		if (empty($var1)){
			echo $errback;
			exit;
		}
		if (preg_match('/^steamCC_/',$var1)==0){
			echo $errback;
			exit;
		}
		if (preg_match('/\s$/',$var1)==0){
			echo $errback;
			exit;
		}
		$this ->ip_spec = $var1;
	}
	protected function valcheck($var1,$var2=NULL){
		if ($var1 =="" or is_null($var1) or empty($var1)){
			$error['success']=0;
			$error['info']='Nessary variaty:$'.$var2.' is empry.';
			throw new  Exception ( json_encode($error) );
		}
	}
	private function checkquest(){
		try {
    		$this ->valcheck ( $this -> quest,'quest' );
			$this ->valcheck ( $this -> service ,'service');
			$this ->valcheck ( $this -> interfaces ,'interfaces');
			$this ->valcheck ( $this -> userkey ,'userkey');
			$this ->valcheck ( $this -> version ,'version');
    	} catch ( Exception $e ) {
   			 echo  $e -> getMessage () ;
			 exit;
		}
	}
	private function checkquest_spec(){
		try {
    		//$this ->valcheck ( $this -> quest_spec,'quest_spec' );
			$this ->valcheck ( $this -> url_spec ,'url_spec');
			$this ->valcheck ( $this -> ck_steamMachineAuth ,'ck_steamMachineAuth');
			$this ->valcheck ( $this -> ck_steamRememberLogin ,'ck_steamRememberLogin');
			$this ->valcheck ( $this -> ck_sessionid ,'ck_sessionid');
			$this ->valcheck ( $this -> ck_steamLogin ,'ck_steamLogin');
			$this ->valcheck ( $this -> ck_steamLoginSecure ,'ck_steamLoginSecure');
			$this ->valcheck ( $this -> ck_webTradeEligibility ,'ck_webTradeEligibility');
			$this ->valcheck ( $this -> ck_steamuid ,'ck_steamuid');
			$this ->valcheck ( $this -> ip_spec ,'ip_spec');
			//$this ->valcheck ( $this -> cookies_spec ,'cookies_spec');
    	} catch ( Exception $e ) {
   			 echo  $e -> getMessage () ;
			 exit;
		}
	}
	protected  function exeapi(){
		$this -> checkquest();
		//
		//echo $tempresult;
		$queststr="";
		$counts=count($this -> quest);
		$i=0;
		while ( $input_name  =  current ($this -> quest ) and $i<$counts) {
			$queststr.="&".key ( $this -> quest )."=".$input_name;
			$i++;
			next ($this -> quest ) ;
		}
		$tempurl= self :: apiurl . ($this-> service) . '/'. ($this-> interfaces).'/'. ($this-> version).'/';
		
		//echo $tempurl;
		$datemess= 'key='.($this -> userkey).'&format=json'.$queststr;;
		
		
		if (($this -> method == "get")or is_null($this -> method)){
			$postdate=NULL;
			$datemess="?".$datemess;
			$tempurl.=$datemess;
		} elseif($this -> method == "post") {
			$postdate="?".$datemess;
			
		} else {
			$error['success']=0;
			$error['info']='An undefined HTTP access method';
			echo json_encode($error);
			exit;
		}
		/*
		echo $tempurl;
		echo "\r\n==============\r\n";
		echo $postdate;
		echo "\r\n==============\r\n";*/
		$tempresult=$this -> vpost($tempurl,'',$postdate);
		return $tempresult;
	}
	private function makecookie(){
		$cookies_result="timezoneOffset=28800,0; ";
		$cookies_result.=$this->ip_spec;//服务器地址
		$cookies_result.="Steam_Language=".($this -> steamlang_spec)."; ";
		$cookies_result.="steamMachineAuth".($this -> ck_steamuid)."=".($this -> ck_steamMachineAuth)."; ";
		//steamRememberLogin=".$steamRememberLogin.";
		//$steamRememberLogin=$steamuid."%7C%7C".$rembercode;
		$cookies_result.="steamRememberLogin=".($this -> ck_steamRememberLogin)."; ";
		//sessionid=".$new_sessionid."; 
		$cookies_result.="sessionid=".($this -> ck_sessionid)."; ";
		$cookies_result.="steamLogin=".($this -> ck_steamLogin)."; ";
		$cookies_result.="steamLoginSecure=".($this -> ck_steamLoginSecure)."; ";
		$cookies_result.="webTradeEligibility=".($this -> ck_webTradeEligibility)."; ";
		return $cookies_result;
	}
	protected  function execspec(){
		$this -> checkquest_spec();
		$cookies=$this -> makecookie();
		$tempurl= $this -> url_spec;
		$postdate=$this -> postdate;;
		//$head=1;
		$head=$this -> head_spec;
		$reffer = $this -> url_ref_spec;
		/*
		echo $tempurl;
		echo "\r\n==============\r\n";
		echo $cookies;
		echo "\r\n==============\r\n";
		echo $postdate;
		echo "\r\n==============\r\n";
		echo $head;
		echo "\r\n==============\r\n";
		echo $reffer;
		echo "\r\n==============\r\n";*/
		$tempresult=$this -> vpost($tempurl,$cookies,$postdate,$head,$reffer);
		//echo $tempresult;
		return $tempresult;
	}
	private function vpost($url,$cookie='',$post="",$head=0,$reffer="http://steamcommunity.com"){ // 模拟提交数据函数
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:31.0) Gecko/20100101 Firefox/31.0'); // 模拟用户使用的浏览器
    curl_setopt($curl, CURLOPT_COOKIE, $cookie);
    curl_setopt($curl, CURLOPT_REFERER,$reffer);// 设置Referer
    curl_setopt($curl, CURLOPT_TIMEOUT, 155); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, $head); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
	if ($post!=""){
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
	}
    $tmpInfo = curl_exec($curl); // 执行操作 
    if (curl_errno($curl)) {
       echo '{"success":0,"info":"CURL Execulated error"}';//捕抓异常
    	exit;
	}
    curl_close($curl); // 关闭CURL会话
    return $tmpInfo; // 返回数据
	}

}
?>