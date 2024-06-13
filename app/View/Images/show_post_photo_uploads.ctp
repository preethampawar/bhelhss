<h2>
<?php echo $this->Html->link('Photo Gallery', '/images/showList/', array('title'=>'Photo gallery'));?>
&nbsp;&nbsp;&raquo;
<?php echo $this->Html->link($postInfo['Post']['title'], '/images/showPostPhotoUploads/'.$postInfo['Post']['id'], array('title'=>$postInfo['Post']['title']. ': Photos'));?>
</h2>
<?php echo $this->Html->link('&raquo; Photos uploaded by me', '/images/showPostPhotoUploads/'.$postInfo['Post']['id'].'/'.$this->Session->read('User.id'), array('title'=>$postInfo['Post']['title']. ': Photos', 'escape'=>false));?>
<div style="padding: 10px 5px; border:1px solid #eee; background-color:#f6f6f6; margin:5px 0 10px 0; ">
	<strong>SEARCH &nbsp; PHOTOS: </strong><br><br>
	<?php
	$batch = $this->Session->read('User.batch');
	echo $this->Form->create(null);
	echo 'Added on: <br>';
	// echo 'Month ';
	echo $this->Form->month('Image.month', array('empty'=>'-All-', 'default'=>$batch));
	echo '&nbsp;&nbsp;&nbsp;&nbsp;';
	// echo 'Year ';
	echo $this->Form->year('Image.year', 2012, date('Y'), array('empty'=>false, 'default'=>$batch));
	echo '&nbsp;&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;&nbsp;';
	echo 'Batch (10th class) ';
	echo $this->Form->year('Image.batch', 2014, 1963, array('empty'=>'-All-', 'default'=>$batch));
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	echo $this->Form->submit('Search &raquo;', array('div'=>false, 'escape'=>false, 'class'=>'small button grey', 'style'=>'margin-top:-4px;'));
	echo $this->Form->end();
	?>
</div>

<?php echo $this->element('upload_post_photo_form');?>
<div class="clear"></div>

<h2><?php echo ($userID) ? 'Photos added by me' : 'Recent Photos';?></h2>
<?php
if(!empty($postImages)) {
?>
	<div>
		<?php
		$prevDate = '';
		$dateCount = 0;
		foreach($postImages as $row) {

			$userID = $row['User']['id'];
			$userName = substr($row['User']['name'], 0, 15);
			$imageID = $row['Image']['id'];
			$imageCaption = $row['Image']['caption'];
			$imageBatch = $row['Image']['batch'];
			$imageClass = $row['Image']['class'];
			$imageSection = $row['Image']['section'];


		?>
			<?php
			$photoDate = date('Y-m-d', strtotime($row['Image']['created']));
			if($photoDate != $prevDate) {
				$prevDate = $photoDate;
				$dateCount++;
			?>
				<?php if($dateCount > 1) { ?>
				<div class="clear"  style="border-bottom:1px dashed #EDC5C2; margin-bottom:20px;"></div>
				<?php } ?>
				<div>
					<?php
					$today = date('Y-m-d');
					$showToday = null;
					if($prevDate == $today) {
						$showToday = 'Today, ';
					}
					?>
					<p class="headingColor"><strong><?php echo $showToday.date('d F, Y', strtotime($photoDate));?></strong></p>
				</div>
			<?php
			}
			?>

			<div style="margin:0 15px 15px 0; width:210px; height:230px; border:1px solid #dedede; text-align:center; background-color:#fdfdfd; "  id="showPhotoBox<?php echo $imageID;?>" class="floatLeft">
				<div style="font-size:11px;" ><?php echo ($imageBatch) ? $imageBatch.' Batch' : '&nbsp;'; echo ($imageClass) ? ' - '.Configure::read('ClassOptions.'.$imageClass) : '';  echo ($imageSection) ? '&nbsp;'.$imageSection : '&nbsp;'; ?></div>
				<a href="<?php echo $this->Html->url('/images/showPostPhoto/'.$imageID);?>" title="<?php echo $imageCaption;?>">
					<?php $this->Img->showImage('img/images/'.$imageID, array('height'=>'150','width'=>'150','type'=>'crop'), array('style'=>'', 'alt'=>$imageCaption, 'title'=>$imageCaption));?>
				</a>
				<p style="font-size:10px; overflow:hidden; padding:0; margin:2px;">
					By, <?php echo $this->Html->link($userName, array('controller'=>'users', 'action'=>'info', $userID), array('target'=>'_blank'));?>
				</p>
				<div style="">
					<div style="text-align: center; display: inline-flex">
						<span class="" style="font-size:10px;" id="likePhotoDiv<?php echo $imageID;?>" style="margin-right:10px; margin-left:0px;">
							<?php echo $this->element('photo_likes', array('photoInfo'=>$row));?>
						</span>
						<span class="">&nbsp;&nbsp;</span>
						<span class="" style="font-size:10px;" id="blockPhotoDiv<?php echo $imageID;?>" style="margin-right:0px;">
							<?php echo $this->element('photo_block', array('photoInfo'=>$row));?>
						</span>
					</div>
				</div>
			</div>
		<?php
		}
		?>
		<div class="clear" style="clear:both;"></div>
		<br>
		<div style="text-align:center;">
			<?php echo $this->Paginator->prev(' << ' . __('previous'), array(), null, array('class' => 'prev disabled'));?>
			&nbsp;&nbsp;&nbsp;<?php echo $this->Paginator->numbers();?>&nbsp;&nbsp;&nbsp;
			<?php echo $this->Paginator->next(__('next').' >>' , array(), null, array('class' => 'next disabled'));?>
		</div>
		<br>
	</div>
<?php
}
else {
	echo ' - No photos found.';
}
?>
