<?php
/**
 * 外部への情報秘匿
 */
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

?>