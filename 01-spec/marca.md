# Especificación de marca — Sarapiquí Race Park

Fuente de verdad leída completa para este documento:
- `manual de marca sarapiqui.pdf` (11 páginas, leídas todas con `pypdf` + render a imagen con PyMuPDF para las páginas A.04 que son solo gráficas).
- `sarapiqui-01.png` y `sarapiqui-02.png` (vistos como imagen, no solo por nombre/tamaño).
- Brief técnico, secciones 1.1, 1.2, 2, 4.3, 5, 5.1, 6, 6.1, 9 y 11.

Este documento es la spec de marca consumible por el agente de tema. El JSON hermano (`marca.json`) trae los mismos datos en formato máquina.

---

## 1. Los dos archivos de logo: qué son realmente (hallazgo importante)

El brief (línea 187) pide "verificar cuál corresponde a la versión principal a color y cuál a la versión en blanco y negro antes de usarlos". **Al abrir y mirar ambos PNG, ninguno de los dos es una versión en blanco y negro.** Los dos están a todo color, con los tres colores de la paleta (Elite Sand, Impact Red, Total Force). Esto es una diferencia frente a lo que el brief asumía sobre los archivos entregados — no una contradicción del manual, sino una corrección de hecho sobre los dos PNG concretos que había disponibles. Ver sección 4 para la señal explícita a Adrián.

### `sarapiqui-02.png` — versión principal (recomendada para uso general)
- Dimensiones: **3508 × 1772 px** (relación ≈ 1.98:1, horizontal).
- Fondo: **transparente de verdad** (canal alfa con píxeles en 0 y en 255; medí manualmente la distribución de alfa con Pillow, no asumí por el nombre). De 6 216 176 píxeles, 3 728 190 son completamente transparentes.
- Contenido visible: imagotipo "SARAPIQUÍ" en Elite Sand con contorno Total Force, "RACE PARK" en Impact Red con contorno Total Force. Coincide en composición con el ejemplo "color sobre fondo claro" de la página A.04 del manual (versiones correctas).
- Uso recomendado: logo de cabecera/header, footer, cualquier lugar donde el logo deba flotar sobre un fondo que no es negro sólido (Elite Sand, blanco, imágenes claras).

### `sarapiqui-01.png` — versión cuadrada con fondo aplicado (uso social/cuadrado, no como logo de header)
- Dimensiones: **3508 × 3508 px** (cuadrado 1:1).
- Fondo: **opaco**, sin transparencia (alfa constante en 255 en los 12 306 064 píxeles). El fondo es un patrón ilustrado de huellas de neumático en negro/gris oscuro sobre negro, con una franja diagonal color tierra/marrón detrás del texto — no es un fondo liso.
- Contenido visible: el mismo imagotipo a color (Elite Sand + Impact Red + contorno Total Force), aplicado sobre esa pieza de fondo oscuro con textura, en composición diagonal.
- Uso recomendado: pieza cuadrada tipo avatar/portada de redes sociales o imagen social (`og:image` si se quiere ese estilo), **no** como el archivo de logo de header — al no ser transparente y traer fondo propio, no se puede colocar sobre Elite Sand ni sobre fotos sin dejar un cuadro negro visible.

### Lo que el manual describe pero ningún PNG entregado cubre
La página A.04 ("Versiones correctas", ver imagen `manual_p9`) muestra 6 aplicaciones, no solo 2:
1. Color sobre fondo claro (≈ `sarapiqui-02.png`).
2. Color sobre fondo oscuro.
3. Monocromática **blanca con contorno negro** sobre fondo claro.
4. Monocromática **contorno blanco hueco** sobre fondo oscuro.
5. **Negro sólido** (100% Total Force, sin color) sobre fondo claro.
6. **Blanco sólido** (100%) sobre fondo oscuro.

Ninguno de los dos archivos PNG entregados corresponde a las versiones 3, 4, 5 o 6 (las monocromáticas reales). Si el sitio necesita el logo en negro sólido o blanco sólido (por ejemplo sobre una foto oscura, o impreso a una tinta), **no existe ese archivo hoy**. Ver sección 4 (PENDIENTE).

---

## 2. Colores corporativos (manual A.02, página 7)

Paleta única y cerrada — coincide exactamente con la regla 9 del encargo y con el brief (sección 6):

| Nombre | Uso según el manual | Pantone | Hex |
|---|---|---|---|
| Elite Sand | Palabra "Sarapiquí"; tono neutro que conecta con la tierra y el entorno natural | 7527 C | `#E6DFD1` |
| Impact Red | Palabra "Race Park"; intensidad, pasión, velocidad, mayor impacto visual | 7597 C | `#CB492C` |
| Total Force | Borde sólido del logo; fuerza y peso visual, asegura contraste sobre cualquier fondo | Black C | `#000000` |

Verificación por muestreo de píxeles en ambos PNG: los tonos medidos están dentro de una diferencia de 1 unidad de los hex oficiales (variación normal de antialiasing/compresión), confirmando que los archivos aplican la paleta correctamente — no hay que corregir nada ahí.

**No usar ningún otro color.** El manual (A.04, "versiones incorrectas", página 10) muestra explícitamente como error: degradado azul, inversión de jerarquía cromática entre "Sarapiquí" y "Race Park", y un solo color plano (rojo/marrón) para todo el logotipo — los tres coinciden con lo que ya anticipaba el brief (línea 189).

---

## 3. Tipografía

### 3.1 Tipografía del logotipo (según el manual, A.03, página 8)

El manual **no da un nombre de fuente** para el logotipo — lo describe cualitativamente:
> "una fuente sin serif para el nombre de marca con tendencias gráficas modernas, minimalistas y cercanas [...] tipografía en mayúsculas, robusta y en cursiva diagonal [...] transmite movimiento y energía [...] acabados con bordes desgastados en la S inicial [...] carácter agresivo y deportivo".

En resumen, características a preservar conceptualmente (no a recrear en CSS): sans-serif, todo mayúsculas, trazo grueso/robusto, inclinación diagonal tipo cursiva, y desgaste tipo brocha/neumático en la "S" inicial de "Sarapiquí". Esto es lettering ilustrado a mano/vectorizado, no una fuente estándar aplicada tal cual — **por eso el imagotipo se usa siempre como imagen (PNG), nunca recreado como texto o CSS**, tal como exige el encargo y el brief (línea 201).

Nota técnica encontrada al leer los metadatos del PDF: el propio manual (para su maquetación, títulos como "A.04 VERSIONES CORRECTAS" y los párrafos de cuerpo) usa las fuentes `LeagueSpartan-Bold` y `CaxtonStd-Book` incrustadas. **Estas son las fuentes del documento del manual, no la fuente del logotipo** — no hay que confundirlas ni usarlas como sustituto del logo.

### 3.2 Fuentes web propuestas para el sitio (títulos y cuerpo)

El brief (línea 201) pide: una display robusta/condensada de carácter deportivo para títulos, y una sans-serif limpia y muy legible para el cuerpo. Los karts deben ir en el brief final, no en este documento; ambas propuestas usan fuentes reales, gratuitas y disponibles en Google Fonts (cargables por CDN estándar).

**Títulos / display: "Anton"**
- Pila de fallback completa: `'Anton', 'Arial Narrow Bold', 'Helvetica Neue Condensed Bold', sans-serif`
- Por qué encaja: es una sans-serif de trazo muy grueso y condensado, pensada para mayúsculas de alto impacto — mismo espíritu "robusto" y "agresivo/deportivo" que describe el manual para el logotipo, sin intentar imitar el lettering cursivo/desgastado del imagotipo (que sigue siendo exclusivo de la imagen). Funciona bien en H1/H2 de gran tamaño y en botones/CTA cortos.

**Cuerpo de texto: "Barlow"**
- Pila de fallback completa: `'Barlow', 'Helvetica Neue', Arial, sans-serif`
- Por qué encaja: es una sans-serif humanista de origen ligado a señalética de tránsito/deportiva, con buena legibilidad en párrafos largos y amplio soporte de tildes y "ñ" (necesario para español de Costa Rica). Su carácter técnico-deportivo discreto complementa a Anton sin competir por atención, y ofrece suficientes pesos (400/500/600/700) para jerarquía de texto sin necesitar una tercera familia.

Ambas están disponibles vía Google Fonts; si el hosting de WordPress no puede llamar a Google Fonts por política de privacidad, ambas también se pueden autoalojar (archivos `.woff2` descargables de Google Fonts) — decisión que le corresponde al agente de tema/implementación, no a este documento.

### 3.3 Escala tipográfica sugerida

Base 16px, para verse consistente con Anton (títulos, mayúsculas) y Barlow (cuerpo):

| Token | Uso | Tamaño | Line-height | Fuente |
|---|---|---|---|---|
| `display-xl` | H1 / hero | 56px (3.5rem) | 1.05 | Anton, mayúsculas |
| `display-lg` | H2 / secciones | 40px (2.5rem) | 1.1 | Anton, mayúsculas |
| `display-md` | H3 / subsecciones | 28px (1.75rem) | 1.15 | Anton, mayúsculas |
| `body-lg` | intro/lead de sección | 18px (1.125rem) | 1.5 | Barlow 400 |
| `body` | párrafo base | 16px (1rem) | 1.6 | Barlow 400 |
| `body-sm` | leyendas, notas, footer | 14px (0.875rem) | 1.5 | Barlow 400 |
| `label` | botones/CTA/etiquetas | 14–16px | 1.2 | Anton o Barlow 700, mayúsculas |

Esta escala es una propuesta razonable derivada de la descripción del manual y del brief; no proviene de un valor explícito del manual (que no especifica tamaños web). Si el agente de tema ya trae una escala definida en otro documento del brief, esa prevalece.

---

## 4. Contradicciones / vacíos a señalar (no se decidieron por cuenta propia)

1. **Ningún PNG entregado es la versión blanco y negro.** El brief asumía que entre `sarapiqui-01.png` y `sarapiqui-02.png` habría una versión "color" y otra "B/N" (línea 187, línea 214-215 "confirmar versión"). Al mirar los archivos, ambos son a color; ninguno es monocromático. Si el tema necesita una versión sólida en negro o en blanco (manual A.04, aplicaciones 3–6, ver sección 1), **hace falta pedirle a Adrián ese archivo** — no existe hoy entre el material fuente.
2. **Vectorial (SVG/AI): sí conviene pedirlo, pero no es bloqueante.** Ambos PNG están a 3508 px de ancho/alto (calidad de impresión, ~300 dpi para un tamaño A4), lo cual alcanza holgadamente para casi cualquier uso en pantalla, incluyendo pantallas de alta densidad (retina) en tamaños de header típicos (logo de ~200–400px de ancho). El brief ya lo marca como prioridad "Baja — los PNG sirven de momento" (línea 348); este documento coincide con esa evaluación. Pedir el SVG/AI sigue siendo buena práctica para: (a) generar el favicon y variantes cuadradas con recorte limpio, (b) tener una fuente editable si el logo se necesita en un tamaño excepcionalmente grande (lona, rótulo), y (c) si además se decide pedir una versión monocromática (punto 1), lo más eficiente es pedir ambas cosas a la vez a Adrián.
3. **No hay contradicción entre el manual y el brief en paleta ni en jerarquía de color** — brief y manual coinciden en los tres hex y en qué palabra lleva cada color. Tampoco hay contradicción en las reglas de "versiones incorrectas": lo que el brief anticipaba (degradados azules, inversión de jerarquía, un solo color plano) es exactamente lo que el manual muestra tachado en la página A.04.

---

## 5. Archivos fuente citados

| Archivo | Ruta | Rol |
|---|---|---|
| Manual de marca | `Dropbox/.../gokarts/Sitio Web Claude/manual de marca sarapiqui.pdf` | Fuente de verdad de logo, paleta y tipografía (solo lectura) |
| Logo principal (color, transparente) | `Dropbox/.../gokarts/Sitio Web Claude/sarapiqui-02.png` | Usar como logo de header/footer |
| Logo cuadrado (color, fondo aplicado) | `Dropbox/.../gokarts/Sitio Web Claude/sarapiqui-01.png` | Usar solo para piezas cuadradas/sociales |

Ninguno de estos tres archivos fue modificado; son material fuente de solo lectura tal como exige el encargo. La generación de derivados optimizados para `assets-web/` (recortes, WebP, tamaños de favicon) es tarea del agente de imágenes/tema, no de este documento — `marca.json` deja marcados como `PENDIENTE` los campos de ruta web que aún no existen.
