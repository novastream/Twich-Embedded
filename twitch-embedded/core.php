<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
/**
 * Plugin Name: Twitch Embedded
 * Plugin URI: http://www.twitter.com/NovaLindgren
 * Description: Embed Twitch channels with shortcodes.
 * Version: 0.5
 * Author: Jonathan Lindgren
 * Author URI: http://www.novastream.se
 * License: GPLv2
 */
 
function te_func( $atts ) {
	
	/* start timer for source code timestamp */
	$time_start = microtime(true);
	
	/* validate channnel information */
	if(!isset($atts['channel']) || empty($atts['channel'])) {
		return false;
	}
	
	/* validate width */
	if(isset($atts['width']) || !empty($atts['width'])) {
		if(!is_numeric($atts['width'])) {
			if(substr($atts['width'], -1) === '%') {
				if(!is_numeric(substr($atts['width'], 0, -1))) {
					if(isset($atts['get']) && $atts['get'] === 'chat') {
						$atts['width'] = '350px';
					} else {
						$atts['width'] = '620px';
					}
				}
			} elseif(substr($atts['width'], -2) === 'px') {
				if(!is_numeric(substr($atts['width'], 0, -2))) {
					if(isset($atts['get']) && $atts['get'] === 'chat') {
						$atts['width'] = '350px';
					} else {
						$atts['width'] = '620px';
					}
				}
			} else {
				if(isset($atts['get']) && $atts['get'] === 'chat') {
					$atts['width'] = '350px';
				} else {
					$atts['width'] = '620px';
				}
			}
		} else {
			$atts['width'] = $atts['width'].'px';
		}
	} else {	
		if(isset($atts['get']) && $atts['get'] === 'chat') {
			$atts['width'] = '350px';
		} else {
			$atts['width'] = '620px';
		}
	}
	
	/* validate height */
	if(isset($atts['height']) || !empty($atts['height'])) {
		if(!is_numeric($atts['height'])) {
			if(substr($atts['height'], -1) === '%') {
				if(!is_numeric(substr($atts['height'], 0, -1))) {
					if(isset($atts['get']) && $atts['get'] === 'chat') {
						$atts['height'] = '500px';
					} else {
						$atts['height'] = '378px';
					}
				}
			} elseif(substr($atts['height'], -2) === 'px') {
				if(!is_numeric(substr($atts['height'], 0, -2))) {
					if(isset($atts['get']) && $atts['get'] === 'chat') {
						$atts['height'] = '500px';
					} else {
						$atts['height'] = '378px';
					}
				}
			} else {
				if(isset($atts['get']) && $atts['get'] === 'chat') {
					$atts['height'] = '500px';
				} else {
					$atts['height'] = '378px';
				}
			}
		} else {
			$atts['height'] = $atts['height'].'px';
		}
	} else {
		if(isset($atts['get']) && $atts['get'] === 'chat') {
			$atts['height'] = '500px';
		} else {
			$atts['height'] = '378px';
		}
	}
	
	/* validate autoplay */
	if(isset($atts['autoplay']) && !empty($atts['autoplay'])) {
		if($atts['autoplay'] != 'true') {
			if($atts['autoplay'] != 'false') {
				$atts['autoplay'] = 'true';
			}
		}
	} else {
		$atts['autoplay'] = 'true';
	}
	
	/* validate volume */
	if(isset($atts['volume']) && !empty($atts['volume'])) {
		if(!is_numeric($atts['volume'])) {
			$atts['volume'] = 25;
		}
	} else {
		$atts['volume'] = 25;
	}
	
	/* validate get */
	if(isset($atts['get']) && !empty($atts['get'])) {
		if($atts['get'] != 'video') {
			if($atts['get'] != 'chat') {
				$atts['get'] = 'video';
			}
		}
	} else {
		$atts['get'] = 'video';
	}
	
	/* validate mode */
	if(isset($atts['mode']) && !empty($atts['mode'])) {
		if($atts['mode'] != 'iframe') {
			if($atts['mode'] != 'object') {
				$atts['mode'] = 'iframe';
			}
		}
	} else {
		$atts['mode'] = 'iframe';
	}
	
	/* validate class */
	if(!isset($atts['class']) && empty($atts['class'])) {
		$atts['class'] = 'default-embed';
	}
	
	/* validate debug */
	if(!isset($atts['debug']) && empty($atts['debug'])) {
		$atts['debug'] = 'false';
	} else {
		if($atts['debug'] != 'true') {
			if($atts['debug'] != 'false') {
				$atts['debug'] = 'false';
			}
		}
	}
	
	/* start building output */
	if($atts['get'] != 'video') {
		$output_data = '<iframe src="http://www.twitch.tv/'.$atts['channel'].'/chat?popout=" class="'.$atts['class'].'" style="width:'.$atts['width'].';height:'.$atts['height'].';" frameborder="0" scrolling="no"></iframe>';
	} else {
		if($atts['mode'] == 'iframe') {
			$output_data = '<iframe src="http://www.twitch.tv/'.$atts['channel'].'/embed" class="'.$atts['class'].'" style="width:'.$atts['width'].';height:'.$atts['height'].';" frameborder="0" scrolling="no"></iframe>';
		} else {
			$output_data = '<object class="'.$atts['class'].'" style="width:'.$atts['width'].';height:'.$atts['height'].';" 
				data="//www-cdn.jtvnw.net/swflibs/TwitchPlayer.swf"
				type="application/x-shockwave-flash">
				<param name="allowFullScreen" 
					value="true" />
				<param name="allowNetworking" 
					value="all" />
				<param name="allowScriptAccess" 
					value="always" />
				<param name="movie" 
					value="//www-cdn.jtvnw.net/swflibs/TwitchPlayer.swf" />
				<param name="flashvars" 
					value="channel='.$atts['channel'].'&auto_play='.$atts['autoplay'].'&start_volume='.$atts['volume'].'" />
				</object>';
		}
	}
	
	/* end timer for sourcecode timestamp */
	$time_end = microtime(true);
	$execution_time = ($time_end - $time_start)/60;
	$output = $output_data."<!--".$execution_time."-->";
	
	if($atts['debug'] != 'true') {
		return $output;
	} else {
		return "<pre>".htmlspecialchars($output)."</pre>";
	}
	
	
}

function twitch_embed_menu_page() {
	add_menu_page( 'Twitch Embedded', 'Twitch Embedded', 'manage_options', 'twitch_embedded', 'twitch_embedded_init', 'dashicons-format-video', 75 );
}

function twitch_embedded_init() {
	
	if( isset( $_GET[ 'tab' ] ) ) {  
		switch($_GET[ 'tab' ]) {
			case 'general':
				$active_tab = 'general';
			break;
			case 'parameters':
				$active_tab = 'parameters';
			break;
			case 'examples':
				$active_tab = 'examples';
			break;
			default:
				$active_tab = 'general';
			break;
		}
	} else {
		$active_tab = 'general';
	}
	
	?>
	<div class="wrap">
		<h2 class="nav-tab-wrapper">  
			<a href="?page=twitch_embedded&tab=general" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>">About</a>  
			<a href="?page=twitch_embedded&tab=parameters" class="nav-tab <?php echo $active_tab == 'parameters' ? 'nav-tab-active' : ''; ?>">Parameters</a>  
			<a href="?page=twitch_embedded&tab=examples" class="nav-tab <?php echo $active_tab == 'examples' ? 'nav-tab-active' : ''; ?>">Examples</a>  
		</h2>
	<?php
	
		if($active_tab == 'general') {
			?>
				<h1>Twich Embedded</h1>	
				
				<h3>Feauters</h3>
				<ul>
					<li>- Easy and quick embedding of Twitch.tv streams and chats</li>
					<li>- Customizable with simple parameters</li>
					<li>- Use iframe or object to embed</li>
					<li>- Fallback code, don't worry if you get it wrong. We got you covered!</li>
				</ul>
			<?php
		}
		
		if($active_tab == 'parameters') {
			?>
				<p><strong>Acceptable parameters for iframe video and chat</strong></p>
				<code>[twitch channel="twitch"]</code> - channel name<br /><br />
				<code>[twitch channel="twitch" width="50%" height="200px"]</code> - Width and height in pixels or percent, default is 620x378px<br /><br />
				<code>[twitch channel="twitch" width="50%" height="200px" get="video"]</code> - Accepts video or chat, default is video<br /><br />
				<code>[twitch channel="twitch" width="50%" height="200px" get="video" mode="iframe"]</code> - Accepts both iframe and object, default is iframe<br /><br />
				<code>[twitch channel="twitch" width="50%" height="200px" get="video" mode="iframe" class="custom_css"]</code> - Custom CSS class, default is "default-embed<br /><br />
				<code>[twitch channel="twitch" width="50%" height="200px" get="video" mode="iframe" class="custom_css" debug="true"]</code> - Accepts true or false, default value is false<br /><br />
				
				<p><strong>Additional parameters for object</strong></p>
				<code>[twitch channel="twitch" width="50%" height="200px" get="video" mode="object" volume="30"]</code> - Accepts numeric values only (0 - 50), default is 25<br /><br />
				<code>[twitch channel="twitch" width="50%" height="200px" get="video" mode="object" volume="30" autoplay="true"]</code> - Accepts true or false, default is true<br /><br />
				
				<p><strong>*to override inline css (width and height) you need to use !important in your stylesheet.</strong></p>
			<?php
		}
		
		if($active_tab == 'examples') {
			?>
				<p><strong>Example #1 - Minified usage</strong></p>
				<code>[twitch channel="lirik]</code><br /><br />
				
				<p><strong>Example #2 - Minified usage chat</strong></p>
				<code>[twitch channel="5hizzle" get="chat"</code><br /><br />
				
				<p><strong>Example #3 - Custom big screen</strong></p>
				<code>[twitch channel="smitegame" get="video" width="800px" height="500px" mode="object" class="theater" volume="30" autoplay="false"]</code><br /><br />
			<?php
		}
		
		?>
	</div><!-- /wrap -->
		<?php
}


add_action( 'admin_menu', 'twitch_embed_menu_page' );
add_shortcode( 'twitch', 'te_func' );

?>