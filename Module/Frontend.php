<?php
namespace CD\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Frontend extends Module {
    
	protected function _init() {

            add_filter( 'body_class', array ( $this, 'body_class' ) );
			add_action ( 'wp_enqueue_scripts', array ( $this, 'enqueue_scripts' ) );
			add_action ( 'wp_head', array ( $this, 'add_css' ) );
			add_action ( 'wp_footer', array ( $this, 'add_js' ), 1000 );
			add_action ( 'wp_footer', array ( $this, 'add_notification_bar' ), 1000 );
	}
		
    public function enqueue_scripts() {
			$exclude = $this->show_bar();

			if( ! empty( $exclude ) ) {
		
				wp_enqueue_style ( 'cookie-consent-style', CD_URL . 'assets/css/style.css', '2.3.0' );
				wp_enqueue_script ( 'cookie-consent', CD_URL . 'assets/js/cookie-disclaimer-js.js', array ( 'jquery' ), '2.3.0', true );
				wp_localize_script (
					'cookie-consent',
					'ctcc_vars',
					array (
						'expiry' 	=> 30,
						'method' 	=> false,
						'version'	=> 1,
					)
				);
			}
	}
	public function show_bar() {
	   
            if (get_current_theme() != 'Landing Page') {
                return true;
            } else {
                return false;
            }
	}
    public function add_css() {
			$exclude = $this->show_bar();
			// Only do all this if post isn't excluded
			if( ! empty( $exclude ) ) {
				$options = get_option ( 'cd_options_settings' );
                
				// Build our CSS
				$css = '<style id="ctcc-css" type="text/css" media="screen">';
				$css .= '
                #catapult-cookie-bar {
					box-sizing: border-box;
					max-height: 0;
					opacity: 0;
					z-index: 99999;
					overflow: hidden;
				    position: fixed;
					right: 20px;
					bottom: 6%;
					width: 300px;
                    border-color: '.$options['base_color'].'; 
                    border-style: solid; 
				}
				#catapult-cookie-bar a {
                    text-decoration: underline; 
				}
				#catapult-cookie-bar .x_close span {
					background-color: ;
				}
                .buttonCenter {
                    text-align:center;    
                }    
				button#catapultCookie {
					background: '.$options['base_color'].';
					border: 0; 
                    padding: 6px 9px; 
                    border-radius: 3px;
                    width: 211px;
				}
				#catapult-cookie-bar h3 {

				}
				.has-cookie-bar #catapult-cookie-bar {
					opacity: 1;
					max-height: 999px;
					min-height: 30px;
				}';
				$css .= '</style>';
				echo $css;
			}
	}
	public function add_js() { 
			
			$exclude = $this->show_bar();
			// Only do all this if post isn't excluded
			if( ! empty( $exclude ) ) {
			 
				$type = 'block';
                
                $position = 'bottom-right-block';
                
                ?>
			
				<script type="text/javascript">
					jQuery(document).ready(function($){
						<?php if ( isset ( $_GET['cookie'] ) ) { ?>
							catapultDeleteCookie('catAccCookies');
						<?php } ?>
						if(!catapultReadCookie("catAccCookies")){ // If the cookie has not been set then show the bar
							$("html").addClass("has-cookie-bar");
							$("html").addClass("cookie-bar-<?php echo $position; ?>");
							$("html").addClass("cookie-bar-<?php echo $type; ?>");
						}
					});
				</script>
			
			<?php }
			
	}
	public function add_notification_bar() {
			
			$exclude = $this->show_bar();
			// Only do all this if post isn't excluded
			if( ! empty( $exclude ) ) {
			 
                $options = get_option ( 'cd_options_settings' );
                
                
							
				$content = '';
                
				$close_content = '';
			
				// Print the notification bar
				$content = '<div id="catapult-cookie-bar" class=" rounded-corners drop-shadow use_x_close">';
                
                if ($options['cookie_statement']) {
                    $content .= '<span class="ctcc-left-side">'.$options['cookie_statement'].'</span>';
                }
                
                if ($options['site_ownership_default']) {
                    $content .= '<span class="ctcc-left-side">'.$options['site_ownership_default'].'</span>';   
                }

                if ($options['accept_button']) {
                    $content .= '<div class="buttonCenter"><button id="catapultCookie" tabindex=0 onclick="catapultAcceptCookies();" title="'.$options['accept_button'].'">'.$options['accept_button'].'</button></div>';  
                }

				// X close button
				$content .= '<div class="x_close"><span></span><span></span></div>';
			
				$content .= '</div><!-- #catapult-cookie-bar -->';
			
				echo apply_filters ( 'catapult_cookie_content', $content, $ctcc_content_settings );
			}
	}
}