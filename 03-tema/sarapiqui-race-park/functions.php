<?php
/**
 * Funciones del tema Sarapiqui Race Park.
 *
 * @package Sarapiqui_Race_Park
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Salir si se accede directamente.
}

define( 'SRP_THEME_VERSION', '1.0.0' );

/**
 * Soporte de bloques, HTML5 y menus.
 */
function srp_setup() {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' )
	);
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'custom-line-height' );

	// Idiomas: el contenido bilingue ES/EN se maneja por rutas (/en/...),
	// pero se deja el text domain listo para .mo/.po si hace falta.
	load_theme_textdomain( 'sarapiqui-race-park', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'srp_setup' );

/**
 * Tamanos de imagen responsivos, coherentes con los anchos generados en
 * assets-web/ (480 / 960 / 1600 px). No se generan tamanos extra que WP
 * tendria que recortar de mas: los anchos ya vienen optimizados en origen.
 */
function srp_image_sizes() {
	add_image_size( 'srp-480', 480, 0, false );
	add_image_size( 'srp-960', 960, 0, false );
	add_image_size( 'srp-1600', 1600, 0, false );
}
add_action( 'after_setup_theme', 'srp_image_sizes' );

/**
 * Enlaza los tamanos anteriores como opciones validas en el selector de
 * tamano de imagen del editor de bloques.
 */
function srp_custom_image_sizes( $sizes ) {
	return array_merge(
		$sizes,
		array(
			'srp-480'  => __( 'Sarapiqui - 480px', 'sarapiqui-race-park' ),
			'srp-960'  => __( 'Sarapiqui - 960px', 'sarapiqui-race-park' ),
			'srp-1600' => __( 'Sarapiqui - 1600px', 'sarapiqui-race-park' ),
		)
	);
}
add_filter( 'image_size_names_choose', 'srp_custom_image_sizes' );

/**
 * Encolado de estilos y fuentes de marca (Anton + Barlow).
 *
 * Las fuentes se cargan hoy desde Google Fonts con font-display: swap y
 * preconnect (ver srp_resource_hints()). Si mas adelante se prefiere
 * autoalojarlas (mejor privacidad y una llamada de red menos), basta con
 * descargar los .woff2 a un directorio /assets/fonts/ del tema, declarar
 * los @font-face correspondientes en theme.json (settings.typography.fontFamilies[].fontFace)
 * y quitar wp_enqueue_style( 'srp-google-fonts', ... ) de aqui abajo.
 */
function srp_enqueue_assets() {
	wp_enqueue_style(
		'srp-google-fonts',
		'https://fonts.googleapis.com/css2?family=Anton&family=Barlow:wght@400;500;600;700&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'sarapiqui-race-park-style',
		get_stylesheet_uri(),
		array( 'srp-google-fonts' ),
		SRP_THEME_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'srp_enqueue_assets' );

/**
 * Preconnect a Google Fonts para acelerar la primera carga (recomendado
 * por el brief seccion 3, objetivo Lighthouse 90+).
 */
function srp_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.googleapis.com',
		);
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => true,
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'srp_resource_hints', 10, 2 );

/**
 * Menu de navegacion principal (usado por parts/header.html via
 * core/navigation con un menu asignado a esta ubicacion).
 */
function srp_register_menus() {
	register_nav_menus(
		array(
			'srp-primary-es' => __( 'Principal - Espanol', 'sarapiqui-race-park' ),
			'srp-primary-en' => __( 'Principal - Ingles', 'sarapiqui-race-park' ),
		)
	);
}
add_action( 'after_setup_theme', 'srp_register_menus' );

/**
 * -------------------------------------------------------------------
 * Google Analytics 4 / Google Tag Manager - hueco preparado, SIN ID.
 * -------------------------------------------------------------------
 * Adrian debe pegar su ID real de medicion (GA4 "G-XXXXXXXXXX" o GTM
 * "GTM-XXXXXXX") en la constante de abajo. Mientras esta vacia, NO se
 * imprime ningun script de analitica: no se inventa ningun ID.
 */
if ( ! defined( 'SRP_GA4_MEASUREMENT_ID' ) ) {
	define( 'SRP_GA4_MEASUREMENT_ID', '' ); // Ej.: 'G-XXXXXXXXXX'. Dejar vacio hasta tener el ID real.
}

function srp_maybe_print_analytics() {
	if ( '' === SRP_GA4_MEASUREMENT_ID ) {
		return;
	}

	$id = esc_js( SRP_GA4_MEASUREMENT_ID );
	?>
	<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $id ); ?>"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', '<?php echo $id; ?>');
	</script>
	<?php
}
add_action( 'wp_head', 'srp_maybe_print_analytics' );

/**
 * Selector de idioma ES/EN reutilizable desde parts/header.html.
 * Enlaza a la version alterna de la pagina actual cuando el propio
 * contenido la declara via el filtro 'srp_hreflang_alterno'; si nada la
 * declara, cae a las paginas de inicio de cada idioma.
 *
 * @return string
 */
function srp_language_switcher() {
	$es_url = home_url( '/' );
	$en_url = home_url( '/en/' );

	$es_url = apply_filters( 'srp_hreflang_es', $es_url );
	$en_url = apply_filters( 'srp_hreflang_en', $en_url );

	$idioma_actual = function_exists( 'srp_idioma_actual' ) ? srp_idioma_actual() : 'es';

	$html  = '<nav class="srp-lang-switch" aria-label="' . esc_attr__( 'Selector de idioma', 'sarapiqui-race-park' ) . '">';
	$html .= '<a href="' . esc_url( $es_url ) . '" hreflang="es" lang="es"' . ( 'es' === $idioma_actual ? ' aria-current="true"' : '' ) . '>ES</a>';
	$html .= '<a href="' . esc_url( $en_url ) . '" hreflang="en" lang="en"' . ( 'en' === $idioma_actual ? ' aria-current="true"' : '' ) . '>EN</a>';
	$html .= '</nav>';

	return $html;
}

function srp_language_switcher_shortcode() {
	return srp_language_switcher();
}
add_shortcode( 'srp_lang_switch', 'srp_language_switcher_shortcode' );

/**
 * Carga del CTA de reserva (componente aislado, ver seccion 7.1 del brief).
 */
require_once get_template_directory() . '/inc/cta-reserva.php';

/**
 * SEO (metadatos, hreflang, JSON-LD) lo escribe otro agente de esta misma
 * fase en inc/seo.php. Se carga de forma condicionada para no romper el
 * tema mientras ese archivo no exista todavia.
 */
if ( file_exists( get_template_directory() . '/inc/seo.php' ) ) {
	require_once get_template_directory() . '/inc/seo.php';
}
