<?php 
if(isset($imageInfo) and !empty($imageInfo)) {
	echo $this->element('photo_block', array('photoInfo'=>$imageInfo));
}
?>	