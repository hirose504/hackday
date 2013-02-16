<h2>Listing Points</h2>
<br>
<?php if ($points): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Line id</th>
			<th>Point</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($points as $point): ?>		<tr>

			<td><?php echo $point->line_id; ?></td>
			<td><?php echo $point->point; ?></td>
			<td>
				<?php echo Html::anchor('point/view/'.$point->id, 'View'); ?> |
				<?php echo Html::anchor('point/edit/'.$point->id, 'Edit'); ?> |
				<?php echo Html::anchor('point/delete/'.$point->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Points.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('point/create', 'Add new Point', array('class' => 'btn btn-success')); ?>

</p>
