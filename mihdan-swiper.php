<?php
/**
 * Plugin Name: Mihdan: Swiper
 * Description: Расширяет дефолтную галерею WordPress при помощи Swiper.JS
 */

function mihdan_swiper_post_gallery( $output, $attr ) {
	return $output;
}
add_filter( 'post_gallery', 'mihdan_swiper_post_gallery', 10, 2 );

/**
 * Поправим вывод тегов
 *
 * @param $out
 * @param $pairs
 * @param $atts
 * @param $shortcode
 *
 * @return mixed
 */
function mihdan_swiper_shortcode_atts_gallery( $out ) {

	$out['icontag'] = 'div';
	$out['itemtag'] = 'div';

	return $out;
}
add_filter( 'shortcode_atts_gallery', 'mihdan_swiper_shortcode_atts_gallery' );

/**
 * Добавить класс для контейнера галереи
 *
 * @param $output
 *
 * @return mixed
 */
function mihdan_swiper_gallery_style( $output ) {

	$output = str_replace( 'gallery ', 'gallery swiper-container ', $output );

	return $output;
}
add_filter( 'gallery_style', 'mihdan_swiper_gallery_style' );

/**
 * Отключить дефолтные стили для галереи
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Включить поддержку галерей
 */
function mihdan_swiper_setup_theme() {
	add_theme_support( 'html5', ['gallery'] );
}
add_action( 'after_setup_theme', 'mihdan_swiper_setup_theme' );

/**
 * Добавить стили и скрипты от Swiper
 */
function mihdan_swiper_enqueue_scripts() {
	if ( is_single() ) {
		wp_enqueue_style( 'swiper', plugins_url( 'assets/css/swiper.min.css', __FILE__ ) );
		wp_enqueue_style( 'mihdan-swiper', plugins_url( 'assets/css/mihdan-swiper-style.css', __FILE__ ) );
		wp_enqueue_script( 'swiper', plugins_url( 'assets/js/swiper.jquery.min.js', __FILE__ ), ['jquery'], null, true );
		
		$js = <<<JS
			jQuery( function( $ ) {			    
			    $('.swiper-container')
			    	.wrapInner('<div class="swiper-wrapper"></div>')
			    	.append('<div class="swiper-pagination"></div>')
			    	.append('<div class="swiper-button-prev"></div>')
			    	.append('<div class="swiper-button-next"></div>')
			    	//.find('.gallery-item')
			    	//.addClass('swiper-slide');
			    	
			  var swiper = new Swiper ('.swiper-container', {
			      loop: true,
			      pagination: '.swiper-pagination',
			      paginationClickable: true,
			      grabCursor: true,
			      nextButton: '.swiper-button-next',
			      prevButton: '.swiper-button-prev',
			      //effect: 'fade',
			      //mousewheelControl: true,
			      keyboardControl: true,
			      hashnav: true,
			      //autoHeight: true
			      setWrapperSize: true,
			      slideClass: 'gallery-item',
			      height: 480
			  })  
			});
JS;
		
		wp_add_inline_script( 'swiper', $js );
	}
}
add_action( 'wp_enqueue_scripts', 'mihdan_swiper_enqueue_scripts' );