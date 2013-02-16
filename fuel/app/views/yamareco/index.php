<h2>Listing Yamarecos</h2>
<br>
<?php if ($yamarecos): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>Line</th>
			<th>Time</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($yamarecos as $yamareco): ?>		<tr>

			<td><?php echo $yamareco->name; ?></td>
			<td><?php echo $yamareco->line; ?></td>
			<td><?php echo $yamareco->time; ?></td>
			<td>
				<?php echo Html::anchor('yamareco/view/'.$yamareco->id, 'View'); ?> |
				<?php echo Html::anchor('yamareco/edit/'.$yamareco->id, 'Edit'); ?> |
				<?php echo Html::anchor('yamareco/delete/'.$yamareco->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Yamarecos.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('yamareco/create', 'Add new Yamareco', array('class' => 'btn btn-success')); ?>

</p>
