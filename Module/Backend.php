<?php
namespace CD\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Backend extends Module {
    
	protected function _init() {
	   
       add_action('admin_menu', array($this, 'admin_menu'));
       add_action('admin_init', array ( $this, 'register_options_init' ) );
	}
    
    public function admin_menu() {
        add_options_page ( __('Cookie disclaimer', CD_TEXTDOMAIN), __('Cookie disclaimer', CD_TEXTDOMAIN), 'manage_options', 'cookie-disclaimer-settings', array($this, 'settings_page') );
	}
    
    public function settings_page() {
            
            require CD_DIR . '/views/Backend/settings.php';
    }    
    
    public function register_options_init(  ) {
		
			register_setting ( 'cd_options', 'cd_options_settings' );
			
			add_settings_section (
				'cookie_statement', 
				__( 'Cookie statement', CD_TEXTDOMAIN ), 
				array ( $this, 'cookie_statement_render' ), 
				'cd_options'
			);
            
            add_settings_section (
				'site_ownership_default', 
				__( 'Site ownership default', CD_TEXTDOMAIN ), 
				array ( $this, 'site_ownership_default_render' ), 
				'cd_options', 
				'cd_options_section'
			);
            
            add_settings_section (
				'accept_button', 
				__( 'Accept button', CD_TEXTDOMAIN ), 
				array ( $this, 'accept_button_render' ), 
				'cd_options', 
				'cd_options_section'
			);
            
            add_settings_section (
				'base_color', 
				__( 'Base color', CD_TEXTDOMAIN ), 
				array ( $this, 'base_color_render' ), 
				'cd_options', 
				'cd_options_section'
			);
			
			// Set default options
			$options = get_option ( 'cd_options_settings' );
			if ( false === $options ) {
				// Get defaults
				$defaults = $this -> get_default_options_settings();
				update_option ( 'cd_options_settings', $defaults );
			}
			
	}
    public function get_default_options_settings() {
			$defaults = array (
				'cookie_statement' => 'We use cookies to give you the best online experience',
                'site_ownership_default' => 'By using our website, you agree to our <a href={url: privacy-policy} target="_blank">privacy policy</a>', 
                'accept_button' => 'I Accept', 
                'base_color' => '#f7c413', 
			);
			return $defaults;
	}
    public function cookie_statement_render() { 
			$options = get_option( 'cd_options_settings' ); ?>
			<input class="widefat" type="text" name="cd_options_settings[cookie_statement]" value="<?php echo esc_attr( $options['cookie_statement'] ); ?>">
			<p class="description"><?php _e( 'displayed always as the first sentence in the banner', CD_TEXTDOMAIN ); ?></p>
		<?php
	}
    public function site_ownership_default_render() { 
			$options = get_option( 'cd_options_settings' ); ?>
			<input class="widefat" type="text" name="cd_options_settings[site_ownership_default]" value="<?php echo esc_attr( $options['site_ownership_default'] ); ?>">
			<p class="description"><?php _e( 'displayed as the second sentence in the banner', CD_TEXTDOMAIN ); ?></p>
		<?php
	}
    public function accept_button_render() { 
			$options = get_option( 'cd_options_settings' ); ?>
			<input class="widefat" type="text" name="cd_options_settings[accept_button]" value="<?php echo esc_attr( $options['accept_button'] ); ?>">
			<p class="description"><?php _e( 'text on the button always', CD_TEXTDOMAIN ); ?></p>
		<?php
	}
    public function base_color_render() { 
			$options = get_option( 'cd_options_settings' ); ?>
			<input class="widefat" type="text" name="cd_options_settings[base_color]" value="<?php echo esc_attr( $options['base_color'] ); ?>">
			<p class="description"><?php _e( 'used to define base color for border and button', CD_TEXTDOMAIN ); ?></p>
		<?php
	}
}