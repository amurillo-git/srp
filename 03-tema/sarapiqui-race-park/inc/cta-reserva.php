<?php
/**
 * Componente de reserva - Sarapiqui Race Park.
 *
 * Segun la seccion 7.1 del brief, el destino del boton de reserva es
 * PROVISIONAL: hoy abre WhatsApp, pero en la Fase 2 del proyecto se
 * reemplazara por un sistema de reservas propio o por Reservas de Google.
 *
 * Por eso todo el componente vive en ESTE UNICO ARCHIVO:
 * - La URL de destino esta en UNA sola constante (SRP_RESERVA_URL).
 * - Todo el markup del boton pasa por srp_cta_reserva(), una funcion con
 *   parametros (texto, variante, tamano, idioma).
 * - El shortcode [srp_cta_reserva] y el boton flotante reutilizan esa
 *   misma funcion, nunca duplican el enlace.
 *
 * Para migrar a la Fase 2: cambiar el valor de SRP_RESERVA_URL (y, si el
 * nuevo sistema lo requiere, la logica interna de srp_cta_reserva()) aqui
 * y solo aqui. Ningun otro archivo del tema debe contener la URL de
 * WhatsApp ni el destino del CTA.
 *
 * @package Sarapiqui_Race_Park
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Salir si se accede directamente.
}

/**
 * Destino actual del CTA de reserva.
 *
 * FASE 1 (actual): enlace directo a WhatsApp.
 * FASE 2 (futuro): reemplazar por la URL del sistema de reservas propio o
 * de Reservas de Google. Es la UNICA constante que define el destino del
 * boton en todo el tema.
 */
if ( ! defined( 'SRP_RESERVA_URL' ) ) {
	define( 'SRP_RESERVA_URL', 'https://wa.me/50672100389' );
}

/**
 * Textos por defecto del CTA, por idioma.
 *
 * @return array{es: string, en: string}
 */
function srp_cta_textos_defecto() {
	return array(
		'es' => __( 'Reserva por WhatsApp', 'sarapiqui-race-park' ),
		'en' => __( 'Book via WhatsApp', 'sarapiqui-race-park' ),
	);
}

/**
 * Detecta el idioma actual de forma ligera, sin depender de un plugin de
 * traduccion. Heuristica: si la URL solicitada empieza por /en/, es ingles;
 * de lo contrario, espanol (idioma por defecto del sitio).
 *
 * Si en el futuro el sitio usa WPML/Polylang, reemplazar el cuerpo de esta
 * funcion por la llamada nativa de ese plugin (p. ej. pll_current_language()).
 *
 * @return string 'es'|'en'
 */
function srp_idioma_actual() {
	$uri = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
	$uri = strtolower( (string) $uri );

	if ( 0 === strpos( $uri, '/en/' ) || '/en' === rtrim( $uri, '/' ) ) {
		return 'en';
	}

	return 'es';
}

/**
 * Genera el markup HTML del CTA de reserva.
 *
 * Componente aislado y reutilizable: cualquier lugar del tema que necesite
 * un boton de reserva debe llamar a esta funcion (o al shortcode
 * [srp_cta_reserva]) en vez de escribir un <a> con la URL a mano.
 *
 * @param array $args {
 *     @type string $texto      Texto visible del boton. Si se omite, usa el texto por defecto del idioma.
 *     @type string $variante   'primary'|'secondary'. Ver style.css .srp-cta--*.
 *     @type string $tamano     'sm'|'md'|'lg'.
 *     @type string $idioma     'es'|'en'. Si se omite, se detecta con srp_idioma_actual().
 *     @type bool   $icono      Si se muestra el icono de WhatsApp. Por defecto true.
 *     @type string $clase_extra Clases CSS adicionales.
 * }
 * @return string Markup HTML del boton (enlace <a>).
 */
function srp_cta_reserva( $args = array() ) {
	$defaults = array(
		'texto'       => '',
		'variante'    => 'primary',
		'tamano'      => 'md',
		'idioma'      => '',
		'icono'       => true,
		'clase_extra' => '',
	);

	$args = wp_parse_args( $args, $defaults );

	$idioma = in_array( $args['idioma'], array( 'es', 'en' ), true ) ? $args['idioma'] : srp_idioma_actual();

	$variante = in_array( $args['variante'], array( 'primary', 'secondary' ), true ) ? $args['variante'] : 'primary';
	$tamano   = in_array( $args['tamano'], array( 'sm', 'md', 'lg' ), true ) ? $args['tamano'] : 'md';

	$textos = srp_cta_textos_defecto();
	$texto  = '' !== $args['texto'] ? $args['texto'] : $textos[ $idioma ];

	$clases = array( 'srp-cta', 'srp-tap-target', 'srp-cta--' . $variante, 'srp-cta--' . $tamano );
	if ( '' !== $args['clase_extra'] ) {
		$clases[] = $args['clase_extra'];
	}

	$icono_svg = '';
	if ( $args['icono'] ) {
		$icono_svg = '<svg aria-hidden="true" focusable="false" viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.29-1.39a9.9 9.9 0 0 0 4.75 1.21h.01c5.46 0 9.9-4.45 9.9-9.91C21.95 6.45 17.5 2 12.04 2Zm0 18.15h-.01a8.2 8.2 0 0 1-4.2-1.15l-.3-.18-3.14.82.84-3.06-.2-.31a8.23 8.23 0 0 1-1.26-4.4c0-4.55 3.7-8.25 8.27-8.25 2.21 0 4.28.86 5.84 2.42a8.19 8.19 0 0 1 2.42 5.83c0 4.56-3.71 8.28-8.26 8.28Zm4.53-6.2c-.25-.12-1.47-.72-1.7-.81-.23-.08-.4-.12-.56.13-.17.25-.65.81-.79.97-.15.17-.29.19-.54.06-.25-.12-1.04-.38-1.98-1.22-.73-.65-1.23-1.46-1.37-1.71-.14-.25-.02-.38.11-.51.11-.11.25-.29.37-.43.12-.15.16-.25.25-.42.08-.17.04-.31-.02-.44-.06-.12-.56-1.35-.77-1.85-.2-.48-.41-.42-.56-.43-.15-.01-.31-.01-.48-.01-.17 0-.44.06-.67.31-.23.25-.87.85-.87 2.08 0 1.23.89 2.41 1.01 2.58.13.17 1.76 2.69 4.27 3.77.6.26 1.06.41 1.43.53.6.19 1.14.16 1.57.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.08.15-1.18-.06-.1-.23-.16-.48-.28Z"/></svg>';
	}

	$html  = '<a class="' . esc_attr( implode( ' ', $clases ) ) . '" href="' . esc_url( SRP_RESERVA_URL ) . '" target="_blank" rel="noopener noreferrer" aria-label="' . esc_attr( $texto ) . '">';
	$html .= $icono_svg;
	$html .= '<span>' . esc_html( $texto ) . '</span>';
	$html .= '</a>';

	return $html;
}

/**
 * Shortcode [srp_cta_reserva texto="" variante="primary" tamano="md" idioma=""].
 *
 * @param array $atts Atributos del shortcode.
 * @return string
 */
function srp_cta_reserva_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'texto'    => '',
			'variante' => 'primary',
			'tamano'   => 'md',
			'idioma'   => '',
		),
		$atts,
		'srp_cta_reserva'
	);

	return srp_cta_reserva(
		array(
			'texto'    => $atts['texto'],
			'variante' => $atts['variante'],
			'tamano'   => $atts['tamano'],
			'idioma'   => $atts['idioma'],
		)
	);
}
add_shortcode( 'srp_cta_reserva', 'srp_cta_reserva_shortcode' );

/**
 * Boton flotante de WhatsApp, reutilizando srp_cta_reserva().
 *
 * Se engancha via wp_footer para aparecer en TODAS las paginas sin
 * copiarlo en cada plantilla.
 */
function srp_whatsapp_float_render() {
	$idioma = srp_idioma_actual();
	$textos = srp_cta_textos_defecto();

	echo '<a class="srp-whatsapp-float srp-tap-target" href="' . esc_url( SRP_RESERVA_URL ) . '" target="_blank" rel="noopener noreferrer" aria-label="' . esc_attr( $textos[ $idioma ] ) . '">'
		. '<svg aria-hidden="true" focusable="false" viewBox="0 0 24 24"><path fill="currentColor" d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.29-1.39a9.9 9.9 0 0 0 4.75 1.21h.01c5.46 0 9.9-4.45 9.9-9.91C21.95 6.45 17.5 2 12.04 2Zm0 18.15h-.01a8.2 8.2 0 0 1-4.2-1.15l-.3-.18-3.14.82.84-3.06-.2-.31a8.23 8.23 0 0 1-1.26-4.4c0-4.55 3.7-8.25 8.27-8.25 2.21 0 4.28.86 5.84 2.42a8.19 8.19 0 0 1 2.42 5.83c0 4.56-3.71 8.28-8.26 8.28Zm4.53-6.2c-.25-.12-1.47-.72-1.7-.81-.23-.08-.4-.12-.56.13-.17.25-.65.81-.79.97-.15.17-.29.19-.54.06-.25-.12-1.04-.38-1.98-1.22-.73-.65-1.23-1.46-1.37-1.71-.14-.25-.02-.38.11-.51.11-.11.25-.29.37-.43.12-.15.16-.25.25-.42.08-.17.04-.31-.02-.44-.06-.12-.56-1.35-.77-1.85-.2-.48-.41-.42-.56-.43-.15-.01-.31-.01-.48-.01-.17 0-.44.06-.67.31-.23.25-.87.85-.87 2.08 0 1.23.89 2.41 1.01 2.58.13.17 1.76 2.69 4.27 3.77.6.26 1.06.41 1.43.53.6.19 1.14.16 1.57.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.08.15-1.18-.06-.1-.23-.16-.48-.28Z"/></svg>'
		. '</a>';
}
add_action( 'wp_footer', 'srp_whatsapp_float_render' );
