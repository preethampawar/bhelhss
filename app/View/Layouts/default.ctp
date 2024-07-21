<?php
$cakeDescription = __d('cake_dev', ' :: BHEL HSS');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php
		$title_for_layout = $title_for_layout.$cakeDescription;
		if(isset($this->params['controller']) and ($this->params['controller'] == 'pages')) {
			if(isset($this->params['pass'][0]) and ($this->params['pass'][0] == 'home')) {
				$title_for_layout = "BHEL HSS Alumni - BHEL Higher Secondary School";
			}
		}
		echo ($title_for_layout) ? $title_for_layout : 'BHEL Higher Secondary School'; ?>
	</title>
	<meta http-equiv="imagetoolbar" content="no" />
	<?php
	//echo $this->Html->meta('icon');

	echo $this->Html->css('layout');
	// echo $this->Html->css('smoothness/jquery-ui-1.8.18.custom'); // jQuery UI
	// <script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script>
	?>
	<?php
	// echo $this->Html->script('jquery-1.7.1.min');
	echo $this->Html->script('jquery-1.7.2.min');
	echo $this->Html->script('jquery-ui-1.8.18.custom.min');
	echo $this->Html->script('jquery.tabs.setup');

	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');
	?>

	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-34085042-1', 'auto');
		ga('send', 'pageview');
	</script>

	<?php
	if(isset($facebookMetaTags) and !empty($facebookMetaTags)) { echo $facebookMetaTags; }

	if(isset($this->params['controller']) and ($this->params['controller'] == 'pages')) {
		if(isset($this->params['pass'][0]) and ($this->params['pass'][0] == 'home')) {
			$image = $this->Html->url('/img/bhel_hss_logo.jpg', true);
			$facebookMetaTags = <<<TAGS
<meta property="og:title" content="BHEL Higher Secondary School" />
<meta property="og:type" content="school" />
<meta property="og:url" content="http://www.bhelhss.com" />
<meta property="og:image" content="$image" />
<meta property="og:site_name" content="BHEL HSS Alumni" />
<meta property="fb:app_id" content="296465983802820" />
TAGS;
			echo $facebookMetaTags;
		}
	}
	?>

</head>
<body id="top">
<?php
echo $this->element('customjs');
echo $this->element('top_header');
echo $this->element('top_navigation_menu');
?>
<?php
if(isset($this->params['controller']) and ($this->params['controller'] == 'pages')) {
	if(isset($this->params['pass'][0]) and ($this->params['pass'][0] == 'home')) {
		//echo $this->element('homepage_slider'); // show image slider
		?>

		<div class="wrapper">
			<div id="featured_slide" class="clear">
				<!-- ###### -->
				<div class="overlay_left"></div>
				<div id="featured_content" style="height:300px;">
					<div class="featured_box" id="fc2" style="height:300px;">
						<?php echo $this->Html->image('slider/6.jpg', array('alt'=>'', 'style'=>'height:300px;'));?>
					</div>
					<div class="featured_box" id="fc3" style="height:300px;">
						<?php echo $this->Html->image('slider/2.jpg', array('alt'=>'', 'style'=>'height:300px;'));?>
					</div>
				</div>
				<ul id="featured_tabs" style="display:none;">
					<li><a href="#fc2">Alumni Reunion<br>21st Dec 2014</a></li>
					<li><a href="#fc3">BHEL Higher Secondary School</a></li>
				</ul>
				<div class="overlay_right"></div>
				<!-- ###### -->
			</div>
		</div>









		<?php
	}
}
?>
<?php
?>
<!-- ####################################################################################################### -->
<div class="wrapper row3">
	<div class="rnd">
		<div id="container" class="clear">
			<?php echo $this->Session->flash();?>

			<?php echo $this->fetch('content');	?>
		</div>
	</div>
</div>
<!-- ####################################################################################################### -->
<?php
// echo $this->element('footer');
//echo $this->element('sql_dump');
?>
</body>
</html>
