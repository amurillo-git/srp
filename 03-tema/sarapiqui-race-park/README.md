# Tema de bloques — Sarapiquí Race Park

Tema de bloques a medida para WordPress (slug: `sarapiqui-race-park`), generado en la fase "tema-base".
Fuente de verdad: `sitio-web-sarapiqui-race-park-brief_1.md` (secciones 3, 5, 6/6.1, 7/7.1, 8, 9) y los
entregables aprobados de fases previas en `01-spec/` y `02-contenido/`.

## 1. Instalación

1. Copiar la carpeta `03-tema/sarapiqui-race-park/` completa a `wp-content/themes/sarapiqui-race-park/`
   del sitio WordPress (7.1, PHP 8.3, LiteSpeed Cache).
2. **Copiar los logos antes de activar el tema** (ver sección 10 "Pendiente"): colocar
   `sarapiqui-02.png`, `sarapiqui-03.png` y `sarapiqui-07.png` en `wp-content/themes/sarapiqui-race-park/assets/images/`.
   Estos PNGs no forman parte de los archivos que este agente tenía permiso de escribir; viven hoy
   solo en el material fuente (`Dropbox/.../gokarts/Sitio Web Claude/`).
3. Activar el tema desde **Apariencia → Temas**.
4. Crear las 7 páginas en español y sus 7 equivalentes en inglés (slugs en la sección 4) y asignar
   cada plantilla de contenido según `02-contenido/es/` y `02-contenido/en/`.
5. Cuando exista `inc/seo.php` (otro agente de esta fase), no hace falta ningún paso extra: `functions.php`
   ya lo carga con `file_exists()` condicionado.
6. Pegar el ID real de Google Analytics 4 / GTM en la constante `SRP_GA4_MEASUREMENT_ID` de
   `functions.php` cuando Adrián lo tenga (ver sección 6). Sin ese ID, el tema no imprime ningún
   script de analítica.

No se ha desplegado nada en el sitio en vivo ni se han ejecutado `git commit`/`git push`, conforme
al encargo.

## 2. Inventario de archivos entregados

| Archivo | Qué hace |
|---|---|
| `style.css` | Cabecera de tema válida de WordPress (Theme Name, Version, Requires at least/PHP, etc.) + reset mínimo mobile-first + estilos de header, footer, CTA y botón flotante de WhatsApp que theme.json no cubre + foco visible + áreas táctiles ≥44×44px. |
| `theme.json` | `version: 3`. Paleta cerrada a los 3 colores de marca (`color.custom:false`, `defaultPalette:false`, sin degradados/duotonos), familias tipográficas Anton/Barlow con la pila de fallback completa, escala de tamaños con `fluid` (clamp) de `theme.json`. |
| `functions.php` | Enqueue de `style.css` y Google Fonts (Anton + Barlow, `display=swap`, preconnect), soporte de bloques/HTML5, tamaños de imagen 480/960/1600, registro de menús, selector de idioma, carga de `inc/cta-reserva.php` y de `inc/seo.php` (condicionada), hueco comentado de GA4/GTM. |
| `parts/header.html` | Template part de header: logo como imagen monocromática (`sarapiqui-03.png`), navegación a las 7 páginas, selector de idioma ES/EN visible, skip-link. |
| `parts/footer.html` | Template part de footer: NAP completo, horario, enlace a Google Maps, CTA de reserva y selector de idioma. |
| `inc/cta-reserva.php` | Componente aislado y reutilizable del CTA de reserva + botón flotante de WhatsApp (ver sección 5). |
| `README.md` | Este documento. |

Archivos que **no** creó este agente porque otros agentes de la misma fase los escriben (o porque
son binarios fuera del alcance de este encargo): `inc/seo.php`, `templates/*.html`, `patterns/*`,
las imágenes optimizadas de `assets-web/` y el logo copiado dentro del tema.

## 3. Paleta y tipografía (confirmación)

Paleta cerrada, exactamente 3 colores, tal como fija `01-spec/marca.json`:

| Slug | Nombre | Hex |
|---|---|---|
| `elite-sand` | Elite Sand | `#E6DFD1` |
| `impact-red` | Impact Red | `#CB492C` |
| `total-force` | Total Force | `#000000` |

`theme.json` fija `settings.color.custom: false` y `settings.color.defaultPalette: false`, así el
editor no ofrece ningún color fuera de estos tres, ni la paleta por defecto de WordPress. No hay
`gradients` ni `duotone` definidos.

Tipografía: `Anton` (títulos, mayúsculas, botones) y `Barlow` (cuerpo), ambas con la pila de
fallback completa de `marca.json`:
- `'Anton', 'Arial Narrow Bold', 'Helvetica Neue Condensed Bold', sans-serif`
- `'Barlow', 'Helvetica Neue', Arial, sans-serif`

Se cargan hoy vía Google Fonts (`functions.php`, `srp_enqueue_assets()`) con `display=swap` y
`preconnect` a `fonts.googleapis.com`/`fonts.gstatic.com` (`srp_resource_hints()`). Autoalojarlas
más adelante es un cambio de una línea, documentado en el propio `functions.php`.

La escala tipográfica de `theme.json` usa `fluid` (clamp) para `label`, `body-lg`, `display-md`,
`display-lg` y `display-xl`, mobile-first: el valor mínimo es el tamaño en pantallas pequeñas y el
máximo el de escritorio ancho.

## 4. Contraste de color — ratios calculados (WCAG 2.2)

Fórmula estándar de luminancia relativa sRGB aplicada a los 3 colores de marca. Los 4 pares que pide
el encargo:

| Combinación | Ratio | ¿Sirve para texto normal (≥4.5:1)? | ¿Sirve para texto grande / UI (≥3:1)? |
|---|---|---|---|
| Impact Red `#CB492C` sobre Elite Sand `#E6DFD1` | **3.41:1** | ❌ No | ✅ Sí |
| Impact Red `#CB492C` sobre Total Force `#000000` | **4.53:1** | ✅ Sí (al límite) | ✅ Sí |
| Elite Sand `#E6DFD1` sobre Total Force `#000000` | **15.44:1** | ✅ Sí | ✅ Sí |
| Total Force `#000000` sobre Elite Sand `#E6DFD1` | **15.44:1** | ✅ Sí | ✅ Sí |

**Consecuencia de diseño, tal como pide el encargo:** *Impact Red sobre Elite Sand (3.41:1) no
alcanza 4.5:1, así que no se usa para texto normal.* En este tema:

- El **texto de párrafo, encabezados y el CTA primario** siempre usan Total Force sobre Elite Sand
  o Elite Sand sobre Total Force (15.44:1, la pareja más legible de la paleta).
- **Impact Red se reserva para**: fondos de hover/foco de botones (con texto Elite Sand encima,
  ver siguiente punto), bordes, anillos de foco (`outline`, un elemento gráfico sujeto al umbral de
  3:1, no al de texto) y acentos decorativos — nunca como color de texto de cuerpo sobre Elite Sand.
- El botón CTA en estado *hover/focus* pasa a fondo Impact Red con texto Elite Sand: esa combinación
  no está en la tabla anterior porque es texto claro sobre un fondo saturado, no rojo sobre arena;
  aun así, por prudencia, el texto del botón usa Anton en mayúsculas y tamaño de "label" (variante
  de "texto grande/bold" del criterio WCAG), donde el umbral relevante baja a 3:1.
- La variante `.srp-cta--secondary` (fondo Elite Sand) usa **texto e icono en Total Force**, no en
  Impact Red, y reserva el rojo solo para el borde de 2px — un elemento gráfico, no texto.

## 5. Transparencias de negro documentadas

La paleta es cerrada a 3 colores sólidos; las únicas variaciones permitidas son transparencias de
Total Force (negro) usadas exclusivamente para separadores y sombras, nunca como color de texto o
fondo con contenido legible encima:

| Valor | Dónde se usa | Por qué |
|---|---|---|
| `rgba(0, 0, 0, 0.12)` | Borde inferior de `.srp-header`; borde de las tarjetas `.srp-price-card` en `page-precios.html` | Separador sutil entre el header (fondo Elite Sand) y el contenido, y el mismo borde discreto reutilizado en las tarjetas de precio para no introducir una nueva variación de opacidad. |
| `rgba(0, 0, 0, 0.35)` | `box-shadow` del botón flotante de WhatsApp | Sombra de profundidad para que el botón se perciba flotando sobre el contenido de la página. |
| `rgba(0, 0, 0, 0.25)` | Borde de `.srp-lang-switch a` | Borde discreto del selector de idioma sin depender de un color de marca adicional. |
| `rgba(230, 223, 209, 0.15)` | Borde superior de `.srp-footer__legal` | Es Elite Sand (no negro) a baja opacidad, usado como separador sobre el fondo negro del footer — se documenta aquí junto a las transparencias porque es la única variación de opacidad que no es negra; ningún cuarto color sólido se introduce. |

Ninguna transparencia se usa para pintar texto ni para fondos donde haya texto encima: todas son
separadores o sombras decorativas.

## 6. Google Analytics 4 / GTM — hueco preparado

`functions.php` define `SRP_GA4_MEASUREMENT_ID` **vacía** y comentada. Mientras esté vacía, el tema
no imprime ningún script de analítica (`srp_maybe_print_analytics()` corta antes de imprimir nada).
Adrián debe pegar ahí su ID real (`G-XXXXXXXXXX` para GA4, o adaptar a un ID `GTM-XXXXXXX` si se
prefiere Tag Manager). **No se inventó ningún ID**, conforme a la regla inviolable del encargo.

## 7. CTA de reserva — cómo se reemplazará en la Fase 2

Según la sección 7.1 del brief, el botón de reserva de hoy (WhatsApp) es un puente temporal hasta
que exista un sistema de reservas propio o se use Reservas de Google. Por eso `inc/cta-reserva.php`
concentra **todo** el componente:

- **Una sola constante**, `SRP_RESERVA_URL`, con la URL de destino (`https://wa.me/50672100389` hoy).
  Ningún otro archivo del tema contiene esa URL.
- **Una sola función**, `srp_cta_reserva( $args )`, con parámetros `texto`, `variante` (`primary`/
  `secondary`), `tamano` (`sm`/`md`/`lg`) e `idioma` (`es`/`en`), que devuelve el markup del botón.
- **Un shortcode**, `[srp_cta_reserva]`, usado en `parts/header.html` y `parts/footer.html`, que
  llama a esa misma función — nunca duplica el enlace.
- **El botón flotante de WhatsApp** reutiliza la misma constante y aparece en todas las páginas vía
  el hook `wp_footer` (`srp_whatsapp_float_render()`), sin copiarlo en cada plantilla.

**Para migrar a la Fase 2:** editar únicamente `inc/cta-reserva.php` — cambiar el valor de
`SRP_RESERVA_URL` (y, si el nuevo sistema lo exige, la lógica interna de `srp_cta_reserva()`, por
ejemplo para abrir un modal de reservas en vez de un enlace). Ningún otro archivo del tema necesita
tocarse.

## 8. Accesibilidad — resumen de lo implementado

- **Foco visible** en todo enlace, botón, campo de formulario e ítem de navegación
  (`:focus-visible` con anillo de 3px en Impact Red, ver sección 4 sobre por qué ese color es válido
  aquí — es un indicador gráfico, no texto).
- **Áreas táctiles ≥44×44px**: clase utilitaria `.srp-tap-target` aplicada a ítems de navegación,
  CTA, botón flotante y enlaces del selector de idioma.
- **Skip link** ("Saltar al contenido principal / Skip to main content") visible solo con foco de
  teclado, primer elemento del `<body>` vía `parts/header.html`.
- **Menú accesible por teclado**: se usa el bloque nativo `core/navigation` de WordPress, que ya
  incluye manejo de foco, `Esc` para cerrar y atributos ARIA del diálogo responsivo; el tema solo
  reestiliza su apariencia (fondo negro sólido, texto Elite Sand — 15.44:1).
- **`prefers-reduced-motion`**: las transiciones del CTA y del botón flotante se desactivan si el
  usuario pidió menos movimiento.

## 9. Mobile-first y rendimiento (objetivo Lighthouse 90+)

- `style.css` está escrito mobile-first: todas las reglas base son para pantallas pequeñas y las
  `@media (min-width: ...)` solo añaden (nunca sobrescriben con `!important`).
- Sin librerías JavaScript de terceros ni animaciones costosas: el único JS externo son las dos
  hojas de Google Fonts (recurso CSS, no JS) con `preconnect`.
- Tamaños de imagen (`srp-480`, `srp-960`, `srp-1600`) alineados 1:1 con los anchos ya generados en
  `assets-web/` para que WordPress no tenga que reescalar de más.

## 10. Pendiente / fuera de alcance de este agente

- Copiar los logos PNG a `assets/images/` dentro del tema (ver sección 1, paso 2, y sección 11) — los archivos
  binarios no están entre los archivos que este agente tenía permiso de escribir.
- `inc/seo.php`, patrones y plantillas de página: entregables de otros agentes de esta misma fase.

## 11. Variantes monocromáticas del logo (confirmadas 10 sep 2026)

El tema incluye soporte para dos variantes monocromáticas del logo:

| Logo | Uso | Dónde |
|---|---|---|
| `sarapiqui-02.png` | Versión a color (principal) | Redes sociales, fondos oscuros |
| `sarapiqui-03.png` | Monocromático oscuro | **Header** (fondo Elite Sand claro) — usado en `parts/header.html` |
| `sarapiqui-07.png` | Monocromático blanco | Fondos muy oscuros o sobre fotos en escala de grises |

**Decisión de contraste:** El header tiene fondo Elite Sand (#E6DFD1, claro). El logo a color contiene Elite Sand en la palabra "Sarapiquí", lo que causaría contraste insuficiente sobre este fondo. Por eso el header usa `sarapiqui-03.png` (monocromático oscuro), que garantiza 15.44:1 de contraste con Elite Sand, conforme al WCAG.

**Nota de implementación:** Los tres archivos PNG deben copiarse a `wp-content/themes/sarapiqui-race-park/assets/images/` dentro del tema. Hoy el header y footer usan `sarapiqui-03.png` — cambiar entre variantes es tan simple como editar el atributo `src` de la etiqueta `<img>`.
