<?php
/**
 * Single Latest Posts Lite Configuration
 * Version: 1.3
 * Author: L'Elite
 * Author URI: http://laelite.info/
 * License: GNU General Public License 2.0 (GPL) http://www.gnu.org/licenses/gpl.html
 */
/* 
 * Copyright 2007 - 2013 L'Elite de José SAYAGO (opensource@laelite.info)
 * 'SLPosts Lite', 'SLPosts Pro', 'NLPosts' are unregistered trademarks of L'Elite, 
 * and cannot be re-used in conjuction with the GPL v2 usage of this software 
 * under the license terms of the GPL v2 without permission.
 *
 * Single Latest Posts brings all the awesomeness available
 * in Network Latest Posts to individual WordPress installations.
 *
 */
// Root Path
$slp_root = dirname( __FILE__ );
define( 'SLPosts_Root', $slp_root, true );
// Current Version
define( 'SLPosts_Version', '1.3', true );
// Classes
require_once dirname( __FILE__ ) . '/core/classes/single-latest-posts-widget.php';
?>