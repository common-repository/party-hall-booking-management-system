<?php
/*-------------------------------- This file contain booking check and saving data both admin and front-end------------------------*/
if (!defined('ABSPATH')) exit;
//booking Check for admin and front-end
function sc_check_booking(){
  if(isset($_REQUEST)){
    global $table_prefix,$wpdb;
    $hdnbookingid = esc_attr($_REQUEST['hdnbookingid']);
    $allroom = esc_attr($_REQUEST['room']);
    $rooms = explode(",",$allroom);
    $room_cond = "";
    $count = 1;
    foreach($rooms as $rm){
      if($count==1){
        $room_cond .= "room like '%".$rm."%'";  
      }
      else{
        $room_cond .= " or room like '%".$rm."%'";  
      }
      $count++;
    }
    $from_date = esc_attr($_REQUEST['from_date']);
    $to_date = esc_attr($_REQUEST['to_date']);
    
    if(isset($_REQUEST['ct'])){
      $to_date= date('Y-m-d', strtotime('-1 day', strtotime($to_date)));
    }    
    
    $sql = "";
    if($hdnbookingid != '' || $hdnbookingid != NULL ){
      $sql = "select * from ".$table_prefix."sc_scbooking where (".$room_cond.") and (from_date between '".$from_date."' and '".$to_date."' or to_date between '".$from_date."' and '".$to_date."' or (from_date < '".$from_date."' and to_date > '".$to_date."') ) and order_status != '0' and booking_id!=".$hdnbookingid;
    }
    else{
      $sql = "select * from ".$table_prefix."sc_scbooking where (".$room_cond.") and (from_date between '".$from_date."' and '".$to_date."' or to_date between '".$from_date."' and '".$to_date."' or (from_date < '".$from_date."' and to_date > '".$to_date."') ) and order_status != '0' ";
    }
    $result = $wpdb->get_results($sql);
    $yesno = "";
    if(count($result)>0){
      $yesno .= "yes";	
    }
    else{
      $yesno .= "no";
    }
    echo $yesno;
  }
  exit;
}
add_action( 'wp_ajax_nopriv_sc_check_booking','sc_check_booking' );
add_action( 'wp_ajax_sc_check_booking', 'sc_check_booking' );

//Booking data save to session for front-end only
function sc_save_booking_session(){
  sc_save_booking();

}
add_action( 'wp_ajax_nopriv_sc_save_booking_session','sc_save_booking_session' );
add_action( 'wp_ajax_sc_save_booking_session', 'sc_save_booking_session' );



// For Admin Only---

//add or update booking from admin
function sc_save_booking(){
  //checking nonce	
  check_ajax_referer('save-hall-data-ajax-nonce', 'security' );
  
  if ( count($_POST) > 0 ){    
    global $table_prefix,$wpdb;
    $hdnbookingid = esc_attr($_REQUEST['hdnbookingid']);
    $room_type = esc_attr($_REQUEST['room_type']);
    $roomid = esc_attr($_REQUEST['roomid']);
    $room = esc_attr($_REQUEST['room']);
    $from_date = esc_attr($_REQUEST['from_date']);
    $to_date = esc_attr($_REQUEST['to_date']);
    $to_date= date('Y-m-d', strtotime('-1 day', strtotime($to_date)));
    $first_name = sanitize_text_field($_REQUEST['first_name']);
    $last_name = sanitize_text_field($_REQUEST['last_name']);
    $email = sanitize_email($_REQUEST['email']);
    $phone = sanitize_text_field($_REQUEST['phone']);
    $details = sanitize_title($_REQUEST['details']);
    $bookingby = sanitize_title($_REQUEST['bookingby']);
    $guest_type = sanitize_title($_REQUEST['guest_type']);
    $price = esc_attr($_REQUEST['price']);
    $paid = esc_attr($_REQUEST['paid']);
    $due = esc_attr($_REQUEST['due']);
    $payment_method = sanitize_title($_REQUEST['payment_method']);
    $tracking_no = esc_attr($_REQUEST['tracking_no']);
    $order_status = 2;

    $values = array(
      'room_type'=>$room_type,
      'room_id'=>$roomid,
      'room'=>$room,
      'from_date'=>$from_date, 
      'to_date'=>$to_date, 
      'first_name'=>$first_name, 
      'last_name'=>$last_name, 
      'email'=>$email, 
      'phone'=>$phone, 
      'details'=>$details, 
      'booking_by'=>$bookingby, 
      'guest_type'=>$guest_type, 
      'custom_price'=>$price, 
      'paid'=>$paid, 
      'due'=>$due,
      'payment_method'=>$payment_method,
      'tracking_no'=> $tracking_no,
      'order_status'=>$order_status
    );
    if($hdnbookingid == "" || $hdnbookingid == NULL){      
      $wpdb->insert($table_prefix.'sc_scbooking',$values );	
      $inserted_id = $wpdb->insert_id;
      echo $inserted_id;
    }else{$wpdb->update($table_prefix.'sc_scbooking', $values, array('booking_id' =>$hdnbookingid));
       echo $hdnbookingid;
    }
  }
  exit;
}
add_action( 'wp_ajax_nopriv_sc_save_booking','sc_save_booking' );
add_action( 'wp_ajax_sc_save_booking', 'sc_save_booking' );


?>