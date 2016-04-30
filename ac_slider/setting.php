<html>
 <head>
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
			 <tr>
			      <td><button name="save" class="save_btn">Save</button></td>
			 </tr>
	           </tbody>
           </table>
         </form>  
       </div>
   </div>
  </div>
 </div>
	<div id="dk-slider-page">
		<p>
		   <button class="set_custom_images button save_btn">Add image</button>
		</p>
	    <img id="dk-slider-preview">
		<h2>Set image Order By Drag and Drop</h2>
	</div>
</body>
</html>

 
  
   
 