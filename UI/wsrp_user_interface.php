<?php wp_nonce_field(  'wsrp_metabox_nonce','wsrp_post_nonce' );
$postID = $post_id->ID;
 ?>
<div id="wsrp_shortcode"><p >Use this shortcode <b>[wsrp_rating id="<?php echo $postID; ?>"]</b></p></div>


<div class="wsrp-container">

  <ul class="tabs">
    <li class="tab-link" data-tab="tab-1">RATING SETTINGS</li>
    <li class="tab-link" data-tab="tab-2">RATING DESIGN</li>
    <li class="tab-link" data-tab="tab-3">RATING TEMPLATE</li>
  </ul>

  <div id="tab-1" class="tab-content current">
   <table class="form-table">
             <tr valign='top'>
                <th scope='row'><?php _e('Enable Plugin :');?></th>
                <td>
                    <div class="onoffswitch">
                     <input type="checkbox" name="wsrp_rating_enable" class="onoffswitch-checkbox"  id="myonoffswitch" value='1'<?php checked(1, get_post_meta($postID ,'wsrp_rating_enable', true)); ?> />
                     <label class="onoffswitch-label" for="myonoffswitch">
                     <span class="onoffswitch-inner"></span>
                     <span class="onoffswitch-switch"></span>
                     </label>
                    </div>
                </td>
            </tr>
             <tr valign='top'>
                <th scope='row'><?php _e('Show Ratings on posts :');?></th>
                <td>
                    <div class="onoffswitch">
                     <input type="checkbox" name="wsrp_rating_on_posts" class="onoffswitch-checkbox"  id="myonoffswitch1" value='1'<?php checked(1, get_post_meta($postID ,'wsrp_rating_on_posts', true)); ?> />
                     <label class="onoffswitch-label" for="myonoffswitch1">
                     <span class="onoffswitch-inner"></span>
                     <span class="onoffswitch-switch"></span>
                     </label>
                    </div>
                </td>
            </tr>
            <tr valign='top'>
                <th scope='row'><?php _e('Show Ratings on pages :');?></th>
                <td>
                    <div class="onoffswitch">
                     <input type="checkbox" name="wsrp_rating_on_pages" class="onoffswitch-checkbox"  id="myonoffswitch2" value='1'<?php checked(1, get_post_meta($postID ,'wsrp_rating_on_pages',true)); ?> />
                     <label class="onoffswitch-label" for="myonoffswitch2">
                     <span class="onoffswitch-inner"></span>
                     <span class="onoffswitch-switch"></span>
                     </label>
                    </div>
                </td>
            </tr>
            <tr valign='top'>
                <th scope='row'><?php _e('Is rating changeable :');?></th>
                <td>
                    <div class="onoffswitch">
                     <input type="checkbox" name="wsrp_rating_changeable" class="onoffswitch-checkbox"  id="myonoffswitch5" value='1'<?php checked(1, get_post_meta($postID ,'wsrp_rating_changeable',true)); ?> />
                     <label class="onoffswitch-label" for="myonoffswitch5">
                     <span class="onoffswitch-inner"></span>
                     <span class="onoffswitch-switch"></span>
                     </label>
                    </div>
                </td>
            </tr>
            <tr valign="top">
              <th scope="row"><?php _e('Rating Type'); ?></th>
              <td><label for="wsrp_rating_type">
                  <select name='wsrp_rating_type'>
                         <option value='utf8_star' <?php selected( get_post_meta($postID ,'wsrp_rating_type',true),'utf8_star'); ?> >Stars
                         </option>
                         <option disabled <?php selected( get_post_meta($postID ,'wsrp_rating_type',true),'fontawesome_star'); ?> >Stars 2
                         </option>
                         <option disabled >Hearts</option>
                         <option disabled >Hexagon</option>
                         <option disabled >Chess King</option>
                         <option disabled >Chess Queen</option>
                         <option disabled >Beer Glass</option>
                         <option disabled >Trophy</option>
                         <option disabled >Tree</option>
                         <option disabled >Ban Sign</option>
                         <option disabled >Thumbs Up</option>
                  </select>
                  <p class="description"><?php _e('Set rating style');?></p>
                  </label>
                  <p class="description"><?php _e( 'Unlock rating types in. <b>Premium Version <a href="http://web-settler.com/wp-rating/" target="_blank" >Unlock Here</a> </b>'); ?></p>
             </td>
            </tr
             <tr valign="top">
              <th scope="row"><?php _e('Rating Max Value'); ?></th>
              <td><label for="wsrp_rating_max_value">
                  <input type='range' step='5'  id='wsrp_rating_max_value' disabled min='0'  max='10'  oninput="this.form.amountInput1.value=this.value" /> <input type="number" disabled  name="amountInput1" min="0" max="10"  size='5' oninput="this.form.wsrp_rating_max_value.value=this.value" />
                  <p class="description"><?php _e( 'Set rating maximum value.'); ?></p>
                 </label>
                 <p class="description"><?php _e( 'Unlock rating maximum value in. <b>Premium Version <a href="http://web-settler.com/wp-rating/" target="_blank">Unlock Here</a> </b>'); ?></p>
             </td>
            </tr>
              <tr valign="top">
              <th scope="row"><?php _e('Rating Initial Value'); ?></th>
              <td><label for="wsrp_rating_initial_value">
                  <input type='range' step='1'  id='wsrp_rating_initial_value' name='wsrp_rating_initial_value' min='0'  max='10' disabled oninput="this.form.amountInput2.value=this.value" /> <input type="number"  name="amountInput2" min="0" max="10" disabled  oninput="this.form.wsrp_rating_initial_value.value=this.value" />
                  <p class="description"><?php _e( 'Set rating initial value.'); ?></p>
                 </label>
                 <p class="description"><?php _e( 'Unlock rating initial value in. <b>Premium Version <a href="http://web-settler.com/wp-rating/" target="_blank">Unlock Here</a> </b>'); ?></p>
             </td>
            </tr>
            <tr valign="top">
              <th scope="row"><?php _e('Rating Size'); ?></th>
              <td><label for="wsrp_rating_size">
                  <select name='wsrp_rating_size'>
                        <option disabled >Full</option>
                        <option value='0.5' <?php selected( get_post_meta($postID ,'wsrp_rating_size',true),'0.5'); ?> >Half
                        </option>
                  </select>
                  <p class="description"><?php _e('Set rating size');?></p>
                  </label>
                  <p class="description"><?php _e( 'Unlock rating size in. <b>Premium Version <a href="http://web-settler.com/wp-rating/" target="_blank">Unlock Here</a> </b>'); ?></p>
             </td>
            </tr>
        </table>
      </div>
      
    
  <div id="tab-2" class="tab-content">
     <table class='form-table'>
        <tr>
        <th scope='row'><?php _e('Rating Color');?></th>
        <td><label for='wsrp_rating_bg_color'>
          <input type='text' class="color_picker" id='wsrp_rating_bg_color' name='wsrp_rating_bg_color' value='<?php echo get_post_meta($postID ,'wsrp_rating_bg_color', true); ?>'/>
          <p class='description'><?php _e('Change background color') ;?></p>
        </label>
        </td>
      </tr>
        <tr>
        <th scope='row'><?php _e('Rating Hover Color');?></th>
        <td><label for='wsrp_rating_hover_color'>
          <input type='text' class="color_picker" id='wsrp_rating_hover_color' name='wsrp_rating_hover_color' value='<?php echo get_post_meta($postID ,'wsrp_rating_hover_color',true ); ?>'/>
          <p class='description'><?php _e('Change hover over color') ;?></p>
        </label>
        </td>
      </tr>
      <tr>
        <th scope='row'><?php _e('Rating Text Color');?></th>
        <td><label for='wsrp_rating_text_color'>
          <input type='color'  disabled id='wsrp_rating_text_color' name='wsrp_rating_text_color' />
          <p class='description'><?php _e('Change rating text color') ;?></p>
        </label>
        <p class="description"><?php _e( 'Unlock rating color option in. <b>Premium Version <a href="http://web-settler.com/wp-rating/" target="_blank">Unlock Here</a> </b>'); ?></p>
        </td>
      </tr>
       <tr>
        <th scope='row'><?php _e(' Ratings Container Background Color');?></th>
        <td><label for='wsrp_rating_container_color'>
          <input type='color'  disabled id='wsrp_rating_container_color' name='wsrp_rating_container_color' />
          <p class='description'><?php _e('Change Rating container background color') ;?></p>
        </label>
        <p class="description"><?php _e( 'Unlock rating color option in. <b>Premium Version <a href="http://web-settler.com/wp-rating/" target="_blank">Unlock Here</a> </b>'); ?></p>
        </td>
      </tr>
       <tr>
        <th scope='row'><?php _e('Rating Container Border Color');?></th>
        <td><label for='wsrp_rating_container_border'>
          <input type='color'  disabled id='wsrp_rating_container_border' name='wsrp_rating_container_border' />
          <p class='description'><?php _e('Change rating container border color') ;?></p>
        </label>
        <p class="description"><?php _e( 'Unlock rating color option in. <b>Premium Version <a href="http://web-settler.com/wp-rating/" target="_blank">Unlock Here</a> </b>'); ?></p>
        </td>
      </tr>
      <tr valign="top">
        <th scope="row"><?php _e('Rating Container Width'); ?></th>
          <td><label for="wsrp_rating_container_width">
            <input type="number" disabled  name="wsrp_rating_container_width" min="0"  max="100"  /> %
            <p class="description"><?php _e( 'Set Container width in percentage.'); ?></p>
            </label>
            <p class="description"><?php _e( 'Unlock rating container width in. <b>Premium Version <a href="http://web-settler.com/wp-rating/" target="_blank">Unlock Here</a> </b>'); ?></p>
          </td>
      </tr>


  </table>
  </div>
  <div id="tab-3" class="tab-content">
    <table class='form-table'>

         <tr valign='top'>
            <th scope='row'><?php _e('Select Rating Layout');?></th>
            <td>

              <div id="left">
                
                <div  class="wsrp-mox">
              <p class="pp"style='padding:0px 0px 0px 20px ;'>Default <input type="radio" name="wsrp_rating_layout" id="layout" value="layout" <?php  checked('layout', get_post_meta($postID,'wsrp_rating_layout',true)); true ?> /></p> 
              <label for='layout'><img style='padding:0px 30px 30px 0px' class="wsrp-temp-img"  src='<?php echo WSRP_PLUGIN_URL.'/img/template1.png'; ?>' /> </label>
              </div>


              <div  class="wsrp-mox">
              <p class="pp"style='padding:0px 0px 0px 20px ;'>Layout 2  Premium <a href="http://web-settler.com/wp-rating/" target="_blank">Buy Pro </a> </p> <input type="radio"  name="wsrp_rating_layout" id="layout2" disabled /></p>
              <label for='layout2'><img style='padding:0px 30px 160px 0px;'  class="wsrp-temp-img" src='<?php echo WSRP_PLUGIN_URL.'/img/template3.png'; ?>' /> </label>
              </div>


              <div  class="wsrp-mox" style="margin-top:35%;">
              <p class="pp"style='padding:0px 0px 0px 20px ;'>Layout 4  Premium <a href="http://web-settler.com/wp-rating/" target="_blank">Buy Pro </a> <input type="radio"   name="wsrp_rating_layout" id="layout4" disabled /></p>
              <label for='layout4'><img style='padding:0px 30px 30px 0px' class="wsrp-temp-img" src='<?php echo WSRP_PLUGIN_URL.'/img/template5.png'; ?>' /> </label> 
              </div>

              <div  class="wsrp-mox">
              <p class="pp"style='padding:0px 0px 0px 20px ;'>Layout 6  Premium <a href="http://web-settler.com/wp-rating/" target="_blank">Buy Pro </a><input type="radio"   name="wsrp_rating_layout" id="layout6" disabled /></p>
              <label for='layout6'><img style='padding:0px 30px 30px 0px' class="wsrp-temp-img" src='<?php echo WSRP_PLUGIN_URL.'/img/template7.png'; ?>' /> </label> 
              </div>


              </div> 

              <div id="right">
                
                <div  class="wsrp-mox">
              <p class="pp"style='padding:0px 0px 0px 20px ;'>Layout 1  Premium <a href="http://web-settler.com/wp-rating/" target="_blank">Buy Pro </a> <input type="radio"  name="wsrp_rating_layout" id="layout1" disabled /> </p>
              <label for='layout1'><img style='padding:0px 30px 30px 0px' class="wsrp-temp-img" src='<?php echo WSRP_PLUGIN_URL.'/img/template2.png'; ?>' /> </label>        
              </div>

              <div  class="wsrp-mox">
              <p class="pp"style='padding:0px 0px 0px 20px ;'>Layout 3   Premium <a href="http://web-settler.com/wp-rating/" target="_blank">Buy Pro </a><input type="radio"   name="wsrp_rating_layout" id="layout3" disabled /></p>
              <label for='layout3'><img style='padding:0px 30px 30px 0px' class="wsrp-temp-img" src='<?php echo WSRP_PLUGIN_URL.'/img/template4.png'; ?>' /> </label> 
              </div>

              <div  class="wsrp-mox">
              <p class="pp"style='padding:0px 0px 0px 20px ;'>Layout 5   Premium <a href="http://web-settler.com/wp-rating/" target="_blank">Buy Pro </a><input type="radio"   name="wsrp_rating_layout" id="layout5" disabled /></p>
              <label for='layout5'><img style='padding:0px 30px 30px 0px' class="wsrp-temp-img" src='<?php echo WSRP_PLUGIN_URL.'/img/template6.png'; ?>' /> </label> 
              </div>

              <div  class="wsrp-mox">
              <p class="pp"style='padding:0px 0px 0px 20px ;'>Layout 7   Premium <a href="http://web-settler.com/wp-rating/" target="_blank">Buy Pro </a><input type="radio"   name="wsrp_rating_layout" id="layout5" disabled /></p>
              <label for='layout5'><img style='padding:0px 30px 30px 0px' class="wsrp-temp-img" src='<?php echo WSRP_PLUGIN_URL.'/img/template8.png'; ?>' /> </label> 
              </div>

              </div> 
              
              </td>
            </tr>


            </table>

  </div>

</div><!-- container -->