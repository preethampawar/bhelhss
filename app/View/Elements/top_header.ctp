<div class="wrapper row1">
	<div id="header" class="clear">
		<div>		
			<div class="fl_left">
				<?php echo $this->Html->link($this->Html->image('bhel_hss_logo.jpg', array('height'=>'120', 'border'=>'0')), '/', array('title'=>'BHEL Higher Secondary School Alumni', 'escape'=>false));?>
			</div>
			<div class='fl_left' style="margin: 40px 10px 0 10px;">				
				<h1><?php echo $this->Html->link('BHEL HSS Alumni', '/', array('title'=>'BHEL Higher Secondary School Alumni'));?></h1>
				<p>&nbsp;- BHEL Higher Secondary School</p>
			</div>
			
			<div class="fl_right" style="margin:35px 10px 0 0; text-align:right;">				
				<?php 
				if(!$this->Session->check('User')) { 
				?>
					<ul>						
						<li><?php echo $this->Html->link('Register', array('controller'=>'users', 'action'=>'register'), array('style'=>'border-bottom:1px dotted #ffffff;'));?></li>
						<li style="text-decoration:blink;"><?php echo $this->Html->link('Refer Your School Friend', '/ReferFriends/referafriend', array('style'=>'border-bottom:1px dotted #ffffff; color:yellow; font-weight:bold;'));?></li>
						<li class='last'><?php echo $this->Html->link('Login', array('controller'=>'users', 'action'=>'login'), array('style'=>'border-bottom:1px dotted #ffffff;'));?></li>			
					</ul>
				<?php
				}
				else { 
				?>
					<ul>
						<?php
						if($this->Session->read('User.has_completed_profile')) {
						?>
						<li><?php echo $this->Html->link('My Profile', '/users/viewProfile', array('style'=>'border-bottom:1px dotted #ffffff;'));?></li>
						<li><?php echo $this->Html->link('Change Password', '/users/changepassword', array('style'=>'border-bottom:1px dotted #ffffff;'));?></li>
						<li><?php echo $this->Html->link('Refer Your School Friend', '/ReferFriends/referafriend', array('style'=>'border-bottom:1px dotted #ffffff; color:yellow; font-weight:bold;'));?></li>
						<?php
						}
						?>
						<li class='last'><?php echo $this->Html->link('Logout', array('controller'=>'users', 'action'=>'logout'), array('style'=>'border-bottom:1px dotted #ffffff;'));?></li>			
					</ul>
				<?php
				}
				?>
				<br>
				<?php
				$showSearch=true;
				if($this->Session->check('User') and !$this->Session->read('User.has_completed_profile')) {
					$showSearch = false;
				}
				if($showSearch) {
				?>
				<form action="<?php echo $this->Html->url('/users/search');?>" method="post" id="sitesearch">
					<fieldset>
						<strong>Search:</strong>
						<input type="text" name="data[User][name]" value="Search Students&hellip;" onfocus="this.value=(this.value=='Search Students&hellip;')? '' : this.value ;" />          
						<?php echo $this->Html->image('search.gif', array('id'=>'search', 'alt'=>'Search', 'onclick'=>'$("#sitesearch").submit()'));?>
					</fieldset>
				</form>		
				<?php
				}
				?>
			</div>
			<div class="clear" style="clear:both"></div>
				<div style="margin-top:10px; color:#fff; text-align:right;">
					Contact Info. Mobile:  <span style="border-bottom:1px dotted #fff; font-weight:bold;">+91 9493692233</span> 
					&nbsp;&nbsp;|&nbsp;&nbsp; 
					Email:  <span style="border-bottom:1px dotted #fff; font-weight:bold;">bhelhssaa@gmail.com</span>
				</div>
			<?php
			if($this->Session->check('User') and $this->Session->read('User.has_completed_profile')) {		
			?>
			<div style="margin:20px 10px 0 10px; color:#eee;">				
				<div class="floatLeft">
					<p>Welcome, <?php echo $this->Session->read('User.name');?> 
					&nbsp;&nbsp;|&nbsp;&nbsp;
					Batch: <?php echo $this->Session->read('User.batch');?> (10<span style="font-style:italic; font-size:80%;">th</span> class)</p>
				</div>
				<div class="floatRight">
					<div id="recentActivityIndicatorBox" class="floatRight">
						<?php echo $this->requestAction('/activity/recentActivityIndicator', array('render'=>true));?>
					</div>
					
				</div>
				<div class="clear" style="clear:both"></div>
			</div>	
			<?php
			}
			?>
			
			
			
			<?php
			if($this->Session->check('User') and ($this->Session->read('User.admin'))) {
			?>			
			<div style="margin:20px 10px 0 10px; color:#eee;">	
				<?php echo $this->Html->link('Manage Posts', '/admin/categories/');?>
				&nbsp;&nbsp;|&nbsp;&nbsp;
				<?php echo $this->Html->link('Manage Users', '/admin/users/');?>	
				&nbsp;&nbsp;|&nbsp;&nbsp;
				<?php echo $this->Html->link('Block Requests', '/admin/activity/blockRequests');?>	
				&nbsp;&nbsp;|&nbsp;&nbsp;
				<?php echo $this->Html->link('Referred People List', '/ReferFriends/showReferredPeople');?>
			</div>
			<?php
			}
			?>	
			
			<?php
			if($this->Session->check('User')) {
			?>			
			<div style="margin:20px 10px 0 10px; color:#eee;">	
				<?php echo $this->Html->link('Students Directory', '/users/studentsDirectory', array('style'=>'border-bottom:1px dotted #ffffff;'));?>
				&nbsp;&nbsp;|&nbsp;&nbsp;
				<?php echo $this->Html->link("Teacher's Contact Info", '/teachers/addInfo', array('style'=>'border-bottom:1px dotted #ffffff;'));?>
				&nbsp;&nbsp;|&nbsp;&nbsp;
				<?php echo $this->Html->link('Refer Your School Friend', '/ReferFriends/referafriend', array('style'=>'border-bottom:1px dotted #ffffff; color:yellow; font-weight:bold;'));?>
				<!-- &nbsp;&nbsp;|&nbsp;&nbsp; -->
			</div>
			<?php
			}
			?>	
		</div>
	</div>
</div>