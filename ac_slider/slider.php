<?php
/*Plugin Name:slider*/  

add_action('init',"slider_register_post_type");
add_action('init',"update_options");
// ragister post 
 function slider_register_post_type(){
 	add_image_size( 'fpw_custom_thumbnail-1', 320);
   $args=array(
         "public"=>true,
         'supports' => array('title','editor','thumbnail'),
         'label'=>'ac_slider'
   );

   register_post_type('slider', $args);

}


function update_options() {

  if(!get_option('ac_slider')){

    $option_array=array(
              "autoplay"=>"false",
              "speed"=>"1000",
              "nav"=>"true",
              "pause"=>"false"
      );

   update_option("ac_slider",$option_array);
   //update default options for jquery plugin 
}

}

 // add support for featured image
 function custom_theme_setup() {

	add_theme_support( 'post-thumbnails' );

}


 add_action( 'after_setup_theme', 'custom_theme_setup' );

// ragister script and style 
function slider_ragister_script(){

  wp_enqueue_script('jquery_min',plugins_url('/js/jquery-1.11.3.min.js',__FILE__),true);
  wp_enqueue_script( 'slider_responsiveslides_js', plugins_url('/js/responsiveslides.min.js',__FILE__), array( 'jquery_min' ));
  wp_enqueue_style( 'slider_responsiveslides_css', plugins_url('/css/responsiveslides.css',__FILE__));
  wp_enqueue_style( 'slider_demo_css', plugins_url('/css/demo.css',__FILE__)); 
 

}

add_action('wp_enqueue_scripts', 'slider_ragister_script');
add_action( 'admin_enqueue_scripts', 'load_admin_files' );

//load js and css files for admin page
function load_admin_files() {
    wp_enqueue_media();
    wp_enqueue_script( 'custom_js', plugins_url('/js/custom.js',__FILE__));
    wp_enqueue_style( 'style_css', plugins_url('/css/style.css',__FILE__)); 

}


// image slider for frontend
 function image_slider($atts){

  global $post;
	 
 $args1=array('post_type' => 'slider',
  'orderby'=>'menu_order',
  'order'=>'asc'
  );
       
       $loop1 = new wp_query($args1); 

	$result = '';
	$result."<div id='wrapper'>";
	$result.="<div class='callbacks_container'>";
  $result .="<ul class='rslides' id='slider2'>";
      
   

    while($loop1->have_posts())
    {
  
    	   	$loop1->the_post();

      $result.='<li><a href="#" alt=""><div class="image_wrapper_frontend">'.get_the_post_thumbnail( ).'</div></a></li>';
      
    }

    $result.="</ul>";
    $result.="</div>";
    $result.="</div>";
    

 	 return $result;

}


add_shortcode( 'slider', 'image_slider' );

add_action('admin_menu', 'slider_menu');

//ragister submenu in backend 
  function slider_menu() {

   add_submenu_page('edit.php?post_type=slider', __('Settings', 'Settings-domain'), __('Settings', 'Settings-domain'), 'manage_options', 'slider-settings', 'submenu_Settings');

  }

 function submenu_Settings(){
    	if(isset($_POST['save']))
    	{

     		update_option("ac_slider",$_POST);
     	} 

        $option=get_option('ac_slider');

        require_once('setting.php');    

         $args=array('post_type' => 'slider',
                     'orderby'=>'menu_order',
                     'order'=>'asc'
         );
       
       $loop2 = new wp_query($args);  

      $html='';
      $html.="<form method='post' class='form'>";
      $html.="<ul id='sortable'>";
  
    while($loop2->have_posts())
     {
     
          $loop2->the_post();

      $html.= "<li class='ui-state-default'><div class='image_wrapper'>".get_the_post_thumbnail($post_id,"fpw_custom_thumbnail-1",array("class"=>"imgs"))."</div>";
      $html.="<input type='hidden' name='post_id'  value=".get_the_id().">";
      
      $html.="<div class='dk-slider-page' >
                  <button class='set_custom_images button save_btn' data-post-id=".get_the_id().">Edit</button>
                  
                  <button class='button del_btn' data-post-id=".get_the_id().">Delete</button>
              </div>
             </li>";
    }
      
      $html.="</ul>";
      $html.="<input type='submit' value='save' class=save_btn>";
      $html.= "</form>";
      echo $html;
    }
 

  add_action( 'wp_ajax_add_image', 'ac_add_image' );
  add_action( 'wp_ajax_order_image', 'ac_set_order_image');
  add_action( 'wp_ajax_edi_image', 'ac_edit_image' );
  add_action( 'wp_ajax_delete_image', 'ac_delete_image');
  
  


//add  image in backend setting page
function ac_add_image() {


$my_post = array(
  'post_status'   => 'publish',
  'post_author'   => 1,
  'post_category' => array( 8,39 ),
  'post_type'=>'slider'
);
 
// Insert the post into the database
 $post_id=wp_insert_post( $my_post );


  //setting  fetuared image
 set_post_thumbnail( $post_id, $_POST['whatever']);

   $args3=array('post_type' => 'slider',
                     'orderby'=>'menu_order',
                     'order'=>'asc'
         );
       
       $loop2 = new wp_query($args3);  
       $html='';

    while($loop2->have_posts())
     {
     
          $loop2->the_post();

      $html.= "<li class='ui-state-default'><div class='image_wrapper'>".get_the_post_thumbnail($post_id,'fpw_custom_thumbnail-1',array("class"=>"imgs"))."</div>";
      $html.="<input type='hidden' name='post_id'  value=".get_the_id().">";
      
      $html.="<div class='dk-slider-page' >
                  <button class='set_custom_images button save_btn' data-post-id=".get_the_id().">Edit</button>
                  
                  <button class='del_btn' data-post-id=".get_the_id().">Delete</button>
              </div>
             </li>";

          wp_reset_postdata();
 
          wp_die($html);
    }



 }
 //set image order for display image
function ac_set_order_image() {
  global $wpdb;

  $i=1;

      foreach ($_POST['order'] as $key => $post_id)
    {
        $data = array('menu_order' => $i);

         // Update the post into the database
        echo $wpdb->update('wp_posts', $data, array('ID' => $post_id['value']) );

                        $i++;
     }
}
// edit image from backend
function ac_edit_image() {

 set_post_thumbnail($_POST['post_id'], $_POST['attachment_id']);
}

// delete image from backend
function ac_delete_image(){

wp_delete_post($_POST['post_id']);

}

//update plugin  options from backend
function custom_script(){
  $option=get_option('ac_slider');
?>

  <script type="text/javascript">    	   
			$(document).ready(function ($) {

		  $("#slider2").responsiveSlides ({
		    auto:<?php echo $option['autoplay'];?>,
		    nav:<?php if($option['nav']==true){echo $option['nav'];}else{echo "false";}?>,
		    speed:<?php echo $option['speed']."000";?>,
		    pause:<?php if($option['pause']==true){echo $option['pause'];}else{echo "false";}?>,
		    namespace: "callbacks"
     });

 });

</script>
<?php
}
add_action('wp_footer', 'custom_script');
 
?>