<?php
/**
 * Template Name: Registration
 */

get_header();
?>
<!--
<div class="counter">
                  <ul id="countdown">
                    <li><span class="days">00</span><p class="days_text">Days</p></li>
                    <li class="seperator">:</li>
                    <li><span class="hours">00</span><p class="hours_text">Hours</p></li>
                    <li class="seperator">:</li>
                    <li><span class="minutes">00</span><p class="minutes_text">Min</p></li>
                    <li class="seperator">:</li>
                    <li><span class="seconds">00</span><p class="seconds_text">Sec</p></li>
                  </ul>
                </div>
-->

<!--
    <script type="text/javascript" src="http://ydirection.com/Domain/assets/js/jquery-2.1.1.js"></script>
    <script type="text/javascript" src="http://ydirection.com/Domain/assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://ydirection.com/Domain/assets/js/plugins.js"></script>
    
<script type="text/javascript">
	jQuery(function($) {
    "use strict";


/* --------- Wow Init ------ */

  new WOW().init();


  /* ------ Countdown ----- */

  $('#countdown').countdown({
  			date: '08/16/2020 17:00:00',
  			offset: +2,
  			day: 'Day',
  			days: 'Days'
  		}, function () {
  			alert('Done!');
  		});


/*----- Preloader ----- */

    $(window).onload = function() {
  		setTimeout(function() {
        $('#loading').fadeOut('slow', function() {
        });
      }, 500);
    };


});

</script>
<link rel="stylesheet" href="http://pixner.net/saldom/saldom/assets/css/bootstrap.min.css">
-->

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

<div class="post-inner <?php echo is_page_template( 'templates/template-full-width.php' ) ? '' : 'thin'; ?> ">

        <div class="entry-content">


<h1 class="entry-title"><?php the_title(); ?></h1>

			<?php 
//shop_order

			?>

			
	
<div class="table-responsive">
    <table class="table domain-table">
        <thead>
            <tr class="rt-light-gray">
                <th class="text-323639 rt-strong f-size-18">Domain</th>
                <th class="text-323639 rt-strong f-size-18">Buyer</th>
                <th class="text-323639 rt-strong f-size-18">Quantity</th>
                
                <th class="text-323639 rt-strong f-size-18">Price</th>
                <th class="text-323639 rt-strong f-size-18">Time left</th>
                <th class="text-323639 rt-strong f-size-18">Place Bid Now/ Place Bid</th>
            </tr>
        </thead>
        <tbody>
<?php
$args = array( 'post_type' => 'shop_order', 'post_status' => 'wc-processing' );
$loop = new WP_Query( $args );
if( $loop->have_posts() ) :
while ( $loop->have_posts() ) : $loop->the_post();
$order = new WC_Order( $post->ID );
$items = $order->get_items();

foreach ( $items as $item ) {
    $product_name = $item['name'];
    $product_id = $item['product_id'];
    $quantity = $item['quantity'];
    $subtotal = $item['subtotal'];
    $product = wc_get_product( $product_id );
	$orders = new WC_Order($post->ID);

	

?>

<tr>
                <th class="f-size-18 f-size-md-18 rt-semiblod text-234"><?php echo $product->get_name(); ?></th>
                <td class="f-size-18 f-size-md-18 rt-semiblod text-eb7"><?php echo $orders->get_billing_email(); ?></td>
                <td class="f-size-18 f-size-md-18 rt-semiblod "><?php echo $quantity; ?></td>
                <td class="f-size-18 f-size-md-18 rt-semiblod text-338"><?php echo $subtotal; ?></td>
                <td class="f-size-18 f-size-md-18 rt-semiblod primary-color">1D 10:31</td>
                <td class="text-center"><a href="<?php echo get_the_permalink(39); ?>?id=<?php echo $post->ID; ?>" class="rt-btn rt-gradient2 rt-sm4 pill">Place Bid</a></td>
            </tr>
<?php 

}
endwhile;

    endif;
        ?> 


        </tbody>
    </table>
</div>


</div><!-- #entry-content-area -->


</div><!-- .post-inner -->

    </article><!-- .article -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>