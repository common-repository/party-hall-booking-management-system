jQuery(document).ready(function(){
  jQuery('.scpd_gateway').hide();
  jQuery('.scpd_gateway :input').prop('disabled',true);
  jQuery('.checkout_gateway').change(function(){
    var gatewayid = jQuery(this).val();
    jQuery('.scpd_gateway').hide();
    jQuery('.scpd_gateway :input').prop('disabled',true);
    jQuery('.scpd_gateway_'+gatewayid).show();
    jQuery('.scpd_gateway_'+gatewayid+' :input').prop('disabled',false);
  });
  
  jQuery('.scpd_checkout_title').click(function(e){ 
    if(jQuery(this).parent().hasClass('enable')){
      jQuery(this).parent().nextAll().removeClass('enable');
      jQuery(this).parent().nextAll().find('.scpd_checkout_title').removeClass('active');
      jQuery('.scpd_step').hide();
      jQuery(this).parent().addClass('enable');
      jQuery(this).addClass('active');
      jQuery(this).parent().find('.scpd_step').show('slide');
    }
  });
  
  jQuery('.checkout_billing').click(function(e){
    var required_check = 1;
    //var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    jQuery(this).parent().find('.checkout_required').each(function(){
      if(jQuery.trim(jQuery(this).val())==''){
        jQuery(this).next('span').remove();
        jQuery(this).after('<span class="scpd_required"><br />This field is required.</span>');
        required_check = 0;
      }else{
        jQuery(this).next('span').remove();
      }
    });
    
    if(!required_check){
      return false;
    }
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    if(!emailReg.test(jQuery.trim(jQuery("#billing_email").val()))){
      alert('please enter valid email address');
      return false;
    }
    //get all billing input field data
    var input = jQuery('#scpd_billing :input');
    var values = {};
    input.each(function() {
			if(this.type=='text' || this.type=='select-one'){
				values[this.name] = jQuery(this).val();
			}
    });
    jQuery.ajax({
      url: scpdAjax.ajaxurl,
      type: 'post',
      data: {action:'scpd_checkout_billing', bill_data:values},
      success: function(data){
				//console.log(data);
        var resp_data = JSON.parse(data);
        if(resp_data.response){
          jQuery('.checkout_billing').parent().parent().find('.scpd_step').hide('slide');
          jQuery('#scpd_payment_method').addClass('enable');
          jQuery('#scpd_payment_method').find('.scpd_checkout_title').addClass('active');
          jQuery('#scpd_payment_method').find('.scpd_step').show('slide');
        }
      }
    });
  });
  
  jQuery('.checkout_payment_method').click(function(e){
    //required field checking
    var required_check = 0;
    jQuery(this).parent().find('.checkout_required').each(function(){
      if(jQuery(this).prop('checked')){ 
        jQuery('#scpd_payment_error').html('');
        required_check = 1;
      }
    });
    if(!required_check){
      jQuery('#scpd_payment_error').html('<span class="scpd_required">Please select a payment method.</span>');
      return false;
    }
    
    jQuery.ajax({
      url: scpdAjax.ajaxurl,
      type: 'post',
      data: {action:'scpd_checkout_overview'},
      success: function(data){
        if(data){
          jQuery('#scpd_overview_content').html(data);
          jQuery('.checkout_payment_method').parent().parent().find('.scpd_step').hide('slide');
          jQuery('#scpd_overview').addClass('enable');
          jQuery('#scpd_overview').find('.scpd_checkout_title').addClass('active');
          jQuery('#scpd_overview').find('.scpd_step').show('slide');
        }else{
          return false;
        }
      }
    });
  });
  
  jQuery('.checkout_submit').click(function(e){
    jQuery('#scpd_checkout').submit();
  });
  
});