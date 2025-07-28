<?php

function render_discord_connect_block( $attributes, $content ) {
	// Extract attributes safely
	$logged_in_text  = esc_html( $attributes['loggedInText'] ?? 'Connect to Discord' );
	$button_color    = esc_attr( $attributes['connectButtonBgColor'] ?? '#77a02e' );
	$text_color      = esc_attr( $attributes['connectButtonTextColor'] ?? '#ffffff' );

	// Custom logic: you might check if user is connected, etc.
	$is_connected = is_user_logged_in(); // Replace with real check if needed

	// Output buffer
	ob_start();
	?>
	<h1>All In One Discord Connect:</h1>
	<div class="discord-connect-block">
		<button style="background-color: <?php echo $button_color; ?>; color: <?php echo $text_color; ?>;">
			<?php echo $logged_in_text; ?>
		</button>
	</div>
	<?php
	return ob_get_clean();
}


