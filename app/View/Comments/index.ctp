<?php
$inventory = false;
$visibility = false;
$showSP = false;
$showCP = false;

if($this->Session->check('UserCompany')) {	
	switch($this->Session->read('Company.business_type')) {
		case 'personal':			
			break;			
		case 'general':
			$visibility = true;
			break;			
		case 'inventory':
			$inventory = true;
			$visibility = true;
			break;	
		case 'wineshop':
			$inventory = true;
			$visibility = true;
			$showCP = true;
			$showSP = true;
			break;			
		case 'finance':
			break;		
		case 'default':
			break;
	}	
}
?>

<div style="width:950px;">
	<div class="floatLeft">
		<h1>Categories</h1>
	</div>
	<?php echo $this->Html->link('+ Create New Category', array('controller'=>'categories', 'action'=>'add'), array('class'=>'button grey medium floatRight'));?>
	<div class="clear"></div>
	<br>
	<?php //echo $this->Html->link('Reorder All Categories', '/categories/reorder', array('style'=>'float:right;', 'class'=>'button green small'), 'Reordering may take sometime. Please be patient and do not press cancel or back button while the request is in process.');?>	
	<?php
	if(!empty($categories)) {
	?>
	<table cellspacing='1' cellpadding='1'>
		<thead>
			<tr>
				<th>Category Name</th>				
				<?php echo ($showCP) ? "<th width='100'>CP (".$this->Session->read('Company.currency').")</th>" : null;?>			
				<?php echo ($showSP) ? "<th width='100'>SP (".$this->Session->read('Company.currency').")</th>" : null;?>			
				<?php echo ($inventory) ? "<th width='80'>Inventory</th>" : null ;?>				
				<?php echo ($visibility) ? "<th width='180'>Visibility</th>" : null;?>			
				<th width="160">Actions</th>	
			</tr>
		</thead>
		<tbody>
			<?php
			foreach($categories as $id=>$name)
			{
				$categoryName = explode('####', $name);
				$spaceCount = count($categoryName)-1;
				$categoryName = ucwords($categoryName[$spaceCount]);
				$space=null;
				if($spaceCount) {
					$style = $this->Html->image('sub_arrow1.gif').'&nbsp;';
					for($i=0; $i<$spaceCount; $i++) {
						$space.='&nbsp;&nbsp;&nbsp;&nbsp;';
					}
				}
				else {
					$style = '';
				}
				$viewin = '-';		
				$hasInventory = '-';
				$isProduct = false;
				$topLevelCategory = false;
				$spPrice = null;
				$cpPrice = null;
				foreach($allCategories as $cat) { 
					if($cat['Category']['id'] == $id) {
						$visibility1 = array();	
						$topLevelCategory = ($cat['Category']['parent_id']) ? false : true;
						$hasInventory = ($cat['Category']['is_product']) ? 'Yes' : '-';
						
						if($cat['Category']['is_product']) {
							$spPrice = $cat['Category']['selling_price'];
							$spPrice = ($spPrice > 0) ? $this->Number->currency($spPrice, $CUR) : '-';
							$cpPrice = $cat['Category']['cost_price'];
							$cpPrice = ($cpPrice > 0) ? $this->Number->currency($cpPrice, $CUR) : '-';
						}
						
						if($cat['Category']['show_in_sales']) {
							$visibility1[] = 'Sales';
						}
						if($cat['Category']['show_in_purchases']) {
							$visibility1[] = 'Purchases';
						}
						if($cat['Category']['show_in_cash']) {
							$visibility1[] = 'Cash';
						}
						$viewin = implode(' | ', $visibility1);	
						
						if($cat['Category']['is_product']) {
							$isProduct = true;
						}
						break;
					}
				}
			?>		
				<tr>
					<td style="">
						<?php 
						echo $space.$style;
						if(!$isProduct) {
							//echo $this->Html->link($categoryName, '/reports/index/category_id:'.$id, array('style'=>'text-decoration:none;', 'escape'=>false));
							echo $categoryName;
							?>
							&nbsp;&nbsp;<?php echo $this->Html->link($this->Html->image('category.png', array('style'=>'height:14px; width:14px;', 'alt'=>'+', 'title'=>'Add new category under - '.$categoryName)), '/categories/add/'.$id, array('escape'=>false));?>
							<?php 
						}
						else {
							echo $this->Html->link($categoryName, '/reports/index/category_id:'.$id, array('style'=>'text-decoration:none; font-weight:normal;', 'escape'=>false));			
						}
						?>
					</td>
					<?php echo ($showCP) ? "<td>".$cpPrice."</td>" : null ?>
					<?php echo ($showSP) ? "<td>".$spPrice."</td>" : null ?>
					<?php echo ($inventory) ? "<td>$hasInventory</td>" : null;?>
					<?php echo ($visibility) ? "<td>$viewin</td>" : null ?>
					
					<td style="text-align:right;">
						<?php
						if(!$isProduct) {
							if($topLevelCategory) {
								echo $this->Html->link('Reorder', array('controller'=>'categories', 'action'=>'reorder/'.$id), array('title'=>'Reorder all categories and product'), 'Reordering may take sometime. Please be patient and do not press cancel or back button while the request is in process.');						
								echo '&nbsp;|&nbsp;';
							}
						}
						echo $this->Html->link('Edit', array('controller'=>'categories', 'action'=>'edit/'.$id), array('title'=>'Edit Category - '.$categoryName));
						echo '&nbsp;|&nbsp;';
						echo $this->Html->link('Delete', array('controller'=>'categories', 'action'=>'delete/'.$id), array('title'=>'Delete Category - '.$categoryName), "Deleting this category will also remove it's child categories. Are you sure you want to continue?");
						?>
					</td>
					
				</tr>			
			<?php	
			}			
			?>
		</tbody>
	</table>		
	<?php
	}
	else {
		echo '&nbsp;No Categories Found.';
	}
	?>	
</div>
<br><br>
