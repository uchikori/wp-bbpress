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
                        <span>
                            bbPress
                        </span>                        
                    </a>
                </h1>
                <div class="button header__button">
                    <a href="#contact"><span class="button__icon"><img src="<?php echo get_template_directory_uri(); ?>/dist/images/ion_mail.svg" width="28" height="28" alt="mail"></span><span class="button__label">お問い合わせ</span></a>
                </div>
            </div>
        </header>