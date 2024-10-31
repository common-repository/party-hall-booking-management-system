jQuery(document).ready(function(){
  jQuery('.scpd_gateway').hide();
  jQuery('.scpd_gateway :input').prop('disabled',true);
  jQuery('.checkout_gateway').change(function(){
    var test = jQuery(this).val();
    //alert(test);
    jQuery('.scpd_gateway').hide();
    jQuery('.scpd_gateway :input').prop('disabled',true);
    jQuery('.scpd_gateway_'+test).show();
    jQuery('.scpd_gateway_'+test+' :input').prop('disabled',false);
    //alert(test);
  });
})