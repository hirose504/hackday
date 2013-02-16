<h2>Listing Lines</h2>
<br>
<?php if ($lines): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>Line</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($lines as $line): ?>		<tr>

			<td><?php echo $line->name; ?></td>
			<td><?php echo $line->line; ?></td>
			<td>
				<?php echo Html::anchor('line/view/'.$line->id, 'View'); ?> |
				<?php echo Html::anchor('line/edit/'.$line->id, 'Edit'); ?> |
				<?php echo Html::anchor('line/delete/'.$line->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Lines.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('line/create', 'Add new Line', array('class' => 'btn btn-success')); ?>

</p>
