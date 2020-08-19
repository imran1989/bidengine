<?php
/**
 * Template Name: Registration
 */

get_header();
?>


<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

<div class="post-inner <?php echo is_page_template( 'templates/template-full-width.php' ) ? '' : 'thin'; ?> ">

        <div class="entry-content">

<?php
global $wpdb, $user_ID;
$form_errors = array();  
$form_success=0;
       
        if(isset($_POST['register_btn'])) 
          {  
       

        echo "<pre>";
        print_r($_POST);
        echo "</pre>";




       // exit;
            // Check username is present and not already in use  
          	/*
            $organization = $wpdb->escape($_REQUEST['organization']);
          	if(empty($organization)){   
                $form_errors['organization'] = "Please select an organization";  
            }
            */

            $first_name = $wpdb->escape($_REQUEST['first_name']);
          	if(empty($first_name)){   
                $form_errors['first_name'] = "Please enter your name";  
            }

            $phone_number = $wpdb->escape($_REQUEST['phone_number']);
          	if(empty($phone_number)){   
                $form_errors['phone_number'] = "Please enter your phone number";  
            }
            


            $abn_number = $wpdb->escape($_REQUEST['abn_number']);
            if(empty($abn_number)){   
                $form_errors['abn_number'] = "Please enter your abn number";  
            }
            
           
            $address = $wpdb->escape($_REQUEST['address']);  
            
            if(empty($address)) 
            {   
                $form_errors['address'] = "Please enter your address";  
            } 
       

         $warehouse = $wpdb->escape($_REQUEST['warehouse']);  
            
            if(empty($address)) 
            {   
                $form_errors['warehouse'] = "Please enter your warehouse";  
            } 

            // Check email address is present and valid  
            $email = $wpdb->escape($_REQUEST['email']);  
            if( !is_email( $email ) ) 
            {   
                $form_errors['email'] = "Please enter a valid email";  
            } elseif( email_exists( $email ) ) 
            {  
                $form_errors['email'] = "This email address is already in use";  
            }  
       
            // Check password is valid  
            if(0 === preg_match("/.{6,}/", $_POST['password']))
            {  
              $form_errors['password'] = "Password must be at least six characters";  
            }  
       
            // Check password confirmation_matches  
            if(0 !== strcmp($_POST['password'], $_POST['password_confirmation']))
             {  
              $form_errors['password_confirmation'] = "Passwords do not match";  
            }  
       
            // Check terms of service is agreed to  
            if($_POST['terms'] != "Yes")
            {  
                $form_errors['terms'] = "You must agree to Terms of Service";  
            }  



            var_dump($form_errors);


       
            if(0 === count($form_errors)) 
             {  
       			
                $password = $_POST['password'];         
                $new_user_id = wp_create_user( $email, $password, $email );  


var_dump($new_user_id);

       			$this_user = new WP_User($new_user_id);
       			$this_user->remove_role( 'subscriber' );
       			$this_user->add_role( 'seller' );
       			//add_user_meta($new_user_id,'organization_id',$organization,1);

       			wp_update_user([
       				'ID' => $new_user_id, 
       				'first_name' => $first_name,
       				'last_name' => $last_name,
       			]);

echo "ADdded!!!!!";

    update_user_meta( $new_user_id, 'phone_number', $phone_number ); 
    update_user_meta( $new_user_id, 'seller_address', $address ); 
    update_user_meta( $new_user_id, 'seller_warehouse', $warehouse ); 
    update_user_meta( $new_user_id, 'abn_number', $abn_number );

    update_user_meta( $new_user_id, 'seller_warehouse2', true ); 

                // You could do all manner of other things here like send an email to the user, etc. I leave that to you.  
       
                $form_success = 1;  
       
                //header( 'Location:' . get_bloginfo('url') . '/login/?success=1&u=' . $username );  
       
            }  
       
        }  
    
$get_org_args = array(
    'role'    => 'organization',
    'orderby' => 'user_nicename',
    'order'   => 'ASC'
);
$organizations = get_users( $get_org_args );


?>

		<?php 

		
		while ( have_posts() ) : the_post(); 
		 get_template_part( 'content', 'page' ); 
		  if ( comments_open() || '0' != get_comments_number() ) : 
		   comments_template( '', true ); 
	endif; 
		    endwhile; // end of the loop. 

		    ?>


		<div class="my_form_box">

			<?php 
			if($form_success==1){
				$login_url=get_the_permalink(1202);
				$login_link='<a href="'.$login_url.'">Login Now</a>';
				echo '<div class="form_success">You have successfully created your account. '.$login_link.'</div>';
			}

			?>

<!--
Name
Email
Phone Number 
Address with Google auto fill 
ABN Number - Get it from ABN Lookup Australia 
Warehouse Address with Google Auto Fill
Add more warehouse address
-->

<h1>Seller Registration</h1>
<form id="wp_signup_form" action="" method="post">  

<!--
		<div class="label_input">
        <label for="username">Select Organization: </label>  
        <select name="organization" id="organization">
        	<option value="">Select</option>
        	<?php foreach ($organizations as $org_key => $org_value) {?>
        		<option value="<?php echo $org_value->data->ID;?>"><?php echo $org_value->data->display_name;?></option>
        	<?php } ?>
        	
        </select> 
        <div class="required_data">
        	<?php if(isset($form_errors['organization'])){echo $form_errors['organization'];}?>
        </div>
        </div>
    -->

        <div class="label_input">
        <label for="first_name">Name:</label>  
        <input type="text" name="first_name" id="first_name">
        <div class="required_data">
        	<?php if(isset($form_errors['first_name'])){echo $form_errors['first_name'];}?>
        </div>  
        </div>

        <div class="label_input">
        <label for="phone_number">Phone Number:</label>  
        <input type="text" name="phone_number" id="phone_number">
        <div class="required_data">
        	<?php if(isset($form_errors['phone_number'])){echo $form_errors['phone_number'];}?>
        </div>  
        </div>


  		<div class="label_input">
        <label for="address">Address:</label>  
        <input type="text" name="address" id="address">
        <div class="required_data">
        	<?php if(isset($form_errors['address'])){echo $form_errors['address'];}?>
        </div>  
        </div>



        <div class="label_input">
        <label for="warehouse">Warehouse Address:</label>  
        <input type="text" name="warehouse" id="warehouse">
        <div class="required_data">
            <?php if(isset($form_errors['warehouse'])){echo $form_errors['warehouse'];}?>
        </div>  
        </div>


        <div class="label_input">
        <label for="abn_number">ABN Number:</label>  
        <input type="text" name="abn_number" id="abn_number">
        <div class="required_data">
            <?php if(isset($form_errors['abn_number'])){echo $form_errors['abn_number'];}?>
        </div>  
        </div>

        <div class="label_input">
        <label for="email">Email address:</label>  
        <input type="text" name="email" id="email"> 
        <div class="required_data">
        	<?php if(isset($form_errors['email'])){echo $form_errors['email'];}?>
        </div> 
        </div> 

        <div class="label_input">
        <label for="password">Password:</label>  
        <input type="password" name="password" id="password">
        <div class="required_data">
        	<?php if(isset($form_errors['password'])){echo $form_errors['password'];}?>
        </div>   
        </div>

        <div class="label_input">
        <label for="password_confirmation">Confirm Password:</label>  
        <input type="password" name="password_confirmation" id="password_confirmation">
        <div class="required_data">
        	<?php if(isset($form_errors['password_confirmation'])){echo $form_errors['password_confirmation'];}?>
        </div>  
        </div> 
  	
  		<div class="label_input">
        <input style="width: auto" name="terms" id="terms" type="checkbox" value="Yes">  
        <label style="width: auto" for="terms">I agree to the Terms of Service</label>
        <div class="required_data">
        	<?php if(isset($form_errors['terms'])){echo $form_errors['terms'];}?>
        </div>  
        </div>  
  		<div class="label_input">
        <button style="margin-left: 140px;" class="my_submit_button" name="register_btn" type="submit" >Register </button>
        </div>  


        <div class="label_input" style="text-align: right;">
        	<?php 
        	$login_url=get_the_permalink(1202);
        	$login_link='<a href="'.$login_url.'">Login</a>';
        	echo 'Already have a seller account? '.$login_link;
        	?>
        </div>
        

  
</form>
			
	



</div><!-- #primary .content-area -->


</div><!-- .entry-content -->

    </div><!-- .post-inner -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>