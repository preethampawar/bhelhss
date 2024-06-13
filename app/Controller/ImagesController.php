<?php
class ImagesController extends AppController
{
	var $name = 'Images';
	var $imgPath = 'img/images/';
	var $cachePath = 'img/cache/';

	function isPostSharingAllowed($postID) {
		App::uses('Post', 'Model');
		$this->Post = new Post;
		$conditions = array('Post.id'=>$postID, 'Post.allow_photo_sharing'=>'1', 'Post.active'=>'1');
		
		$postInfo = $this->Post->find('first', array('conditions'=>$conditions));
		
		return $postInfo;
	}
	
	function uploadImage($params)
	{
		if($this->isValidFile($params))
		{			
			return $this->saveFile($params);
		}
		return false;
	}
	
	function isValidFile($params)
	{		
		if ((isset($params['error']) && $params['error'] == 0) || (!empty( $params['tmp_name']) && $params['tmp_name'] != 'none')) 
		{
			return is_uploaded_file($params['tmp_name']);
		}
		return false;
	}
	
	function saveFile($params, $caption='')
	{		
		$image['Image']['caption'] = $caption;
		$image['Image']['type'] = $params['type'];
		$image['Image']['extension'] = $this->getFileExtension($params['name']);
		if($this->Image->save($image))
		{
			$imageInfo = $this->Image->read();
			$filename = $imageInfo['Image']['id'];
			if(move_uploaded_file($params['tmp_name'], $this->imgPath.$filename))
			{				
				return $filename;
			}
			else
			{
				$this->Image->delete($filename);
			}
		}
		return false;
	}
	
	function getFileExtension($filename)
	{
		return substr($filename, strrpos($filename, '.'));
	}
	
	function get($imageId, $resizeType)
	{
		if($imgPath = $this->resize($imageId, $resizeType))
		{
			if(file_exists($imgPath))
			{
				return $imgPath;
			}			
		}		
		return $_SERVER['HTTP_HOST'].'/img/noimage.jpg';
	}
	
	function showList() {
		
	}

	/**
	 * Function to show post photos 
	 */
	function showPostPhotoUploads($postID, $userID=null) {
	
		if(!$postInfo = $this->isPostSharingAllowed($postID)) {
			$this->Session->setFlash('Page not found', 'default', array('class'=>'error'));
			$this->redirect('/images/showList');
		}		
		
		$conditions = array();
		
		$year = null;
		$month = null;
		if($this->request->isPost()) {
			$data = $this->request->data;
			$year = $data['Image']['year']['year'];	
			$month = $data['Image']['month']['month'];	
			$batch = $data['Image']['batch']['year'];	
			
			if($batch) {
				$conditions[] = array('Image.batch'=>$batch);
			}			
		}
		
		if($userID) {
			$conditions[] = array('Image.uploaded_by'=>$userID);
		}
		
		if($year) {
			$startDate = $year.'-01-01';
			$endDate = $year.'-12-31 24:00:00';
			$conditions[] = array('Image.created >='=>$startDate, 'Image.created <='=>$endDate);
		}
		
		if($month) {
			$startDate = $year.'-'.$month.'-01';
			$endDate = $year.'-'.$month.'-31 24:00:00';
			$conditions[] = array('Image.created >='=>$startDate, 'Image.created <='=>$endDate);
		}
		$conditions[] = array('Image.shared_photo'=>'1', 'Image.post_id'=>$postID);
 		
		$this->paginate = array(
				'limit' => 50,
				// 'order' => array('Image.class' => 'ASC', 'Image.section' => 'ASC', 'Image.created' => 'DESC'),
				'order' => array('Image.created'=>'DESC'),
				'conditions' => $conditions,
				'fields'=>array('Image.id', 'Image.caption', 'Image.uploaded_by', 'Image.batch', 'Image.class', 'Image.section', 'Image.created', 'Image.modified', 'Image.likes_user_ids', 'Image.likes_update_time', 'Image.block_user_ids', 'Image.block_update_time', 'User.id', 'User.email', 'User.name', 'User.batch', 'User.class', 'User.section', 'Post.id', 'Post.title', 'Post.category_id'
							)
			);				
		$this->Image->bindModel(array('belongsTo'=>array('User'=>array('foreignKey'=>'uploaded_by'), 'Post'), 'hasMany'=>array('Comment'=>array('fields'=>'Comment.id'))));
		$postImages = $this->paginate();
		
		$this->set(compact('postImages', 'postInfo', 'userID'));
	}

	/**
	 * function to upload post photos
	 */
	function uploadPostPhoto($postID) {		
		if(!$postInfo = $this->isPostSharingAllowed($postID)) {
			$this->Session->setFlash('Page not found', 'default', array('class'=>'error'));
			$this->redirect('/images/showList');
		}	
					
		$errorMsg = null;
		$userID = $this->Session->read('User.id');
		
		if($this->request->isPost()) {
			$data = $this->request->data;
			$uploadStatus = $this->validateAndUploadImage($data);
			
			if(!$uploadStatus['errorMsg']) {
				$imageID = $uploadStatus['imageID'];
				$tmp['Image']['id'] = $imageID;
				$tmp['Image']['post_id'] = $postID;
				$tmp['Image']['shared_photo'] = '1';
				
				$tmp['Image']['batch'] = $data['Image']['batch'];
				$tmp['Image']['class'] = $data['Image']['class'];
				$tmp['Image']['section'] = $data['Image']['section'];
				
					
				if($this->Image->save($tmp)) {
					$imageInfo = $this->Image->read();
					
					$tmp['Activity']['type'] = 'photo_upload';
					$tmp['Activity']['title'] = 'Post photo added';
					$tmp['Activity']['image_id'] = $imageID;
					$tmp['Activity']['post_id'] = $postID;
					$tmp['Activity']['url'] = '/images/showPostPhoto/'.$imageID;
					$this->saveActivity($tmp);
				

					$messageType = 'notification';
					$subject = 'New photo added in "'.$postInfo['Post']['title'].'" section';
					$message = '
'.$this->Session->read('User.name').' has added a photo in "'.$postInfo['Post']['title'].' section".

For more details visit:
http://www.bhelhss.com/images/showPostPhoto/'.$imageID.'

Unsubscribe from the mailing list:
http://www.bhelhss.com/users/subscribe


-
bhelhss.com
support@bhelhss.com

This message is for notification purpose only and is auto generated. Please do not reply. 		

';
					
					
					try {					
						$this->sendBulkEmail($messageType, $subject, $message);
					}
					catch(Exception $e) {
					
					}					
					
					
					
					
					$this->Session->setFlash('Photo Uploaded Successfully.', 'default', array('class'=>'success'));
				}
				else {
					$this->deleteImage($imageID);
					$this->Session->setFlash('An error occured while communicating with the server.', 'default', array('class'=>'error'));
				}
				
			}
			else {
				$this->Session->setFlash($uploadStatus['errorMsg'], 'default', array('class'=>'error'));
			}
		}
		
		$this->redirect($this->request->referer());
	} 
	
		
	/**
	 * show post photo
	 */
	
	function showPostPhoto($imageID) {
		$this->Image->bindModel(array('belongsTo'=>array('User'=>array('foreignKey'=>'uploaded_by'), 'Post'), 'hasMany'=>array('Comment'=>array('fields'=>'Comment.id'))));
		if(!$postPhotoInfo = $this->Image->findById($imageID)) {		
			$this->Session->setFlash('Photo not found', 'default', array('class'=>'error'));
			$this->redirect('/');
		}
		
		// Set photo views
		$data['Image']['id'] = $postPhotoInfo['Image']['id'];
		$data['Image']['views'] = $postPhotoInfo['Image']['views']+1;
		$this->Image->save($data);
		
		$this->set(compact('postPhotoInfo'));
	}
	 
	/**
	 * Like photo
	 */
	function likePhoto($photoID) {
		
		$this->Image->recursive = -1;
		
		if($imageInfo = $this->Image->findById($photoID)) {			
			$currentUserID = $this->Session->read('User.id');
			$userIDs = $imageInfo['Image']['likes_user_ids'];
			if(empty($userIDs)) {
				$data = array();
				$data['Image']['id'] = $photoID;
				$data['Image']['likes_user_ids'] = $currentUserID;				
				$data['Image']['likes_update_time'] = date('Y-m-d h:i:s');				
			}
			else {
				$data = array();
				$userIDs = explode(',', $userIDs);
				if(in_array($currentUserID, $userIDs)) {
					foreach($userIDs as $index=>$userid) {
						if($userid == $currentUserID) {
							unset($userIDs[$index]);
							break;
						}
					}					
				}
				else {
					$userIDs[] = $currentUserID;
					$data['Image']['likes_update_time'] = date('Y-m-d h:i:s');	
				}
				$userIDs = implode(',', $userIDs);
				
				$data['Image']['id'] = $photoID;
				$data['Image']['likes_user_ids'] = $userIDs;
			}
			
			if(!empty($data)) {
				$this->Image->save($data);
				$this->Image->recursive = -1;
				$imageInfo = $this->Image->read();					
				
				$tmp = array();
				$tmp['Activity']['type'] = 'photo_like';
				$tmp['Activity']['title'] = 'Photo Like';
				$tmp['Activity']['image_id'] = $photoID;				
				$tmp['Activity']['post_id'] = $imageInfo['Image']['post_id'];				
				$tmp['Activity']['url'] = '/images/showPostPhoto/'.$photoID;
				$this->saveActivity($tmp);		
			}			
		}
		$this->set(compact('imageInfo'));
	}

	
	/**
	 * Block post photo
	 */
	function blockPhoto($imageID) {
		
		$this->Image->recursive = -1;
		
		if($photoInfo = $this->Image->findById($imageID)) {			
			$currentUserID = $this->Session->read('User.id');
			$userIDs = $photoInfo['Image']['block_user_ids'];
			
			if(empty($userIDs)) {
				$data = array();
				$data['Image']['id'] = $imageID;
				$data['Image']['block_user_ids'] = $currentUserID;				
				$data['Image']['block_update_time'] = date('Y-m-d h:i:s');				
			}
			else {
				$data = array();
				$userIDs = explode(',', $userIDs);
				if(in_array($currentUserID, $userIDs)) {
					foreach($userIDs as $index=>$userid) {
						if($userid == $currentUserID) {
							unset($userIDs[$index]);
							break;
						}
					}					
				}
				else {
					$userIDs[] = $currentUserID;
					$data['Image']['block_update_time'] = date('Y-m-d h:i:s');	
				}
				$userIDs = implode(',', $userIDs);
				
				$data['Image']['id'] = $imageID;
				$data['Image']['block_user_ids'] = $userIDs;
			}
			
			if(!empty($data)) {
				$this->Image->save($data);
				
				$this->Image->bindModel(array('belongsTo'=>array('User'=>array('foreignKey'=>'uploaded_by'), 'Post'), 'hasMany'=>array('Comment'=>array('fields'=>'Comment.id'))));
				$imageInfo = $this->Image->read();		
				
				$blockUserIDs = explode(',', $imageInfo['Image']['block_user_ids']);
				$countVotes = count($blockUserIDs);
				$requiredBlockVotes = Configure::read('PhotoBlockVotes');
				if($countVotes >= $requiredBlockVotes) {
					$this->removePhoto($imageID);
					$imageInfo = array();
				}	
				else {
					$tmp = array();
					$tmp['Activity']['type'] = 'photo_block';
					$tmp['Activity']['title'] = 'Block Photo Request';
					$tmp['Activity']['image_id'] = $imageID;
					$tmp['Activity']['post_id'] = $photoInfo['Image']['post_id'];
					$tmp['Activity']['url'] = '/images/showPostPhoto/'.$photoInfo['Image']['id'];
					$this->saveActivity($tmp);
				}	
			}			
		}
		$this->set(compact('imageInfo'));
	}
	
	/**
	 * Delete post photo
	 */
	function deletePhoto($imageID) {
			
		if($imageInfo = $this->Image->findById($imageID)) {
			if(($imageInfo['Image']['uploaded_by'] == $this->Session->read('User.id'))  or $this->Session->read('User.admin')) {
				$this->removePhoto($imageID);
			}
		}
		
		$this->Image->bindModel(array('belongsTo'=>array('User'=>array('foreignKey'=>'uploaded_by'), 'Post'), 'hasMany'=>array('Comment'=>array('fields'=>'Comment.id'))));
		$imageInfo = $this->Image->findById($imageID);
		$this->set(compact('imageInfo'));
	}
	
	/**
	 * function to remove post photo
	 */
	function removePhoto($imageID) {		
		if($imageInfo = $this->Image->findById($imageID)) {			
			$imageID = $imageInfo['Image']['id'];
			try {
				// remove image
				$this->deleteImage($imageID);							
			}			
			catch(Exception $e) {
				
			}
		}
		return true;		
	}
	

	function admin_managePostImages($postID, $categoryID) {
		App::uses('Post', 'Model');
		$this->Post = new Post;
		
		// check if post belongs to the selected site
		if(!$postInfo = $this->Post->findById($postID)) {
			$this->Session->setFlash('Post Not Found', 'default', array('class'=>'error'));
			if(!empty($categoryID)) {
				$this->redirect('/admin/posts/showPosts/'.$categoryID);			
			}
			else {
				$this->redirect('/admin/posts/');
			}
		}
		
		$errorMsg = null;
		$successMsg = null;
		if($this->request->isPost()) {			
			$data = $this->request->data;
			if(!empty($data['Image']['file']['name'])) {
				$results = $this->admin_uploadImage($data);
				
				if($results['errorMsg']) {
					$errorMsg = $results['errorMsg'];					
				}
				else {
					$imageID = $results['imageID'];
					$tmp['Image']['id'] = $imageID;
					$tmp['Image']['post_id'] = $postID;
					$tmp['Image']['caption'] = $data['Image']['caption'];
					$tmp['Image']['uploaded_by'] = $this->Session->read('User.id');
					if($this->Image->save($tmp)) {
						$successMsg = 'Image uploaded successfully';
					}
					else {
						$errorMsg = 'An error occured while communicating with the server';
					}
				}	
			}
		}
		
		$postImages = $this->Image->findAllByPostId($postID);		
		$this->set(compact('postInfo', 'successMsg', 'errorMsg', 'postImages', 'categoryID'));
	}
	
	function managePostImages($postID, $categoryID) {
		App::uses('Post', 'Model');
		$this->Post = new Post;
		
		// check if post belongs to the selected site
		if(!$postInfo = $this->Post->findById($postID)) {
			$this->Session->setFlash('Post Not Found', 'default', array('class'=>'error'));
			if(!empty($categoryID)) {
				$this->redirect('/posts/showPosts/'.$categoryID);			
			}
			else {
				$this->redirect('/');
			}
		}
		
		$errorMsg = null;
		$successMsg = null;
		if($this->request->isPost()) {			
			$data = $this->request->data;
			if(!empty($data['Image']['file']['name'])) {
				$results = $this->admin_uploadImage($data);
				
				if($results['errorMsg']) {
					$errorMsg = $results['errorMsg'];					
				}
				else {
					$imageID = $results['imageID'];
					$tmp['Image']['id'] = $imageID;
					$tmp['Image']['post_id'] = $postID;
					$tmp['Image']['caption'] = $data['Image']['caption'];
					$tmp['Image']['uploaded_by'] = $this->Session->read('User.id');
					if($this->Image->save($tmp)) {
						$successMsg = 'Image uploaded successfully';
					}
					else {
						$errorMsg = 'An error occured while communicating with the server';
					}
				}	
			}
		}
		
		$postImages = $this->Image->findAllByPostId($postID);		
		$this->set(compact('postInfo', 'successMsg', 'errorMsg', 'postImages', 'categoryID'));
	}
	
	function validateAndUploadImage($data) {
		$status = array();
		$imageID = null;
		$errorMsg = null;
		$uploadedBy = $this->Session->read('User.id');
		$imageCaption = (isset($data['Image']['caption'])) ? $data['Image']['caption'] : null;
		
		// upload image
		if(isset($data['Image']['file']['name']) and !empty($data['Image']['file']['name']))
		{
			if(!$this->isValidImageSize($data['Image']['file']['size'])) {	
				$errorMsg =  'Image size exceeded '.Configure::read('MaxImageSize').'Mb limit';
			}
			elseif(!$this->isValidImage($data['Image']['file'])) {
				$errorMsg = 'Not a valid image';
			}
			else {					
				$imageID = $this->uploadImage($data['Image']['file']);										
				$tmp['Image']['id'] = $imageID;
				$tmp['Image']['uploaded_by'] = $uploadedBy;
				$tmp['Image']['caption'] = htmlentities($imageCaption);
				App::uses('Image', 'Model');
				$this->Image = new Image;
				if(!$this->Image->save($tmp))
				{
					$Images->delete($imageID);
					$errorMsg = 'Image could not be uploaded';
				}				
			}
		}
		else
		{
			$errorMsg = 'Select an Image to upload';
		}
		
		$status['errorMsg'] = $errorMsg;
		$status['imageID'] = $imageID;
		return $status;
	}
	
	function admin_uploadImage($data) {
		$status = array();
		$imageID = null;
		$errorMsg = null;
		
		// upload image
		if(!empty($data['Image']['file']['name']))
		{
			if(!$this->isValidImageSize($data['Image']['file']['size'])) {	
				$errorMsg =  'Image size exceeded '.Configure::read('MaxImageSize').'Mb limit';
			}
			elseif(!$this->isValidImage($data['Image']['file'])) {
				$errorMsg = 'Not a valid image';
			}
			else {					
				$imageID = $this->uploadImage($data['Image']['file']);										
				$tmp['Image']['id'] = $imageID;
				App::uses('Image', 'Model');
				$this->Image = new Image;
				if(!$this->Image->save($tmp))
				{
					$Images->delete($imageID);
					$errorMsg = 'Image could not be uploaded';
				}				
			}
		}
		else
		{
			$errorMsg = 'Select an Image to upload';
		}
		
		$status['errorMsg'] = $errorMsg;
		$status['imageID'] = $imageID;
		return $status;
	}
	
	function admin_deleteImage($imageID) {
		$image = $this->Image->findById($imageID);
		if($image) {
			$this->deleteImage($imageID);
			$this->Session->setFlash('Image Deleted Successfully', 'default', array('class'=>'success'));			
		}
		else {
			$this->Session->setFlash('Image Not Found', 'default', array('class'=>'error'));						
		}
		$this->redirect($this->request->referer());		
	}
	
	function deletePostImage($imageID) {
		$image = $this->Image->findById($imageID);
		if($image) {
			$this->deleteImage($imageID);
			$this->Session->setFlash('Image Deleted Successfully', 'default', array('class'=>'success'));			
		}
		else {
			$this->Session->setFlash('Image Not Found', 'default', array('class'=>'error'));						
		}
		$this->redirect($this->request->referer());		
	}
	
}
?>