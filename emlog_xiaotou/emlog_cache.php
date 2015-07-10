<?php

class Cache_xiaotou{
	private $db;
	private static $instance = null;
	private function __construct() {
		$this->db = MySql::getInstance();
	}
	public static function getInstance() {
		if (self::$instance == null) {
			self::$instance = new Cache_xiaotou();
		}
		return self::$instance;
	}
	
	function update_cache($cacheName){
		$sql="select * from ".DB_PREFIX."xiaotou";
		$query = $this->db->query($sql);
		
		$user_cache = array();
		$cache_result = $this->db->query($sql);
		while ($catchArr = mysql_fetch_array($cache_result,MYSQL_ASSOC)){
			$user_cache[]=$catchArr;
		}
		$cacheData = serialize($user_cache);
		$this->cacheWrite($cacheData, $cacheName);
		
		$cacheData = serialize($user_cache);
		
	}
	/**
	 * 写入缓存
	 */
	function cacheWrite ($cacheData, $cacheName) {
		$cachefile = EMLOG_ROOT.'/content/plugins/emlog_xiaotou/'.$cacheName.'.php';
		$cacheData = "<?php exit;//" . $cacheData;
		@ $fp = fopen($cachefile, 'wb') OR emMsg('读取缓存失败。如果您使用的是Unix/Linux主机，请修改缓存目录 (content/cache) 下所有文件的权限为777。如果您使用的是Windows主机，请联系管理员，将该目录下所有文件设为可写'.$cachefile);
		@ $fw = fwrite($fp, $cacheData) OR emMsg('写入缓存失败，缓存目录 (cache) 不可写');
		$this->{$cacheName.'_cache'} = null;
		fclose($fp);
	}
	/**
	 * 读取缓存文件
	 */
	function readCache($cacheName,$sql="") {
		if ($this->{$cacheName.'_cache'} != null) {
			return $this->{$cacheName.'_cache'};
		} else {
			$cachefile = EMLOG_ROOT.'/content/plugins/emlog_xiaotou/'.$cacheName.'.php';
			// 如果缓存文件不存在则自动生成缓存文件
			if (!is_file($cachefile) || filesize($cachefile) <= 0) {
				if($sql=="")$sql=sql_define($cacheName);
				if($sql=="")return;
				$this->update_cache($cacheName);
			}
			if ($fp = fopen($cachefile, 'r')) {
				$data = fread($fp, filesize($cachefile));
				fclose($fp);
				   clearstatcache();
				$this->{$cacheName.'_cache'} = unserialize(str_replace("<?php exit;//", '', $data));
				return $this->{$cacheName.'_cache'};
			}
		}
	}
}
?>