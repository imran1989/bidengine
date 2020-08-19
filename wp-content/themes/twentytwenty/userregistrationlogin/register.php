<?php
/**
 * This template displays full width pages without a page title.
 *
 * @package vantage
 * @since vantage 1.0
 * @license GPL 2.0
 * 
 * Template Name: Registration
 */

get_header();
global $wpdb, $user_ID;
$form_errors = array();  
$form_success=0;
       
        if( $_SERVER['REQUEST_METHOD'] == 'POST' ) 
          {  
       
            // Check username is present and not already in use  
          	$organization = $wpdb->escape($_REQUEST['organization']);
          	if(empty($organization)){   
                $form_errors['organization'] = "Please select an organization";  
            }

            $first_name = $wpdb->escape($_REQUEST['first_name']);
          	if(empty($first_name)){   
                $form_errors['first_name'] = "Please enter your first name";  
            }

            $last_name = $wpdb->escape($_REQUEST['last_name']);
          	if(empty($last_name)){   
                $form_errors['last_name'] = "Please enter your last name";  
            }

            $username = $wpdb->escape($_REQUEST['username']);  
            if ( strpos($username, ' ') !== false )
            {   
                $form_errors['username'] = "Sorry, no spaces allowed in usernames";  
            }  
            if(empty($username)) 
            {   
                $form_errors['username'] = "Please enter a username";  
            } elseif( username_exists( $username ) ) 
            {  
                $form_errors['username'] = "Username already exists, please try another";  
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
       
            if(0 === count($form_errors)) 
             {  
       			
                $password = $_POST['password'];         
                $new_user_id = wp_create_user( $username, $password, $email );  
       			$this_user = new WP_User($new_user_id);
       			$this_user->remove_role( 'subscriber' );
       			$this_user->add_role( 'seller' );
       			add_user_meta($new_user_id,'organization_id',$organization,1);

       			wp_update_user([
       				'ID' => $new_user_id, 
       				'first_name' => $first_name,
       				'last_name' => $last_name,
       			]);

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
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/templates/my_style.css" type="text/css" media="screen" />
<div id="primary" class="content-area">
	<div id="content" class="site-content" role="main">

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

<form id="wp_signup_form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">  

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

        <div class="label_input">
        <label for="username">First Name:</label>  
        <input type="text" name="first_name" id="first_name">
        <div class="required_data">
        	<?php if(isset($form_errors['first_name'])){echo $form_errors['first_name'];}?>
        </div>  
        </div>

        <div class="label_input">
        <label for="username">Last Name:</label>  
        <input type="text" name="last_name" id="last_name">
        <div class="required_data">
        	<?php if(isset($form_errors['last_name'])){echo $form_errors['last_name'];}?>
        </div>  
        </div>


  		<div class="label_input">
        <label for="username">Username:</label>  
        <input type="text" name="username" id="username">
        <div class="required_data">
        	<?php if(isset($form_errors['username'])){echo $form_errors['username'];}?>
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
        <button style="margin-left: 140px;" class="my_submit_button" type="submit" >Register </button>
        </div>  


        <div class="label_input" style="text-align: right;">
        	<?php 
        	$login_url=get_the_permalink(1202);
        	$login_link='<a href="'.$login_url.'">Login</a>';
        	echo 'Already have a seller account? '.$login_link;
        	?>
        </div>
        

  
</form>
			
		</div><!--my_form_box-->

	</div><!-- #content .site-content -->



</div><!-- #primary .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>