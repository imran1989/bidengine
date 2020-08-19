<?php
/**
 * Template Name: Single Bid Page
 */

get_header();
error_reporting(E_ERROR | E_PARSE);
date_default_timezone_set('Asia/Kolkata');
 
$get_current_user_id = get_current_user_id();
$get_end_bid = get_post_meta(($_REQUEST["id"]), 'bid_end_time' );


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