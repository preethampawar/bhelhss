<?php
if(isset($errorMsg) and !empty($errorMsg))
{
	echo '<p class="alert alert-danger rounded-pill">'.$errorMsg.'</p>';
}
if(isset($successMsg) and !empty($successMsg))
{
	echo '<p class="alert alert-success rounded-pill">'.$successMsg.'</p>';
}
?>
