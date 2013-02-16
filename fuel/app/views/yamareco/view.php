<h2>Viewing #<?php echo $yamareco->id; ?></h2>

<p>
	<strong>Name:</strong>
	<?php echo $yamareco->name; ?></p>
<p>
	<strong>Line:</strong>
	<?php echo $yamareco->line; ?></p>
<p>
	<strong>Time:</strong>
	<?php echo $yamareco->time; ?></p>

<?php echo Html::anchor('yamareco/edit/'.$yamareco->id, 'Edit'); ?> |
<?php echo Html::anchor('yamareco', 'Back'); ?>