<?php 

class WSRP_Init_Class{
	public function __construct(){
		$this->_init();
		$this->_hooks();
		$this->_filters();
	}

	public function _init(){

	}

	public function _hooks(){
		add_action( 'init', array( $this, 'assets' ) );
		add_action( 'init', array( $this, 'wsrp_register_post_type' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'wsrp_admin_scripts' ) );		
		add_action('edit_form_after_title',array($this,'wsrp_user_interface') );
		add_action('save_post',array($this,'wsrp_save_metabox_data') );

		// Ajax Save
		add_action( 'wp_ajax_nopriv_wsrp_rating',array( $this, 'wsrp_rating_wp_ajax' ) );
		add_action( 'wp_ajax_wsrp_rating',array( $this, 'wsrp_rating_wp_ajax' ) );

		//Ajax Reset

		add_action( 'wp_ajax_nopriv_wsrp_rating_reset',array( $this, 'wsrp_rating_current_reset' ) );
		add_action( 'wp_ajax_wsrp_rating_reset',array( $this, 'wsrp_rating_current_reset' ) );


		add_shortcode( 'wsrp_rating', array($this,'wsrp_rating_shortcode' ) );

	}

	public function _filters(){
		add_filter('the_content',array($this,'wsrp_content_filter') );

		add_filter('manage_wsrp_rating_posts_columns', array($this,'wsrp_custom_posts_column'));
		add_action('manage_wsrp_rating_posts_custom_column',array($this,'wsrp_display_custom_column_data'),10, 2);
	}

	public function wsrp_admin_scripts(){
		$current_screen = get_current_screen();

	if ($current_screen->post_type === 'wsrp_rating') {
		wp_enqueue_style('wp-color-picker' );
		wp_enqueue_script('wp-color-picker');
		wp_enqueue_script( 'wsrp-color-picker', WSRP_PLUGIN_URL . '/js/admin.js', array( 'jquery' )  );
		wp_enqueue_style('wsrp-admin-css' , WSRP_PLUGIN_URL .'/css/wsrpAdminCss.css' , true , 1.00);
	}
		
	}

	public function assets(){

		//wp_enqueue_style( 'wsrp-rating-style', WSRP_PLUGIN_URL . '/css/bootstrap-rating.css' );

		wp_enqueue_script( 'wsrp-bootstrap-rating-script', WSRP_PLUGIN_URL . '/js/rater.js', array( 'jquery' )  );
		//wp_enqueue_script( 'wsrp-rating-script', WSRP_PLUGIN_URL . '/js/rating.js', array( 'jquery' )  );
	}

	public function wsrp_register_post_type(){

		$menu_icon_path = WSRP_PLUGIN_URL.'/img/star-icon.png';
	
		$labels = array(
			'name'                => __( 'Ratings', 'wsrp-text-domain' ),
			'singular_name'       => __( 'Rating', 'wsrp-text-domain' ),
			'add_new'             => _x( 'Add New Rating', 'wsrp-text-domain', 'wsrp-text-domain' ),
			'add_new_item'        => __( 'Add New Rating', 'wsrp-text-domain' ),
			'edit_item'           => __( 'Edit Rating', 'wsrp-text-domain' ),
			'new_item'            => __( 'New Rating', 'wsrp-text-domain' ),
			'view_item'           => __( 'View Rating', 'wsrp-text-domain' ),
			'search_items'        => __( 'Search Ratings', 'wsrp-text-domain' ),
			'not_found'           => __( 'No Ratings found', 'wsrp-text-domain' ),
			'not_found_in_trash'  => __( 'No Ratings found in Trash', 'wsrp-text-domain' ),
			'parent_item_colon'   => __( 'Parent Rating:', 'wsrp-text-domain' ),
			'menu_name'           => __( 'Ratings', 'wsrp-text-domain' ),
		);
	
		$args = array(
			'labels'              => $labels,
			'hierarchical'        => false,
			'description'         => 'WebSettler Social share plugin.',
			'taxonomies'          => array(),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => null,
			'menu_icon'           => $menu_icon_path,
			'show_in_nav_menus'   => true,
			'publicly_queryable'  => true,
			'exclude_from_search' => false,
			'has_archive'         => true,
			'query_var'           => true,
			'can_export'          => true,
			'rewrite'             => true,
			'capability_type'     => 'post',
			'supports'            => array('title')
		);
	
		register_post_type( 'wsrp_rating', $args );
	}
 
// CREATE TWO FUNCTIONS TO HANDLE THE COLUMN
function wsrp_custom_posts_column($defaults) {
	unset($defaults['date']);
    $defaults['rating_shortocode']  = 'Shortocode';
    return $defaults;
}
function wsrp_display_custom_column_data($column_name, $post_ID) {
    if ($column_name == 'rating_shortocode') {
        echo "<div style='padding: 7px 10px 8px 31px;background: #fff;border: 1px solid #D2D2D2;border-radius: 3px;width: 20%; min-width:200px;font-weight: bold;' >[wsrp_rating id='$post_ID']</div>";
    }
}
		
	

	public function wsrp_getIP() {

    $ip = $_SERVER['SERVER_ADDR'];

    if (PHP_OS == 'WINNT'){
        $ip = getHostByName(getHostName());
    }

    if (PHP_OS == 'Linux'){
        $command="/sbin/ifconfig";
        exec($command, $output);
        // var_dump($output);
        $pattern = '/inet addr:?([^ ]+)/';

        $ip = array();
        foreach ($output as $key => $subject) {
            $result = preg_match_all($pattern, $subject, $subpattern);
            if ($result == 1) {
                if ($subpattern[1][0] != "127.0.0.1")
                $ip = $subpattern[1][0];
            }
        }
    }
    return $ip;
}

	function wsrp_rating_shortcode($atts){
	   ob_start();
	  
		extract( shortcode_atts( array(

			'id' => null,

		), $atts ) );

	
		$wsrp_shortcode_enable = get_post_meta($id,'wsrp_shortcode_enable',true );
		$wsrp_rating_enable = get_post_meta($id,'wsrp_rating_enable',true);
		$wsrp_posts_enable = get_post_meta($id,'wsrp_rating_on_posts',true);
	    $wsrp_rating_on_pages = get_post_meta( $id,'wsrp_rating_on_pages',true);
	    $wsrp_rating_on_pages_posts = get_post_meta( $id,'wsrp_rating_on_pages_posts',true);

	  // if rating is enabled  

	  	// if shortcode is selected
	    if($wsrp_rating_enable == 1){
	    	$post_id = get_the_id();
			$url =  admin_url('admin-ajax.php?action=wsrp_rating'); 
			$user_ip = $this->wsrp_getIP();
			$selected_temp = get_post_meta( $id, 'wsrp_rating_layout', true );

		    
				
			switch ($selected_temp) {
				case 'layout':
					include_once WSRP_PLUGIN_PATH.'templates/template-1.php';
					break;

				case 'layout1':
					include_once WSRP_PLUGIN_PATH.'templates/template-2.php';
					break;

				case 'layout2':
					include_once WSRP_PLUGIN_PATH.'templates/template-3.php';
					break;
						
				case 'layout3':
					include_once WSRP_PLUGIN_PATH.'templates/template-4.php';
					break;
						
				case 'layout4':
					include_once WSRP_PLUGIN_PATH.'templates/template-5.php';
					break;
						
				case 'layout5':
					include_once WSRP_PLUGIN_PATH.'templates/template-6.php';
					break;
						
				case 'layout6':
					include_once WSRP_PLUGIN_PATH.'templates/template-7.php';
					break;						
					
				default:
					include_once WSRP_PLUGIN_PATH.'templates/template-1.php';
					break;
			}
			
		}
					  		   

	   return ob_get_clean();

} // shortcode function ends here



public function wsrp_content_filter($content){

$args = array(
	'posts_per_page'   => 5,
	'offset'           => 0,
	'orderby'          => 'date',
	'order'            => 'ASC',
	'post_type'        => 'wsrp_rating',
	'post_status'      => 'publish',
	);
	
	$posts = get_posts($args);

	$c_ID = 0;
	foreach ($posts as $rating) {
		$currentID = $rating->ID;
		$wsrp_rating_on_posts = get_post_meta( $currentID, 'wsrp_rating_on_posts', true ); 
		$wsrp_rating_on_pages = get_post_meta( $currentID, 'wsrp_rating_on_pages', true ); 
		$wsrp_rating_on_pages_posts = get_post_meta( $currentID, 'wsrp_rating_on_pages_posts', true ); 

		if ($wsrp_rating_on_posts == 1 && is_single()) {
			return do_shortcode($content)."<br/>".do_shortcode("[wsrp_rating id='$currentID']" );
		} elseif ($wsrp_rating_on_pages == 1 && is_page()) {
			return do_shortcode($content)."<br/>".do_shortcode("[wsrp_rating id='$currentID']" );
		} else{
			return do_shortcode($content);
		}

	}

	return do_shortcode($content);


}

function wsrp_rating_current_reset($post_id){
	if (is_admin()) {
	update_post_meta( $post_id, 'rating'," ", $unique = false);	
	}
}

function wsrp_rating_wp_ajax(){

function check_input($data)
{
	$allowed = array( 
        'a' => array( // on allow a tags
            'href' => array() // and those anchors can only have href attribute
        )
    );
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = wp_kses( $data,$allowed);
    return $data;
}
	
	$array_data = $_POST;
	
	$Rating_Id 			= check_input($array_data['Rating_ID']);
	$postID 			= check_input($array_data['id']);
	$user_IP 			= check_input($array_data['IP']);
	$value 				= check_input($array_data['value']);

	

	$ratings_data_array = get_post_meta( $Rating_Id, 'rating' , true );

	if ( ! is_array( $ratings_data_array ) )
		$ratings_data_array = array();

	if ( ! is_array( $ratings_data_array["$Rating_Id"] ) )
		$ratings_data_array = array();

	if ( ! is_array( $ratings_data_array["$Rating_Id"]["$postID"] ) )
		$ratings_data_array["$Rating_Id"]["$postID"] = array();

	if ( ! is_array( $ratings_data_array["$Rating_Id"]["$postID"]["$user_IP"] ) )
		$ratings_data_array["$Rating_Id"]["$postID"]["$user_IP"] = array();

	$ratings_data_array["$Rating_Id"]["$postID"]["$user_IP"] = array(
				'rate_value' => $value, 
			);

	//var_dump($ratings_data_array);

	
	update_post_meta( $Rating_Id, 'rating', $ratings_data_array, $unique = false);
}



public function wsrp_user_interface($post_id){

	$current_screen = get_current_screen();

	if ($current_screen->post_type === 'wsrp_rating') {
		include_once(WSRP_PLUGIN_PATH.'/UI/wsrp_user_interface.php');
	}

}


public function wsrp_save_metabox_data($post_id){


  	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
     
    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['wsrp_post_nonce'] ) || !wp_verify_nonce( $_POST['wsrp_post_nonce'], 'wsrp_metabox_nonce' ) ) return;
    
     
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;
     
    // now we can actually save the data
    $allowed = array( 
        'a' => array( // on allow a tags
            'href' => array() // and those anchors can only have href attribute
        )
    );
     
    // Make sure your data is set before trying to save it
    if(isset($_POST['wsrp_rating_enable'])){
        update_post_meta( $post_id, 'wsrp_rating_enable', wp_kses( $_POST['wsrp_rating_enable'], $allowed ) );
    }else{
    	update_post_meta( $post_id, 'wsrp_rating_enable', false);
    }

    if(isset($_POST['wsrp_rating_on_posts'])){
        update_post_meta( $post_id, 'wsrp_rating_on_posts', wp_kses( $_POST['wsrp_rating_on_posts'], $allowed ) );
    }else{
    	update_post_meta( $post_id, 'wsrp_rating_on_posts', false);
    }

    if(isset($_POST['wsrp_rating_on_pages'])){
        update_post_meta( $post_id, 'wsrp_rating_on_pages', wp_kses( $_POST['wsrp_rating_on_pages'], $allowed ) );
    }else{
    	update_post_meta( $post_id, 'wsrp_rating_on_pages', false);
    }

    if(isset($_POST['wsrp_rating_changeable'])){
        update_post_meta( $post_id, 'wsrp_rating_changeable', wp_kses( $_POST['wsrp_rating_changeable'], $allowed ) );
    }else{
    	update_post_meta( $post_id, 'wsrp_rating_changeable', false);
    }

    if( isset( $_POST['wsrp_rating_type'] ) )
        update_post_meta( $post_id, 'wsrp_rating_type', wp_kses( $_POST['wsrp_rating_type'], $allowed ) );

    if( isset( $_POST['wsrp_rating_max_value'] ) )
        update_post_meta( $post_id, 'wsrp_rating_max_value', wp_kses( $_POST['wsrp_rating_max_value'], $allowed ) );

    if( isset( $_POST['wsrp_rating_initial_value'] ) )
        update_post_meta( $post_id, 'wsrp_rating_initial_value', wp_kses( $_POST['wsrp_rating_initial_value'], $allowed ) );

    if( isset( $_POST['wsrp_rating_size'] ) )
        update_post_meta( $post_id, 'wsrp_rating_size', wp_kses( $_POST['wsrp_rating_size'], $allowed ) );

    if( isset( $_POST['wsrp_rating_bg_color'] ) )
        update_post_meta( $post_id, 'wsrp_rating_bg_color', wp_kses( $_POST['wsrp_rating_bg_color'], $allowed ) );

    if( isset( $_POST['wsrp_rating_hover_color'] ) )
        update_post_meta( $post_id, 'wsrp_rating_hover_color', wp_kses( $_POST['wsrp_rating_hover_color'], $allowed ) );

    if( isset( $_POST['wsrp_rating_container_color'] ) )
        update_post_meta( $post_id, 'wsrp_rating_container_color', wp_kses( $_POST['wsrp_rating_container_color'], $allowed ) );

    if( isset( $_POST['wsrp_rating_container_border'] ) )
        update_post_meta( $post_id, 'wsrp_rating_container_border', wp_kses( $_POST['wsrp_rating_container_border'], $allowed ) );

    if( isset( $_POST['wsrp_rating_container_border_radius'] ) )
        update_post_meta( $post_id, 'wsrp_rating_container_border_radius', wp_kses( $_POST['wsrp_rating_container_border_radius'], $allowed ) );

    if( isset( $_POST['wsrp_rating_layout'] ) )
        update_post_meta( $post_id, 'wsrp_rating_layout', wp_kses( $_POST['wsrp_rating_layout'], $allowed ) );

    if( isset( $_POST['wsrp_rating_container_height'] ) )
        update_post_meta( $post_id, 'wsrp_rating_container_height', wp_kses( $_POST['wsrp_rating_container_height'], $allowed ) );

    if( isset( $_POST['wsrp_rating_container_width'] ) )
        update_post_meta( $post_id, 'wsrp_rating_container_width', wp_kses( $_POST['wsrp_rating_container_width'], $allowed ) );

    if( isset( $_POST['wsrp_rating_text_color'] ) )
        update_post_meta( $post_id, 'wsrp_rating_text_color', wp_kses( $_POST['wsrp_rating_text_color'], $allowed ) );
}




}

?>