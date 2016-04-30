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

			  'action': 'add_image',
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
            		'action': 'edit_image',
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
			'action': 'delete_image',
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
			'action': 'order_image',
			'order': $('.form').serializeArray()
		   };

		    jQuery.post(ajaxurl, data, function(response) {
	
		});
   
 });
    jQuery( "#sortable" ).disableSelection();
  });

});