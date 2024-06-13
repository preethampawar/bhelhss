<div class="wrapper row4">
  <div class="rnd">
    <div id="footer" class="clear">
      <!-- ####################################################################################################### -->
      <div class="fl_left clear">
        <div class="fl_left center"><?php echo $this->Html->image('bhel_hss_map.png', array('alt'=>'bhel hss on google maps', 'style'=>'height:98px; width:200px;  margin-bottom: 22px;'));?><br />
          <a href="https://maps.google.com/maps/ms?msid=210952262730083484589.0004c7367b16c7770c431&msa=0&ll=17.498003,78.302865&spn=0.022348,0.042272" target="_blank" title="BHEL Higher Secondary School on Google Map">Find School With Google Maps &raquo;</a></div>
        <address>
        BHEL Higher Secondary School<br />        
        RC Puram, Hyderabad<br />
        Andhra Pradesh, India<br />
        Pin - 502032<br />
        <br />
        Mob: +91 9493692233 <br />
        Email: <a href="mailto:bhelhssaa@gmail.com">bhelhssaa@gmail.com</a>
        </address>
      </div>
      <div class="fl_right">
		<?php 
			App::uses('User', 'Model');
			$this->User = new User;
			
			App::uses('Image', 'Model');
			$this->Image = new Image;
			
			$confirmedRegistrations = $this->User->find('count', array('conditions'=>array('User.active'=>'1', 'User.registered'=>'1'), 'recursive'=>'-1'));
			// $notConfirmedRegistrations = $this->User->find('count', array('conditions'=>array('User.active'=>'1', 'User.registered'=>'0'), 'recursive'=>'-1'));
			$sharedPhotos = $this->Image->find('count', array('conditions'=>array('Image.shared_photo'=>'1'), 'recursive'=>'-1'));
		?>       
		<div id="social" class="clear">						
			<p>Stay Up to Date With Whats Happening</p>
			<ul>
				<!-- <li><a style="background-position:0 0;" href="#">Twitter</a></li> -->
				<li><a style="background-position:-72px 0;" href="http://in.linkedin.com/groups?gid=161745" target="_blank">LinkedIn</a></li>
				<li><a style="background-position:-142px 0;" href="https://www.facebook.com/groups/296465983802820/?fref=ts" target="_blank">Facebook</a></li>
				<!-- <li><a style="background-position:-212px 0;" href="#">Flickr</a></li>
				<li><a style="background-position:-282px 0;" href="#">RSS</a></li> -->
			</ul>
		</div>
		<?php
		if(isset($this->params['controller']) and ($this->params['controller'] == 'pages')) {
			if(isset($this->params['pass'][0]) and ($this->params['pass'][0] == 'home')) {
			?>
			<br>
			<div id="fb-root"></div>
			<script>
			$(document).ready(function() {
				(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
			});
			</script>
			<div class="fb-like" data-send="true" data-width="400" data-show-faces="true"></div>
			<?php					
			}
		}

		?>
		
		<!--
        <div id="newsletter">
          <form action="#" method="post">
            <fieldset>
              <legend>Subscribe To Our Newsletter:</legend>
              <input type="text" value="Enter Email Here&hellip;" onfocus="this.value=(this.value=='Enter Email Here&hellip;')? '' : this.value ;" />
              <input type="text" id="subscribe" value="Submit" />
            </fieldset>
          </form>
        </div>
		-->
		
		<div style="font-weight:normal; background-color:#f3f3f3; padding:5px 0 5px 0; text-align:center; margin:10px 0 0 0; font-size:12px;">
			Total Visits: <strong><?php echo $this->Session->read('SiteVisitCount');?></strong>
			&nbsp;&nbsp;|&nbsp;&nbsp; 
			<span>Members: <strong><?php echo $confirmedRegistrations;?>+</strong></span> 
			&nbsp;&nbsp;|&nbsp;&nbsp; 
			Photos Shared: <strong><?php echo $sharedPhotos;?>+</strong>
			<!--
			<div style="margin-top:10px;">
				<?php echo $this->Html->link('Subscribe/Unsubscribe to our mailing list', '/users/subscribe', array('title'=>'Subscribe/Unsubscribe to our mailing list'));?>
			</div>
			-->
		</div>
      </div>
      <!-- ####################################################################################################### -->
    </div>
  </div>
</div>
<!-- ####################################################################################################### -->
<div class="wrapper">
  <div id="copyright" class="clear">
    <p class="fl_left">Copyright &copy; 2013 - All Rights Reserved - <?php echo $this->Html->link('bhelhss.com', '#', array('title'=>'BHEL Higher Secondary School Alumni'));?></p>
    <!-- <p class="fl_right">Template by <a href="http://www.os-templates.com/" title="Free Website Templates">OS Templates</a></p> -->
    <p class="fl_right">Powered by <a href="http://www.cakephp.org" title="CakePHP Framework">CakePHP</a></p>
  </div>	
</div>