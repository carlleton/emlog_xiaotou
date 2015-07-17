<?php
header("content-type:text/html;charset=utf-8");
require_once(dirname(__FILE__).'/../../../init.php');
require_once('emlog_cache.php');

$url=$_REQUEST["url"];
if($url==''||$url==null){echo "null,没有url";return;}


get_format($url);
function get_format($url){
	$cacheName="xiaotou";
	if($url==''||$url=='http://'){echo "null,url不对";return;}
	
	$remark='';
	$title = '';
	$body = '';
	$title_start='';
	$title_end='';
	$body_start='';
	$body_end='';
	
	$cache = Cache_xiaotou::getInstance();
	$query = $cache->readCache($cacheName);
	while(list($key,$rs)=each($query)):
		$url_reg=$rs["url_reg"];
		$url_reg=str_replace("/","\\/",$url_reg);
		$url_reg="/".$url_reg."/";
		
		preg_match($url_reg,$url,$result);
		if($result){
			$remark=$rs["sitename"];
			$title_start=$rs["title_start"];
			$title_end=$rs["title_end"];
			$body_start=$rs["body_start"];
			$body_end=$rs["body_end"];
			break;
		}
	endwhile;
	
	
	$content = curls($url);
	
	if($content==''){
		$content = file_get_contents($url);
		if($content==''){
			echo "null,内容获取为空";
			return;
		}
	}
//	$content = str_replace(array("\r\n", "\r", "\n"), "", $content);
	
	
	$content = substr($content, stripos($content, $title_start)+strlen($title_start));
	$title= substr($content,0,stripos($content, $title_end));
	$content = substr($content, stripos($content, $title_end)+strlen($title_end));
	
	$content = substr($content, stripos($content, $body_start)+strlen($body_start));
	$body = substr($content, 0,stripos($content, $body_end));
	
	
//	$body = str_replace(array("\r\n", "\r", "\n"), "", $body);
	$body.='<p>来自：<a href="'.$url.'" target="_blank">'.$remark.'</a></p>';
	
	$title = str_replace(array("\r\n", "\r", "\n"),"",strip_tags($title));
	//$title = trim(str_replace('"','\"',$title));
	//$body = str_replace('"','\"',$body);
	//$body=preg_replace("/\s/","",$body);

	echo $title.'$$$$$'.$body;
}
function curls($url, $timeout = '20'){
	// 1. 初始化
    $ch = curl_init();
    // 2. 设置选项，包括URL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    // 3. 执行并获取HTML文档内容
    $info = curl_exec($ch);
    // 4. 释放curl句柄
    curl_close($ch);

    return $info;
}
?>