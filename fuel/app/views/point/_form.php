<?php echo Form::open(); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Line id', 'line_id'); ?>

			<div class="input">
				<?php echo Form::input('line_id', Input::post('line_id', isset($point) ? $point->line_id : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Point', 'point'); ?>

			<div class="input">
				<?php echo Form::input('point', Input::post('point', isset($point) ? $point->point : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>