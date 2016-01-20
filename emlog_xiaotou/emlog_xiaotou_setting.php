<?php
!defined('EMLOG_ROOT') && exit('access deined!');

require_once('emlog_cache.php');

function plugin_setting_view() {
	$cacheName="xiaotou";
	$DB = MySql::getInstance();
	$cid = isset($_REQUEST["cid"])?intval($_REQUEST["cid"]):"";
	$act = $_REQUEST["act"];
	$cache = Cache_xiaotou::getInstance();
	
	if($act=='del'){
		$sql="delete from ".DB_PREFIX."xiaotou where cid=".$cid;
		$DB->query($sql);
		$cache->update_cache($cacheName);
		header("Location: ./plugin.php?plugin=emlog_xiaotou&setting=true");
		return;
	}
	if($act=='copy'){
		$sql="insert into ".DB_PREFIX."xiaotou(title,sitename,siteurl,url_reg,title_start,title_end,body_start,body_end,charset) select title,sitename,siteurl,url_reg,title_start,title_end,body_start,body_end,charset from ".DB_PREFIX."xiaotou where cid=".$cid;
		
		$DB->query($sql);
		$cache->update_cache($cacheName);
		header("Location: ./plugin.php?plugin=emlog_xiaotou&setting=true");
		return;
	}
	if($act=='save'){
		$title=isset($_POST["title"])?addslashes($_POST["title"]):"";
		$sitename=isset($_POST["sitename"])?addslashes($_POST["sitename"]):"";
		$siteurl=isset($_POST["siteurl"])?addslashes($_POST["siteurl"]):"";
		$url_reg=isset($_POST["url_reg"])?addslashes($_POST["url_reg"]):"";
		$title_start=isset($_POST["title_start"])?addslashes($_POST["title_start"]):"";
		$title_end=isset($_POST["title_end"])?addslashes($_POST["title_end"]):"";
		$body_start=isset($_POST["body_start"])?addslashes($_POST["body_start"]):"";
		$body_end=isset($_POST["body_end"])?addslashes($_POST["body_end"]):"";
		$charset=isset($_POST["charset"])?addslashes($_POST["charset"]):"";
		if($cid==''){
			$sql="insert into ".DB_PREFIX."xiaotou set title='$title',sitename='$sitename',siteurl='$siteurl',url_reg='$url_reg',title_start='$title_start',title_end='$title_end',body_start='$body_start',body_end='$body_end',charset='$charset'";
		}else{
			$sql="UPDATE ".DB_PREFIX."xiaotou set title='$title',sitename='$sitename',siteurl='$siteurl',url_reg='$url_reg',title_start='$title_start',title_end='$title_end',body_start='$body_start',body_end='$body_end',charset='$charset' where cid={$cid}";
		}
		$DB->query($sql);
		$cache->update_cache($cacheName);
		header("Location: ./plugin.php?plugin=emlog_xiaotou&setting=true");
		return;
	}
	?>
<div class="containertitle">
	<a href="./plugin.php?plugin=emlog_xiaotou"><b>小偷程序设置</b></a>————<a href="./plugin.php?plugin=emlog_xiaotou&act=add">添加</a>
	<?php if(isset($_GET['setting'])):?><span class="actived">插件设置完成</span><?php endif;?>
	<?php if(isset($_GET['error'])):?><span class="actived">插件设置失败</span><?php endif;?>
	<script type="text/javascript">
	$(document).ready(function(){
		setTimeout(hideActived,2600);
	});
	</script>
</div>
<div class="line"></div>
	<?php
	if($act=='edit'||$act=='add'){
		if($cid==''){
			$rs = array(
				"cid"=>"",
				"title"=>"",
				"sitename"=>"",
				"siteurl"=>"",
				"url_reg"=>"",
				"title_start"=>"",
				"title_end"=>"",
				"body_start"=>"",
				"body_end"=>"",
				"charset"=>"",
			);
		}else{
			$sql = "select * from ".DB_PREFIX."xiaotou where cid=".$cid;
			$query = $DB->query($sql);
			$rs = $DB->fetch_array($query);
		}
		?>
		<form action="./plugin.php?plugin=emlog_xiaotou&act=save" method="post">
		<table style="line-height:30px;">
		<tr>
			<td>&nbsp;</td>
			<td>添加/编辑</td>
		</tr>
		<tr><td>标识：</td><td><input type="text" name="title" value="<?php echo $rs["title"]; ?>" style="width:300px;" />
			<input type="hidden" name="cid" value="<?php echo $rs["cid"] ?>" />
			<input type="hidden" name="act" value="save" />
		</td></tr>
		<tr><td>正则识别：</td><td><input type="text" name="url_reg" value="<?php echo $rs["url_reg"] ?>" style="width:300px;" /></td></tr>
		<tr><td>网站名称：</td><td><input type="text" name="sitename" value="<?php echo $rs["sitename"] ?>" style="width:300px;" /></td></tr>
		<tr><td>网站地址：</td><td><input type="text" name="siteurl" value="<?php echo $rs["siteurl"] ?>" style="width:300px;" /></td></tr>
		<tr><td>网站编码：</td><td><input type="text" name="charset" value="<?php echo $rs["charset"] ?>" style="width:300px;" /></td></tr>
		<tr><td>标题开始：</td><td>
			<textarea name="title_start" rows="5" cols="10" style="width:300px;height:50px;"><?php echo $rs["title_start"] ?></textarea>
		</td></tr>
		<tr><td>标题结束：</td><td>
			<textarea name="title_end" rows="5" cols="10" style="width:300px;height:50px;"><?php echo $rs["title_end"] ?></textarea>
		</td></tr>
		<tr><td>内容开始：</td><td>
			<textarea name="body_start" rows="5" cols="10" style="width:300px;height:50px;"><?php echo $rs["body_start"] ?></textarea>
		</td></tr>
		<tr><td>内容结束：</td><td>
			<textarea name="body_end" rows="5" cols="10" style="width:300px;height:50px;"><?php echo $rs["body_end"] ?></textarea>
		</td></tr>
		<tr><td>&nbsp;</td><td><input type="submit" value="保存" /></td></tr>
		</table>
		</form>
		<?php
		return;
	}
	
$pageSize=10;
$pageNum=empty($_REQUEST["pagenum"])?1:$_REQUEST["pagenum"];

$sql="select * from ".DB_PREFIX."xiaotou";
$limit=" limit ".($pageNum-1)*$pageSize.",".$pageSize;
$query = $DB->query($sql);
$pageCount = $DB->num_rows($query);
$query = $DB->query($sql.$limit);

?>
<table width="100%" id="adm_comment_list" class="item_list">
	<thead>
		<tr>
			<th><b>序号</b></th>
			<th><b>标识</b></th>
			<th><b>网站名称</b></th>
			<th><b>编码</b></th>
			<th><b>操作</b></th>
		</tr>
	</thead>
	<tbody>
		<?php while($rs = $DB->fetch_array($query)): ?>
		<tr>
			<td><?php echo $rs["cid"]; ?></td> 
			<td><?php echo $rs["title"]; ?></td>
			<td><a href="<?php echo $rs["siteurl"]; ?>" target="_blank"><?php echo $rs["sitename"]; ?></a></td>
			<td><?php echo $rs["charset"]==""?"UTF-8":$rs["charset"]; ?></td>
			<td>
				<a href='./plugin.php?plugin=emlog_xiaotou&act=edit&cid=<?php echo $rs["cid"]; ?>'>编辑</a>
				<a onclick='if(!confirm("您确认要复制？"))return false;' href='./plugin.php?plugin=emlog_xiaotou&act=copy&cid=<?php echo $rs["cid"]; ?>'>复制</a>
				<a onclick='if(!confirm("您确认要删除吗？"))return false;' href='./plugin.php?plugin=emlog_xiaotou&act=del&cid=<?php echo $rs["cid"]; ?>'>删除</a>
			</td>
		</tr>
		<?php endwhile; ?>
	</tbody>
</table>

<div>
	<?php echo pagination($pageCount,$pageSize,$pageNum,'./plugin.php?plugin=emlog_xiaotou&pagenum=') ?>
</div>
<?php
}

?>