<?php
/**
 * Block Name: FMW Log in Form
 *
 */

// create id attribute for specific styling
$id = 'fmw-' . $block['id'];

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';
$class = $block['className'];


$attachmentId = $block['data']['cover_image'];

?>

<div class="container <?=$class?>" id="<?=$id?>">
    <div id="tab1_login" class="tab_content_login">

    <h1>Login</h1>

    <form id="login-form" method="post" action="<?php bloginfo('url') ?>/wp-login.php" class="wp-user-form">
        <?php if(isset($_GET['login'])){
            if($_GET['login'] === 'failed'){
                echo '<p class="input-error">Invalid credentails.</p>';
            }
        } ?>
        <div class="username">
            <label for="user_login"><?php _e('Username'); ?>: </label>
            <input type="text" name="log" value="<?php echo esc_attr(stripslashes($user_login)); ?>" size="20" id="user_login" tabindex="11" />
        </div>
        <div class="password">
            <label for="user_pass"><?php _e('Password'); ?>: </label>
            <input type="password" name="pwd" value="" size="20" id="user_pass" tabindex="12" />
        </div>
        <div class="login_fields">
            <div class="rememberme">
                <label for="rememberme">
                    <input type="checkbox" name="rememberme" value="forever" checked="checked" id="rememberme" tabindex="13" /> Remember me
                </label>
            </div>
            <?php do_action('login_form'); ?>
            <div id="login-loader" class="lds-roller" style="display:none;"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
            <input type="submit" name="user-submit" value="<?php _e('Login'); ?>" tabindex="14" class="user-submit" />
            <input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
            <input type="hidden" name="user-cookie" value="1" />
        </div>
    </form>
    <p>Don't have an account? <a href="<?=site_url('/join-now')?>">Click here</a></p>
    </div>
</div>


	