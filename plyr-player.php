<?php
/**
 * Plyr Player
 *
 * @package     Package
 * @author      Badabingbreda
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Plyr Player
 * Plugin URI:  https://www.badabing.nl
 * Description: implementation of the plyr.io player
 * Version:     1.0.0
 * Author:      Badabingbreda
 * Author URI:  https://www.badabing.nl
 * Text Domain: textdomain
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

define( 'PLYRPLAYER_VERSION' 	, '1.0.0' );
define( 'PLYRPLAYER_DIR'		, plugin_dir_path( __FILE__ ) );
define( 'PLYRPLAYER_FILE'		, __FILE__ );
define( 'PLYRPLAYER_URL' 		, plugins_url( '/', __FILE__ ) );

require_once( 'inc/class.plyr.player.php' );
