<h2>Viewing #<?php echo $line->id; ?></h2>

<p>
	<strong>Name:</strong>
	<?php echo $line->name; ?></p>
<p>
	<strong>Line:</strong>
	<?php echo $line->line; ?></p>

<?php echo Html::anchor('line/edit/'.$line->id, 'Edit'); ?> |
<?php echo Html::anchor('line', 'Back'); ?>