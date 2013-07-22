<?php if ( ci_setting( 'show_bc' ) == 'enabled' ): ?>
	<div class="row bc">
		<?php if(function_exists('bcn_display')) { bcn_display(); } ?>
	</div><!-- /bc -->
<?php endif; ?>
