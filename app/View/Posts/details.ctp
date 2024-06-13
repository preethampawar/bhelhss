<?php 
echo $this->Html->css('jquery.lightbox-0.5'); // jQuery Light box
echo $this->Html->script('jquery.lightbox-0.5'); // jQuery Light box	
?>

<nav>
	<?php
	$categoryID = $categoryInfo['Category']['id'];
	$categoryName = $categoryInfo['Category']['name'];
	$categoryNameSlug = Inflector::slug($categoryName, '-');
	
	$productID = $productInfo['Product']['id'];
	$productName = $productInfo['Product']['name'];
	$productNameSlug = Inflector::slug($productName, '-');
	$productDesc = $productInfo['Product']['description'];	
	?>
	<ul id="productNav">
		<li><?php echo $this->Html->link($categoryName, '/products/show/'.$categoryID.'/'.$categoryNameSlug);?></li>
		<li><?php echo $this->Html->link($productName, '/products/show/'.$categoryID.'/'.$productID.'/'.$categoryNameSlug.'/'.$productNameSlug);?></li>
	</ul>
	<div class='clear'></div>
</nav>
<?php
if(!empty($productImages)) {
?>
<script type="text/javascript">
    $(function() {
        $('#productImages a').lightBox();
    });
    </script>
<div id="productImages">	
	<?php 
	foreach($productImages as $row) { 
		$imageID = $row['Image']['id'];
		$imageCaption = ($row['Image']['caption']) ? $row['Image']['caption'] : $productName;
		
		$imageUrl = $this->Img->showImage('img/images/'.$imageID, array('height'=>'600','width'=>'600','type'=>'auto'), array('style'=>'', 'alt'=>$productName, 'title'=>$imageCaption), true);
	?>
	<div style="float:left; border:0px solid #fff; width:auto; padding:2px;">
		<a href="<?php echo $imageUrl;?>" title='<?php echo $imageCaption;?>'>
			<?php 
			echo $this->Img->showImage('img/images/'.$imageID, array('height'=>'150','width'=>'150','type'=>'crop'), array('style'=>'', 'alt'=>$productName, 'title'=>$imageCaption));
			?>			
		</a>
	</div>	
	<?php } ?>
	<div class='clear'></div>	
	<br><br>
</div>
<?php
}
?>

<div id="productDetails">
	<section>
		<article>
			<header><h2><?php echo $productName;?></h2></header>
			<?php 
			if($this->Session->read('Site.request_price_quote')) {
				echo $this->Form->create('ShoppingCart', array('url'=>'/shopping_carts/add/'.$categoryID.'/'.$productID, 'encoding'=>false)); ?>
					
				<div class="floatLeft" style="width:100px; margin-right:10px;">
					<?php 
					$qtyOptions = Configure::read('Product.quantity');
					echo $this->Form->input('ShoppingCartProduct.quantity', array('options'=>$qtyOptions, 'empty'=>false));
					?>
				</div>	
				<div class="floatLeft" style="width:100px; margin-right:10px;">
					<?php 
					$sizeOptions = Configure::read('Product.size');
					echo $this->Form->input('ShoppingCartProduct.size', array('options'=>$sizeOptions, 'empty'=>'-'));
					?>
				</div>			
				<div class="floatLeft" style="width:150px; margin-right:10px;">
					<?php 
					$ageOptions = Configure::read('Product.age');
					echo $this->Form->input('ShoppingCartProduct.age', array('options'=>$ageOptions, 'empty'=>'-'));
					?>
				</div>
				<div class="floatLeft" style="margin-right:10px;">
					<br>
					<?php echo $this->Form->submit('Add To My Shopping List &raquo;', array('escape'=>false));?>
				</div>
				<div class='clear'></div>
					
				<?php 
				echo $this->Form->end();
			}
			?>
				<?php 
				if(!empty($productDesc)) {
				?>
				<div>
					<br><br>
					<h3>Description</h3>
					<?php echo $productDesc;?>
				</div>
				<?php
				}
				?>
			<br><br>	
			<p><strong>Total Page Views = <?php echo $visits;?></strong></p>	
		</article>
	</section>
</div>
