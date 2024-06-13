<?php 
echo $this->Html->css('smoothness/jquery-ui-1.8.18.custom'); // jQuery UI 
echo $this->Html->script('jquery-ui-1.8.18.custom.min'); // jQuery UI	
?>
<section id="ProductsInfo">
	<article>
		<header><h2>Featured</h2></header>	
		<?php
		if(!empty($allCategories)) {
			$k=1;
			$z =0;
			$categoriesCount = count($allCategories);			
			foreach($allCategories as $row) {	
				$categoryID = $row['Category']['id'];
				$categoryName = ucwords($row['Category']['name']);
				$categoryNameSlug = Inflector::slug($categoryName, '-');
		?>
		
				
				
				<?php				
				if(!empty($row['CategoryProducts'])) {
				?>
					<div class="productsContainer">
					<?php
					foreach($row['CategoryProducts'] as $row2) {
						$productID = $row2['Product']['id'];
						$productName = ucwords($row2['Product']['name']);
						$productNameSlug = Inflector::slug($productName, '-');
						
						$productTitle = $productName;						
						$productLength = strlen($productTitle);
						if($productLength > 20) {
							$productTitle = substr($productTitle, 0, 18).'...';	
						}
						
						
						$productDsc = $row2['Product']['description'];
						
						$descLength = strlen($productDsc);
						if($descLength > 250) {
							$desc = substr($productDsc, 0, 250);
							$desc.='...';
							$productDsc = $desc;							
						}
						$imageID = 0;
						if(!empty($row2['Images'])) {
							$imageID = (isset($row2['Images'][0]['Image']['id'])) ? $row2['Images'][0]['Image']['id'] : 0;
						}						
						
						$marginRight = -(70*$z);
						if(($z==4) or ($z==0)) {
							$z=0;
							$marginRight = -(20);
						}
						
						
						?>
							<div style="float:left; border:0px solid #efefef; margin:0 7px 8px 0; padding:0px;" onmouseover="$('#infoDiv<?php echo $categoryID.'-'.$productID;?>').css('display', 'block'); $('#image<?php echo $categoryID.'-'.$imageID;?>').prop('class', 'halfTransparent');"  onmouseout="$('#infoDiv<?php echo $categoryID.'-'.$productID;?>').css('display', 'none'); $('#image<?php echo $categoryID.'-'.$imageID;?>').prop('class', 'opaque');" >
								<div style="margin:auto; text-align:center;">
									<strong><?php echo $productTitle; //$this->Html->link($productName, '/products/details/'.$categoryID.'/'.$productID.'/'.$categoryNameSlug.'/'.$productNameSlug, array('title'=>$productName, 'escape'=>false));?></strong>
									<p>
									<?php 
										$productImage = $this->Img->showImage('img/images/'.$imageID, array('height'=>'150','width'=>'150','type'=>'crop'), array('style'=>'', 'alt'=>$productName, 'id'=>'image'.$categoryID.'-'.$imageID));
										echo $this->Html->link($productImage, '/products/details/'.$categoryID.'/'.$productID.'/'.$categoryNameSlug.'/'.$productNameSlug, array('title'=>$productName, 'escape'=>false));
									?>
									</p>
								</div>
								<div style="width:400px; position:absolute; display:none; background-color:#fff; padding:0px 0px 0 0px; margin-left:<?php echo $marginRight;?>px; margin-top:-50px; " id="infoDiv<?php echo $categoryID.'-'.$productID;?>">
									<table class='table' style="margin-bottom:0px;">
										<thead>
											<tr>
												<th><?php echo $categoryName;?></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>
													<?php 
														$productImage = $this->Img->showImage('img/images/'.$imageID, array('height'=>'60','width'=>'60','type'=>'crop'), array('style'=>'', 'alt'=>$productName));
														echo $this->Html->link($productImage, '/products/details/'.$categoryID.'/'.$productID.'/'.$categoryNameSlug.'/'.$productNameSlug, array('title'=>$productName, 'escape'=>false, 'style'=>'float:left; margin:0px 10px 10px 0px;'));
													?>
													
														<h3 style='margin-bottom:5px;'><?php echo $productName;?></h3>
														<?php 
														echo $this->Html->link($productDsc, '/products/details/'.$categoryID.'/'.$productID.'/'.$categoryNameSlug.'/'.$productNameSlug, array('title'=>$productName, 'escape'=>false));
														?>
													
													<div class="clear"></div>
													
													
													<?php if($this->Session->read('Site.request_price_quote')) { ?>
													<div style="text-align:center;">
														<?php echo $this->Form->submit('Request Price Quote &raquo;', array('div'=>false, 'escape'=>false, 'style'=>'width:200px; margin-bottom:8px;', 'onclick'=>"$('#requestPriceQuoteDiv".$categoryID.'-'.$productID."').dialog({ width: 450, height:200, title:'Request Price Quote', modal: true });"));?>
														<br>
														<?php echo $this->Form->submit('Add To My Shopping List &raquo;', array('div'=>false, 'escape'=>false, 'style'=>'width:200px;', 'onclick'=>"$('#addToShoppingListDiv".$categoryID.'-'.$productID."').dialog({ width: 450, height:200, title:'Add To My Shopping List', modal: true });"));?>
													</div>	
													
													<div style="display:none;" id='addToShoppingListDiv<?php echo $categoryID.'-'.$productID;?>'><?php echo $this->element('addtocart_form', array('productID'=>$productID, 'categoryID'=>$categoryID, 'productName'=>$productName, 'categoryName'=>$categoryName));?></div>
													<div style="display:none;" id='requestPriceQuoteDiv<?php echo $categoryID.'-'.$productID;?>'><?php echo $this->element('request_price_quote_form', array('productID'=>$productID, 'categoryID'=>$categoryID, 'productName'=>$productName, 'categoryName'=>$categoryName));?></div>
													<br>	
													<?php } ?>													
												</td>
											</tr>
										</tbody>
									</table>									
								
									
								</div>	
							</div>
						<?php
						$z++;	
					}
					?>
						
					</div>
					
				<?php
				}
				?>
			
			<?php
				$k++;
			}
			?>
			<div class='clear'></div>
		<?php
		}
		else {
		?>			
			<p>No Products Found</p>
		<?php
		}
		?>
		
	</article>	
</section>	