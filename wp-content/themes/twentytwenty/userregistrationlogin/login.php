<?php
/**
 * This template displays full width pages without a page title.
 *
 * @package vantage
 * @since vantage 1.0
 * @license GPL 2.0
 * 
 * Template Name: Login
 */

get_header();
global $wpdb, $user_ID;
$form_errors = array();  
$is_login_failed=false;
       
        if($_POST) 
          {  
       
             $username = $wpdb->escape($_REQUEST['username']);
             $password = $wpdb->escape($_REQUEST['password']);  
             $remember = $wpdb->escape($_REQUEST['rememberme']); 

              if($remember) $remember = "true";  
              else $remember = "false";
              $login_data = array();  
              $login_data['user_login'] = $username;  
              $login_data['user_password'] = $password;  
              $login_data['remember'] = $remember;  

              $user_verify = wp_signon( $login_data, false ); 
              if ( is_wp_error($user_verify) ) { 
              $is_login_failed=true; 
                echo "Invalid login details";  
                // Note, I have created a page called "Error" that is a child of the login page to handle errors. This can be anything, but it seemed a good way to me to handle errors.  
            } else
            {    
                
                $dashboard_page=get_the_permalink(1204);                
                echo "<script type='text/javascript'>window.location.href='".$dashboard_page."'</script>";  
                exit();  
     }  


       
            
       
        }  


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

			

<form id="login1" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">  

		

    <?php if($is_login_failed==1){
        echo '<div class="required_data">Invalid login details</div>';
    }?>
  		<div class="label_input">
        <label for="username">Username:</label>  
        <input type="text" name="username" id="username">
        
        </div>

      

        <div class="label_input">
        <label for="password">Password:</label>  
        <input type="password" name="password" id="password">
        
        </div>

      
  		<div class="label_input">
        <button  style="margin-left: 140px;" class="my_submit_button" type="submit" >Login</button>
        </div>  

        <div class="label_input" style="text-align: right;">
            <?php 
            $register_url=get_the_permalink(1199);
            $register_link='<a href="'.$register_url.'">Register</a>';
            echo "Don't have a seller account? ".$register_link;
            ?>
        </div>

  
</form>
			
		</div><!--my_form_box-->

	</div><!-- #content .site-content -->



</div><!-- #primary .content-area -->




<?php get_sidebar(); ?>
<?php get_footer(); ?>