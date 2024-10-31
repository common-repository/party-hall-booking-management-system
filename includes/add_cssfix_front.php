<?php
if (!defined('ABSPATH')) exit;
?>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#frmCssFix').on('submit',function(e){
		e.preventDefault();
		sc_save_CssFixFront();
	});
	
});	

function sc_save_CssFixFront(){
	var css = jQuery('#cssfix').val();
	if(css == ""){
		alert('<?php _e("Field is Empty","sc-scbooking"); ?>');
		return;
	}
	jQuery.ajax({
			type: "POST",
      url: '<?php echo admin_url( 'admin-ajax.php' );?>?cssfix=front',
			data: {
        action:'sc_save_cssfixfront',
        css : css 
      },
			success: function (data) {
					console.log(data);
					if(data.length>0){
						alert('<?php _e("added successfully","sc-scbooking"); ?>');
					}
			},
			error : function(s , i , error){
					console.log(error);
			}
	});
}	
</script>

<div class="wrapper">
  <div class="wrap" style="float:left; width:95%;">
    <div id="icon-options-general" class="icon32"></div>
    <!--<div style="width:70%;float:left;"><h2><?php //_e("Hotel Booking","sc-scbooking"); ?></h2></div> -->
       <div class="main_div">
     	<div class="metabox-holder" style="width:98%; float:left;">
          <div id="namediv" class="stuffbox" style="width:60%;">
          	<h3 class="top_bar"><?php _e("FrontEnd Css Fix :","sc-scbooking"); ?></h3>
         	<form id="frmCssFix" action="" method="post" style="width:100%">
                <table style="margin:10px;width:300px;">
                    <tr>
                        <td><?php _e("CSS:","sc-scbooking"); ?> </td>
                        <td><textarea cols="50" rows="10" id="cssfix" class="rounded" name="details"><?php echo get_option('cssfix_front');?></textarea> </td>
                    </tr>
                    <tr><td colspan="2"></td></tr>
                    <tr>
                      <td></td>
                      <td>
                      	<input type="submit" id="btnaddcssfix" name="btnaddcssfix" class="button button-primary" value="<?php _e("Add Css","sc-scbooking"); ?>" style="width:150px;"/>
                      </td>
                    </tr>
                </table>	
             </form>	 
          </div>
        </div>
       </div>  
  </div>
</div>