<?php
/*
Plugin Name: Add Logo to Admin
Plugin URI: http://bavotasan.com/downloads/add-your-logo-to-the-wordpress-admin-and-login-page/
Description: Adds a custom logo to your wp-admin and login page.
Author: c.bavota
Version: 1.5
Author URI: http://bavotasan.com
*/

//Initialization
add_action('admin_menu', 'add_logo_init');

$add_logo_upload_dir = wp_upload_dir();
$add_logo_directory = $add_logo_upload_dir['basedir']. '/logos';

//add page to admin 
function add_logo_init() {
	global $add_logo_directory, $add_logo_upload_dir;
	if(!empty($_GET['delete-logo'])) {
		unlink($add_logo_directory ."/". $_GET['delete-logo']);
		if($_GET['delete-logo'] == get_option('add_logo_filename')) {
			update_option('add_logo_filename', ""); 
			update_option('add_logo_logo', ""); 
		}
		
		$location = str_replace("&delete-logo=". $_GET['delete-logo'], "", $_SERVER['REQUEST_URI']."&deleted=true");
		header("Location: $location");
		die();		
	}

	if(!empty($_POST['add_logo_submit'])) {
		if (!wp_verify_nonce($_POST['add_logo_to_admin_nonce'], 'add_logo_to_admin_nonce'))
			exit();
		
		if ($_FILES["file"]["type"]){
			$image = str_replace(" ", "-", $_FILES["file"]["name"]);
			move_uploaded_file($_FILES["file"]["tmp_name"],
			$add_logo_directory .'/'. $image);
			update_option('add_logo_logo', $add_logo_upload_dir['baseurl'] . "/logos/" . $image);
			update_option('add_logo_filename', $image); 
		}
		
		if($_POST['add_logo_on_login']) update_option('add_logo_on_login',$_POST['add_logo_on_login']);
		if($_POST['add_logo_on_admin']) update_option('add_logo_on_admin',$_POST['add_logo_on_admin']);	
	
		if($_POST['add_logo_filename']) {
			update_option('add_logo_filename',$_POST['add_logo_filename']);
			update_option('add_logo_logo',  $add_logo_upload_dir['baseurl'] . "/logos/" . $_POST['add_logo_filename']);
		}	
		
		if($_POST['saved']==true) {
			$location = $_SERVER['REQUEST_URI'];
		} else {
			$location = str_replace("&deleted=true", "", $_SERVER['REQUEST_URI']."&saved=true");		
		}
		header("Location: $location");
		die();
		
	}	
	$add_logo_page = add_options_page('Add Logo to Admin', 'Add Logo to Admin', "manage_options", __FILE__, 'add_logo_options');

	//add logo to admin if "yes" is selected
	if(get_option('add_logo_on_admin') == "yes") {
		add_action( "admin_head", 'add_logo_css' );
		add_action( "admin_footer", 'add_logo_script' );
	}
}

//add logo to admin if "yes" selected
function add_logo_css() {
	$img = get_option('add_logo_logo');
	if(!empty($img))
		echo '<style type="text/css">
#admin-logo { margin: 10px 0; padding: 0 0 5px; border-bottom: 1px solid #ddd; width: 100%; }
</style>'."\n";
}

function add_logo_script() {
	$img = get_option('add_logo_logo');
	if(!empty($img))
		echo '<script type="text/javascript">
/* <![CDATA[ */
(function($) {
	$(".wrap").prepend("<div id=\"admin-logo\"><img src=\"'.($img).'\" alt=\"\" /></div>");
})(jQuery);
/* ]]> */
</script>';
}
	
//add logo to login if "yes" is selected
if(get_option('add_logo_on_login') == "yes") {
	add_action('login_head', 'login_logo_css');	
	function login_logo_css() {
		echo '<style type="text/css">
.login h1 a { background-image: url('.get_option('add_logo_logo').'); }
</style>'."\n";
	}
}

function add_logo_settings_link( $links ) { 
	$settings_link = '<a href="options-general.php?page=add-logo-to-admin/add-logo.php">Settings</a>'; 
	array_unshift( $links, $settings_link ); 
	return $links; 
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'add_logo_settings_link' );

//set default options
function set_add_logo_options() {	
	add_option('add_logo_on_login','yes');
	add_option('add_logo_on_admin','yes');	
	add_option('add_logo_logo',get_option("siteurl").'/wp-content/plugins/add-logo-to-admin/images/logo.png');	
	add_option('add_logo_filename', 'logo.png');	
}

//delete options upon plugin deactivation
function unset_add_logo_options() {
	delete_option('add_logo_on_login');
	delete_option('add_logo_on_admin');
	delete_option('add_logo_logo');
	delete_option('add_logo_filename');
}

register_activation_hook(__FILE__,'set_add_logo_options');
register_deactivation_hook(__FILE__,'unset_add_logo_options');

//creating the admin page
function add_logo_options() { 
	global $add_logo_directory, $add_logo_upload_dir;
	if(!file_exists($add_logo_directory)) mkdir($add_logo_directory, 0755);
	
	$default_login = get_option('add_logo_on_login');
	$default_admin = get_option('add_logo_on_admin');
	$the_logo = get_option('add_logo_logo');
	?>
    <div class="wrap">
        <h2>Add Logo to Admin</h2>
        <?php
        if ( $_REQUEST['saved'] ) { echo '<div id="message" class="updated fade"><p><strong>Add Logo to Admin settings saved.</strong></p></div>'; }
        if ( $_REQUEST['deleted'] ) { echo '<div id="message" class="updated fade"><p><strong>Logo deleted.</strong></p></div>'; }
        ?>
        <!-- Add Logo to Admin box begin-->
        <form method="post" id="myForm" enctype="multipart/form-data">
        <table class="form-table">
        <tr valign="top">
        <th scope="row" style="width: 370px;">
            <label for="add_logo_on_login">Would you like your logo to appear on the login page?</label>
        </th>
        <td>
            <input type="radio" name="add_logo_on_login" value="yes" <?php checked($default_login, "yes"); ?> />&nbsp;Yes&nbsp;&nbsp;
            <input type="radio" name="add_logo_on_login" value="no" <?php checked($default_login, "no"); ?> />&nbsp;No
        </td>
         </tr>   
        <tr valign="top">
        <th scope="row" style="width: 370px;">
            <label for="add_logo_on_admin">Would you like your logo to appear on the admin pages?</label>
        </th>
        <td>
            <input type="radio" name="add_logo_on_admin" value="yes" <?php checked($default_admin, "yes"); ?> />&nbsp;Yes&nbsp;&nbsp;
            <input type="radio" name="add_logo_on_admin" value="no" <?php checked($default_admin, "no"); ?> />&nbsp;No
        </td>
        </tr>
        <tr valign="top">
        <th scope="row" style="width: 370px;">
            <label for="add_logo_logo">Choose a file to upload: </label>
        </th>
        <td>
            <input type="file" name="file" id="file" />&nbsp;<em><small>Click Save Changes below to upload your logo.</small></em><br />
            (max. logo size 326px by 67px)
            <?php
                $directory = $add_logo_upload_dir['baseurl'] . "/logos/";
                //update_option('add_logo_logo', $directory.get_option('add_logo_filename'));
                // Open the folder 
                $dir_handle = @opendir($add_logo_directory) or die("Unable to open $add_logo_directory"); 
                // Loop through the files 
                $count = 1;
                while ($file = readdir($dir_handle)) { 
                
                    if($file == "." || $file == ".." || $file == "index.php" ) {
                        continue; 
                        }
                    if($count==1) { echo "<br /><br />Select which logo you would like to use.<br />"; $count++; }
                    if($file == get_option('add_logo_filename')) { $checked = "checked"; } else { $checked = ""; }
                    echo "<br /><table><tr><td style=\"padding-right: 5px;\"><img src=\"$directory$file\" style=\"max-height:100px;border:1px solid #aaa;padding:10px;\" /></td><td><input id=\"add_logo_filename\" name=\"add_logo_filename\" type=\"radio\" value=\"$file\" $checked />&nbsp;Select<br /><br /><a href=\"options-general.php?page=add-logo-to-admin/add-logo.php&delete-logo=$file\">&laquo; Delete</a></td></tr></table>"; 
                } 
                
                // Close 
                closedir($dir_handle); 
             ?>    </td>
        </tr>
        </table>   
        <p class="submit">
        <input type="submit" name="add_logo_submit" class="button-primary" value="Save Changes" />
        </p>
 	    <?php if(function_exists('wp_nonce_field')) wp_nonce_field('add_logo_to_admin_nonce', 'add_logo_to_admin_nonce'); ?>
       </form>
        <!-- Add Logo to Admin admin box end-->
    </div>
 <?php
 }  