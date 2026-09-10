# Mapa de secciones — plantillas de bloques

Documento de mantenimiento del agente **tema-plantillas**. Para cada plantilla en `templates/`,
indica qué sección de qué archivo de `02-contenido/` alimenta cada bloque, para que Adrián pueda
actualizar contenido sin tener que adivinar la correspondencia.

Fuente de contenido: `02-contenido/es/*.md` (español, el único idioma con plantilla de contenido
propia en esta fase — ver "Bilingüe" al final). Fuente de imágenes: `01-spec/assets.json`.

## Convención de rutas de imagen (pendiente de copiar, igual que el logo)

Los 46 WebP de `assets-web/` (anchos 480/960/1600 + 1 OG) **no forman parte de los archivos que este
agente tenía permiso de escribir**. Las plantillas los referencian ya copiados a una ruta dentro del
tema, con la misma convención que `parts/header.html` ya usa para el logo:

```
/wp-content/themes/sarapiqui-race-park/assets/images/{slug}-{480|960|1600}.webp
```

**Acción pendiente para Adrián (o el agente de despliegue):** copiar el contenido de `assets-web/`
a `wp-content/themes/sarapiqui-race-park/assets/images/` tal cual, sin renombrar archivos — los
`slug` de `assets.json` ya coinciden con el nombre de archivo sin el sufijo de ancho.

## Transparencias de negro introducidas en esta fase (para el README del tema)

`tema-base` documentó en `style.css` las transparencias de negro para separadores/foco. Esta fase
añade una más, **solo dentro de `templates/page-precios.html`** (bloques `core/html`, no en `style.css`):

- `border: 1px solid rgba(0, 0, 0, 0.15)` — borde sutil de las tarjetas de precio (`.srp-price-card`),
  mismo criterio que el separador del header (`rgba(0,0,0,0.12)`): un elemento gráfico/estructural,
  no texto, así que no está sujeto al umbral de contraste de texto de la paleta cerrada de 3 colores.

No se introdujo ningún color fuera de Elite Sand / Impact Red / Total Force.

## front-page.html (Inicio, slug `inicio`, `02-contenido/es/inicio.md`)

| Bloque | Contenido / fuente |
|---|---|
| `wp:template-part` header/footer | `parts/header.html`, `parts/footer.html` (ya existentes) |
| H1 (`core/heading` nivel 1) | Título H1 exacto del `.md`: "Vive la Emoción del Off-Road en Sarapiquí Race Park". **Es el único H1 de la plantilla** — corrige el hallazgo de `01-spec/auditoria.md` donde el tema anterior autogeneraba el H1 desde el título SEO. |
| Párrafo lead | Línea bajo el H1 del `.md` ("Go karts de 270cc en una pista de 500m...") |
| CTA shortcode (x2: tras el lead y al final) | `[srp_cta_reserva]` → `inc/cta-reserva.php`, nunca la URL literal |
| H2 "Quiénes Somos" + 2 párrafos + imagen | Sección `## Quiénes Somos` del `.md`. Imagen: `go-kart-270cc-salpicando-lodo-pista-off-road-sarapiqui` — es el `hero_inicio` de `assets.json`, por eso lleva `loading="eager" fetchpriority="high"` aunque no sea el primer elemento visual de la página (sigue el orden del contenido redactado) |
| H2 "Actividades Destacadas" + lista + imagen | Sección `## Actividades Destacadas` del `.md`. Imagen `familia-feliz-nina-casco-go-kart-sarapiqui`, lazy |
| H2 "Por Qué Elegirnos" + lista + imagen | Sección `## Por Qué Elegirnos` del `.md`. Imagen `amigos-sonrientes-lodo-fin-recorrido-karts`, lazy |
| H2 "Conoce Nuestros Servicios" | Sección `## Conoce Nuestros Servicios` del `.md`, con enlaces internos ya presentes en el contenido a `/actividades/`, `/precios/`, `/ubicacion-horarios/` |
| H2 "Reserva Tu Experiencia Ahora" (CTA final) | Corresponde a `## Reserva por WhatsApp` del `.md`; el enlace `https://wa.me/...` del `.md` se reemplaza por el shortcode `[srp_cta_reserva]` (regla 7.1: nunca hardcodear WhatsApp). Teléfono/email quedan como texto + `tel:`/`mailto:`, que no son el enlace de reserva |

## page-actividades.html (slug `actividades`, `02-contenido/es/actividades.md`)

Un H1 ("Experiencias de Karting en Sarapiquí Race Park") + un H2 por cada `##` del `.md` en el mismo
orden: Los Mejores Karts de Costa Rica (con H3 Especificaciones Técnicas), Pista Off-Road Profesional,
Requisitos y Restricciones, Seguridad, Terreno Variado, Horarios de Operación, Información Importante.
Las 6 imágenes de la sección `imagenes:` del front matter se insertan en el mismo punto donde aparece
`[IMAGEN: ...]` en el `.md`, todas `loading="lazy"`. La sección final "Reserva Tu Carrera Ahora" usa
`[srp_cta_reserva]` en vez del enlace de WhatsApp literal del `.md`.

## page-ubicacion-horarios.html (slug `ubicacion-horarios`, `02-contenido/es/ubicacion-horarios.md`)

H1 + H2 por sección: Dónde Encontrarnos (con el `iframe` del mapa), Cómo Llegar, Horarios de
Operación, Información Importante, Cómo Reservar (lista ordenada), Contacto y Reservas, Términos de
Cancelación, y un bloque final de CTA que corresponde a `## Reserva por WhatsApp` del `.md`.

**Mapa:** el `.md` solo trae el enlace corto `https://maps.app.goo.gl/Rk2z39BCwLQFtY4A9` (no es
embebible como `src` de iframe de forma fiable porque es un redirect). El `iframe` usa
`https://maps.google.com/maps?q=<dirección real>&output=embed`, construido con el texto exacto de la
dirección del brief ("Sarapiquí Race Park, Ruta 4, Horquetas de Sarapiquí, Costa Rica"). **No se
inventó ninguna coordenada GPS** (regla inviolable): es una búsqueda por texto, no por lat/long. El
enlace corto original se deja además como texto visible ("Abrir la ubicación en Google Maps") y en
`parts/footer.html`. El `iframe` lleva `loading="lazy"` y un `title` descriptivo para lectores de
pantalla, tal como pide el encargo.

## page-precios.html (slug `precios`, `02-contenido/es/precios.md`)

H1 + H2 por sección del `.md`. Las 5 tarifas (Vuelta Individual, Paquete 10 Min, Paquete 15 Min, Grupo
10 Min, Grupo 15 Min) se muestran como tarjetas apiladas en un `core/html` con `display:flex` +
`flex-wrap:wrap` dentro de un contenedor `overflow-x:auto` — nunca como tabla ancha, para que el
`body` no scrollee en horizontal en pantallas angostas. El resto de secciones (Qué Está/No Está
Incluido, Términos y Condiciones, Requisitos de Edad y Peso, Horarios, Dudas) siguen el `.md` sección
por sección. La tabla de tiempos de viaje (si se necesitara aquí) no se usó porque esa tabla vive en
`page-faq.html`; aquí no se repite contenido ancho.

## page-galeria.html (slug `galeria`, `02-contenido/es/galeria.md`)

H1 + H2 por cada agrupación temática del `.md`: Acción Pura: En la Pista (7 fotos), Pilotos y Grupos
en Acción (4 fotos), Para Toda la Familia (2 fotos), Instalaciones y Acceso (2 fotos) — total 15 fotos,
exactamente las que existen en `assets.json` (no se inventó ninguna foto adicional). Cada grupo es un
`core/html` con `display:grid; grid-template-columns:repeat(auto-fill,minmax(220px,1fr))`, responsivo
sin media queries adicionales. La sección "Contenido de Video" documenta en texto visible que los 7
videos reales están pendientes de compresión (no hay ffmpeg en la máquina), tal como exige
`assets.json → videos.estado`; no se inserta ningún `<video>` ni póster inventado. Se añadieron 2
enlaces internos nuevos hacia `/actividades/` y `/precios/` con texto descriptivo (mejora pendiente
que señalaba la Fase 2, sección "Notas de Cobertura Fotográfica" del `.md` no los traía enlazados).

## page-faq.html (slug `faq`, `02-contenido/es/faq.md`)

H1 + un H2 por cada agrupación temática del `.md` (Edades y Requisitos, Reservas y Pagos, Horarios de
Operación, Cómo Llegar, Precios y Paquetes, Proceso de Reserva). Cada par pregunta/respuesta es un
bloque `core/html` con `<details class="srp-faq-item"><summary>` — funciona sin JavaScript (widget
nativo del navegador) y es compatible con la estructura de `Question`/`acceptedAnswer` del
`02-contenido/seo/jsonld-faqpage.json` ya validado: el texto de `<summary>` coincide literalmente con
cada `name` del JSON-LD y el texto dentro de `<details>` coincide con cada `acceptedAnswer.text`.

**Excluido a propósito:** la sección `## PENDIENTES DE CONFIRMAR CON ADRIAN` del `.md` (lluvia, llegar
sin reserva, comida en el lugar, ruta exacta de bus) **no se publicó** porque son respuestas sin
confirmar; publicarlas violaría la sección 9 del brief (no inventar información). Cuando Adrián las
confirme, se añaden como nuevos bloques `<details>` en la sección correspondiente.

Se añadieron enlaces internos con texto descriptivo hacia `/precios/` y `/actividades/` en varias
respuestas (mejora pendiente que la Fase 2 dejó sin resolver), nunca con el texto "haz clic aquí".

## page.html (plantilla de página por defecto)

Genérica: `wp:post-title` (H1, nivel 1) + `wp:post-featured-image` + `wp:post-content` (el contenido
real se edita en el editor de bloques de WordPress) + un CTA final con `[srp_cta_reserva]`. La usa
cualquier página que no tenga una plantilla `page-{slug}.html` más específica.

## index.html (fallback genérico del tema)

Único fallback cuando ninguna otra plantilla aplica (búsquedas, archivos 404 no capturados, o
cualquier tipo de contenido no cubierto). Usa `wp:query` con `inherit:true` + `wp:post-template`. El
título de cada resultado del loop es `core/post-title` **nivel 2** (no nivel 1): en un archivo con
varios resultados, un H1 por cada tarjeta rompería la regla de "un único H1 por plantilla"; el nivel 2
evita esa colisión sin dejar de ser semánticamente correcto para una lista de resultados.

## Sobre Nosotros — NO se creó plantilla publicable

`02-contenido/es/sobre-nosotros.md` trae en su front matter `estado: borrador` y el aviso explícito
**"BORRADOR — NO PUBLICAR"**: es una estructura de preguntas pendientes para Adrián, sin contenido real
todavía. Por instrucción directa del encargo ("NO crees plantilla publicable para Sobre Nosotros"), no
se generó `page-sobre-nosotros.html`. La página, si se crea en WordPress con ese slug, caerá
automáticamente en `page.html` (la plantilla genérica) hasta que exista una plantilla dedicada; el
enlace de navegación a `/sobre-nosotros/` ya existe en `parts/header.html` (trabajo de `tema-base`),
así que no falta nada de ese lado. Cuando Adrián entregue el contenido real, un agente posterior debe
crear `templates/page-sobre-nosotros.html` siguiendo el mismo patrón que las demás páginas de esta
fase.

## Bilingüe (ES/EN)

Esta fase solo escribió el contenido de `02-contenido/es/` directamente en las plantillas de bloques,
tal como pidió el encargo. `02-contenido/en/` existe con el contenido equivalente en inglés, pero
**no genera plantillas `page-{slug}-en.html` separadas** porque la jerarquía de plantillas de
WordPress no soporta esa variante por slug de forma nativa sin un plugin de idiomas. El mecanismo
vigente (`srp_idioma_actual()` en `functions.php`, ya escrito por `tema-base`) detecta `/en/...` por
URL y ajusta el texto del CTA; las 7 páginas en inglés deberán crearse en el editor de WordPress con
la plantilla `page.html` (genérica) y el contenido de `02-contenido/en/` pegado en el editor de
bloques, o bien un agente futuro puede clonar cada `page-{slug}.html` reemplazando los textos por los
de `02-contenido/en/` si se prefiere contenido "hardcodeado" también en inglés. Se documenta aquí para
que Adrián no asuma que las páginas en inglés ya están listas.
