<?php
class Httpsvc
{
    const PROXY_PORT=':8080';
    const PROXY_NUM =2;
    const TIME_OUT=30;
    static  $ALL_CURL=array('post','get');

    public static function httpReqUrl($url,$method='get',$timeout=30,$header = array(),$restful=false)
    {
        if(!in_array(strtolower($method),self::$ALL_CURL))
            return $url;
        if(!$url)
            return ;
        $param = array();
        $urlarr = explode("?",$url,2);
        $url = $urlarr[0];
        if(isset($urlarr[1]) && !empty($urlarr[1])) {
            parse_str($urlarr[1],$param);
        }
        $res=self::HttpReqArr($url,$param,$timeout,strtolower($method),$header,$restful);
        return $res['data'];
    }

    public static function HttpReqArr($url,$opts=array(),$timeout=200,$mothod='post',$header = array(),$restful=false)
    {
        $mothod = strtolower($mothod);
        if(!in_array($mothod,self::$ALL_CURL))
        	return $url;
        if(!$url)
        	return ;
        $logger = Logger::ins('Httpsvc');
        try{
            $stime=microtime(true);
            $url = trim($url);
            $ch = curl_init();
            if(!empty($header))
            {
            	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            }
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            if(isset($opts) && count($opts)>0)
            {
                $pstring='';
                foreach($opts as $key => $val)
                {
                	if (is_numeric($key)) {
                		$restful && $pstring .= trim($val).' ';
                		!$restful && $pstring .= urlencode(trim($val)).' ';

                	}else {
                		$restful && $pstring .= trim($key) . '=' . trim($val) . "&";
                		!$restful && $pstring .= trim($key) . '=' . urlencode(trim($val)) . "&";
                	}
                }

                $pstring = substr($pstring,0,-1);

                if(strtolower($mothod)=='post') {
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $pstring);
                    curl_setopt($ch, CURLOPT_URL, $url);
                }
                else
                {
                    curl_setopt($ch, CURLOPT_HTTPGET, true);
                    curl_setopt($ch, CURLOPT_URL, $url."?".$pstring);
                }
            }
            else
            {
                if(strtolower($mothod)=='post')
                    curl_setopt($ch, CURLOPT_POST, true);
                else
                    curl_setopt($ch, CURLOPT_HTTPGET, true);
                curl_setopt($ch, CURLOPT_URL, $url);
            }
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//解决ssl访问失败
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);//解决ssl访问失败
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $r = curl_exec($ch);
            $http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
            $etime=microtime(true);
            $usetime=$etime-$stime;
            $logger->debug("[response] code: $http_code, usetime: $usetime, url:$url");
            $error = curl_error($ch);
            if($error){
                $logger->error("code: $http_code, usetime: $usetime, callbackUrl:$url?$pstring method:$mothod  opt=".var_export($opts,true));
            }
        }catch(Exception $e) {
            $logger->error("code: $http_code, usetime: $usetime, callbackUrl:$url?$pstring method:$mothod  opt=".var_export($opts,true).' exception '.$e->getMessage());
        }
        curl_close($ch);
        $r = self::RemoveBom($r);
        $data=array('code'=>$http_code,'data'=>$r);
        $logger->info("code: $http_code, usetime: $usetime, method:$mothod,callBackUrl:$url?$pstring ,putData:".$r);
        return $data;
    }

    public static function RemoveBom($content)
    {
        if(substr($content, 0,3) == pack("CCC",0xef,0xbb,0xbf)) {
            $content=substr($content, 3);
        }
        return $content;
    }
}

