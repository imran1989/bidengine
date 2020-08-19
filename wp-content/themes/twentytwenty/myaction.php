<?php
require_once('../../../wp-config.php');

global $wpdb;



$querystr = "INSERT INTO `wp_biddetails` (`bid_amount`, `order_id`, `user_id`) VALUES (".$_REQUEST["bidamount"].", ".$_REQUEST["order_id"].", ".$_REQUEST["user_id"].")";


 $pageposts = $wpdb->get_results($querystr, OBJECT);


//INSERT INTO `wp_biddetails` (`id`, `bid_amount`, `order_id`, `user_id`) VALUES (NULL, '9', '38', '4');

?>
<?php 
print_r($_REQUEST);

echo "hello";

?>
<script>
alert('form was submitted on myaction.php');

</script>script>