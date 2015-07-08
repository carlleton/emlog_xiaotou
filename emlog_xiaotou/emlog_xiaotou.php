<?php
/*
Plugin Name: 小偷程序
Version: 0.1
Plugin URL:http://www.qiyuuu.com/for-emlog/emlog-plugin-images-to-local
Description: 获取其他网站的文章
Author: vcandou
Author Email: 279814252@qq.com
Author URL: http://www.vcandou.com/
*/

!defined('EMLOG_ROOT') && exit('access deined!');

function xiaotou_nav(){//写入插件导航
	echo '<div id="duoshuo_settings" class="sidebarsubmenu"><a href="./plugin.php?plugin=emlog_xiaotou">小偷程序</a></div>';
}

addAction('adm_sidebar_ext', 'xiaotou_nav');

function emlog_xiaotou_option(){
	?><span><input type="text" value="" name="emlog_xiaotou_url" id="emlog_xiaotou_url" style="width:300px; margin-left:5px;" />
	<input type="button" value="偷取文章" onclick="emlog_xiaotou_getContent();" /></span>
	<script type="text/javascript">
	function emlog_xiaotou_getContent(){
		var xiaotou_url = $('#emlog_xiaotou_url').val();
		if(xiaotou_url==''||xiaotou_url=='http://')return;
		if(xiaotou_url.indexOf('http://')<0){
			alert('请输入正确的网址！');
			return;
		}
		var url = '<?php echo BLOG_URL."content/plugins/emlog_xiaotou/emlog_xiaotou_getData.php" ?>';
		var data='t='+(new Date()).valueOf()+'&url='+encodeURIComponent(xiaotou_url);
		console.log(xiaotou_url);console.log(url);console.log(data);
		$.ajax({
			type:"POST",
			url:url,
			data:data,
			success:function(su){
				if(!su||su=='null'){alert('该网址无法正确解析！');console.log(su);return;}
				var title=su.substr(0,su.indexOf('$$$$$'));
				var content=su.substr(su.indexOf('$$$$$')+5);
				$('#title_label').css('display','none');
				$('#title').val(title);
				editorMap['content'].html(content);//insertHtml
			},
			error:function(a){
				console.log(a);
			}
		});
	}
	</script>
	<?php
}

addAction('adm_writelog_head', 'emlog_xiaotou_option');

?>