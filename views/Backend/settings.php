<div class="wrap">
				<h1><?php echo __( 'Cookie disclaimer', CD_TEXTDOMAIN ); ?></h1>
				<div class="ctdb-outer-wrap">
					<div class="ctdb-inner-wrap">
						<form action='options.php' method='post'>
							<?php
							settings_fields( 'cd_options' );
							do_settings_sections( 'cd_options' );
							submit_button();
							?>
						</form>
					</div><!-- .ctdb-inner-wrap -->					
				</div><!-- .ctdb-outer-wrap -->
			</div><!-- .wrap -->