<?php
class CommentsController extends AppController {

	var $name = 'Comments';

	function isImage($imageID) {
		App::uses('Image', 'Model');
		$this->Image = new Image;
		$this->Image->recursive = '-1';
		if($imageInfo = $this->Image->findById($imageID)) {
			return $imageInfo;
		}
		return false;
	}

	function addPhotoComment($encodedImageID) {
		$imageID = base64_decode($encodedImageID);
		$errorMsg = null;
		$successMsg = null;
		$comments = array();

		if(!$imageInfo = $this->isImage($imageID)) {
			$errorMsg = 'Photo has been removed';
		}
		else {
			if($this->request->isPost()) {
				$data['Comment']['name'] = $this->request->data['name'];

				if(Validation::blank(trim($data['Comment']['name']))) {
					$errorMsg = 'Enter some text';
				}
				else {
					$data['Comment']['name'] = htmlentities($data['Comment']['name']);
					$data['Comment']['user_id'] = $this->Session->read('User.id');
					$data['Comment']['image_id'] = $imageID;
					$data['Comment']['id'] = null;
					if($this->Comment->save($data)) {
						$successMsg = 'Comment Successfully Added';
						$commentInfo = $this->Comment->read();

						$tmp = array();
						$tmp['Activity']['type'] = 'photo_comment';
						$tmp['Activity']['title'] = 'Comment added';
						$tmp['Activity']['image_id'] = $imageID;
						$tmp['Activity']['comment_id'] = $commentInfo['Comment']['id'];
						$tmp['Activity']['url'] = '/images/showPostPhoto/'.$imageID;
						$this->saveActivity($tmp);
					}
					else {
						$errorMsg = 'An error occurred while communicating with the server. Please try again.';
					}
				}
			}

			$conditions = array('Comment.image_id'=>$imageID);
			$comments = $this->Comment->find('all', array('conditions'=>$conditions, 'order'=>array('Comment.created DESC'), 'limit'=>'200'));
		}

		$this->set(compact('errorMsg', 'successMsg', 'comments', 'imageID', 'encodedImageID'));
		if($this->request->isAjax()) {
			$this->layout = 'ajax';
		}
	}

	function likeComment($commentID) {
		$this->Comment->recursive = -1;

		if($commentInfo = $this->Comment->findById($commentID)) {
			$currentUserID = $this->Session->read('User.id');
			$userIDs = $commentInfo['Comment']['likes_user_ids'];
			if(empty($userIDs)) {
				$data = array();
				$data['Comment']['id'] = $commentID;
				$data['Comment']['likes_user_ids'] = $currentUserID;
				$data['Comment']['likes_update_time'] = date('Y-m-d h:i:s');
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
					$data['Comment']['likes_update_time'] = date('Y-m-d h:i:s');
				}
				$userIDs = implode(',', $userIDs);

				$data['Comment']['id'] = $commentID;
				$data['Comment']['likes_user_ids'] = $userIDs;
			}

			if(!empty($data)) {
				$this->Comment->save($data);
				$this->Comment->recursive = -1;
				$commentInfo = $this->Comment->read();

				$tmp = array();
				$tmp['Activity']['comment_id'] = $commentID;

				$tmp['Activity']['url'] = '/images/showPostPhoto/'.$commentInfo['Comment']['image_id'];
				$tmp['Activity']['image_id'] = $commentInfo['Comment']['image_id'];
				$tmp['Activity']['post_id'] = $commentInfo['Comment']['post_id'];

				$tmp['Activity']['type'] = 'comment_like';
				$tmp['Activity']['title'] = 'Liked Comment';
				$this->saveActivity($tmp);

			}
		}
		$this->set(compact('commentInfo'));
	}

	function blockComment($commentID) {
		$this->Comment->recursive = -1;

		if($commentInfo = $this->Comment->findById($commentID)) {
			$currentUserID = $this->Session->read('User.id');
			$userIDs = $commentInfo['Comment']['block_user_ids'];

			if(empty($userIDs)) {
				$data = array();
				$data['Comment']['id'] = $commentID;
				$data['Comment']['block_user_ids'] = $currentUserID;
				$data['Comment']['block_update_time'] = date('Y-m-d h:i:s');
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
					$data['Comment']['block_update_time'] = date('Y-m-d h:i:s');
				}
				$userIDs = implode(',', $userIDs);

				$data['Comment']['id'] = $commentID;
				$data['Comment']['block_user_ids'] = $userIDs;
			}

			if(!empty($data)) {
				$this->Comment->save($data);
				$this->Comment->recursive = -1;
				$commentInfo = $this->Comment->read();

				$blockUserIDs = explode(',', $commentInfo['Comment']['block_user_ids']);
				$countVotes = count($blockUserIDs);
				$requiredBlockVotes = Configure::read('CommentBlockVotes');
				if($countVotes >= $requiredBlockVotes) {
					$this->removeComment($commentID);
					$commentInfo = array();
				}
				else {
					$tmp = array();
					$tmp['Activity']['comment_id'] = $commentID;

					$tmp['Activity']['url'] = '/images/showPostPhoto/'.$commentInfo['Comment']['image_id'];
					$tmp['Activity']['image_id'] = $commentInfo['Comment']['image_id'];

					$tmp['Activity']['type'] = 'comment_block';
					$tmp['Activity']['title'] = 'Comment blocked';
					$this->saveActivity($tmp);
				}
			}
		}
		$this->set(compact('commentInfo'));
	}

	function removeComment($commentID) {
		$this->Comment->delete($commentID);

		if(!empty($commentID)) {
			$conditions = array('Activity.comment_id'=>$commentID);
			$this->deleteActivity($conditions);
		}

		return true;
	}


	function removePhotoComment($photoID, $commentID) {
		$encodedPhotoID = base64_encode($photoID);
		if($this->request->isAjax()) {
			$this->layout = 'ajax';
		}
		if($this->request->isPost()) {
			$this->Comment->recursive = -1;
			if($commentInfo = $this->Comment->findById($commentID)) {
				if($commentInfo['Comment']['user_id'] == $this->Session->read('User.id')) {
					$this->removeComment($commentID);
				}
			}
		}
		$this->redirect('/comments/addPhotoComment/'.$encodedPhotoID);
	}

	function listPhotoComments($encodedImageID) {
		$imageID = base64_decode($encodedImageID);
		$errorMsg = null;
		$successMsg = null;
		$comments = array();

		if(!$imageInfo = $this->isImage($imageID)) {
			$errorMsg = 'Photo not found';
		}
		else {
			$conditions = array('Comment.image_id'=>$imageID);
			$comments = $this->Comment->find('all', array('conditions'=>$conditions, 'order'=>array('Comment.created DESC'), 'limit'=>'100'));
		}

		$this->set(compact('errorMsg', 'successMsg', 'comments', 'imageID', 'encodedImageID'));
		if($this->request->isAjax()) {
			$this->layout = 'ajax';
		}
	}

}
?>
