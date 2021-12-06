<?php
namespace App\Common;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class Helper{

	/**
	 * 记录日志
	 * @param  [string] $content [日志内容]
	 * @param  string $level   [日志级别]
	 * @param  string $channel [日志频道]
	 * @return [type]          [description]
	 */
	public static function log($content, $level='info', $channel='record'){
		$allow=[
			'emergency',
			'alert',
			'critical',
			'error',
			'warning',
			'notice',
			'info',
			'debug',
		];
		if(!in_array($level, $allow)){
			throw new \Exception('非法的日志级别');
		}
		Log::channel($channel)->$level($content);
	}

	//api默认返回数据
	public static function getReturn(){
		$result=[
			'code'=>200,
			'msg'=>'success',
			// 'data'=>[],
		];
		return $result;
	}

	/**
	 * 上传图片
	 * @param  Request $request [依赖注入]
	 * @param  [type]  $key     [文件上传key]
	 * @return [type]           [description]
	 */
	public static function uploadImg(Request $request, $key){
		$result=self::getReturn();
		$allowed_extensions = [
			'jpg','jpeg','png','gif','svg',
		];
		$allowed_extensions_string=implode(', ', $allowed_extensions);
		$allow_size=4;
		try{
			if(!$request->hasFile($key)){
				throw new \Exception('未上传文件');
			}
			$file=$request->file($key);
			if(!$file->isValid()){
				$originalName = $file->getClientOriginalName();
				throw new \Exception("{$originalName}文件不合法");
			}
			$extension=$file->getClientOriginalExtension();
	        if(!in_array($extension, $allowed_extensions)){
	        	throw new \Exception("请上传格式为{$allowed_extensions_string}的图片");
	        }
	        if($file->getSize()/1024/1024 > $allow_size){
	        	throw new \Exception("图片上传限制为{$allow_size}MB");
	        }
	        $fileName=md5(time().rand(1,1000)).'.'.$extension;
	        $filePath='/img/'.date('Y-m-d').'/';
	        $path = $file->storeAs($filePath, $fileName, 'web');
	        if(!$path){
	        	throw new \Exception('上传失败');
	        }
	        $result['path']='/uploads'.$filePath.$fileName;
		} catch(\Exception $e){
			$result['msg']=$e->getMessage();
			$result['code']=1001;
		}
        return $result;
	}

	/**
	 * 上传图片
	 * @param  Request $request [依赖注入]
	 * @param  [type]  $key     [文件上传key]
	 * @return [type]           [description]
	 */
	public static function uploadImgs(Request $request, $key){
		$result=self::getReturn();
		$allowed_extensions = [
			'jpg','jpeg','png','gif','svg',
		];
		$allowed_extensions_string=implode(', ', $allowed_extensions);
		$allow_size=4;
		try{
			if(!$request->hasFile($key)){
				throw new \Exception('未上传图片');
			}
			$files=$request->file($key);
			if(!is_array($files)){
				throw new \Exception('未开启多图模式');
			}
			foreach ($files as $k => $file) {
				if(!$file->isValid()){
					$originalName = $file->getClientOriginalName();
					throw new \Exception("{$originalName}文件不合法");
				}
				$extension=$file->getClientOriginalExtension();
		        if(!in_array($extension, $allowed_extensions)){
		        	throw new \Exception("请上传格式为{$allowed_extensions_string}的图片");
		        }
		        if($file->getSize()/1024/1024 > $allow_size){
		        	throw new \Exception("图片上传限制为{$allow_size}MB");
		        }
		        $fileName=md5(time().rand(1,1000)).'.'.$extension;
		        $filePath='/img/'.date('Y-m-d').'/';
		        $path = $file->storeAs($filePath, $fileName, 'web');
		        if(!$path){
		        	throw new \Exception('上传失败');
		        }
		        $result['path'][]='/uploads'.$filePath.$fileName;
			}
		} catch(\Exception $e){
			$result['msg']=$e->getMessage();
			$result['code']=1001;
		}
        return $result;
	}

	/**
	 * 上传文件
	 * @param  Request $request [依赖注入]
	 * @param  [type]  $key     [文件上传key]
	 * @return [type]           [description]
	 */
	public static function uploadFile(Request $request, $key){
		$result=self::getReturn();
		$allowed_extensions = [
        	'jpg','jpeg','png','gif','svg',
        	'mp3',
        	'mp4','avi',
        	'xls','xlsx','doc','docx','ppt','pptx',
        	'exe','txt','pdf',
        ];
        $allowed_extensions_string=implode(', ', $allowed_extensions);
        $allow_size=50;
		try{
			if(!$request->hasFile($key)){
				throw new \Exception('未上传文件');
			}
			$file=$request->file($key);
			if(!$file->isValid()){
				$originalName = $file->getClientOriginalName();
				throw new \Exception("{$originalName}文件不合法");
			}
			$extension=$file->getClientOriginalExtension();
	        if(!in_array($extension, $allowed_extensions)){
	        	throw new \Exception("请上传格式为{$allowed_extensions_string}的文件");
	        }
	        if($file->getSize()/1024/1024 > $allow_size){
	        	throw new \Exception("文件上传限制为{$allow_size}MB");
	        }
	        $fileName=md5(time().rand(1,1000)).'.'.$extension;
	        $filePath='/file/'.date('Y-m-d').'/';
	        $path = $file->storeAs($filePath, $fileName, 'web');
	        if(!$path){
	        	throw new \Exception('上传失败');
	        }
	        $result['path']='/uploads'.$filePath.$fileName;
		} catch(\Exception $e){
			$result['msg']=$e->getMessage();
			$result['code']=1001;
		}
        return $result;
	}

	/**
	 * 发送邮件
	 * @param  [email] $to         [接收邮箱]
	 * @param  string $subject    [邮件主题]
	 * @param  string $content    [邮件内容]
	 * @param  [type] $attachment [附件]
	 * @return [type]             [description]
	 */
	public static function sendMail($to, $subject='无题', $content='无', $attachment=null){
		$result=self::getReturn();
		try{
			$send=Mail::raw($content, function($message) use($to, $subject, $attachment){
	            $message->to($to)->subject($subject);
	            if(is_array($attachment) && !empty($attachment)){
	            	foreach ($attachment as $k => $v) {
	            		if (file_exists($v)) {
					        // 防止中文乱码
				    		$message->attach($v);
					    }
	            	}
	            }elseif(!empty($attachment)){
	            	if (file_exists($attachment)) {
				        // 防止中文乱码
			    		$message->attach($attachment);
				    }
	            }
	        });
		} catch(\Exception $e){
			$result['msg']=$e->getMessage();
			$result['code']=1001;
		}
        return $result;
	}

	


	//截取html字符串
	public static function html_str_sub($str, $length=120){
	    str_replace('&nbsp;','',$str);
	    $tmp=htmlspecialchars_decode($str);
	    $tmp2=preg_replace("/<(.*?)>/","",$tmp);
	    $tmp3=mb_substr($tmp2,0,$length,'UTF8');
	    $tmp4=ltrim($tmp3,'&nbsp;');
	    $tmp5=ltrim($tmp4,' ');
	    return $tmp5;
	}

	//生成随机字符串
	public static function random_str($length, $numerical=false){
	    if($numerical){
	        //生成一个包含  数字 的数组
	        $arr = array_merge(range(0, 9));
	    }else{

	        //生成一个包含 大写英文字母, 小写英文字母, 数字 的数组
	        $arr = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
	    }
	    $str = '';
	    $arr_len = count($arr);
	    for ($i = 0; $i < $length; $i++){
	        $rand = mt_rand(0, $arr_len-1);
	        $str.=$arr[$rand];
	    }
	    return $str;
	}

	//创建表格列序号
	public static function createExcelRange($rangeInit='A'){
	    $range=range('A','Z');
	    if(!is_array($rangeInit)){
	        $rangeInit=explode(',', $rangeInit);
	    }
	    foreach ($rangeInit as $k => $v) {
	        $rangeTmp=range('A','Z');
	        foreach ($rangeTmp as $k2 => $v2) {
	            array_push($range, $v.$v2);
	        }
	    }
	    return $range;
	}

	//curl get类型请求
	public static function http_curl($url){
	    $ch = curl_init();
	    //设置抓取的url
	    curl_setopt($ch, CURLOPT_URL, $url);
	    //设置头文件的信息作为数据流输出
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
	    //设置获取的信息以文件流的形式返回，而不是直接输出。
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    $output = curl_exec($ch);

	    if (curl_errno($ch)) {  
	        $res=array('msg'=>'Errno:'.curl_error($ch));
	        return $res;
	    }
	    curl_close($ch);
	    return json_decode($output,true);
	}

	//curl post类型请求
	public static function curl_post($url = '', $param = '') {
	    if (empty($url) || empty($param)) {
	        return false;
	    }
	    if(is_array($param)){
	        $o = "";
	        foreach ( $param as $k => $v ) 
	        {
	            $o.= "$k=" . urlencode( $v ). "&" ;
	        }
	        $param = substr($o, 0, -1);
	    }
		$postUrl  = $url;
		$curlPost = $param;
		$curl     = curl_init();//初始化curl
	    curl_setopt($curl, CURLOPT_URL, $postUrl);//抓取指定网页
	    curl_setopt($curl, CURLOPT_HEADER, 0);//设置header
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
	    curl_setopt($curl, CURLOPT_POST, 1);//post提交方式
	    curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
	    // 关闭SSL验证
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
	    $data = curl_exec($curl);//运行curl
	    if (curl_errno($curl)) {  
	        $res=['status'=>-1,'Errno'=>curl_errno($curl),'Error'=>curl_error($curl)];
	        return $res;
	    }
	    curl_close($curl);
	    return json_decode($data,true);
	}

	//对图片进行base64Encode处理
	public static function base64EncodeImage ($img) {
	    $images = file_get_contents('.'.$img);
	    $base64_img = base64_encode($images);
	    return $base64_img;
	}

	/**
	 * 将数值金额转换为中文大写金额
	 * @param $amount float 金额(支持到分)
	 * @param $type   int   补整类型,0:到角补整;1:到元补整
	 * @return mixed 中文大写金额
	 */
	public static function convertAmountToCn($amount, $type = 1) {
	    // 判断输出的金额是否为数字或数字字符串
	    if(!is_numeric($amount)){
	        return "要转换的金额只能为数字!";
	    }
	    // 金额为0,则直接输出"零元整"
	    if($amount == 0) {
	        return "人民币零元整";
	    }
	    // 金额不能为负数
	    if($amount < 0) {
	        return "要转换的金额不能为负数!";
	    }
	    // 金额不能超过万亿,即12位
	    if(strlen($amount) > 12) {
	        return "要转换的金额不能为万亿及更高金额!";
	    }
	    // 预定义中文转换的数组
	    $digital = array('零', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖');
	    // 预定义单位转换的数组
	    $position = array('仟', '佰', '拾', '亿', '仟', '佰', '拾', '万', '仟', '佰', '拾', '元');
	    // 将金额的数值字符串拆分成数组
	    $amountArr = explode('.', $amount);
	    // 将整数位的数值字符串拆分成数组
	    $integerArr = str_split($amountArr[0], 1);
	    // 将整数部分替换成大写汉字
	    $result = '人民币';
	    $integerArrLength = count($integerArr);     // 整数位数组的长度
	    $positionLength = count($position);         // 单位数组的长度
	    $zeroCount = 0;                             // 连续为0数量
	    for($i = 0; $i < $integerArrLength; $i++) {
	        // 如果数值不为0,则正常转换
	        if($integerArr[$i] != 0){
	            // 如果前面数字为0需要增加一个零
	            if($zeroCount >= 1){
	                $result .= $digital[0];
	            }
	            $result .= $digital[$integerArr[$i]] . $position[$positionLength - $integerArrLength + $i];
	            $zeroCount = 0;
	        }else{
	            $zeroCount += 1;
	            // 如果数值为0, 且单位是亿,万,元这三个的时候,则直接显示单位
	            if(($positionLength - $integerArrLength + $i + 1)%4 == 0){
	                $result = $result . $position[$positionLength - $integerArrLength + $i];
	            }
	        }
	    }
	    // 如果小数位也要转换
	    if($type == 0) {
	        // 将小数位的数值字符串拆分成数组
	        $decimalArr = str_split($amountArr[1], 1);
	        // 将角替换成大写汉字. 如果为0,则不替换
	        if($decimalArr[0] != 0){
	            $result = $result . $digital[$decimalArr[0]] . '角';
	        }
	        // 将分替换成大写汉字. 如果为0,则不替换
	        if($decimalArr[1] != 0){
	            $result = $result . $digital[$decimalArr[1]] . '分';
	        }
	    }else{
	        $result = $result . '整';
	    }
	    return $result;
	}

	//字节转换KB,MB
	public static function size_trancelate($size){
	    if($size==0){
	        return '0字节';
	    }
	    switch ($size) {
	        case $size<1000:
	            $res=$size.'B';
	            break;
	        case $size<1000*1000:
	            $res=round($size/1024, 1).'K';
	            break;
	        case $size<1000*1000*1000:
	            $res=round($size/1024/1024, 1).'M';
	            break;
	        default:
	            $res=round($size/1024/1024/1024, 1).'G';
	            break;
	    }
	    return $res;
	}

	/**
	 * 获取签名 加密验证
	 * @param $objData 提交的数据
	 * @param $key  安全密钥
	 * @return bool
	 */
	public static function self_signature($objData, $key='baida'){
	    if(is_array($objData)){
	       $data=$objData;
	    }else{
	       $data=queryStrToArray($objData);
	    }
	    if(isset($data['sign'])){
	        unset($data['sign']);
	    }
	    ksort($data);
	    $str='';
	    foreach ($data as $k => $v) {
	        if($v===''){
	           continue;
	        }
	        if($str!=''){
	           $str.='&';
	        }
	        if ('UTF-8' === mb_detect_encoding($v)) {
	           $v = rawurlencode($v);
	        }
	        $str.="{$k}={$v}";
	    }
	    $str.="&key={$key}";
	    $signature = md5($str);
	    $signature = strtoupper($signature);
	    return $signature;
	}

	/**
	 * 将字符串转换为数组
	 * @param $str 提交的字符串
	 * @return $data
	 */
	public static function queryStrToArray($str){
	   if(is_array($str)){
	       return $str;
	   }
	   $data=[];
	   $str=ltrim($str,'?');
	   $tmpData=explode('&',$str);
	   foreach($tmpData as $k => $v){
	       $tmp=explode('=',$v);
	       $data[$tmp[0]]=$tmp[1];
	   }
	   return $data;
	}

	//获取物理地址
	public static function getMacAddr(){
	    $os_type=PHP_OS;
	    switch ( strtolower($os_type) ){
	        case "linux":
	            @exec("ifconfig -a", $return_array);
	            break;
	        case "solaris":
	            break;
	        case "unix":
	            break;
	        case "aix":
	            break;
	        default:
	            @exec("ipconfig /all", $return_array);
	            if ( !$return_array ){
	                $ipconfig = $_SERVER["WINDIR"]."\system32\ipconfig.exe";
	                if ( is_file($ipconfig) ){
	                    @exec($ipconfig." /all", $return_array);
	                }else{
	                    @exec($_SERVER["WINDIR"]."\system\ipconfig.exe /all", $return_array);
	                }
	            }
	            break;
	    }
	    $temp_array = array();
	    foreach ( $return_array as $value ){
	        if (preg_match("/[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f]/i", $value, $temp_array ) ){
	            $mac_addr = $temp_array[0];
	            break;
	        }
	    }
	    return $mac_addr;
	}

	//浏览目录
	public static function scanDirectory($path){
		$result=self::getReturn();
		$files=[];
		try{
			if(!$path){
				throw new \Exception('缺少路径');
			}
			if(!is_dir($path)){
		        throw new \Exception('路径非目录或目录不存在');
		    }
		    $dh=opendir($path);
		    if(!$dh){
		    	throw new \Exception('打开目录失败');
		    }
		    while ( $file=readdir($dh) ) {
		    	if($file=='.' || $file=='..'){
		    		continue;
		    	}
		    	$filename=$path.DIRECTORY_SEPARATOR.$file;
		    	if(is_file($filename)){
		    		$file_tmp=[
		    			'type'=>'file',
		    			'name'=>$file,
		    			'filename'=>$filename,
		    			'size'=>self::size_trancelate(filesize($filename)),
		    		];
		    	}else{
		    		$file_tmp=[
		    			'type'=>'directory',
		    			'name'=>$file,
		    			'filename'=>$filename,
		    			// 'files'=>self::scanDirectory($filename),
		    		];
		    	}
		    	$files[]=$file_tmp;
		    }
		    closedir($dh);
		    return $files;
		}catch(\Exception $e){
			$result['msg']  =$e->getMessage();
			$result['code'] =1001;
		}
		return $result;
	}

	//删除目录和目录下的文件
	public static function del_dir($path){
		$result=self::getReturn();
		try{
			if(!is_dir($path)){
		        throw new \Exception('路径非目录或目录不存在');
		    }
		    $handle=opendir($path);
	        while ( $file=readdir($handle) ) {
	            if($file!='.' && $file!='..'){
	                $filepath=$path.DIRECTORY_SEPARATOR.$file;
	                if(is_dir($filepath)){
	                    self::del_dir($filepath);
	                }else{
	                    unlink($filepath);
	                }
	            }
	        }
	        closedir($handle);
	        rmdir($path);
		} catch(\Exception $e){
			$result['msg']  =$e->getMessage();
			$result['code'] =1001;
		}
		return $result;
	}

	/**
	 * 格式化异常捕获的描述信息
	 * @param  [object] $e [异常捕获对象]
	 * @return [string] $message   [描述信息]
	 */
	public static function formatExceptionMsg($e){
	    $msg        =$e->getMessage();
	    $line       =$e->getLine();
	    $file       =$e->getFile();
	    $code       =$e->getCode();
	    $file       =str_replace("\\", "/", $file);
	    $file_array =explode('/', $file);
	    $filename   =$file_array[count($file_array)-1];
	    $message="[{$code}] Exception in {$filename} line {$line}:\r\n{$msg}";
	    return $message;
	}

	/**
	 * http get请求
	 * @param  string $url  [请求地址]
	 * @param  array  $data [请求数据]
	 * @return [type]       [description]
	 */
	public static function curlGet($url='', $data=[]){
		if(!$url){
			return false;
		}
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		//设置获取的信息以文件流的形式返回，而不是直接输出。
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}

	/**
	 * http post请求
	 * @param  string $url  [请求地址]
	 * @param  string $data [请求数据]
	 * @return [type]       [description]
	 */
	public static function curlPost($url='', $data=''){
		if(!$url){
			return false;
		}
		if(is_array($data) && !empty($data)){
	        $o = "";
	        foreach ( $data as $k => $v ) 
	        {
	            $o.= "$k=" . urlencode( $v ). "&" ;
	        }
	        $postData = substr($o, 0, -1);
	    }
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		//声明使用POST方式来进行发送
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		//忽略证书
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		//设置获取的信息以文件流的形式返回，而不是直接输出。
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}
}
