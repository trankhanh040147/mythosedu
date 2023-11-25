<?php
/*
* Template Name: Login Page
*/
get_header();
?>

    <main id="main" class="site-main page">
        <div class="container">
            <div class="row pt-5 pb-5 pl-3 pr-3 center sign_in">
            
               <?php
               if (!is_user_logged_in()) {
                    $args = array(
                    'redirect' => home_url('/dashboard'),
                    'label_username' => __( 'E-mail' ),
                    'id_username' => '',
                    'label_password' => __( 'Password' ),
                    'id_password' => '',
                    );

                ?>
                <h1><?php echo _e('Log in');?></h1>
                <p class="__logsub">Please fill your information below</p>
                <?php

                //wp_login_form($args);



                ?>

        <form method="post" action="<?php bloginfo('url') ?>/wp-login.php" class="wp-user-form">
            <div class="username">
                <input type="text" name="log" value="<?php echo $_REQUEST['log'] ?>" placeholder="E-mail"/>
                <img class="_icon_input" src="<?php echo THEME_URL;?>/component/img/icon_email.svg">
                <p class="__notes">The email address you used to register with VUS Training Hub - Teacher Training Platform.</p>
            </div>
            <div class="password">
                <input type="password" name="pwd" value="" size="20" id="user_pass" placeholder="Password"/>
                <img class="_icon_input" src="<?php echo THEME_URL;?>/component/img/icon_password.svg">
            </div>
            <div class="_forgot">
                <a href="/wp-login.php?action=lostpassword">Forgot password?</a>
            </div>

            <div class="login_fields">
                <?php do_action('login_form'); ?>
                <input type="submit" name="user-submit" value="<?php _e('Sign In'); ?>" tabindex="14" class="user-submit login-button border-5px" />
                <input type="hidden" name="redirect_to" value="<?php echo home_url('/'); ?>" />
                <input type="hidden" name="user-cookie" value="1" />
                <input type="hidden" name="custom_login" value="1" />
                <input type="hidden" name="custom_token_login" value="<?php echo wp_create_nonce( 'custom_nonce' ) ?>">
            </div>

            
        </form>


                <p>No account? <a href="/student-registration">Create one!</a></p>
                <div class="msg">
                    <?php 
                    if(isset($_SESSION["LOGIN_FE_STATUS"]) && $_SESSION["LOGIN_FE_STATUS"] != "" && $_SESSION["LOGIN_FE_STATUS"] == "FAILED") {
                        echo 'Invalid username and/or password';
                    } else {
                        if(isset($_SESSION["LOGIN_FE_STATUS"]) && $_SESSION["LOGIN_FE_STATUS"] != "" && $_SESSION["LOGIN_FE_STATUS"] == "BLANK") {
                            echo 'Username and/or Password is empty.';
                        }
                    }
                    // clean value
                    unset($_SESSION["LOGIN_FE_STATUS"]); 
                    ?>
                </div>
                <?php
               } else {
                ?>
                <h1><a href="/dashboard">My Dashboard</a></h1>
                <?php
               }
               ?>
            </div>
        </div>
    </main><!-- #main -->

<?php
get_footer();
