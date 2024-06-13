<div id="addCommentForm<?php echo $imageID;?>" style="text-align:left;">	
	<?php echo $this->Form->create(null, array('onsubmit'=>'return false;'));?>
	<table cellpadding='0' cellspacing='0' style="width:100%;">
		<tr>
			<td style='padding:0px 0px;'>
				<?php
				echo $this->Form->input('Comment.name', array('type'=>'text', 'label'=>false, 'required'=>true, 'placeholder'=>'Your text goes here...', 'style'=>'width:99%; height:30px;', 'id'=>'photoCommentName'.$imageID));
				?>
			</td>
		</tr>
		<tr>
			<td>
				<?php
				echo $this->Form->submit('Add Comment', array('escape'=>false, 'class'=>'button small green floatRight', 'onclick'=>"addPhotoComment('".$imageID."', '".$encodedImageID."'); $('#addCommentButton".$imageID."').css('display', 'none');", 'type'=>'submit', 'id'=>'addCommentButton'.$imageID)); 
				?>
			</td>
		</tr>
	</table>
	<?php echo $this->Form->end();?>
	
</div>