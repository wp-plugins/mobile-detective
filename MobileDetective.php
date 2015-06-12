<?php
/*
Plugin Name: Mobile Detective
Plugin URI: 
Description: Detects user device type (Phone, Tablet, Desktop...) and info
Version: 1.0.0
Author: Leonid N. Malyshev
Author URI: http://mln.sk http://wpplugins.ml
*/

require_once plugin_dir_path(__FILE__).'Mobile_Detect.php';
class WP_MD_mln{

	public function __construct() {
		add_shortcode('MobDetective', array(&$this,'MobDetective'));
		wp_register_style( 'MD-style', plugins_url( '/CSS/MD_styles.css', __FILE__ ), array(), '20150609', 'all' );
		wp_enqueue_style( 'MD-style' );
		// Hook for adding admin menus
		if ( is_admin() ){ // admin actions
			add_action('admin_menu', array(&$this,'MD_add_pages'));
			add_action( 'admin_init', array(&$this,'register_mysettings' ));
		} else {
		  // non-admin enqueues, actions, and filters
		}
	}
	
	function register_mysettings() { // whitelist options
	  register_setting( 'MD-settings-group', 'MD_groups_json' );
	  register_setting( 'MD-settings-group', 'MD_groups_json_t' );
	}

	// action function for above hook
	function MD_add_pages() {
		// Add a new submenu under Options:
		add_options_page('MD Options', 'Mobile Detective', 8, 'MDoptions', array(&$this,'MD_options_page'));
	}

	// MD_options_page() displays the page content for the Options submenu
	function MD_options_page() {
		include_once (__DIR__.'/MD_admin.php');
	}

	public function MobDetective($atts, $content = null) {
		
						/*if (isset($atts['redirect'])){
							$location=$atts['redirect'];
							wp_safe_redirect( $location);return ($atts['redirect']);
						} return ("url not set");*/
		$detect = new Mobile_Detect;
		$s=file_get_contents(plugin_dir_path(__FILE__).'filters.txt');
		$a=explode (",",$s);
		foreach ($a as $valid_str){
			$p=explode ("=>",$valid_str);
			$valid[]=trim($p[0]);
		}
		$encoded=wp_unslash(get_option('MD_groups_json'));
		$mygroups=json_decode($encoded);
		foreach ($atts as $filter) {
			if (trim($filter)=='') continue;
			if (isset($atts['output']) && ($filter==$atts['output'])) continue;
			if (isset($atts['redirect']) && ($filter==$atts['redirect'])) continue;
			$isgroup=false;
			$g_result=false;
			foreach ($mygroups as $group) { //Check if group
				if ($group[0] == $filter || '!'.$group[0] == $filter) {
					$isgroup=true;
					$g_p=explode(',',$group[1]);
					foreach ($g_p as $gpi) {
						if ($gpi !=''){ //$proc_to_call[]=(($group[0] == $filter)?'':'!')."\$detect->".trim($gpi).'()';
							$cond="\$detect->".trim($gpi).'()';
							eval("\$s=".$cond.';');
							if ($s==1){
								$g_result=true;
								break;
							} 
						}
					}							
					//Check if !group
					$g_result=(($group[0] == $filter)?$g_result:!$g_result);
					// Return if group failed
					if ($isgroup && !$g_result){	
						if (isset($atts['redirect'])){
							$location=$atts['redirect'];
							wp_safe_redirect( $location);exit;
						}
						if (isset($atts['output'])) return ($atts['output']);//return ($atts['output']);
						return ('Failed '.trim($filter));
					}
				} 
			}
			if (!$isgroup) {
			//Check valid operation
				if (strpos(trim($filter),"!")===false)$name=trim($filter);else $name=substr(trim($filter),1);
				if (!in_array($name,$valid)) return ('"'.trim($filter).'" is not valid check name');
				if (strpos($filter,"!")===false) $cond="\$detect->".trim($filter).'()';
				else $cond="!\$detect->".substr(trim($filter),1).'()';
				// Check this condition 
				eval("\$s=".$cond.';');
				// Return if filter failed
				if ($s!=1){	
					if (isset($atts['redirect'])){
						$location=$atts['redirect'];
						wp_safe_redirect( $location); 
					}
					if (isset($atts['output'])) return ($atts['output']);//return ($atts['output']);
					return ('Failed '.$cond);
				}
			}
		}
		return  $content;
	}
}
 $x=new WP_MD_mln();
?>