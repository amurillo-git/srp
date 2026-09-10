# SEO del tema — sin plugin (brief, sección 6.1)

Este documento explica qué hacen `inc/seo.php` e `inc/seo-datos.php`, dónde pega Adrián los
datos que faltan y cómo validar la entrega antes de cerrarla. Ningún plugin de SEO se instala:
todo se inyecta desde el tema, enganchado en `wp_head`.

## 1. Los dos archivos

| Archivo | Qué contiene |
|---|---|
| `inc/seo-datos.php` | **Solo datos**: los arrays PHP con título/description/OG de las 7 páginas en ES y EN (portados de `02-contenido/seo/metadatos.json` y `metadatos-en.json`), los datos de LocalBusiness/AggregateOffer/FAQPage (portados de los 3 JSON-LD ya validados), y las constantes de coordenadas y la funcion de redes sociales, ya rellenas. |
| `inc/seo.php` | **Solo lógica**: lee `seo-datos.php` y engancha en `wp_head`/`language_attributes`/`pre_get_document_title` para imprimir todo. |

Para editar un título o una meta description, Adrián solo necesita abrir `seo-datos.php` y
cambiar el texto entre comillas — no hace falta tocar `seo.php`.

## 2. Qué emite cada función (para el verificador)

- `srp_seo_language_attributes()` (filtro `language_attributes`): pone `lang="es"` o `lang="en"`
  en `<html>` según `srp_idioma_actual()` (definida en `inc/cta-reserva.php`, detecta `/en/` en
  la URL).
- `srp_seo_document_title()` (filtro `pre_get_document_title`): sustituye el `<title>` de WordPress
  por el de `seo-datos.php` cuando la página es una de las 7 mapeadas.
- `srp_seo_hreflang_es_actual()` / `srp_seo_hreflang_en_actual()` (filtros `srp_hreflang_es` /
  `srp_hreflang_en` que ya existían en `functions.php`): hacen que el selector de idioma del
  header enlace a la página alterna real, no siempre a la portada.
- `srp_seo_meta_tags()` (acción `wp_head`, prioridad 1): imprime, en este orden, meta
  description, `<link rel="canonical">`, el juego completo de `hreflang` (`es`, `en` y
  `x-default` — el `x-default` apunta siempre al español, brief sección 8), Open Graph completo
  (`og:title`, `og:description`, `og:image`, `og:url`, `og:type`, `og:locale`, `og:site_name`) y
  Twitter Card (`summary_large_image`).
- `srp_seo_jsonld()` (acción `wp_head`, prioridad 5): imprime uno o más bloques
  `<script type="application/ld+json">`:
  - `srp_seo_construir_localbusiness()` → `LocalBusiness`/`SportsActivityLocation`, en las 7 páginas.
  - `srp_seo_construir_offers()` → `AggregateOffer`, solo cuando la página es Precios.
  - `srp_seo_construir_faqpage( $lang )` → `FAQPage`, solo cuando la página es FAQ (con las
    preguntas en el idioma correspondiente).
  - Todos usan `wp_json_encode( $datos, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES )` para
    que tildes/eñes y URLs no salgan escapadas.
- `srp_seo_identificar_pagina()`: compara el `post_name` real de la página que se está viendo
  contra los `post_name` declarados en `seo-datos.php`, y devuelve a qué de las 7 páginas
  corresponde y en qué idioma. Si la página no es ninguna de las 7 (404, búsqueda, etc.), todo
  el módulo se queda callado y WordPress hace lo de siempre.
- `srp_seo_urls_alternas( $clave )`: dado un identificador de página (`inicio`, `precios`...),
  devuelve el par de URLs absolutas ES/EN — es la función que pide el encargo para resolver el
  par de URLs de cada página a partir del mapeo del frontmatter de `02-contenido/en/`.

## 3. Dónde pega Adrián las coordenadas GPS

Al principio de `inc/seo-datos.php`:

```php
define( 'SRP_SEO_GEO_LATITUDE', '10.342081' );
define( 'SRP_SEO_GEO_LONGITUDE', '-83.954097' );
```

**Ya estan rellenas** con las coordenadas que Adrian confirmo el 10 sep 2026, asi que el campo `geo`
se emite. La logica se mantiene: si cualquiera de las dos quedara vacia, el
campo `geo` completo se omite del JSON-LD de LocalBusiness — no se imprime con ceros ni con un
valor de relleno.

## 4. Perfiles sociales (ya configurados, salvo TripAdvisor)

Misma sección de `inc/seo-datos.php`, función `srp_seo_perfiles_sociales()`:

```php
function srp_seo_perfiles_sociales() {
	return array(
		'https://www.instagram.com/sarapiquiracepark',
		'https://www.facebook.com/sarapiquiracepark',
		'https://www.tiktok.com/@sarapiquiracepark',
		'https://linktr.ee/sarapiquiracepark',
		// PENDIENTE: TripAdvisor. Registrado como "Sarapiqui Race Park" pero aun no activo.
		// Cuando exista la ficha, anadir su URL aqui. NO inventar la URL.
	);
}
```

Descomentar y completar solo las líneas de los perfiles que existan de verdad. **Mientras el
array esté vacío**, el campo `sameAs` completo se omite del JSON-LD — nunca se inventa una URL.

## 5. Dónde pega Adrián el ID de GA4

**No es este archivo.** El hueco de Google Analytics 4 / Google Tag Manager ya lo dejó preparado
el agente de tema base en `functions.php`, en la constante `SRP_GA4_MEASUREMENT_ID` (sección
"Google Analytics 4 / Google Tag Manager - hueco preparado, SIN ID"). `inc/seo.php` no toca
analítica: solo metadatos, Open Graph, JSON-LD y hreflang.

## 6. Imagen Open Graph

Se usa la misma foto para las 7 páginas, tal como la fija `01-spec/assets.json` en su campo
`open_graph`: `assets-web/go-kart-270cc-salpicando-lodo-pista-off-road-sarapiqui-og-1200x630.webp`
(1200×630). La URL absoluta la construye `srp_seo_og_image_url()` en `seo-datos.php`, asumiendo
que `assets-web/` queda copiada dentro del tema (mismo criterio que las imágenes 480/960/1600 que
ya usa `functions.php`). Si en el sitio real esa carpeta termina sirviéndose desde la biblioteca
de medios de WordPress en vez de desde el tema, basta con enganchar el filtro
`srp_seo_og_image_url` — no hace falta tocar el resto de la lógica.

## 7. Verificación de JSON-LD hecha en esta entrega

Este entorno de desarrollo no tiene un intérprete PHP disponible (`php` no existe en el PATH), así
que la validación de sintaxis de `seo.php`/`seo-datos.php` no pudo ejecutarse con `php -l` y queda
pendiente de que el verificador (u otro entorno con PHP) la corra.

Sí se verificó el **contenido y la forma exacta del JSON-LD** que producen
`srp_seo_construir_localbusiness()` y `srp_seo_construir_offers()`: se transcribió campo por campo
a un script Python (`json.dumps(..., ensure_ascii=False)` seguido de `json.loads()`, equivalente a
`wp_json_encode(..., JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)`), para el caso de **Inicio**
(solo LocalBusiness, sin `geo` ni `sameAs` porque las constantes/el array están vacíos, como debe
ser) y de **Precios** (LocalBusiness + AggregateOffer). Resultado: los tres bloques son JSON válido
y conservan tildes/eñes sin escapar. Antes de cerrar la entrega en un WordPress real, de todos
modos hace falta:

1. Correr `php -l inc/seo.php` e `inc/seo-datos.php` en un entorno con PHP 8.3.
2. Activar el tema, visitar cada una de las 7 páginas en ES y EN, y pasar la URL por
   [Google Rich Results Test](https://search.google.com/test/rich-results) para confirmar que
   Google reconoce `LocalBusiness`, `AggregateOffer` (en Precios) y `FAQPage` (en FAQ) sin errores.
3. Repetir esa validación después de pegar las coordenadas GPS y los perfiles sociales, para
   confirmar que `geo` y `sameAs` aparecen bien formados.

## 8. Qué NO hace este módulo (fuera de alcance, a propósito)

- No imprime ningún script de analítica (eso vive en `functions.php`, ver sección 5 de arriba).
- No inventa coordenadas, URLs de redes sociales, ni IDs de medición (brief, sección 9).
- No traduce topónimos: "Ruta 4" queda igual en `es` y en `en`.
- No genera sitemap.xml ni robots.txt: fuera del encargo de este agente.
