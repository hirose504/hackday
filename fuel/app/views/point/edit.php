<h2>Editing Point</h2>
<br>

<?php echo render('point/_form'); ?>
<p>
	<?php echo Html::anchor('point/view/'.$point->id, 'View'); ?> |
	<?php echo Html::anchor('point', 'Back'); ?></p>
