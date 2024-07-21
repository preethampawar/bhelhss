
<div class="container">
	<div class="col-md-6 m-auto p-5 bg-light rounded-3 text-center" style="border-radius: 2rem !important;">
		<?php echo $this->element('message');?>


		<?php echo $this->Form->create();?>
		<h1 class="text-center">Log in</h1>

		<?php echo $this->Form->input('User.email', array('label'=>false, 'type'=>'email', 'div'=>true, 'required'=>true, 'placeholder'=>'Enter Email Address', 'class'=>'form-control mt-5'));?>

		<?php echo $this->Form->input('User.password', array('label'=>false, 'div'=>true, 'type'=>'password', 'required'=>true, 'placeholder'=>'Enter Password', 'class'=>'form-control mt-4'));?>

		<?php echo $this->Form->submit('Log In &nbsp;&raquo;', array('escape'=>false, 'div'=>false, 'class'=>'btn btn-primary rounded-pill mt-4'));?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo $this->Html->link('Cancel', '/', array('escape'=>false, 'div'=>false, 'class'=>'btn btn-outline-secondary rounded-pill mt-4'));	?>

		<!--
		<br>
		<?php echo $this->Html->link('Forgot your password?', '/users/forgotpassword', array('style'=>'text-decoration:none;')); ?>
		<br><br>
		Need an account? Click here to <?php echo $this->Html->link('Register', '/users/register', array('style'=>'text-decoration:none;', 'escape'=>false)); ?>.
		-->

		<?php echo $this->Form->end();?>
	</div>
</div>
<br><br><br><br>
