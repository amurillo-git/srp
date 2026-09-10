<?php
/**
 * SEO — Sarapiqui Race Park.
 *
 * Brief técnico, sección 6.1: NO se instala plugin de SEO. Todo el
 * <title>, meta description, canonical, Open Graph, Twitter Card,
 * hreflang y JSON-LD se inyecta desde el tema, enganchado en wp_head.
 *
 * Los DATOS (títulos, descriptions, JSON-LD) viven en inc/seo-datos.php,
 * que este archivo requiere. Aquí solo hay lógica: qué se imprime, cuándo
 * y cómo se escapa.
 *
 * @package Sarapiqui_Race_Park
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Salir si se accede directamente.
}

require_once __DIR__ . '/seo-datos.php';

/**
 * -------------------------------------------------------------------
 * 1. Atributo lang del elemento <html>.
 * -------------------------------------------------------------------
 * Corresponde siempre al idioma real de la página que se está viendo,
 * detectado con srp_idioma_actual() (definida en inc/cta-reserva.php).
 */
function srp_seo_language_attributes( $output ) {
	$lang = function_exists( 'srp_idioma_actual' ) ? srp_idioma_actual() : 'es';

	// Sustituye cualquier lang="..." ya presente por el idioma real.
	if ( preg_match( '/lang="[^"]*"/', $output ) ) {
		$output = preg_replace( '/lang="[^"]*"/', 'lang="' . esc_attr( $lang ) . '"', $output );
	} else {
		$output .= ' lang="' . esc_attr( $lang ) . '"';
	}

	return $output;
}
add_filter( 'language_attributes', 'srp_seo_language_attributes' );

/**
 * -------------------------------------------------------------------
 * 2. <title> del documento.
 * -------------------------------------------------------------------
 * Si la página actual es una de las 7 mapeadas en seo-datos.php, se usa
 * el title curado ahí. Si no (página no mapeada, 404, búsqueda...), se
 * deja que WordPress genere el título por defecto.
 */
function srp_seo_document_title( $title ) {
	$info = srp_seo_identificar_pagina();

	if ( ! $info ) {
		return $title;
	}

	$paginas = srp_seo_datos_paginas();
	$datos   = $paginas[ $info['clave'] ][ $info['lang'] ];

	return $datos['title'];
}
add_filter( 'pre_get_document_title', 'srp_seo_document_title', 20 );

/**
 * -------------------------------------------------------------------
 * 3. Filtros de hreflang para el selector de idioma del header
 *    (srp_language_switcher() en functions.php), para que enlace a la
 *    URL real correspondiente en vez de siempre a la portada.
 * -------------------------------------------------------------------
 */
function srp_seo_hreflang_es_actual( $url_defecto ) {
	$info = srp_seo_identificar_pagina();

	if ( ! $info ) {
		return $url_defecto;
	}

	$alternas = srp_seo_urls_alternas( $info['clave'] );

	return $alternas ? $alternas['es'] : $url_defecto;
}
add_filter( 'srp_hreflang_es', 'srp_seo_hreflang_es_actual' );

function srp_seo_hreflang_en_actual( $url_defecto ) {
	$info = srp_seo_identificar_pagina();

	if ( ! $info ) {
		return $url_defecto;
	}

	$alternas = srp_seo_urls_alternas( $info['clave'] );

	return $alternas ? $alternas['en'] : $url_defecto;
}
add_filter( 'srp_hreflang_en', 'srp_seo_hreflang_en_actual' );

/**
 * -------------------------------------------------------------------
 * 4. Meta description, canonical, Open Graph, Twitter Card y hreflang.
 * -------------------------------------------------------------------
 * Se imprime todo junto, temprano en wp_head, solo cuando la página
 * actual es una de las 7 mapeadas.
 */
function srp_seo_meta_tags() {
	$info = srp_seo_identificar_pagina();

	if ( ! $info ) {
		return;
	}

	$paginas  = srp_seo_datos_paginas();
	$datos    = $paginas[ $info['clave'] ][ $info['lang'] ];
	$alternas = srp_seo_urls_alternas( $info['clave'] );
	$url_actual = home_url( $datos['url'] );
	$imagen_og  = srp_seo_og_image_url();
	$locale     = 'en' === $info['lang'] ? 'en_US' : 'es_CR';

	echo "\n<!-- SEO: inc/seo.php (Sarapiqui Race Park) -->\n";

	// Meta description.
	printf( '<meta name="description" content="%s">' . "\n", esc_attr( $datos['description'] ) );

	// Canonical.
	printf( '<link rel="canonical" href="%s">' . "\n", esc_url( $url_actual ) );

	// hreflang: juego completo es / en / x-default. x-default apunta al
	// español porque el brief (sección 8) fija el español como idioma de
	// referencia del sitio.
	if ( $alternas ) {
		printf( '<link rel="alternate" hreflang="es" href="%s">' . "\n", esc_url( $alternas['es'] ) );
		printf( '<link rel="alternate" hreflang="en" href="%s">' . "\n", esc_url( $alternas['en'] ) );
		printf( '<link rel="alternate" hreflang="x-default" href="%s">' . "\n", esc_url( $alternas['es'] ) );
	}

	// Open Graph.
	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $datos['og_title'] ) );
	printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $datos['og_description'] ) );
	printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $imagen_og ) );
	printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $url_actual ) );
	printf( '<meta property="og:type" content="%s">' . "\n", esc_attr( $datos['og_type'] ) );
	printf( '<meta property="og:locale" content="%s">' . "\n", esc_attr( $locale ) );
	printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( 'Sarapiquí Race Park' ) );

	// Twitter Card.
	printf( '<meta name="twitter:card" content="summary_large_image">' . "\n" );
	printf( '<meta name="twitter:title" content="%s">' . "\n", esc_attr( $datos['og_title'] ) );
	printf( '<meta name="twitter:description" content="%s">' . "\n", esc_attr( $datos['og_description'] ) );
	printf( '<meta name="twitter:image" content="%s">' . "\n", esc_url( $imagen_og ) );
}
add_action( 'wp_head', 'srp_seo_meta_tags', 1 );

/**
 * -------------------------------------------------------------------
 * 5. JSON-LD.
 * -------------------------------------------------------------------
 * - LocalBusiness/SportsActivityLocation: en las 7 páginas.
 * - AggregateOffer: solo en Precios.
 * - FAQPage: solo en FAQ.
 *
 * "geo" solo se añade si SRP_SEO_GEO_LATITUDE/LONGITUDE tienen valor real;
 * "sameAs" solo si srp_seo_perfiles_sociales() no está vacío. Omitir el
 * campo entero es la regla (brief, sección 9: no inventar datos).
 */
function srp_seo_construir_localbusiness() {
	$datos = srp_seo_datos_localbusiness();
	$datos['url'] = home_url( '/' );

	if ( '' !== SRP_SEO_GEO_LATITUDE && '' !== SRP_SEO_GEO_LONGITUDE ) {
		$datos['geo'] = array(
			'@type'     => 'GeoCoordinates',
			'latitude'  => SRP_SEO_GEO_LATITUDE,
			'longitude' => SRP_SEO_GEO_LONGITUDE,
		);
	}

	$perfiles = srp_seo_perfiles_sociales();

	if ( ! empty( $perfiles ) ) {
		$datos['sameAs'] = array_values( $perfiles );
	}

	$mapas = srp_seo_mapas();

	if ( ! empty( $mapas ) ) {
		$datos['hasMap'] = array_values( $mapas );
	}

	return $datos;
}

function srp_seo_construir_offers() {
	$datos = srp_seo_datos_offers();
	$url_precios = home_url( '/precios/' );

	foreach ( $datos['offers'] as &$oferta ) {
		$oferta['@type']        = 'Offer';
		$oferta['priceCurrency'] = 'CRC';
		$oferta['availability']  = 'https://schema.org/InStock';
		$oferta['url']           = $url_precios;
		$oferta['seller']        = array(
			'@type' => 'Organization',
			'name'  => 'Sarapiquí Race Park',
		);
	}
	unset( $oferta );

	return $datos;
}

function srp_seo_construir_faqpage( $lang ) {
	$preguntas   = srp_seo_datos_faq( $lang );
	$mainEntity  = array();

	foreach ( $preguntas as $par ) {
		$mainEntity[] = array(
			'@type'          => 'Question',
			'name'           => $par['pregunta'],
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => $par['respuesta'],
			),
		);
	}

	return array(
		'@context'   => 'https://schema.org/',
		'@type'      => 'FAQPage',
		'mainEntity' => $mainEntity,
	);
}

/**
 * Imprime un array como <script type="application/ld+json">, usando
 * JSON_UNESCAPED_UNICODE (para no romper los acentos/tildes) y
 * JSON_UNESCAPED_SLASHES (para que las URLs no salgan con "\/").
 *
 * @param array $datos
 */
function srp_seo_imprimir_jsonld( $datos ) {
	echo '<script type="application/ld+json">'
		. wp_json_encode( $datos, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES )
		. '</script>' . "\n";
}

function srp_seo_jsonld() {
	$info = srp_seo_identificar_pagina();

	if ( ! $info ) {
		return;
	}

	// LocalBusiness/SportsActivityLocation: todas las páginas mapeadas.
	srp_seo_imprimir_jsonld( srp_seo_construir_localbusiness() );

	// AggregateOffer: solo Precios.
	if ( 'precios' === $info['clave'] ) {
		srp_seo_imprimir_jsonld( srp_seo_construir_offers() );
	}

	// FAQPage: solo FAQ.
	if ( 'faq' === $info['clave'] ) {
		srp_seo_imprimir_jsonld( srp_seo_construir_faqpage( $info['lang'] ) );
	}
}
add_action( 'wp_head', 'srp_seo_jsonld', 5 );
