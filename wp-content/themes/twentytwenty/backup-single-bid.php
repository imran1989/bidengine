<?php
/**
 * Template Name: Single Bid Page
 */

get_header();
error_reporting(E_ERROR | E_PARSE);

date_default_timezone_set('Asia/Kolkata');
 $get_current_user_id = get_current_user_id();




$get_end_bid = get_post_meta(($_REQUEST["id"]), 'bid_end_time' );







function insert_winner($order_id)
{
 global $wpdb;



$get_lowest_bid = get_lowest_bid($order_id);
$get_end_bid = get_post_meta(($_REQUEST["id"]), 'bid_end_time' );






 $query = "INSERT INTO `wp_bid_winner` ( `bid_amount`, `order_id`, `user_id`) VALUES (".$get_lowest_bid->bid_amount.", ".$order_id.", 
   ".$get_lowest_bid->user_id.")";


$chkendbid = getTheDay($get_end_bid[0]);

if($chkendbid == "Today" && check_winner_added($order_id) == false)
{
    
    $showresult = $wpdb->get_results($query, OBJECT);
}


//$showresult = $wpdb->get_results($query, OBJECT);

}




?>


<?php 

$timestamp = strtotime($get_end_bid[0]);
$new_date_format = date('M d, Y H:i:s', $timestamp);

?>
<script>
// Set the date we're counting down to
var countDownDate = new Date("<?php echo $new_date_format; ?>").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  document.getElementById("demo").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "EXPIRED";
  }
}, 1000);
</script>

<?php 


function get_records()
{

global $wpdb;

  $user = $wpdb->get_results( "SELECT * FROM `wp_biddetails` WHERE `order_id` = ".$_REQUEST["id"]." ORDER BY `bid_amount` ASC  " );


  //echo "SELECT * FROM `wp_biddetails` WHERE `order_id` = ".$_REQUEST["id"]." ORDER BY `bid_amount` ASC  ";


if(empty($user))
{
    echo "<div>No Bid Found</div>";
}

else {

?>

<table>
<tbody>
<tr>
<td>Sr</td>
<td>Bid Amount</td>
<td>Order Id</td>
<td>User Id</td>
</tr>

<?php
$i=1;
foreach ($user as $row){

/*
echo "bid_amount = ".$row->bid_amount;
echo "<br>";
echo "order_id = ".$row->order_id;
echo "<br>";
echo "user_id = ".$row->user_id;
echo "<br><br>";
*/


    
$user_obj = get_user_by('id', $row->user_id);


$get_winner_id = get_winner_id($_REQUEST["id"]);

if($get_winner_id == $row->user_id)
{
    $winnerclass =  "winnerclass";
}
else {
    $winnerclass =  "otherclass";
}

?>


<tr class="<?php echo $winnerclass; ?>">
<td><?php echo $i; ?></td>
<td><?php echo $row->bid_amount; ?></td>
<td><?php echo $row->order_id; ?></td>
<td><?php echo $user_obj->user_email; ?></td>
</tr>

<?php 
$i++;

}

?>

</tbody>
</table>

<?php  
}



   
}










function is_currentuser_bid($userid,$order_id)
{

global $wpdb;



$query = "SELECT * FROM `wp_biddetails` WHERE `order_id` = ".$order_id." AND `user_id` = ".$userid." ORDER BY `bid_amount` ASC";


//echo "SELECT * FROM `wp_biddetails` WHERE `order_id` = ".$order_id." AND `user_id` = ".$userid." ORDER BY `bid_amount` ASC";

$showresult = $wpdb->get_results($query, OBJECT);


$get_lowest_bid = get_lowest_bid($order_id);


/*
echo "bid_amount ==".$showresult[0]->bid_amount;
echo "<br>";
echo $get_lowest_bid;

if($showresult[0]->bid_amount > $get_lowest_bid)
{
    echo "Allow";
}
else
{
    echo "Not Allow";
}
*/
//exit;

//var_dump($showresult[0]->bid_amount);
//var_dump($get_lowest_bid->bid_amount);

//|| $showresult[0]->bid_amount = $get_lowest_bid->bid_amount 


//var_dump($showresult[0]->user_id);
//var_dump($userid);


    if($showresult[0]->user_id == $userid && $showresult[0]->bid_amount > $get_lowest_bid->bid_amount )
    {
        return true;
        //echo "Allow";
    }

    elseif($showresult[0]->user_id != $userid)
    {
        return true;
        //echo "Else Allow";
    }
    else
    {
        return false;
        //echo "Not Allow";
    }


}

//echo is_currentuser_bid($get_current_user_id,$_REQUEST["id"]);
//exit;

?>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script>
      $(function () {

        $('form').on('submit', function (e) {

          e.preventDefault();

          $.ajax({
            type: 'post',
            url: '<?php bloginfo("template_directory"); ?>/myaction.php',
            data: $('form').serialize(),
            success: function () {
              alert('form was submitted');
            }
          });

        });

      });
    </script>
  </head>
  <body>
    

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

<div class="post-inner <?php echo is_page_template( 'templates/template-full-width.php' ) ? '' : 'thin'; ?> ">

        <div class="entry-content">

<?php

//echo $_GET["id"];



echo get_order_details($_GET["id"]);



function get_order_details($order_id){

    $get_current_user_id = get_current_user_id();
    $order = wc_get_order( $order_id );

/*
var_dump($order->total);

echo "<pre>";
print_r($order);
echo "</pre>";

    // OUTPUT
    echo '<h3>RAW OUTPUT OF THE ORDER OBJECT: </h3>';
    print_r($order);
    echo '<br><br>';
    echo '<h3>THE ORDER OBJECT (Using the object syntax notation):</h3>';
    echo '$order->order_type: ' . $order->order_type . '<br>';
    echo '$order->id: ' . $order->id . '<br>';
    echo '<h4>THE POST OBJECT:</h4>';
    echo '$order->post->ID: ' . $order->post->ID . '<br>';
    echo '$order->post->post_author: ' . $order->post->post_author . '<br>';
    echo '$order->post->post_date: ' . $order->post->post_date . '<br>';
    echo '$order->post->post_date_gmt: ' . $order->post->post_date_gmt . '<br>';
    echo '$order->post->post_content: ' . $order->post->post_content . '<br>';
    echo '$order->post->post_title: ' . $order->post->post_title . '<br>';
    echo '$order->post->post_excerpt: ' . $order->post->post_excerpt . '<br>';
    echo '$order->post->post_status: ' . $order->post->post_status . '<br>';
    echo '$order->post->comment_status: ' . $order->post->comment_status . '<br>';
    echo '$order->post->ping_status: ' . $order->post->ping_status . '<br>';
    echo '$order->post->post_password: ' . $order->post->post_password . '<br>';
    echo '$order->post->post_name: ' . $order->post->post_name . '<br>';
    echo '$order->post->to_ping: ' . $order->post->to_ping . '<br>';
    echo '$order->post->pinged: ' . $order->post->pinged . '<br>';
    echo '$order->post->post_modified: ' . $order->post->post_modified . '<br>';
    echo '$order->post->post_modified_gtm: ' . $order->post->post_modified_gtm . '<br>';
    echo '$order->post->post_content_filtered: ' . $order->post->post_content_filtered . '<br>';
    echo '$order->post->post_parent: ' . $order->post->post_parent . '<br>';
    echo '$order->post->guid: ' . $order->post->guid . '<br>';
    echo '$order->post->menu_order: ' . $order->post->menu_order . '<br>';
    echo '$order->post->post_type: ' . $order->post->post_type . '<br>';
    echo '$order->post->post_mime_type: ' . $order->post->post_mime_type . '<br>';
    echo '$order->post->comment_count: ' . $order->post->comment_count . '<br>';
    echo '$order->post->filter: ' . $order->post->filter . '<br>';
    echo '<h4>THE ORDER OBJECT (again):</h4>';
    echo '$order->order_date: ' . $order->order_date . '<br>';
    echo '$order->modified_date: ' . $order->modified_date . '<br>';
    echo '$order->customer_message: ' . $order->customer_message . '<br>';
    echo '$order->customer_note: ' . $order->customer_note . '<br>';
    echo '$order->post_status: ' . $order->post_status . '<br>';
    echo '$order->prices_include_tax: ' . $order->prices_include_tax . '<br>';
    echo '$order->tax_display_cart: ' . $order->tax_display_cart . '<br>';
    echo '$order->display_totals_ex_tax: ' . $order->display_totals_ex_tax . '<br>';
    echo '$order->display_cart_ex_tax: ' . $order->display_cart_ex_tax . '<br>';
    echo '$order->formatted_billing_address->protected: ' . $order->formatted_billing_address->protected . '<br>';
    echo '$order->formatted_shipping_address->protected: ' . $order->formatted_shipping_address->protected . '<br><br>';
    echo '- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - <br><br>';
*/
    // 2) Get the Order meta data
    $order_meta = get_post_meta($order_id);

/*
    echo '<h3>RAW OUTPUT OF THE ORDER META DATA (ARRAY): </h3>';
    print_r($order_meta);
    echo '<br><br>';
    echo '<h3>THE ORDER META DATA (Using the array syntax notation):</h3>';
    echo '$order_meta[_order_key][0]: ' . $order_meta[_order_key][0] . '<br>';
    echo '$order_meta[_order_currency][0]: ' . $order_meta[_order_currency][0] . '<br>';
    echo '$order_meta[_prices_include_tax][0]: ' . $order_meta[_prices_include_tax][0] . '<br>';
    echo '$order_meta[_customer_user][0]: ' . $order_meta[_customer_user][0] . '<br>';
    echo '$order_meta[_billing_first_name][0]: ' . $order_meta[_billing_first_name][0] . '<br><br>';
    echo 'And so on ……… <br><br>';
    echo '- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - <br><br>';
    */

    // 3) Get the order items
    $items = $order->get_items();

    //echo '<h3>RAW OUTPUT OF THE ORDER ITEMS DATA (ARRAY): </h3>';

    foreach ( $items as $item_id => $item_data ) {

?>

<div class="bigbox">
    
    <div class="leftbox">
    
<?php

 $get_end_bid = get_post_meta(($order_id), 'bid_end_time' );

echo insert_winner($order_id);

     ?>

    Product Name: <?php echo $item_data['name']; ?><br>
    Product Quantity: <?php echo $order->get_item_meta($item_id, '_qty', true); ?><br>
    Price: <?php echo $order->total; ?><br>
    Bid End: <span id="demo"></span><?php //echo $get_end_bid[0]; ?>
    
    

    </div>
    <div class="rightbox">
        
Bid Now:




<form name="bidform" action="" method="POST">
<input type="number" name="bidamount" value=""><br>
<input type="hidden" name="user_id" value="<?php echo $get_current_user_id; ?>">
<input type="hidden" name="order_id" value="<?php echo $order_id; ?>">


<?php 
 $get_current_user_id = get_current_user_id();


$chkendbid = getTheDay($get_end_bid[0]);

if($chkendbid == "Today")
{
    
   ?>
    <strong>Bid is Expired</strong>
    <?php 
}

else {

if(is_currentuser_bid($get_current_user_id,$order_id) == false)
{
    ?>
    <input type="submit" name="submit" value="Already Bid" disabled>
    <?php 
}
else {
    ?>
<input type="submit" name="submit" value="Bid Now">
    <?php 
}

}

?>




</form>



    </div>


    


</div>


<div style="clear:both"></div>


<?php echo get_records(); ?>

<?php
        //echo '<h4>RAW OUTPUT OF THE ORDER ITEM NUMBER: '. $item_id .'): </h4>';
        //print_r($item_data);
        //echo '<br><br>';
        //echo 'Item ID: ' . $item_id. '<br>';
        //echo '$item_data["product_id"] <i>(product ID)</i>: ' . $item_data['product_id'] . '<br>';
        //echo '$item_data["name"] <i>(product Name)</i>: ' . $item_data['name'] . '<br>';

        // Using get_item_meta() method
        //echo 'Item quantity <i>(product quantity)</i>: ' . $order->get_item_meta($item_id, '_qty', true) . '<br><br>';
        //echo 'Item line total <i>(product quantity)</i>: ' . $order->get_item_meta($item_id, '_line_total', true) . '<br><br>';
      //  echo 'And so on ……… <br><br>';
        //echo '- - - - - - - - - - - - - <br><br>';
    }
    //echo '- - - - - - E N D - - - - - <br><br>';
}



 ?>
<style type="text/css">
    
    .bigbox {
    /*border: 1px solid;
     float: left; */
    width: 100%;
}


.leftbox {
   
    float: left; 
    width: 49%;
}

.rightbox {
   
    float: left;
    width: 49%;
}


tr.winnerclass {
    background: green;
    color: #fff;
}

</style>





</div><!-- #primary .content-area -->


</div><!-- .entry-content -->

    </article><!-- .post-inner -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>