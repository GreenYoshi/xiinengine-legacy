<?
/**
 * XiinEngine
 *
 * * XiinEngine is supplied under the MIT license. Please read license.md  in the root directory
 *
 * @package XiinEngine Legacy
 * @author Ian Karlsson <ian.karlsson@xiinet.com>
 * @author Philip Whitehall <philip.whitehall@xiinet.com> 
 * @copyright Copyright 2006-2013 Xiin Networks <http://xiinet.com/>
 * @link http://xiinengine.com/
 * @since v1.2
 */   
?><script language="javascript" type="text/javascript">
	$(document).ready(function() {
		setTimeout(redirect,10000);
	});
	
	function redirect() {
		window.location = '<?=sysBaseURL?>';
	}
</script>
<div class="body_other_outer">
    <div class="body_news_main_outer">
    	<div class="news_outer">
			<div class="news_header_outer">Page Not Found</div>
            <p>Sorry, this page doesn't exist! You will be redirected to the homepage in 10 seconds.</p>
        </div>
	</div>
    <div class="body_news_main_sidebar">
    	<?php include sysModulePath."p_sidebar.php"; ?>
    </div>
    <div class="xe_clear"></div>
</div>