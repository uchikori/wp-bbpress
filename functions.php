<?php
/****************************************************************
 * セッションスタート
 ****************************************************************/
function my_session_start(){
    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
    }
    $_SESSION['foo'] = 'var'; 
}
add_action('template_redirect', 'my_session_start'); 

/****************************************************************
 * 外部への情報秘匿
 ****************************************************************/
remove_action('wp_head', 'wp_generator');// WordPressのバージョン
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );//ショートリンク三駆除
remove_action('wp_head', 'print_emoji_detection_script', 7);// 絵文字に関するJavaScript
remove_action('wp_print_styles', 'print_emoji_styles');// 絵文字に関するCSS
remove_action('admin_print_scripts', 'print_emoji_detection_script');// 絵文字に関するJavaScript
remove_action('admin_print_styles', 'print_emoji_styles');// 絵文字に関するCSS

function vc_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
add_filter( 'style_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'vc_remove_wp_ver_css_js', 9999 );

/*************************************************************
 * スタイル・スクリプトのセットアップ
 ************************************************************/
function my_enqueue_script(){
    //メインスクリプトの読み込み
    wp_enqueue_script('main', get_template_directory_uri().'/dist/main.js', array(), false, true);
    //メインスタイル読み込み
    wp_enqueue_style('style', get_template_directory_uri().'/dist/style.css', array());
}
add_action('wp_enqueue_scripts', 'my_enqueue_script');

/*************************************************************
 * body_class()にスラッグ名を追加する 
 ************************************************************/
function add_slug_body_class($classes){
    if(is_page()){
        $page = get_post(get_the_ID());
        $classes[] = $page->post_name;
    }
    return $classes;
}
add_filter('body_class', 'add_slug_body_class');

/*************************************************************
 * サイドバーウィジェット 
 ************************************************************/
function theme_widgets_init() {
    register_sidebar(array(
      'name' => 'サイドバーウィジェットエリア',
      'id' => 'primary-widget-area',
      'description' => 'サイドバー',
      'before_widget' => '<aside class="side-inner">',
      'after_widget' => '</aside>',
      'before_title' => '<h4 class="title">',
      'after_title' => '</h4>',
    )
    );
  }
  add_action('widgets_init', 'theme_widgets_init');

/****************************************************************
 * デフォルトログインセッション時間の変更
 ****************************************************************/
remove_action('admin_enqueue_scripts', 'wp_auth_check_load');
 
function mytheme_auth_cookie_expiration( $expiration, $user_id, $remember ) {
    if ( $remember ) $expiration = 60 * 60; //30分
    return $expiration;
}
 
function mytheme_init() {
    if ($_SERVER["REQUEST_URI"] !== '/wp-admin/admin-ajax.php') {
        add_filter('auth_cookie_expiration', 'mytheme_auth_cookie_expiration', 10, 3);
        wp_set_auth_cookie(get_current_user_id(), true, is_ssl(), wp_get_session_token());
    }
}
add_action( 'init', 'mytheme_init' );

/****************************************************************
 * デフォルトログイン画面カスタム
 ****************************************************************/
/* ログインしてない＆ログインページじゃない＆場合リダイレクト */
function require_login() {
    if ( !is_user_logged_in() && !is_page(array('2269','2278')) ) {
        wp_redirect( home_url('wp-login.php') );
    }
}
add_action( 'template_redirect', 'require_login' );

/**ログイン後にフォーラム画面にリダイレクト */
function login_redirect(){
    wp_safe_redirect(home_url());
    exit();
}
add_action('wp_login', 'login_redirect');

/**ログアウト後にログイン画面にリダイレクト */
add_action('wp', function() {
	if(isset($_GET['action']) && $_GET['action'] === 'do_logout') {
		do_logout();
	}
});
function do_logout() {

	//トークン認証
	if(!wp_verify_nonce($_GET['token'], 'do_logout')) {
		return;
	}

	if(is_user_logged_in()) {

		$user_id = get_current_user_id();

		//ログアウト
		wp_logout();

		//ログアウト日時をカスタムフィールドに保存
		update_user_meta($user_id, 'last_logout_time', wp_date('Y-m-d H:i:s'));

		//任意のページにリダイレクト
		wp_safe_redirect(home_url('wp-login.php'));

		exit;

	}

}

/**ログアウト後にログイン画面にリダイレクト */
function logout_redirect(){
    wp_safe_redirect(home_url('wp-login.php'));
    exit();
}
add_action('wp_logout', 'logout_redirect');

/**ログイン画面のスタイル変更 */
function custom_login(){
    $files='<link rel="stylesheet" href="'.get_stylesheet_directory_uri().'/login.css" />';
    echo $files;
}
add_action('login_enqueue_scripts', 'custom_login');

// 管理バーを管理者を除き非表示
if (! current_user_can('publish_posts')){
    show_admin_bar(false);
}

?>