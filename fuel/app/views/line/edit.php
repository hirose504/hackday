<h2>Editing Line</h2>
<br>

<?php echo render('line/_form'); ?>
<p>
	<?php echo Html::anchor('line/view/'.$line->id, 'View'); ?> |
	<?php echo Html::anchor('line', 'Back'); ?></p>
