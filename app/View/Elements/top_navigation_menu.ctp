<div class="wrapper row2">
  <div class="rnd">
    <!-- ###### -->
	<?php 
	//if(!$this->Session->check('User')) { 
	?>
    <div id="topnav">		
      <ul>
        <li class="active">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->Html->link('Home', '/');?></li>
		<li><?php echo $this->Html->link('About BHEL HSS', '/posts/show/6/9/BHEL-Higher-Secondary-School/About-the-School', array('title'=>'About the school'));?></li>
		<li><?php echo $this->Html->link('About BHELHSS Alumni Association', '/posts/showAll/10/About-BHELHSS-Association');?></li>		
		<li><?php echo $this->Html->link('News & Events', '/posts/showAll/5/News-And-Events');?></li>		
		<li><?php echo $this->Html->link('Blog', '/blog/posts_show_all/');?></li>
		<li><?php echo $this->Html->link('Photo Gallery', '/images/showList');?></li>		
		<li><?php echo $this->Html->link('Contact Us', '/contactus');?></li>	
		<?php 
		if($this->Session->check('User')) { 
		?>
			
			
				
			<!-- <li><?php //echo $this->Html->link('Live Event*', '/pages/alumni_reunion_live_online/', array('style'=>'color:red'));?></li> -->
			
			<!-- 
			<li><?php //echo $this->Html->link('Alumni Reunion - Live Online *', '/pages/alumni_reunion_live_online/', array('style'=>'color:red'));?></li>
			<li><a href="style-demo.html">Style Demo</a></li>
			<li><a href="full-width.html">Full Width</a></li>
			<li><a href="3-columns.html">3 Columns</a></li>
			<li><a href="portfolio.html">Portfolio</a></li>
			<li><a href="gallery.html">Gallery</a></li>
			<li><a href="#">This a very long link</a></li>
			-->
		<?php
		}
		?>
      </ul>
    </div>
    <!-- ###### -->
  </div>
</div>