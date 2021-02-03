<?php if (count($Error) >0): ?>
	<div class="error">
		<?php  foreach ($Error as $error) : ?>
			<p><?php echo $error; ?></p>
		<?php endforeach ?>
	</div>
<?php endif ?>