<?php
App::uses('CakeEmail', 'Network/Email');
class ActivityController extends AppController {
	
	public function beforeFilter() {
		parent::beforeFilter();		
		$this->Auth->allow('recentActivity');
	}	
	
	function recentActivityIndicator() {				
		$fromActivityTime = $this->Session->read('User.last_activity_visit');
		$conditions = array('Activity.created >='=>$fromActivityTime);				
		$hasActivity = $this->Activity->find('count', array('conditions'=>$conditions));
		$latestActivityInfo = $this->Activity->find('first', array('conditions'=>$conditions, 'order'=>'Activity.created DESC'));
		$this->set(compact('hasActivity', 'latestActivityInfo'));	
	}
	
	function showRecentActivity($type='NewPhotos') {	
		
		$fromActivityTime = $this->Session->read('User.last_activity_visit');
		$fromActivityTime = '2012-01-01';
		
		$prevReq = $this->request->referer();
		$tmp = explode('/', $prevReq);
		if(!in_array('showRecentActivity', $tmp)) {
			$tmpTime = $this->Session->read('User.last_activity_visit');
			$fromActivityTime = $tmpTime;
			$this->Session->write('tmpActivityTime', $tmpTime);
		}
		else {
			if(!$this->Session->check('tmpActivityTime')) {
				$this->Session->write('tmpActivityTime', $fromActivityTime); 	
			}			
		}		
		$fromActivityTime = $this->Session->read('tmpActivityTime');
		
		$photoUploads = $likePhotos = $likeComments = $blockPhotoRequests = $blockCommentRequests = $photoComments = array();
		$photoUploadsCount = $likePhotosCount = $likeCommentsCount = $blockPhotoRequestsCount = $blockCommentRequestsCount = $photoCommentsCount = $blockPostRequestsCount = $newPostRequestsCount = array();
	
		// get photo upload activity
		$conditions = array('Activity.type'=>'photo_upload');
		$this->Activity->bindModel(array('belongsTo'=>array('User'=>array('fields'=>array('User.id', 'User.name', 'User.email')), 'Image'=>array('fields'=>array('Image.id', 'Image.caption')))));
		$tmpConditions = array();
		$tmpConditions[] = $conditions;
		$tmpConditions[] = array('Activity.created >='=>$fromActivityTime);

		$photoUploadsCount = $this->Activity->find('count', array('conditions'=>$tmpConditions, 'order'=>'Activity.created DESC'));
		if($type == 'NewPhotos') {
			$this->Activity->bindModel(array('belongsTo'=>array('User'=>array('fields'=>array('User.id', 'User.name', 'User.email')), 'Image'=>array('fields'=>array('Image.id', 'Image.caption')), 'Post'=>array('fields'=>array('Post.id', 'Post.title')))));
			$photoUploads = $this->Activity->find('all', array('conditions'=>$conditions, 'order'=>'Activity.created DESC'));
		}
		
		// get like photo activity
		$conditions = array('Activity.type'=>'photo_like');
		$this->Activity->bindModel(array('belongsTo'=>array('User'=>array('fields'=>array('User.id', 'User.name', 'User.email')), 'Image'=>array('fields'=>array('Image.id', 'Image.likes_user_ids')))));
		$tmpConditions = array();
		$tmpConditions[] = $conditions;
		$tmpConditions[] = array('Activity.created >='=>$fromActivityTime);
		$likePhotosCount = $this->Activity->find('count', array('conditions'=>$tmpConditions, 'order'=>'Activity.created DESC'));
		if($type == 'PhotoLikes') {
			$this->Activity->bindModel(array('belongsTo'=>array('User'=>array('fields'=>array('User.id', 'User.name', 'User.email')), 'Image'=>array('fields'=>array('Image.id', 'Image.likes_user_ids')))));
			$likePhotos = $this->Activity->find('all', array('conditions'=>$conditions, 'order'=>'Activity.created DESC'));			
		}
		
		// get block photo requests
		$conditions = array('Activity.type'=>'photo_block');
		$this->Activity->bindModel(array('belongsTo'=>array('User'=>array('fields'=>array('User.id', 'User.name', 'User.email')), 'Image'=>array('fields'=>array('Image.id', 'Image.block_user_ids')))));
		$tmpConditions = array();
		$tmpConditions[] = $conditions;
		$tmpConditions[] = array('Activity.created >='=>$fromActivityTime);	
		$blockPhotoRequestsCount = $this->Activity->find('count', array('conditions'=>$tmpConditions, 'order'=>'Activity.created DESC'));
		if($type == 'BlockPhotos') {
			$this->Activity->bindModel(array('belongsTo'=>array('User'=>array('fields'=>array('User.id', 'User.name', 'User.email')), 'Image'=>array('fields'=>array('Image.id', 'Image.block_user_ids')))));
			$blockPhotoRequests = $this->Activity->find('all', array('conditions'=>$conditions, 'order'=>'Activity.created DESC'));
		}
		
		// get new photo comments activity(add comment)
		$conditions = array('Activity.type'=>'photo_comment');		
		$this->Activity->bindModel(array('belongsTo'=>array('User'=>array('fields'=>array('User.id', 'User.name', 'User.email')), 'Image'=>array('fields'=>array('Image.id', 'Image.caption')))));		
		$tmpConditions = array();
		$tmpConditions[] = $conditions;
		$tmpConditions[] = array('Activity.created >='=>$fromActivityTime);	
		$photoCommentsCount = $this->Activity->find('count', array('conditions'=>$tmpConditions, 'order'=>'Activity.created DESC'));
		if($type == 'PhotoComments') {
			$this->Activity->bindModel(array('belongsTo'=>array('User'=>array('fields'=>array('User.id', 'User.name', 'User.email')), 'Image'=>array('fields'=>array('Image.id', 'Image.caption')), 'Comment'=>array('fields'=>array('Comment.id', 'Comment.name', 'Comment.image_id')))));		
			$photoComments = $this->Activity->find('all', array('conditions'=>$conditions, 'order'=>'Activity.created DESC'));
		}
		
		// get like comments activity
		$conditions = array('Activity.type'=>'comment_like');		
		$this->Activity->bindModel(array('belongsTo'=>array('User'=>array('fields'=>array('User.id', 'User.name', 'User.email')), 'Comment'=>array('fields'=>array('Comment.id', 'Comment.name', 'Comment.likes_user_ids')))));		
		$tmpConditions = array();
		$tmpConditions[] = $conditions;
		$tmpConditions[] = array('Activity.created >='=>$fromActivityTime);	
		$likeCommentsCount = $this->Activity->find('count', array('conditions'=>$tmpConditions, 'order'=>'Activity.created DESC'));
		if($type == 'CommentLikes') {
			$this->Activity->bindModel(array('belongsTo'=>array('User'=>array('fields'=>array('User.id', 'User.name', 'User.email')), 'Comment'=>array('fields'=>array('Comment.id', 'Comment.name', 'Comment.likes_user_ids', 'Comment.image_id', 'Comment.user_id')), 'Image'=>array('fields'=>array('Image.id', 'Image.caption')))));		
			
			$this->Activity->Comment->unbindModel(array('belongsTo'=>array('ParentComment')));
			$this->Activity->Comment->bindModel(array('belongsTo'=>array('User'=>array('fields'=>array('User.id', 'User.name', 'User.image_id')))));
			$likeComments = $this->Activity->find('all', array('conditions'=>$conditions, 'order'=>'Activity.created DESC', 'recursive'=>2));			
		}
		
		// get block comment requests
		$conditions = array('Activity.type'=>'comment_block');		
		$this->Activity->bindModel(array('belongsTo'=>array('User'=>array('fields'=>array('User.id', 'User.name', 'User.email')), 'Comment'=>array('fields'=>array('Comment.id', 'Comment.name', 'Comment.block_user_ids')))));		
		$tmpConditions = array();
		$tmpConditions[] = $conditions;
		$tmpConditions[] = array('Activity.created >='=>$fromActivityTime);	
		$blockCommentRequestsCount = $this->Activity->find('count', array('conditions'=>$tmpConditions, 'order'=>'Activity.created DESC'));
		if($type == 'BlockComments') {
			$this->Activity->bindModel(array('belongsTo'=>array('User'=>array('fields'=>array('User.id', 'User.name', 'User.email')), 'Comment'=>array('fields'=>array('Comment.id', 'Comment.name', 'Comment.block_user_ids')))));		
			$blockCommentRequests = $this->Activity->find('all', array('conditions'=>$conditions, 'order'=>'Activity.created DESC'));
		}	

		// get block post requests
		$conditions = array('Activity.type'=>'post_block');		
		$this->Activity->bindModel(array('belongsTo'=>array('User'=>array('fields'=>array('User.id', 'User.name', 'User.email')), 'Post'=>array('fields'=>array('Post.id', 'Post.title', 'Post.block_user_ids')))));		
		$tmpConditions = array();
		$tmpConditions[] = $conditions;
		$tmpConditions[] = array('Activity.created >='=>$fromActivityTime);	
		$blockPostRequestsCount = $this->Activity->find('count', array('conditions'=>$tmpConditions, 'order'=>'Activity.created DESC'));
		if($type == 'BlockPosts') {
			$this->Activity->bindModel(array('belongsTo'=>array('User'=>array('fields'=>array('User.id', 'User.name', 'User.email')), 'Post'=>array('fields'=>array('Post.id', 'Post.title', 'Post.block_user_ids')), 'Category'=>array('fields'=>array('Category.id', 'Category.name')))));		
			$blockPostRequests = $this->Activity->find('all', array('conditions'=>$conditions, 'order'=>'Activity.created DESC'));
		}	
		
		// get new post requests (post_add)
		$conditions = array('Activity.type'=>'post_add');		
		$this->Activity->bindModel(array('belongsTo'=>array('User'=>array('fields'=>array('User.id', 'User.name', 'User.email')), 'Post'=>array('fields'=>array('Post.id', 'Post.title', 'Post.block_user_ids')))));		
		$tmpConditions = array();
		$tmpConditions[] = $conditions;
		$tmpConditions[] = array('Activity.created >='=>$fromActivityTime);	
		$newPostRequestsCount = $this->Activity->find('count', array('conditions'=>$tmpConditions, 'order'=>'Activity.created DESC'));
		if($type == 'NewPosts') {
			$this->Activity->bindModel(array('belongsTo'=>array('User'=>array('fields'=>array('User.id', 'User.name', 'User.email')), 'Post'=>array('fields'=>array('Post.id', 'Post.title', 'Post.block_user_ids', 'Post.description')), 'Category'=>array('fields'=>array('Category.id', 'Category.name')))));		
			$newPostRequests = $this->Activity->find('all', array('conditions'=>$conditions, 'order'=>'Activity.created DESC'));
		}	
			

		// update last activity visit time
		$data['User']['id'] = $this->Session->read('User.id');
		$data['User']['last_activity_visit'] = date('Y-m-d H:i:s');
		App::uses('User', 'Model');
		$this->User = new User;
		$this->User->save($data);
		$this->Session->write('User.last_activity_visit', $data['User']['last_activity_visit']);
		
		$this->set(compact('photoUploads', 'likePhotos', 'likeComments', 'blockPhotoRequests', 'blockCommentRequests', 'photoComments', 'photoUploadsCount', 'likePhotosCount', 'likeCommentsCount', 'blockPhotoRequestsCount', 'blockCommentRequestsCount', 'photoCommentsCount', 'type', 'blockPostRequestsCount', 'blockPostRequests', 'newPostRequestsCount', 'newPostRequests'));
	}	
	
	function admin_blockRequests($type='photos') {
		$blockPhotoRequests = array();
		$blockCommentRequests = array();
		
		if($type == 'photos') {
			// get block photo requests
			$conditions = array('Activity.type'=>'photo_block');
			$this->Activity->bindModel(array('belongsTo'=>array('User'=>array('fields'=>array('User.id', 'User.name', 'User.email')), 'Image'=>array('fields'=>array('Image.id', 'Image.block_user_ids')))));
			$blockPhotoRequests = $this->Activity->find('all', array('conditions'=>$conditions, 'order'=>'Activity.created DESC'));
		}
		
		if($type == 'comments') {
			// get block comment requests
			$conditions = array('Activity.type'=>'comment_block');		
			$this->Activity->bindModel(array('belongsTo'=>array('User'=>array('fields'=>array('User.id', 'User.name', 'User.email')), 'Comment'=>array('fields'=>array('Comment.id', 'Comment.name', 'Comment.block_user_ids')))));
			$blockCommentRequests = $this->Activity->find('all', array('conditions'=>$conditions, 'order'=>'Activity.created DESC'));
		}			
		$this->set(compact('blockPhotoRequests', 'blockCommentRequests', 'type'));
	}
}
?>