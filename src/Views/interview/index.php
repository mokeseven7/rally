<?php $user =  \Dsc\System::instance()->get('session')->get('activeUser'); ?>


<?php if (!empty($user)) : ?>
	<h3 class="headline">Welceome <?php echo $user->name; ?></h3>
	<div class="row ymm-sort" style="margin-bottom: 40px;">
		<div class="col-xs-12 col-sm-2 col-md-2 ymmSortHeightOdd">
			<span class="verCenter ">Showing Results:</span>
		</div>
		<div class="col-xs-12 col-sm-5 col-md-7 paddingLNone ymmSortHeightOdd">
			<h1 class="verCenter marginTopNone marginBottomNone ymmTitleSort">
				<?php foreach ($user->interests as $interest) : ?>
					<h1><?php echo $interest; ?></h1>
				<?php endforeach; ?>
			</h1>
		</div>
	</div>
<?php endif; ?>