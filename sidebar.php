<!-- sidebar -->
<?php Plugins::act( 'theme_sidebar_top' ); ?>

    <div id="search">
     <h2><?php _e('Search'); ?></h2>
<?php $theme->display ('searchform' ); ?>
    </div>

	<div id="viddler">
		<h2>Dean's Videos</h2>
		<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="240" height="200" id="viddler_widget">
			<param name="movie" value="http://www.viddler.com/simple_widget/" />
			<param name="allowScriptAccess" value="always" />
			<param name="allowFullScreen" value="true" />
			<param name="wmode" value="transparent" />
			<param name="flashvars" value="widgeturl=http%3A%2F%2Fvidgets.viddler.com%2Fwidgets%2Fcallback.php%3Ftitle%3DDean%255C%2527s%2BVideos%26user%3DMorydd%26tags%3D%26max%3D12%26source%3Duser%26widget_type%3Dplaylist&autoplay=f" />
			<embed src="http://www.viddler.com/simple_widget/" width="240" height="200" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" name="viddler_widget" wmode="transparent" flashvars="widgeturl=http%3A%2F%2Fvidgets.viddler.com%2Fwidgets%2Fcallback.php%3Ftitle%3DDean%255C%2527s%2BVideos%26user%3DMorydd%26tags%3D%26max%3D12%26source%3Duser%26widget_type%3Dplaylist&autoplay=f">
		</object>
	</div>

	<!-- Start of Flickr Badge -->
	<div id="flickr">
	<h2>Dean's Photos</h2>
		<div id="flickr_badge_wrapper">
			<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=5&display=random&size=m&layout=x&source=user_set&user=60859889%40N00&set=72157605588553612&context=in%2Fset-72157605588553612%2F"></script>
		</div>
	</div>
	<!-- End of Flickr Badge -->


    <div class="sb-user">
     <h2><?php _e('User'); ?></h2>
<?php $theme->display ( 'loginform' ); ?>
    </div>

<?php Plugins::act( 'theme_sidebar_bottom' ); ?>
<!-- /sidebar -->
