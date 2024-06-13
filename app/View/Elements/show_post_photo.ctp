<?php
if(isset($photoInfo) and !empty($photoInfo)) {
	
	$userID = $photoInfo['User']['id'];
	$userName = $photoInfo['User']['name'];
	$imageID = $photoInfo['Image']['id'];
	$encodedImageID = base64_encode($photoInfo['Image']['id']);
	$imageCaption = $photoInfo['Image']['caption'];
	
	$imageTitle = 'By, '.$userName.', '.
					date('g:i a', strtotime($photoInfo['Image']['created'])).', '.
					date('D, d  M - Y', strtotime($photoInfo['Image']['created'])).'</p>';			
	
	$imageUrl = $this->Img->showImage('img/images/'.$imageID, array('height'=>'800','width'=>'800','type'=>'auto'), array('style'=>'', 'alt'=>$imageCaption, 'title'=>$imageCaption), true);	
	?>
		
		<div class="imageInfo" style="text-align:left; width:600px;">
			<div class="imageInfoText floatLeft" style="text-align:left;">
				By, <?php echo $this->Html->link($userName, array('controller'=>'users', 'action'=>'info', $userID), array('target'=>'_blank'));?> 
				<div style="margin:5px 0 10px;">					
					<div class="floatLeft">
						<?php echo date('g:i a', strtotime($photoInfo['Image']['created']));?>,
						<?php echo date('D, d  M - Y', strtotime($photoInfo['Image']['created']));?> 				
						&nbsp;&nbsp;|&nbsp;&nbsp;				
					</div>
				
					<div class="floatLeft" id="likePhotoDiv<?php echo $imageID;?>" style="margin-right:10px; margin-left:5px;">
						<?php echo $this->element('photo_likes', array('photoInfo'=>$photoInfo));?>
					</div>
					<div class="floatLeft" id="blockPhotoDiv<?php echo $imageID;?>" style="margin-right:10px;">
						<?php echo $this->element('photo_block', array('photoInfo'=>$photoInfo));?>
					</div>				
				</div>
			</div>	
			<div class="clear" style="clear:both;"></div>			
			<div class="postPhotos floatLeft" style="width:520px; text-align:left;">							
				<div style="padding:15px 0;">
					
					<a href="<?php echo $imageUrl;?>" title='<?php echo $imageTitle;?>'>
						<?php 
						echo $this->Img->showImage('img/images/'.$imageID, array('height'=>'500','width'=>'500','type'=>'auto'), array('style'=>'', 'alt'=>$imageTitle, 'title'=>$imageTitle));
						?>			
					</a>
				</div>
				<div class="imageCaption" style="margin-top:5px;">
				<?php echo $imageCaption;?>
				</div>
			</div>
			<div class="clear" style="clear:both;"></div>			

			<div class="photoComments" style="width:500px;" id="photoCommentsDiv<?php echo $imageID;?>">				
				<?php echo $this->requestAction('/comments/addPhotoComment/'.$encodedImageID, array('render'=>true));?>
			</div>	
			
		</div>	
<?php
}
else {
	$successMsg = 'Photo removed successfully';
	?>
	<div style="">
		<?php echo $this->element('simple_message', array('successMsg'=>$successMsg));?>
	</div>
	<?php
}
?>	
<br>