<?php 
if(isset($errorMsg) and !empty($errorMsg))
{
	echo '<p class="errorMsg">'.$errorMsg.'</p>';
}
if(isset($successMsg) and !empty($successMsg))
{
	echo '<p class="successMsg">'.$successMsg.'</p>';
} 
?>