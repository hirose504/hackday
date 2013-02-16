<h2>Viewing #<?php echo $point->id; ?></h2>

<p>
	<strong>Line id:</strong>
	<?php echo $point->line_id; ?></p>
<p>
	<strong>Point:</strong>
	<?php echo $point->point; ?></p>

<?php echo Html::anchor('point/edit/'.$point->id, 'Edit'); ?> |
<?php echo Html::anchor('point', 'Back'); ?>