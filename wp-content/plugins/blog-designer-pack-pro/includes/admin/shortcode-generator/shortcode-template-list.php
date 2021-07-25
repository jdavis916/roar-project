<?php
/**
 * Shortcode Template List Class
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Taking some variables
$shrt_gen_page = add_query_arg( array('page' => 'bdpp-shrt-generator'), admin_url('admin.php'));

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class BDPP_Shrt_Tmpl_List extends WP_List_Table {

	var $template_data, $per_page;

	function __construct() {

        // Set parent defaults
        parent::__construct( array(
										'singular'  => 'bdpp_tmpl',	// singular name of the listed records
										'plural'    => 'bdpp_tmpls', // plural name of the listed records
										'ajax'      => false        // does this table support ajax?
									));

        $template_data = get_option( 'bdpp_shrt_tmpl' );

        $this->template_data = ( !empty( $template_data ) && is_array( $template_data ) ) ? $template_data : array();
		$this->per_page	= apply_filters( 'bdpp_tmpl_list_per_page', 15 ); // Per page
    }

    /**
	 * Displaying shortcode templates
	 * 
	 * Does prepare the data for displaying the products in the table.
	 * 
	 * @package Blog Designer Pack Pro
 	 * @since 1.0
	 */
	function bdpp_display_shrt_tmpl() {

		// Taking parameter
		$data = array();
		$page = ( !empty($_GET['paged']) && $_GET['paged'] > 1 ) ? $_GET['paged'] : 1;

		// start position in the array
	    // +1 is to account for total values.
	    $start = ( ($page - 1) * ($this->per_page) );

	    // Get template data
	    $tmpl_data = array_slice( $this->template_data, $start, $this->per_page );

		if( !empty( $tmpl_data ) ) {
			foreach ( $tmpl_data as $key => $value ) {
				$data[$key]['id'] 			= $value['id'];
				$data[$key]['type'] 		= $value['type'];
				$data[$key]['name'] 		= $value['name'];
				$data[$key]['enable'] 		= ( $value['enable'] ) ? '<i class="dashicons dashicons-yes"></i>' : '<i class="dashicons dashicons-no"></i>';
				$data[$key]['shortcode'] 	= '<span class="bdpp-shrt-preview">[bdpp_tmpl id="'.$value['id'].'"]</span>';
			}
		}

		$result_arr['data']		= !empty($data) ? $data : array();
		$result_arr['total'] 	= count( $this->template_data ); // Total no of data

		return $result_arr;
	}
	
	/**
	 * Mange column data
	 * 
	 * Default Column for listing table
	 * 
	 * @package Blog Designer Pack Pro
 	 * @since 1.0
	 */
	function column_default( $item, $column_name ) {
		
        switch( $column_name ) {
            default:
				$default_val = $item[ $column_name ];
				break;
        }
        return apply_filters( 'bdpp_shrt_tmpl_column_value', $default_val, $column_name, $item );
    }
	
    /**
	 * Handles checkbox HTML
	 * 
	 * @package Blog Designer Pack Pro
 	 * @since 1.0
	 **/
    function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            /*$1%s*/ $this->_args['singular'],  // Let's simply repurpose the table's singular label ("movie")
            /*$2%s*/ $item['id']                // The value of the checkbox should be the record's id
        );
    }
    
    /**
     * Manage Post Title Column
     *
     * @package Blog Designer Pack Pro
     * @since 1.0
     */
    function column_name($item) {
    	
    	$paged 		= isset($_GET['paged']) ? $_GET['paged'] : false;
    	$page_url	= add_query_arg( array( 'page' => 'bdpp-templates', 'paged' => $paged ), admin_url('admin.php') );
    	$view_link 	= add_query_arg( array('page' => 'bdpp-shrt-generator', 'shortcode' => $item['type'], 'tmpl_id' => $item['id'] ), admin_url('admin.php') );
    	$del_link 	= add_query_arg( array('action' => 'delete', 'bdpp_tmpl[]' => $item['id'] ), $page_url );

    	$actions['view'] 	= sprintf( '<a class="bdpp-shrt-tmpl-view" href="%s">'.__('View', 'blog-designer-pack').'</a>', $view_link );
    	$actions['delete'] 	= sprintf( '<a class="bdpp-shrt-tmpl-delete bdpp-confirm" href="%s">'.__('Delete', 'blog-designer-pack').'</a>', $del_link );

    	$actions = apply_filters( 'bdpp_shrt_tmpl_row_actions', $actions, $item ); // Filter to add row actions

        // Return title contents	        
        return sprintf('%1$s %2$s',
            /*$1%s*/ $item['name'],
            /*$2%s*/ $this->row_actions( $actions )
        );
    }
    
    /**
     * Display Columns
     * 
     * Handles which columns to show in table
     * 
	 * @package Blog Designer Pack Pro
 	 * @since 1.0
     */
	function get_columns() {
		
		$columns = array(
							'cb'      	=> '<input type="checkbox" />',
							'name'		=> __( 'Template Name', 'blog-designer-pack' ),
							'shortcode' => __( 'Shortcode', 'blog-designer-pack' ),
							'enable'	=> __( 'Live', 'blog-designer-pack' ),
						);
		return apply_filters('bdpp_shrt_tmpl_list_columns', $columns);
	}
	
    /**
     * Sortable Columns
     *
     * Handles soratable columns of the table
     * 
	 * @package Blog Designer Pack Pro
 	 * @since 1.0
     */
	function get_sortable_columns() {
		
		$sortable_columns = array();
		
		return apply_filters('bdpp_shrt_tmpl_list_sortable_columns', $sortable_columns);
	}
	
	/**
	 * Message to show when no records in database table
	 *
	 * @package Blog Designer Pack Pro
 	 * @since 1.0
	 */
	function no_items() {
		$shrt_generator = add_query_arg( array('page' => 'bdpp-shrt-generator'), admin_url('admin.php') );
		echo apply_filters( 'bdpp_shrt_tmpl_no_item_msg', esc_html__('No shortcode template found', 'blog-designer-pack') );
	}

	/**
	 * Show the search field
	 *
	 * @param string $text Label for the search box
	 * @param string $input_id ID of the search box
	 *
	 * @package Blog Designer Pack Pro
 	 * @since 1.0
	 */
	public function search_box( $text, $input_id ) {

		$input_id = $input_id . '-search-input';

		if ( ! empty( $_REQUEST['orderby'] ) ) {
			echo '<input type="hidden" name="orderby" value="' . esc_attr( $_REQUEST['orderby'] ) . '" />';
		}
		if ( ! empty( $_REQUEST['order'] ) ) {
			echo '<input type="hidden" name="order" value="' . esc_attr( $_REQUEST['order'] ) . '" />';
		}
		?>
		<div id="bdpp-shrt-tmpl-list-search" class="bdpp-shrt-tmpl-list-search bdpp-clearfix">
			<p class="search-box">
				<label class="screen-reader-text" for="<?php echo $input_id ?>"><?php echo $text; ?>:</label>
				<input type="search" id="<?php echo $input_id ?>" name="s" value="<?php _admin_search_query(); ?>" />
				<?php submit_button( $text, 'button', false, false, array('ID' => 'search-submit') ); ?>
			</p>
		</div><!-- end .bdpp-shrt-tmpl-list-search -->
		<?php
	}
	
	/**
     * Bulk actions field
     *
     * Handles Bulk Action combo box values
     * 
	 * @package Blog Designer Pack Pro
 	 * @since 1.0
     */
	function get_bulk_actions() {
        $actions = array(
							'delete' => __('Delete', 'blog-designer-pack')
						);
        return apply_filters('bdpp_shrt_tmpl_list_bulk_act', $actions);
	}
	
	/**
	 * Add Filter for Sorting
	 * 
	 * @package Blog Designer Pack Pro
 	 * @since 1.0
	 **/
	function extra_tablenav( $which ) {
		
		if( $which == 'top' ) {
			
			$html = '';
			$html .= '<div class="alignleft actions bdpp-shrt-tmpl-list-act">';
			
			// Action for third party filter
			ob_start();
			do_action( 'bdpp_shrt_tmpl_list_filter' );
			$html .=ob_get_clean();
			
			$html .= '</div><!-- end .bdpp-shrt-tmpl-list-act -->';
			
			echo $html;
    	}
    }
    
    /**
	 * Prepare Items to display
	 * 
	 * @package Blog Designer Pack Pro
 	 * @since 1.0
	 **/
	function prepare_items() {
        
        // Get how many records per page to show
        $per_page	= $this->per_page;
        
        // Get All, Hidden, Sortable columns
        $columns	= $this->get_columns();
        $hidden 	= array();
        $sortable 	= $this->get_sortable_columns();
        
		// Get final column header
        $this->_column_headers = array($columns, $hidden, $sortable);
		
		// Get Data of particular page
		$data_res 	= $this->bdpp_display_shrt_tmpl();
		$data 		= $data_res['data'];
   		
		// Get current page number
        $current_page = $this->get_pagenum();
        
		// Get total count
        $total_items  = $data_res['total'];
		
        // Get page items
        $this->items = $data;
        
		// Register pagination options and calculations.
        $this->set_pagination_args( array(
									            'total_items' => $total_items,                  // Calculate the total number of items
									            'per_page'    => $per_page,                     // Determine how many items to show on a page
									            'total_pages' => ceil($total_items / $per_page)	// Calculate the total number of pages
									        ));
    }
    
    /**
	 * Retrieve the view types
	 *
	 * @access public
	 * @since 1.0
	 * @return array $views All the views available
	 */
	public function get_views() {
		
		$all_counts = count( $this->template_data );
		$page_url 	= add_query_arg( array('page' => 'bdpp-templates'), admin_url('admin.php'));
		
		$current		= isset( $_GET['status'] ) ? $_GET['status'] : '';
		$total_count	= '&nbsp;<span class="count">(' . $all_counts    . ')</span>';

		$views = array(
			'all' => sprintf( '<a href="%s"%s>%s</a>', remove_query_arg( array( 'status', 'paged' ), $page_url ), $current === 'all' || $current == '' ? ' class="current"' : '', __('All', 'blog-designer-pack' ) . $total_count ),
		);

		return apply_filters( 'bdpp_shrt_tmpl_list_views', $views );
	}
}

// Create an instance of Log class
$bdpp_shrt_tmpl_list = new BDPP_Shrt_Tmpl_List();

// Fetch, prepare, sort, and filter data
$bdpp_shrt_tmpl_list->prepare_items();
?>

<div class="wrap bdpp-shrt-tmpl-list-wrp">

	<h1 class="wp-heading-inline"><?php _e( 'Shortcode Templates', 'blog-designer-pack' ); ?></h1>
	<a href="<?php echo esc_url( $shrt_gen_page ); ?>" class="page-title-action"><?php _e('Add New', 'blog-designer-pack'); ?></a>
    <hr class="wp-header-end">

    <?php
    if( !empty($_GET['message']) && $_GET['message'] == 1 ) {
    	echo '<div class="updated notice notice-success is-dismissible">
				<p><strong>'.__('Shortcode template deleted successfully.', 'blog-designer-pack').'</strong></p>
		      </div>';
    }
    ?>
    
    <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
    <form id="bdpp-shrt-tmpls-list-frm" class="bdpp-shrt-tmpls-list-frm" method="get" action="">
        
    	<!-- For plugins, we also need to ensure that the form posts back to our current page -->
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
        
		<?php $bdpp_shrt_tmpl_list->views(); // Showing sorting links on the top of the list ?>

        <!-- Now we can render the completed list table -->
        <?php $bdpp_shrt_tmpl_list->display(); ?>

    </form><!-- end .bdpp-shrt-tmpls-list-frm -->

</div><!-- end .wrap -->