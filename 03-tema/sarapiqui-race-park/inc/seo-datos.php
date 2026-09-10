<?php
/**
 * Datos SEO — Sarapiqui Race Park.
 *
 * Fuente de verdad de este archivo: 02-contenido/seo/metadatos.json,
 * 02-contenido/seo/metadatos-en.json, 02-contenido/seo/jsonld-localbusiness.json,
 * 02-contenido/seo/jsonld-offers.json y 02-contenido/seo/jsonld-faqpage.json
 * (ya validados: brief técnico secciones 6 y 6.1).
 *
 * Este archivo SOLO contiene datos (arrays PHP) para que Adrián pueda editar
 * un title, una description o pegar un dato pendiente sin tocar lógica ni
 * PHP de verdad. La lógica que LEE estos datos y los imprime en <head>
 * vive en inc/seo.php.
 *
 * @package Sarapiqui_Race_Park
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Salir si se accede directamente.
}

/**
 * -------------------------------------------------------------------
 * 1. Coordenadas GPS — Confirmadas 10 sep 2026.
 * -------------------------------------------------------------------
 * Latitud y longitud exactas del pin de Google Maps del parque
 * (Horquetas de Sarapiquí, Ruta 4, km 16), confirmadas por Adrián.
 * Formato: string decimal.
 */
if ( ! defined( 'SRP_SEO_GEO_LATITUDE' ) ) {
	define( 'SRP_SEO_GEO_LATITUDE', '10.342081' );
}
if ( ! defined( 'SRP_SEO_GEO_LONGITUDE' ) ) {
	define( 'SRP_SEO_GEO_LONGITUDE', '-83.954097' );
}

/**
 * -------------------------------------------------------------------
 * 2. Perfiles sociales ("sameAs") — Confirmados 10 sep 2026.
 * -------------------------------------------------------------------
 * URLs reales de los perfiles sociales del negocio, extraídas del Linktree
 * oficial. Solo se incluyen perfiles que existen y están activos.
 * TripAdvisor omitido: registrado pero no activo aún.
 *
 * @return string[] URLs completas de perfiles sociales activos.
 */
function srp_seo_perfiles_sociales() {
	return array(
		'https://www.instagram.com/sarapiquiracepark',
		'https://www.facebook.com/sarapiquiracepark',
		'https://www.tiktok.com/@sarapiquiracepark',
		'https://linktr.ee/sarapiquiracepark',
	);
}

/**
 * -------------------------------------------------------------------
 * 2.1 URLs de mapas (Google Maps y Waze) para hasMap en LocalBusiness.
 * -------------------------------------------------------------------
 * Se devuelve como array de URLs válidas. Solo se agrega a JSON-LD
 * si este array no está vacío (condición en inc/seo.php).
 *
 * @return array URLs de mapas.
 */
function srp_seo_mapas() {
	return array(
		'https://maps.app.goo.gl/Rk2z39BCwLQFtY4A9',
		'https://waze.com/ul/hd1u6cddqv',
	);
}

/**
 * -------------------------------------------------------------------
 * 3. Imagen Open Graph.
 * -------------------------------------------------------------------
 * Ruta tal como la fija 01-spec/assets.json en su campo "open_graph"
 * (1200x630, ya generada en assets-web/). Es la misma foto para todas las
 * páginas mientras no exista una imagen de portada específica por página.
 *
 * Se asume que assets-web/ vive copiada dentro del propio tema (mismo
 * criterio que assets-web/ para los tamaños 480/960/1600 que usa
 * functions.php). Si en el sitio real esas imágenes terminan servidas
 * desde la biblioteca de medios de WordPress en vez de desde el tema,
 * basta con enganchar el filtro 'srp_seo_og_image_url' para devolver esa
 * otra URL sin tocar el resto de la lógica.
 */
if ( ! defined( 'SRP_SEO_OG_IMAGE_RELATIVA' ) ) {
	define( 'SRP_SEO_OG_IMAGE_RELATIVA', 'assets-web/go-kart-270cc-salpicando-lodo-pista-off-road-sarapiqui-og-1200x630.webp' );
}

/**
 * URL absoluta de la imagen Open Graph / Twitter Card.
 *
 * @return string
 */
function srp_seo_og_image_url() {
	$url = get_template_directory_uri() . '/' . ltrim( SRP_SEO_OG_IMAGE_RELATIVA, '/' );

	/**
	 * Permite reapuntar la imagen OG (p. ej. si se sirve desde la
	 * biblioteca de medios de WordPress en vez de desde el tema).
	 */
	return apply_filters( 'srp_seo_og_image_url', $url );
}

/**
 * -------------------------------------------------------------------
 * 4. Metadatos de las 7 páginas, en ES y EN.
 * -------------------------------------------------------------------
 * Clave de primer nivel = identificador canónico de página (el mismo en
 * ambos idiomas). Cada idioma trae:
 * - post_name   : slug real de la página de WordPress en ese idioma.
 * - url         : ruta pública (para canonical y hreflang).
 * - title       : <title> (50-60 caracteres, ya verificado).
 * - description : meta description (140-160 caracteres, ya verificado).
 * - og_title / og_description : variante para Open Graph / Twitter.
 * - og_type     : "website" en las 7 páginas.
 *
 * Adrián puede editar cualquier title/description aquí abajo sin tocar
 * inc/seo.php.
 *
 * @return array
 */
function srp_seo_datos_paginas() {
	return array(
		'inicio'             => array(
			'es' => array(
				'post_name'      => 'inicio',
				'url'            => '/',
				'title'          => 'Sarapiquí Race Park - Go Karts Off-Road Costa Rica',
				'description'    => 'Vive la emoción del off-road en Sarapiquí Race Park. Go karts de 270cc en pista de 500m. Diversión extrema para toda la familia en Horquetas.',
				'og_title'       => 'Sarapiquí Race Park - Go Karts Off-Road en Costa Rica',
				'og_description' => 'Go karts de 270cc en pista de 500m. Diversión extrema para toda la familia. Reserva tu experiencia en Horquetas de Sarapiquí.',
				'og_type'        => 'website',
			),
			'en' => array(
				'post_name'      => 'home',
				'url'            => '/en/',
				'title'          => 'Sarapiquí Race Park – Off-Road Go Karts in Costa Rica',
				'description'    => 'Experience off-road thrills at Sarapiquí Race Park in Horquetas, Costa Rica. 270cc go karts on a 500m track. Extreme family fun for all ages and skill levels.',
				'og_title'       => 'Sarapiquí Race Park – Off-Road Go Karts Costa Rica',
				'og_description' => '270cc go karts, 500m off-road track. Adventure for families and experienced drivers. Book your race in Horquetas today.',
				'og_type'        => 'website',
			),
		),
		'actividades'        => array(
			'es' => array(
				'post_name'      => 'actividades',
				'url'            => '/actividades/',
				'title'          => 'Go Karts Off-Road en Sarapiquí - Actividades que ofrece',
				'description'    => 'Go karts 270cc en Horquetas de Sarapiquí. Pista off-road 500m, edad mínima 9 años, seguridad con personal certificado. Reserva previa y depósito 50%.',
				'og_title'       => 'Go Karts Off-Road en Sarapiquí - Actividades que ofrece',
				'og_description' => 'Karts 270cc, pista off-road de 500m, edad mínima 9 años, personal certificado supervisando. Reserva previa obligatoria.',
				'og_type'        => 'website',
			),
			'en' => array(
				'post_name'      => 'activities',
				'url'            => '/en/activities/',
				'title'          => 'Off-Road Go Kart Activities – Sarapiquí Race Park Costa Rica',
				'description'    => 'Off-road karting in Horquetas de Sarapiquí, Costa Rica: 270cc karts on a 500 m track, minimum age 9, certified staff and a mandatory safety briefing.',
				'og_title'       => 'Off-Road Go Kart Activities – Sarapiquí Race Park',
				'og_description' => '270cc go karts, 500m track, minimum age 9, certified safety staff. Book in advance.',
				'og_type'        => 'website',
			),
		),
		'ubicacion-horarios' => array(
			'es' => array(
				'post_name'      => 'ubicacion-horarios',
				'url'            => '/ubicacion-horarios/',
				'title'          => 'Ubicación y Horarios - Sarapiquí Race Park Costa Rica',
				'description'    => 'Go karts off-road en Horquetas de Sarapiquí, Ruta 4, kilómetro 16. Abierto sábado, domingo y feriados de 9:00 am a 4:00 pm. Acceso en vehículo.',
				'og_title'       => 'Ubicación y Horarios - Sarapiquí Race Park',
				'og_description' => 'Ubicación: Horquetas de Sarapiquí, Ruta 4 km 16. Abierto sáb, dom, feriados 9am-4pm.',
				'og_type'        => 'website',
			),
			'en' => array(
				'post_name'      => 'location',
				'url'            => '/en/location-hours/',
				'title'          => 'Location and Hours | Sarapiquí Race Park Costa Rica',
				'description'    => 'Sarapiquí Race Park at Ruta 4 km 16, Horquetas, Costa Rica. Open Sat–Sun & holidays 9am–4pm. San José 1.5h, Puerto Viejo 15m, La Fortuna 1.5h, Guápiles 30m.',
				'og_title'       => 'Location & Hours – Sarapiquí Race Park',
				'og_description' => 'Location: Horquetas, Ruta 4 km 16. Open Sat-Sun & holidays 9am–4pm. Easy access.',
				'og_type'        => 'website',
			),
		),
		'precios'            => array(
			'es' => array(
				'post_name'      => 'precios',
				'url'            => '/precios/',
				'title'          => 'Precios y Paquetes - Go Karts Off-Road en Sarapiquí',
				'description'    => 'Tarifas go karts: desde ₡2,000/vuelta, paquetes 10-15 min desde ₡6,000. Grupos ₡5,500/pers (descuento 20+). Horquetas de Sarapiquí. Depósito 50%.',
				'og_title'       => 'Precios y Paquetes - Go Karts Off-Road',
				'og_description' => 'Desde ₡2,000 por vuelta. Paquetes 10 min (₡6,000), 15 min (₡7,000). Grupos desde ₡5,500/persona.',
				'og_type'        => 'website',
			),
			'en' => array(
				'post_name'      => 'pricing',
				'url'            => '/en/pricing/',
				'title'          => 'Pricing & Packages – Off-Road Go Karts in Costa Rica',
				'description'    => 'Sarapiquí Race Park rates in Horquetas de Sarapiquí, Costa Rica: single lap 2,000 colones, 10-min 6,000, 15-min 7,000. Group rates from 5,500 per person.',
				'og_title'       => 'Pricing & Packages – Go Karts Sarapiquí',
				'og_description' => 'From ₡2,000 per lap. Packages 10 min (₡6,000), 15 min (₡7,000). Group rates available.',
				'og_type'        => 'website',
			),
		),
		'galeria'            => array(
			'es' => array(
				'post_name'      => 'galeria',
				'url'            => '/galeria/',
				'title'          => 'Galería Fotos y Videos - Go Karts Off-Road Sarapiquí',
				'description'    => 'Fotos y videos de experiencias de go karts off-road en Sarapiquí. Pista de 500m, pilotos en acción, familias disfrutando en Horquetas de Sarapiquí.',
				'og_title'       => 'Galería - Sarapiquí Race Park Go Karts Off-Road',
				'og_description' => 'Fotos y videos de pilotos en acción, pista off-road, familias disfrutando en Sarapiquí Race Park.',
				'og_type'        => 'website',
			),
			'en' => array(
				'post_name'      => 'gallery',
				'url'            => '/en/gallery/',
				'title'          => 'Gallery – Off-Road Go Karts & Action in Costa Rica',
				'description'    => 'Real photos and videos of off-road go kart action at Sarapiquí Race Park. Drivers in action, mud spray, technical curves, and 500m track adventure for families.',
				'og_title'       => 'Gallery – Sarapiquí Race Park Go Karts',
				'og_description' => 'Photos and videos: drivers in action, mud, 500m off-road track. Real moments at Sarapiquí.',
				'og_type'        => 'website',
			),
		),
		'faq'                => array(
			'es' => array(
				'post_name'      => 'faq',
				'url'            => '/faq/',
				'title'          => 'Preguntas Frecuentes - Go Karts Sarapiquí Race Park',
				'description'    => 'Respuestas sobre go karts off-road: edad mínima (9 años), cómo reservar, depósito, qué incluye, ubicación (Horquetas de Sarapiquí), horarios.',
				'og_title'       => 'Preguntas Frecuentes - Go Karts Sarapiquí Race Park',
				'og_description' => 'FAQ: edad mínima 9 años, reservas, depósito 50%, qué incluye, ubicación y horarios en Horquetas de Sarapiquí.',
				'og_type'        => 'website',
			),
			'en' => array(
				'post_name'      => 'faq',
				'url'            => '/en/faq/',
				'title'          => 'Questions & Answers – Sarapiquí Race Park Costa Rica',
				'description'    => "Common questions: age 9+ to drive solo, children under 9 with adult, booking, 50% deposit, cancellation terms. Sarapiquí Race Park, Horquetas, Costa Rica.",
				'og_title'       => 'FAQ – Go Karts Sarapiquí Race Park',
				'og_description' => "FAQ: age 9+, booking, 50% deposit, what's included, location & hours.",
				'og_type'        => 'website',
			),
		),
		'sobre-nosotros'     => array(
			'es' => array(
				'post_name'      => 'sobre-nosotros',
				'url'            => '/sobre-nosotros/',
				'title'          => 'Sobre Nosotros - Sarapiquí Race Park Go Karts Off-Road',
				'description'    => 'Historia de Sarapiquí Race Park, líder en go karts off-road en Horquetas de Sarapiquí. Personal certificado, karts última generación en Costa Rica.',
				'og_title'       => 'Sobre Nosotros - Sarapiquí Race Park',
				'og_description' => 'Sarapiquí Race Park: experiencias de go karts off-road únicas, personal certificado, karts de última generación en Horquetas de Sarapiquí.',
				'og_type'        => 'website',
			),
			'en' => array(
				'post_name'      => 'about-us',
				'url'            => '/en/about-us/',
				'title'          => 'About Sarapiquí Race Park – Off-Road Go Karts Costa Rica',
				'description'    => 'Sarapiquí Race Park: Costa Rica\'s premier off-road go kart destination. 270cc karts, certified staff, family activities, safe track, competitive prices.',
				'og_title'       => 'About Us – Sarapiquí Race Park',
				'og_description' => 'Leading off-road go kart destination. Latest karts, certified staff, family experiences.',
				'og_type'        => 'website',
			),
		),
	);
}

/**
 * Busca la página canónica (clave de srp_seo_datos_paginas()) y el idioma
 * correspondientes al post/página que se está viendo, comparando el
 * "post_name" real de WordPress contra los valores de arriba.
 *
 * @param int|null $post_id ID de post/página. Por defecto, la página consultada actual.
 * @return array{clave: string, lang: string}|null Null si no es ninguna de las 7 páginas mapeadas.
 */
function srp_seo_identificar_pagina( $post_id = null ) {
	if ( null === $post_id ) {
		$post_id = get_queried_object_id();
	}

	$post_name = $post_id ? get_post_field( 'post_name', $post_id ) : '';

	if ( ! $post_name ) {
		return null;
	}

	$lang = function_exists( 'srp_idioma_actual' ) ? srp_idioma_actual() : 'es';

	foreach ( srp_seo_datos_paginas() as $clave => $por_idioma ) {
		if ( isset( $por_idioma[ $lang ] ) && $por_idioma[ $lang ]['post_name'] === $post_name ) {
			return array(
				'clave' => $clave,
				'lang'  => $lang,
			);
		}
	}

	return null;
}

/**
 * Devuelve el par de URLs absolutas ES/EN (para hreflang y para el
 * selector de idioma) de una página canónica dada.
 *
 * @param string $clave Clave de srp_seo_datos_paginas() (ej. 'inicio', 'precios'...).
 * @return array{es: string, en: string}|null
 */
function srp_seo_urls_alternas( $clave ) {
	$paginas = srp_seo_datos_paginas();

	if ( ! isset( $paginas[ $clave ] ) ) {
		return null;
	}

	return array(
		'es' => home_url( $paginas[ $clave ]['es']['url'] ),
		'en' => home_url( $paginas[ $clave ]['en']['url'] ),
	);
}

/**
 * -------------------------------------------------------------------
 * 5. JSON-LD: LocalBusiness / SportsActivityLocation (todas las páginas).
 * -------------------------------------------------------------------
 * Portado de 02-contenido/seo/jsonld-localbusiness.json. El campo "url"
 * se resuelve en inc/seo.php con home_url() en vez de dejarlo fijo aquí,
 * para que apunte siempre al dominio real de la instalación de WordPress.
 *
 * "geo" y "sameAs" NO están aquí: inc/seo.php los añade condicionalmente
 * solo si SRP_SEO_GEO_LATITUDE/LONGITUDE o srp_seo_perfiles_sociales()
 * tienen valores reales.
 *
 * @return array
 */
function srp_seo_datos_localbusiness() {
	return array(
		'@context'                => 'https://schema.org/',
		'@type'                   => array( 'SportsActivityLocation', 'LocalBusiness' ),
		'name'                    => 'Sarapiquí Race Park',
		'description'             => 'Parque de go karts off-road en Horquetas de Sarapiquí, Costa Rica. Experiencias de carreras en karts 270cc en pista de 500m.',
		'telephone'               => '+506 7210-0389',
		'email'                   => 'info@srp.cr',
		'address'                 => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => 'Ruta 4, kilómetro 16',
			'addressLocality' => 'Horquetas de Sarapiquí',
			'addressRegion'   => 'Heredia',
			'addressCountry'  => 'CR',
		),
		'openingHoursSpecification' => array(
			array(
				'@type'     => 'OpeningHoursSpecification',
				'dayOfWeek' => 'Saturday',
				'opens'     => '09:00',
				'closes'    => '16:00',
			),
			array(
				'@type'     => 'OpeningHoursSpecification',
				'dayOfWeek' => 'Sunday',
				'opens'     => '09:00',
				'closes'    => '16:00',
			),
			array(
				'@type'     => 'OpeningHoursSpecification',
				'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday' ),
				'opens'     => '00:00',
				'closes'    => '00:00',
			),
		),
		'priceRange'              => '₡₡',
		'sportsActivityLocation'  => array(
			'@type'       => 'SportsActivityLocation',
			'name'        => 'Pista Off-Road',
			'description' => 'Pista de go karts off-road de 500 metros con curvas, rectas y terreno variado',
		),
	);
}

/**
 * -------------------------------------------------------------------
 * 6. JSON-LD: AggregateOffer (solo página Precios).
 * -------------------------------------------------------------------
 * Portado de 02-contenido/seo/jsonld-offers.json. El campo "url" de cada
 * oferta se resuelve en inc/seo.php con home_url( '/precios/' ) para no
 * fijar el dominio aquí.
 *
 * @return array
 */
function srp_seo_datos_offers() {
	return array(
		'@context'     => 'https://schema.org/',
		'@type'        => 'AggregateOffer',
		'priceCurrency' => 'CRC',
		'lowPrice'     => '2000',
		'highPrice'    => '7000',
		'offers'       => array(
			array(
				'name'         => 'Vuelta Individual',
				'description'  => 'Una vuelta individual en kart 270cc en la pista off-road de Sarapiquí Race Park',
				'price'        => '2000',
			),
			array(
				'name'        => 'Paquete 10 Minutos',
				'description' => 'Paquete de 10 minutos de carrera en kart 270cc (aproximadamente 5-6 vueltas). Incluye instrucción de seguridad, equipo de protección y acceso a pista.',
				'price'       => '6000',
			),
			array(
				'name'        => 'Paquete 15 Minutos',
				'description' => 'Paquete de 15 minutos de carrera en kart 270cc (aproximadamente 8-9 vueltas, máxima adrenalina). Incluye instrucción de seguridad, equipo de protección y acceso a pista.',
				'price'       => '7000',
			),
			array(
				'name'             => 'Paquete Grupo 10 Minutos',
				'description'      => 'Paquete de 10 minutos por persona para grupos de mínimo 5 personas (máximo 5 por heat). Incluye instrucción de seguridad, equipo de protección y acceso a pista.',
				'price'            => '5500',
				'eligibleQuantity' => array(
					'@type'   => 'QuantitativeValue',
					'minValue' => '5',
				),
			),
			array(
				'name'             => 'Paquete Grupo 15 Minutos',
				'description'      => 'Paquete de 15 minutos por persona para grupos de mínimo 5 personas (máximo 5 por heat). Incluye instrucción de seguridad, equipo de protección y acceso a pista.',
				'price'            => '6500',
				'eligibleQuantity' => array(
					'@type'   => 'QuantitativeValue',
					'minValue' => '5',
				),
			),
		),
	);
}

/**
 * -------------------------------------------------------------------
 * 7. JSON-LD: FAQPage (solo página FAQ), ES y EN.
 * -------------------------------------------------------------------
 * ES portado literalmente de 02-contenido/seo/jsonld-faqpage.json.
 * EN traducido a partir del contenido real y ya redactado de
 * 02-contenido/en/faq.md (mismas 9 preguntas que el ES, sin inventar
 * datos nuevos ni añadir las preguntas marcadas "PENDING" en ese archivo).
 *
 * @param string $lang 'es'|'en'.
 * @return array[] Lista de pares pregunta/respuesta.
 */
function srp_seo_datos_faq( $lang ) {
	$preguntas_es = array(
		array(
			'pregunta' => '¿Cuál es la edad mínima para conducir un go kart?',
			'respuesta' => 'La edad mínima para conducir solo es 9 años. Los menores de 9 años pueden participar acompañados por un adulto en el mismo kart.',
		),
		array(
			'pregunta' => '¿Es obligatorio hacer una reserva previa?',
			'respuesta' => 'Sí, la reserva previa es obligatoria. Se requiere un depósito del 50% para confirmar tu reserva.',
		),
		array(
			'pregunta' => '¿Cuál es la política de cancelación?',
			'respuesta' => 'Si cancelas con 48 horas de anticipación, tienes derecho a un reembolso completo. Cancelaciones realizadas con menos de 48 horas de anticipación no son reembolsables.',
		),
		array(
			'pregunta' => '¿Cuál es el horario de operación?',
			'respuesta' => 'Sarapiquí Race Park abre sábado, domingo y feriados de 9:00 am a 4:00 pm. Permanecemos cerrados el resto de la semana.',
		),
		array(
			'pregunta' => '¿Dónde están ubicados?',
			'respuesta' => 'Nos encontramos en Horquetas de Sarapiquí, sobre la Ruta 4, kilómetro 16, en la provincia de Heredia, Costa Rica.',
		),
		array(
			'pregunta' => '¿Cuáles son los requisitos de peso?',
			'respuesta' => 'El peso máximo permitido es 100 kg para adultos y 50 kg para niños. Estos límites son por seguridad.',
		),
		array(
			'pregunta' => '¿Qué incluye el paquete?',
			'respuesta' => 'Cada paquete incluye: carrera en kart 270cc, instrucción de seguridad previa, equipo de protección completo, uso de la pista off-road y acceso a las duchas.',
		),
		array(
			'pregunta' => '¿Cómo hago una reserva?',
			'respuesta' => 'El proceso es simple: 1) Contacta a través de WhatsApp o email, 2) Especifica la fecha, hora y cantidad de personas, 3) Elige tu paquete preferido, 4) Realiza el depósito del 50%, 5) ¡Tu reserva está confirmada!',
		),
		array(
			'pregunta' => '¿Cuáles son los datos de contacto?',
			'respuesta' => 'Puedes contactarnos por WhatsApp al +506 7210-0389 o enviar un email a info@srp.cr para realizar tu reserva.',
		),
		array(
			'pregunta' => '¿Qué pasa si llueve?',
			'respuesta' => 'Aquí no importa si llueve, se opera igual. Si hay algún cierre de ruta por problemas del temporal, el cliente no pierde su reserva: se le reagenda dentro de los siguientes 30 días naturales.',
		),
		array(
			'pregunta' => '¿Se puede ir sin reserva?',
			'respuesta' => 'No. La reserva es necesaria para comodidad del cliente: así no tiene que esperar. Llega a la hora de su reserva e ingresa a la pista de inmediato.',
		),
		array(
			'pregunta' => '¿Hay comida en el lugar?',
			'respuesta' => 'Hay convenios con restaurantes de la zona. El parque se encarga de que entreguen los pedidos dentro de las instalaciones.',
		),
		array(
			'pregunta' => '¿Cómo llegar en transporte público?',
			'respuesta' => 'Desde San José o Guápiles, tomar los buses de Los Caribeños con destino a Puerto Viejo de Sarapiquí. Pedir al chofer que avise la parada antes de Materiales Sarapiquí.',
		),
	);

	$preguntas_en = array(
		array(
			'pregunta' => "What's the minimum age to drive a go kart?",
			'respuesta' => 'The minimum age to drive a go kart solo is 9 years. Children under 9 can participate in the same go kart with an adult or responsible guardian.',
		),
		array(
			'pregunta' => 'Is advance booking required?',
			'respuesta' => 'Yes, advance booking is mandatory. A 50% deposit is required to confirm your reservation.',
		),
		array(
			'pregunta' => "What's the cancellation policy?",
			'respuesta' => '48 hours or more in advance: full deposit refund. Less than 48 hours before your reserved time: the deposit is non-refundable.',
		),
		array(
			'pregunta' => 'What are the operating hours?',
			'respuesta' => "Sarapiquí Race Park is open Saturdays, Sundays and national holidays from 9:00 am to 4:00 pm. We're closed Monday through Friday.",
		),
		array(
			'pregunta' => 'Where are you located?',
			'respuesta' => 'We are located in Horquetas de Sarapiquí, on Ruta 4, kilometer 16, in Heredia province, Costa Rica.',
		),
		array(
			'pregunta' => 'What are the weight requirements?',
			'respuesta' => 'Maximum weight is 100 kg for adults and 50 kg for children. These limits are for safety.',
		),
		array(
			'pregunta' => "What's included in the package?",
			'respuesta' => 'Each package includes: 270cc go kart racing, a pre-race safety briefing, full protective gear, off-road track access and shower facilities.',
		),
		array(
			'pregunta' => 'How do I make a reservation?',
			'respuesta' => 'The process is simple: 1) Contact us via WhatsApp or email, 2) Specify the date, time and number of people, 3) Choose your preferred package, 4) Make the 50% deposit, 5) Your reservation is confirmed!',
		),
		array(
			'pregunta' => 'What are your contact details?',
			'respuesta' => 'You can contact us via WhatsApp at +506 7210-0389 or by email at info@srp.cr to make your reservation.',
		),
		array(
			'pregunta' => 'What happens if it rains?',
			'respuesta' => "It doesn't matter if it rains — we operate the same. If a road closure occurs due to severe weather, your reservation is not lost: we'll reschedule you within the following 30 days.",
		),
		array(
			'pregunta' => 'Can I show up without an advance reservation?',
			'respuesta' => 'No. Advance booking is required — we cannot accommodate walk-ins without a reservation. Please contact us ahead of time to secure your spot.',
		),
		array(
			'pregunta' => 'Is food available at the park?',
			'respuesta' => 'Yes, food is available. We have agreements with local restaurants who deliver orders to our facilities. You can enjoy a great meal between races.',
		),
		array(
			'pregunta' => 'Can I use public transportation?',
			'respuesta' => 'Yes, public transportation is available. From San José or Guápiles, take the Los Caribeños buses heading to Puerto Viejo de Sarapiquí. Ask the driver to let you know at the stop before Materiales Sarapiquí. For exact schedules, contact us on WhatsApp at +506 7210-0389 or by email at info@srp.cr.',
		),
	);

	return 'en' === $lang ? $preguntas_en : $preguntas_es;
}
