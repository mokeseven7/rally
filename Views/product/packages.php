<?php $activeVehicle =  \Dsc\System::instance()->get('session')->get('activeVehicle'); ?>

<?php if(!empty($activeVehicle)) : ?>
<h3 class="class=cat-title paddingTop cat-title-section marginTopNone">Search package deals for: <span style="color: gray;">“<?php echo  $item-> title; ?>”</span></h3>
<div class="row ymm-sort" style="margin-bottom: 40px;">
	   <div class="col-xs-12 col-sm-2 col-md-2 ymmSortHeightOdd">
		   <span class="verCenter ">Showing Results:</span>
	   </div>
	   <div class="col-xs-12 col-sm-5 col-md-7 paddingLNone ymmSortHeightOdd">
		   <h1 class="verCenter marginTopNone marginBottomNone ymmTitleSort">
			   
			   <?php echo strtoupper($activeVehicle['vehicle_year'].' '.$activeVehicle['vehicle_make'].' '.$activeVehicle['vehicle_model'].' '.$activeVehicle['vehicle_sub_model']); ?>
			  
		   </h1>
	   </div>
	  </div>
<?php else : ?>

<div class="row ymm-sort" style="margin-top: 40px; margin-bottom: 40px;">
	   <div class="col-xs-12 col-sm-2 col-md-2 ymmSortHeightOdd">
		   <span class="verCenter ">Showing package deals for:</span>
	   </div>
	   <div class="col-xs-12 col-sm-5 col-md-7 paddingLNone ymmSortHeightOdd">
		   <h1 class="verCenter marginTopNone marginBottomNone ymmTitleSort">
			   
			   <?php echo  $item-> title; ?>
			  
		   </h1>
	   </div>
	  </div>
 <?php endif; ?>
<div class="paddingBottom">
<?php 
	$kitRows = array_chunk ($kits, 3);
	foreach($kitRows as $row) : ?>
		<?php $this->row = $row; ?>
		<div class="row">
		<?php foreach($row as $kit) :
			$item = $kit;?>
			<div class="position-0   productItem paddingBottom noCompare col-xs-12 col-sm-4 paddingLNone paddingRNone">
				<?php $this->item = $item; ?> 
				<?php echo $this->renderLayout('Shop/Site/Views::category/list_item.php'); ?> 
			</div>
		<?php endforeach; ?>
		</div>
	<?php endforeach; ?>
</div>