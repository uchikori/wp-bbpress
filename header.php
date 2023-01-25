<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/dist/favicon.ico">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div class="wrapper">
        <header class="header js-fix-header js-header">
            <div class="header__inner container">
                <h1 class="header_logo">
                    <a href="<?php echo esc_url(home_url()); ?>" class="logo">
                        bbPress
                    </a>
                </h1>
                <div class="header__login">
                    <?php if(!is_user_logged_in()):?>
                    <a href="<?php echo esc_url(home_url('login')); ?>" class="loginButton">ログイン</a>
                    <?php else :?>
                    <a href="<?php echo wp_nonce_url(add_query_arg('action', 'do_logout'), 'do_logout', 'token'); ?>" class="logoutButton">ログアウト</a>
                    <?php endif; ?>
                </div>
            </div>
        </header>
        <div class="container">