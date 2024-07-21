<?php
App::uses('CakeEmail', 'Network/Email');
class BlogController extends AppController {
	var $name = 'Blog';

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('posts_show_all', 'posts_show');
	}

	public function posts_show_all() {
		$categoryID = Configure::read('CategoryBlogID');
		$conditions = array('Blog.category_id'=>$categoryID);
		$blogs = $this->Blog->find('all', array('conditions'=>$conditions));

		$this->paginate = array(
				'limit' => 50,
				'order' => array('Blog.created'=>'DESC'),
				'conditions' => $conditions
				);
		$blogs = $this->paginate();

		$this->set('blogs', $blogs);
	}

	public function posts_show($blogID) {

		if(!$blogInfo = $this->Blog->findById($blogID)) {
			$this->Session->setFlash('Page not found', 'default', array('class'=>'error'));
			$this->redirect('/blog/posts_show_all');
		}

		// Set post views
		$data['Blog']['id'] = $blogInfo['Blog']['id'];
		$data['Blog']['views'] = $blogInfo['Blog']['views']+1;
		$this->Blog->save($data);

		$this->set(compact('blogInfo'));
	}

	/**
	 * Function to create a post by user
	 */
	public function posts_create() {
		$categoryID = Configure::read('CategoryBlogID');

		$errorMsg = array();

		if($this->request->isPost()) {
			$data = $this->request->data;

			// Validate name
			if(Validation::blank($data['Blog']['title'])) {
				$errorMsg[] = 'Enter Title';
			}

			// Sanitize data
			$data['Blog']['title'] = Sanitize::paranoid($data['Blog']['title'], array(' ','-','!',',','.', '(',')'));
			$data['Blog']['category_id'] = $categoryID;
			$data['Blog']['user_id'] = $this->Session->read('User.id');

			if(!$errorMsg) {
				$conditions = array('Blog.title'=>$data['Blog']['title']);
				if($this->Blog->find('first', array('conditions'=>$conditions))) {
					$errorMsg[] = 'Post with title "'.$data['Blog']['title'].'" already exists';
				}
				else {
					if($this->Blog->save($data)) {
						$blogInfo = $this->Blog->read();

						$tmp['Activity']['type'] = 'post_add';
						$tmp['Activity']['title'] = $blogInfo['Blog']['title'];
						$tmp['Activity']['post_id'] = $blogInfo['Blog']['id'];
						$tmp['Activity']['category_id'] = $categoryID;
						$tmp['Activity']['url'] = '/blog/posts_show/'.$blogInfo['Blog']['id'].'/'.Inflector::slug($blogInfo['Blog']['title'], '-');
						$this->saveActivity($tmp);

						// Notify all users
						$messageType = 'notification';
						$subject = 'New post has been added titled "'.$blogInfo['Blog']['title'].'"';
						$message = '
'.$this->Session->read('User.name').' has added a new post titled "'.$blogInfo['Blog']['title'].'" in "Blog" section.

For more details visit:
http://www.bhelhss.com'.$tmp['Activity']['url'].'

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

						$this->Session->setFlash('Post successfully added', 'default', array('class'=>'success'));
						$this->redirect('/blog/posts_show_all');
					}
					else {
						$errorMsg[] = 'An error occurred while communicating with the server';
					}
				}
			}
		}

		$errorMsg = implode('<br>', $errorMsg);
		$this->set(compact('errorMsg'));
	}

	/**
	 * Function to edit a post
	 */
	public function posts_edit($blogID) {
		$categoryID = Configure::read('CategoryBlogID');

		if(!$blogInfo = $this->Blog->findById($blogID)) {
			$this->Session->setFlash('Page not found', 'default', array('class'=>'error'));
			$this->redirect('/blog/posts_show_all');
		}
		else {
			if(!$this->isModerator()) {
				if($this->Session->read('User.id') != $blogInfo['Blog']['user_id']) {
					$this->Session->setFlash('You are not authorized to edit this post.', 'default', array('class'=>'error'));
					$this->redirect('/blog/posts_show_all');
				}
			}
		}

		$errorMsg = array();
		if($this->request->isPut()) {
			$data = $this->request->data;

			// Validate name
			if(Validation::blank($data['Blog']['title'])) {
				$errorMsg[] = 'Enter Title';
			}

			// Sanitize data
			$data['Blog']['title'] = Sanitize::paranoid($data['Blog']['title'], array(' ','-','!',',','.', '(',')'));
			$data['Blog']['category_id'] = $categoryID;
			$data['Blog']['id'] = $blogID;

			if(!$errorMsg) {
				$conditions = array('Blog.title'=>$data['Blog']['title'], 'Blog.id NOT'=>$blogID);
				if($this->Blog->find('first', array('conditions'=>$conditions))) {
					$errorMsg[] = 'Post with title "'.$data['Blog']['title'].'" already exists';
				}
				else {
					if($this->Blog->save($data)) {
						$blogInfo = $this->Blog->read();
						$this->Session->setFlash('Post successfully added', 'default', array('class'=>'success'));
						$this->redirect('/blog/posts_show/'.$blogID.'/'.Inflector::slug($blogInfo['Blog']['title']));
					}
					else {
						$errorMsg[] = 'An error occurred while communicating with the server';
					}
				}
			}
		}
		else {
			$this->data = $blogInfo;
		}

		$errorMsg = implode('<br>', $errorMsg);
		$this->set(compact('errorMsg', 'blogInfo'));
	}

	/**
	 * Function to delete a post
	 */
	public function posts_delete($blogID) {
		$categoryID = Configure::read('CategoryBlogID');

		if(!$blogInfo = $this->Blog->findById($blogID)) {
			$this->Session->setFlash('Page not found', 'default', array('class'=>'error'));
			$this->redirect('/blog/posts_show_all');
		}
		else {
			if(!$this->isModerator()) {
				if($this->Session->read('User.id') != $blogInfo['Blog']['user_id']) {
					$this->Session->setFlash('You are not authorized to delete this post.', 'default', array('class'=>'error'));
					$this->redirect('/blog/posts_show_all');
				}
			}
		}

		$this->deletePost($blogID, $categoryID);
		$this->Session->setFlash('Post deleted successfully', 'default', array('class'=>'success'));
		$this->redirect('/blog/posts_show_all');

	}

	public function block_post($blogID) {
		$categoryID = Configure::read('CategoryBlogID');

		if(!$blogInfo = $this->Blog->findById($blogID)) {
			$this->Session->setFlash('Page not found', 'default', array('class'=>'error'));
			$this->redirect('/blog/posts_show_all');
		}
		$blockUserIDs = $blogInfo['Blog']['block_user_ids'];
		$currentUserID = $this->Session->read('User.id');
		$data = array();

		$blockPost =false;
		if(!empty($blockUserIDs)) {
			$userIDsArray = explode(',',$blockUserIDs);
			if(!in_array($currentUserID, $userIDsArray)) {
				$userIDsArray[] = $currentUserID;
				$blockPost = true;
				$data['Blog']['id'] = $blogID;
				$data['Blog']['block_user_ids'] = implode(',', $userIDsArray);
				$this->Blog->save($data);
			}
		}
		else {
			$blockPost = true;
			$data['Blog']['id'] = $blogID;
			$data['Blog']['block_user_ids'] = $currentUserID;
			$this->Blog->save($data);
		}

		if($blockPost) {
			$tmp['Activity']['type'] = 'post_block';
			$tmp['Activity']['title'] = $blogInfo['Blog']['title'];
			$tmp['Activity']['post_id'] = $blogInfo['Blog']['id'];
			$tmp['Activity']['category_id'] = $categoryID;
			$tmp['Activity']['url'] = '/blog/posts_show/'.$blogInfo['Blog']['id'].'/'.Inflector::slug($blogInfo['Blog']['title'], '-');
			$this->saveActivity($tmp);

			// Notify all users
			$messageType = 'notification';
			$subject = 'Request to block post: "'.$blogInfo['Blog']['title'].'"';
			$message = '
'.$this->Session->read('User.name').' has requested to block a post titled "'.$blogInfo['Blog']['title'].'" in "Blog" section.

For more details visit:
http://www.bhelhss.com'.$tmp['Activity']['url'].'

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

		}

		// if block votes reach max limit then remove the post.
		$blockCount = Configure::read('PostBlockVotes');

		$this->Blog->recursive = -1;
		$blogInfo = $this->Blog->findById($blogID);
		$blockUserIDs = $blogInfo['Blog']['block_user_ids'];
		if(!empty($blockUserIDs)) {
			$userIDsArray = explode(',',$blockUserIDs);
			$currentBlockCount = count($userIDsArray);

			if($currentBlockCount >= $blockCount) {
				// remove post
				$this->deletePost($blogID, $categoryID);
				$this->Session->setFlash('Post has been removed.', 'default', array('class'=>'success'));
				$this->redirect('/blog/posts_show_all/');
			}
		}
		$this->Session->setFlash('Your vote has been counted.', 'default', array('class'=>'success'));
		$this->redirect('/blog/posts_show/'.$blogID.'/'.Inflector::slug($blogInfo['Blog']['title']));
	}

}
?>
