<div>
<h2>Categories</h2>
<?php
$categories = $this->requestAction(array('controller'=>'categories', 'action'=>'getCategories', 'admin'=>true));
if(!empty($categories)) {
?>
<div><?php echo $this->Html->Link('+ Add New Category', '/admin/categories/add');?></div>
<br>
<div id='adminCategoryNavigation' style="width:400px;">

		<?php
		$k=0;
		foreach($categories as $row) {
			$k++;
			$categoryID = $row['Category']['id'];
			$categoryName = Inflector::humanize($row['Category']['name']);
			$tmp = substr($categoryName, 0, 25);
			$categoryDisplayName = (strlen($categoryName) > 28) ? $tmp.'...' : $categoryName;
			$categoryNameSlug = Inflector::slug($categoryName, '-');
		?>

				<?php echo $k.'. '.$this->Html->link($categoryName, '/admin/posts/showPosts/'.$categoryID.'/'.$categoryNameSlug, array('title'=>$categoryName, 'style'=>'width:350px; overflow:hidden;', 'escape'=>false));?>
				<div class='floatRight' style=''>
					<?php //echo $this->Html->link('Edit', '/admin/categories/edit/'.$categoryID, array('style'=>'color:orange;'));?>

					<?php //echo $this->Html->link($this->Html->image('error.png', array('alt'=>'active', 'title'=>'Click to remove this category')), '/admin/categories/delete/'.$categoryID, array('escape'=>false, 'style'=>'color:red;'), 'Deleting this category will delete all the category information and products associated with it. This action is irreversable. Are you sure you want to delete this category?');?>
				</div>
				<div class='clear'></div>
				<br>

		<?php
		}
		?>

</div>
<?php
}
else {
	echo '<p>No Category Found</p>';
}
?>
</div>
