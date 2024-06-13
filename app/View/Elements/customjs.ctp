<script type="text/javascript">
function setBatch() {
	passoutYear = parseInt($('#UserPassoutYear').val()); // 8
	userClass = parseInt($('#UserClass').val()); // 1998
	if(userClass > 10) {
		tmp = userClass-10;
		batch = passoutYear-tmp ;
	}
	else {
		tmp = 10-userClass;
		batch = passoutYear+tmp
	}
	$('#UserBatch').val(batch);
}

function likeComment(commentID) {
	commentUrl = '<?php echo $this->Html->url('/comments/likeComment/');?>'+commentID;	
		
	request = $.ajax({
	  type: "POST",
	  url: commentUrl,
	  data: { id: commentID },
	  dataType: "html"
	});
	
	request.done(function( msg ) {
	  $('#likeCommentDiv'+commentID).css('display', 'block');
	  $('#likeCommentDiv'+commentID).html(msg);
	});	
	
	request.fail(function(jqXHR, textStatus) {
	  //alert( "Request failed: " + textStatus );
	});
}


function blockComment(commentID) {
	var r = confirm("Are you sure you want to block this comment?");	
	if(r == false) {
		return false;
	}

	commentUrl = '<?php echo $this->Html->url('/comments/blockComment/');?>'+commentID;	
		
	request = $.ajax({
	  type: "POST",
	  url: commentUrl,
	  data: { id: commentID },
	  dataType: "html"
	});
	
	request.done(function( msg ) {
	  $('#blockCommentDiv'+commentID).css('display', 'block');
	  $('#blockCommentDiv'+commentID).html(msg);
	});	
	
	request.fail(function(jqXHR, textStatus) {	  
	 // alert( "Request failed: " + textStatus );
	});
}


function likePhoto(photoID) {
	likeUrl = '<?php echo $this->Html->url('/images/likePhoto/');?>'+photoID;	
		
	request = $.ajax({
	  type: "POST",
	  url: likeUrl,
	  data: { id: photoID },
	  dataType: "html"
	});
	
	request.done(function( msg ) {
	  $('#likePhotoDiv'+photoID).css('display', 'block');
	  $('#likePhotoDiv'+photoID).html(msg);
	});	
	
	request.fail(function(jqXHR, textStatus) {
	  //alert( "Request failed: " + textStatus );
	});
}

function blockPhoto(photoID) {
	var r = confirm("Are you sure you want to block this photo?");	
	if(r == false) {
		return false;
	}

	blockUrl = '<?php echo $this->Html->url('/images/blockPhoto/');?>'+photoID;	
		
	request = $.ajax({
	  type: "POST",
	  url: blockUrl,
	  data: { id: photoID },
	  dataType: "html"
	});
	
	request.done(function( msg ) {	  
	  $('#blockPhotoDiv'+photoID).html(msg);
	});	
	
	request.fail(function(jqXHR, textStatus) {	  
	 // alert( "Request failed: " + textStatus );
	});
}


function removePhoto(photoID) {
	var r = confirm("Are you sure you want to remove this photo?");	
	if(r == false) {
		return false;
	}

	removeUrl = '<?php echo $this->Html->url('/images/deletePhoto/');?>'+photoID;	
	request = $.ajax({
	  type: "POST",
	  url: removeUrl,
	  data: { id: photoID },
	  dataType: "html"
	});
	
	request.done(function( msg ) {
		$('#showPhotoBox'+photoID).html(msg);
	});	
	
	request.fail(function(jqXHR, textStatus) {
	  //alert( "Request failed: " + textStatus );
	});
}






function addPhotoComment(photoID, encodedPhotoID) {
	commentUrl = '<?php echo $this->Html->url('/comments/addPhotoComment/');?>'+encodedPhotoID;
	comment = $('#photoCommentName'+photoID).val();
		
	request = $.ajax({
	  type: "POST",
	  url: commentUrl,
	  data: { name: comment },
	  dataType: "html"
	});
	
	request.done(function( msg ) {
	  $('#addCommentButton'+photoID).css('display', 'block');
	  $('#photoCommentsDiv'+photoID).html(msg);
	});	
	
	request.fail(function(jqXHR, textStatus) {
	  $('#addCommentButton'+photoID).css('display', 'block');
	  //alert( "Request failed: " + textStatus );
	});
}	

function removePhotoComment(photoID, commentID) {
	var r = confirm("Are you sure you want to remove this comment?");	
	if(r == false) {
		return false;
	}

	commentUrl = '<?php echo $this->Html->url('/comments/removePhotoComment/');?>'+photoID+'/'+commentID;	
	request = $.ajax({
	  type: "POST",
	  url: commentUrl,
	  data: { comment_id: commentID, photo_id: photoID },
	  dataType: "html"
	});
	
	request.done(function( msg ) {
		$('#photoCommentsDiv'+photoID).html(msg);
	});	
	
	request.fail(function(jqXHR, textStatus) {
	 // alert( "Request failed: " + textStatus );
	});
}

function likeComment(commentID) {
	commentUrl = '<?php echo $this->Html->url('/comments/likeComment/');?>'+commentID;	
		
	request = $.ajax({
	  type: "POST",
	  url: commentUrl,
	  data: { id: commentID },
	  dataType: "html"
	});
	
	request.done(function( msg ) {
	  $('#likeCommentDiv'+commentID).css('display', 'block');
	  $('#likeCommentDiv'+commentID).html(msg);
	});	
	
	request.fail(function(jqXHR, textStatus) {
	  //alert( "Request failed: " + textStatus );
	});
}


function blockComment(commentID) {
	var r = confirm("Are you sure you want to block this comment?");	
	if(r == false) {
		return false;
	}

	commentUrl = '<?php echo $this->Html->url('/comments/blockComment/');?>'+commentID;	
		
	request = $.ajax({
	  type: "POST",
	  url: commentUrl,
	  data: { id: commentID },
	  dataType: "html"
	});
	
	request.done(function( msg ) {
	  $('#blockCommentDiv'+commentID).css('display', 'block');
	  $('#blockCommentDiv'+commentID).html(msg);
	});	
	
	request.fail(function(jqXHR, textStatus) {	  
	 // alert( "Request failed: " + textStatus );
	});
}

function updatePhotoComments(encodedImageID, imageID) {
	commentUrl = '<?php echo $this->Html->url('/comments/listPhotoComments/');?>'+encodedImageID;	
		
	request = $.ajax({
	  type: "POST",
	  url: commentUrl,
	  data: { encodedimageid: encodedImageID },
	  dataType: "html"
	});
	
	request.done(function( msg ) {	  
		$('#photoCommentsList'+imageID).html(msg);		
	});	
	
	request.fail(function(jqXHR, textStatus) {	  
		//alert( "Request failed: " + textStatus );
	});
}

function checkActivity() {
	// setInterval('getActivityUpdates', '1000');
}

function getActivityUpdates() {	
	activityUrl = '<?php echo $this->Html->url('/activity/recentActivityIndicator');?>';	
		
	request = $.ajax({
	  type: "POST",
	  url: activityUrl,
	  data: { id: 'getUpdates' },
	  dataType: "html"
	});
	
	request.done(function( msg ) {	  
		$('#recentActivityIndicatorDiv').html(msg);		
	});
	
	request.fail(function(jqXHR, textStatus) {	  
		//alert( "Request failed: " + textStatus );
	});
}


</script>