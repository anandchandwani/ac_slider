<html>
<head>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<style type="text/css">	
#wrap {
    width:40%;
    float:right;
    margin-top:150px;
    margin-right:50px;
}
.hndle span {
     margin-left:182px;
     margin-bottom:2px;
}
.save_btn {
	color:white;
	border:1px rebeccapurple;
	background-color:rebeccapurple;
	margin-left:180px;
	width:100px;
	height:30px;
}
.del_btn {
	width:100px;
	height:30px;
    color: #555;
    border-color: #ccc;
    background: #f7f7f7;
    box-shadow: 0 1px 0 #ccc;
    vertical-align: top;
}
.ui-state-default{
    cursor:move;
}
.ui-state-default {
	clear: left;
	float: left;
}

.image_wrapper{
height:110px;
overflow:hidden ! important;
margin-bottom: 4px;

}
ul#sortable:after {
    content: ' ';
    visibility: hidden;
    clear: both;
    display: block;
}
</style>
</head>
<body>
<div "wrapper">
 <div id="wrap">
   <div id="advanced-sortables" class="meta-box-sortables ui-sortable">
      <div id="ssp_slider_options_metabox" class="postbox ">
         <h2 class="hndle ui-sortable-handle"><span>Options</span></h2>
            <div class="inside">
              <form method="post">
			   <table class="ssp_input widefat" id="ssp_slider_options">
	              <tbody>
		             <tr id="slider_slideshow">
			            	<td class="label">
					            <label>
						             Slideshow	
						         </label>
					               <p class="description">( Animate slider automatically )</p>		
				            </td>
				            <td>
					           <p>
						          <label>
							        <input type="radio" name="autoplay" value="true" <?php if($option['autoplay']==='true'){echo "checked=checked";}?>> Yes	
							      </label>				 
					           </p>
					           <p>
						          <label>
							           <input type="radio" name="autoplay" value="false" <?php if($option['autoplay']==='false'){echo "checked=checked";}?> > No
							      </label>					
					           </p>
				           </td>
			           </tr>

			           <tr id="slider_animation_speed">			
				          <td class="label">
					          <label>Animation speed</label>
					             <p class="description"></p>
				           </td>
				         <td>
				            <p>
				              <label>
				                  <input type="text" style="width: 80%" name="speed" value="<?php echo $option['speed']?>">Seconds
				             </label>
				          </p>
				       </td>
			         </tr>
			
			<tr id="slider_controls">
			   <td class="label">
				  <label>Navigation</label>
				  	<p class="description">( Enable or Disable different navigation)</p>

			    </td>
				<td>
					<p>
				      <label>
						<input type="checkbox" name="nav" value="true" <?php  if($option['nav']==='true'){echo "checked=checked";} ?>> Previous/Next
					  </label>
					</p>
					
				</td>
			 </tr>	
			 <tr id="slider_controls">
			   <td class="label">
				  <label>Pause</label>
				  	<p class="description">( Enable or Disable pause on hover options )</p>

			    </td>
				<td>
					<p>
				      <label>
						<input type="checkbox" name="pause" value="true" <?php  if($option['pause']==='true'){echo "checked=checked";} ?>> Pause
					  </label>
					</p>
					
				</td>
				
			 </tr>	
			 <tr><td><button name="save" class="save_btn">Save</button></td></tr>
	           </tbody>
           </table>
         </form>  
       </div>
  </div>
</div>
</div>
<p><br/></p>

<div id="dk-slider-page">
	<p>
		<button class="set_custom_images button save_btn">Add image</button>
	</p>
	<img id="dk-slider-preview">
	<h2>Set image Order By Drag and Drop</h2>
</div>
<script type="text/javascript">
jQuery(document).ready(function($){
   if ($('.set_custom_images').length > 0) {
    if ( typeof wp !== 'undefined' && wp.media && wp.media.editor) {
        $('#dk-slider-page').on('click', '.set_custom_images', function(e) {
            e.preventDefault();
            var button = $(this);
            var id = $('#process_custom_images1');
            wp.media.editor.send.attachment = function(props, attachment) {
            id.val(attachment.id);
            var attachment_id=attachment.id;
          
               
            var data = {

			  'action': 'my_action',
			  'whatever': attachment_id

		   };

		    jQuery.post(ajaxurl, data, function(response) {

		    $("#sortable").append(response);
		    $(".").css({'width':"320","height":"110"});

		    
		  });
            };
            wp.media.editor.open(button);
            return false;
        });
    }
}
 if ($('.set_custom_images').length > 0) {
 	
    if ( typeof wp !== 'undefined' && wp.media && wp.media.editor) {
        $(document).on('click', '.set_custom_images', function(e) {
            e.preventDefault();
            var button = $(this);
            var id = $('.process_custom_images1');
            var post_id=$(this).data("post-id");
            var img=$(this).parent().parent().find('.imgs');


          
            wp.media.editor.send.attachment = function(props, attachment) {
            	var attachment_id=attachment.id;
            	var data = {
            		'action': 'my_action_2',
            		'attachment_id': attachment_id,
            		'post_id':post_id
            	};

            	jQuery.post(ajaxurl, data, function(response) {
            		console.log(attachment);
            		img.attr('srcset',attachment.url);
            		img.css({'width':"320","height":"110"});
            	});

            };
            wp.media.editor.open(button);
            return false;
        });

    }
}
$(document).on("click",'.del_btn',function(){

 var post_id=jQuery(this).data('post-id');
     var data = {
			'action': 'delete',
			 'post_id':post_id
		   };

		  jQuery.post(ajaxurl, data, function(response) {
	
		});
		  $(this).parent().parent().remove();

});

 $(function() {
   jQuery( "#sortable" ).sortable({
});
 jQuery(".form").submit(function(e){
    e.preventDefault();
       var data = {
			'action': 'my_action_1',
			'order': $('.form').serializeArray()
		   };

		    jQuery.post(ajaxurl, data, function(response) {
	
		});
   
 });
    jQuery( "#sortable" ).disableSelection();
  });

});
</script>
</body>
</div>
 
  
   
 