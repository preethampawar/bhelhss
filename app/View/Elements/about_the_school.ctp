<?php
App::uses('Post', 'Model');
$this->Post = new Post;

$conditions = array('Post.id'=>'9');
$post = $this->Post->find('first', array('conditions'=>$conditions, 'recursive'=>'1', 'limit'=>'6', 'order'=>'Post.created DESC'));

App::uses('Image', 'Model');
$this->Image = new Image;	

$categoryID = '6';
$categoryName = $post['Category']['name'];
$categoryNameSlug = Inflector::slug($categoryName, '-');	

$postID = $post['Post']['id'];
$postTitle = $post['Post']['title'];
$postTitleSlug = Inflector::slug($postTitle, '-');
$postDesc = $post['Post']['description'];				

$descLength = strlen($postDesc);
if($descLength > 900) {
	$desc = substr($postDesc, 0, 835);
	$desc.='... <br><p style="text-align:right;">'.$this->Html->link('Read more...', '/posts/show/'.$categoryID.'/'.$postID.'/'.$categoryNameSlug.'/'.$postTitleSlug, array('title'=>$postTitle, 'escape'=>false)).'</p>';
	$postDesc = $desc;							
}			

$imageID = null;
$imageConditions = array('Image.post_id'=>$postID);
$postImage = $this->Image->find('first', array('conditions'=>$imageConditions, 'order'=>'Image.created desc', 'limit'=>'1'));
if(!empty($postImage)) {				
	$imageID = $postImage['Image']['id'];						
}
?>
<h1><?php echo $postTitle;?></h1>

<a href="<?php echo $this->Html->url('/posts/show/6/9/BHEL-Higher-Secondary-School/About-the-School');?>" style="border:0px;" title="About BHEL Higher Secondary School">
	<?php echo $this->Html->image('hss_banner.jpg', array('alt'=>'About BHEL Higher Secondary School', 'style'=>'width:100%;'));?> 
</a>
<br>
<?php echo $postDesc;?>
