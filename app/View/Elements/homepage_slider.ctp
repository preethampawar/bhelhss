<div class="wrapper">
  <div id="featured_slide" class="clear">
    <!-- ###### -->
    <div class="overlay_left"></div>
    <div id="featured_content">
      <div class="featured_box" id="fc1">
		<?php echo $this->Html->image('slider/5.jpg', array('alt'=>''));?>
        
		<div class="floater">
          <h2>Latest News &amp; Events</h2>
          <p>Check out the latest news and happenings, related to BHEL Higher Secondary School.</p>
		  <br>
          <p class="readmore">
			<?php
			$categoryID = '5';
			$categoryName = 'Latest News And Events';
			$categoryNameSlug = Inflector::slug($categoryName, '-');
			echo $this->Html->link('Show all &raquo;', '/posts/showAll/'.$categoryID.'/'.$categoryNameSlug, array('title'=>'Show all latest news and events', 'escape'=>false, 'style'=>'color:blue;'));
			?>
		  </p>
        </div>
		
		
      </div>
      <div class="featured_box" id="fc2">
		<?php echo $this->Html->image('slider/2.jpg', array('alt'=>''));?>
		
        <div class="floater">
			<h2>BHEL Higher Secondary School</h2>
			<p>BHEL Higher Secondary School (also known as BHEL HSS) Ramachandrapuram, Hyderabad was established in the year 1965.</p>
			<br>
			<br>
			<p class="readmore">
			<?php
			$categoryID = '6';
			$categoryName = 'BHEL Higher Secondary School';
			$categoryNameSlug = Inflector::slug($categoryName, '-');
			echo $this->Html->link('About BHEL Higher Secondary School &raquo;', '/posts/showAll/'.$categoryID.'/'.$categoryNameSlug, array('title'=>'Know more about BHEL HSS', 'escape'=>false, 'style'=>'color:blue;'));
			?>
			</p>
        </div>		
      </div>
      <div class="featured_box" id="fc3">
		<?php echo $this->Html->image('slider/3.jpg', array('alt'=>''));?>
		<!--
        <div class="floater">
          <h2>Awards & Achievements</h2>
          <p>Ex-students of BHEL Higher Secondary School</p>
         <p class="readmore"><a href="#">Continue Reading &raquo;</a></p> 
        </div>
		 -->
		
      </div>
      <div class="featured_box" id="fc4">
		<?php echo $this->Html->image('slider/4.jpg', array('alt'=>''));?>
        <!--
		<div class="floater">
          <h2>Aliquatjusto quisque nam</h2>
          <p>Attincidunt vel nam a maurisus lacinia consectetus magnisl sed ac morbi. Inmaurisus habitur pretium eu et ac vest penatibus id lacus parturpis.</p>
          <p class="readmore"><a href="#">Continue Reading &raquo;</a></p>
        </div-->
      </div>
      <div class="featured_box" id="fc5">
			<?php echo $this->Html->image('slider/1.jpg', array('alt'=>''));?>
			<!--
			<div class="floater">
			  <h2>Nullamlacus dui ipsum</h2>
			  <p>Attincidunt vel nam a maurisus lacinia consectetus magnisl sed ac morbi. Inmaurisus habitur pretium eu et ac vest penatibus id lacus parturpis.</p>
			  <p class="readmore"><a href="#">Continue Reading &raquo;</a></p>
			</div>
			-->
      </div>
    </div>
    <ul id="featured_tabs">
      <li><a href="#fc1">Latest News <br>&amp; Events</a></li>
      <li><a href="#fc2">BHEL Higher Secondary School</a></li>
      <li><a href="#fc3">Awards And Achievements</a></li>
      <li><a href="#fc4">Memories From The Past</a></li>
      <li class="last"><a href="#fc5">Alumni Reunion<br>23 Dec 2012</a></li>
    </ul>
    <div class="overlay_right"></div>
    <!-- ###### -->
  </div>
</div>