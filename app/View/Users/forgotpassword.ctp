<?php echo $this->element('message');?>

<?php echo $this->Form->create();?>

	<h2>Forgot your password?</h2>


<div class="input text required"><label for="email">Email Address: </label>
	<?php echo $this->Form->input('User.email', array('label'=>false, 'div'=>false, 'type'=>'email', 'required'=>true, 'placeholder'=>'Enter Email Address', 'style'=>'width:200px;'));?>		
</div>
<br>
&nbsp;Note<span style='color:#ff0000;'>*</span>: Verfication code will be sent to the above Email Address.	
<br><br>
<div>
<?php echo $this->Form->submit('Continue &nbsp;&raquo;', array('escape'=>false, 'div'=>false, 'class'=>'button green small'));?>	
</div>
<?php //echo $this->Html->link('&raquo; Forgot your password?', '/users/forgotpassword', array('style'=>'text-decoration:none;', 'escape'=>false)); ?>
<?php //echo $this->Html->link('Need an account?', '/users/signup'); ?>
<br>
<br>
&nbsp;<?php echo $this->Html->link('&raquo; Log in', '/users/login', array('style'=>'text-decoration:none;', 'escape'=>false)); ?>
<br>
<?php echo $this->Form->end();?>
	
