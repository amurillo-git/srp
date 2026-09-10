# Auditoría de contenido publicado — Sarapiquí Race Park

Fecha de auditoría: 2026-09-10
Fuente de los datos publicados: REST API de WordPress, `https://sarapiquiracepark.com/wp-json/wp/v2/pages/{id}?_fields=id,slug,title,content`, contrastada además con el HTML renderizado de cada URL pública (`/inicio/`, `/actividades/`, `/ubicacion-horarios/`, `/precios/`) para verificar jerarquía de encabezados, enlaces internos, meta description, Open Graph y JSON-LD.
Fuente de verdad: `sitio-web-sarapiqui-race-park-brief_1.md` (secciones 1.1, 2, 4, 4.2, 4.3, 4.4, 9).

Archivos crudos guardados para trazabilidad (en este mismo repo, `01-spec/`): `raw-9.json`, `raw-11.json`, `raw-13.json`, `raw-15.json` (respuesta cruda de la API) y `rendered-inicio.html`, `rendered-actividades.html`, `rendered-ubicacion.html`, `rendered-precios.html` (HTML público tal como lo sirve el sitio).

**Nota de limitación técnica:** el tema `hostinger-ai-theme` ofusca en el HTML renderizado los valores de teléfono, WhatsApp y email (aparecen como `tel:trans-encoded_phone`, `href="https://trans-whatsapp-number"`, `mailto:trans-encoded_email` — se resuelven por JavaScript en el navegador). Por eso los valores de contacto de esta auditoría se verifican contra el texto plano del campo `content` de la API (que sí trae los números/email en claro), no contra los atributos `href` del HTML renderizado.

---

## 1. Página Inicio (`/inicio/`, ID 9)

Contenido íntegro descargado (campo `content.rendered`, decodificado):

> Vive la Emoción del Off-Road en Sarapiquí Race Park / Go Karts de 270cc en una pista de 500m. Diversión extrema para toda la familia. Reserva tu experiencia hoy. / Quiénes Somos / Sarapiquí Race Park es el destino de aventura número uno en Horquetas de Sarapiquí, Costa Rica. Ofrecemos experiencias de carreras en go karts off-road de última generación, diseñadas para principiantes y pilotos experimentados. / **Con más de 7 meses operando, hemos brindado experiencias inolvidables a cientos de visitantes nacionales e internacionales.** / Ubicados sobre la Ruta 4 en Horquetas de Sarapiquí, somos fáciles de encontrar y accesibles desde toda la región. / Actividades Destacadas / Karting Off-Road en Pista de 500m [...] / Por Qué Elegirnos [...] / Reserva tu Carrera Ahora / Presiona «Contacto» o WhatsApp 7210-0389

| Dato publicado hoy | Lo que dice el brief | Veredicto |
|---|---|---|
| "Con más de 7 meses operando, hemos brindado experiencias inolvidables a cientos de visitantes nacionales e internacionales." | Sección 9: "No mencionar cuánto tiempo lleva operando el negocio." Sección 9 también: "No inventar [...] cifras que no se han confirmado." | **ELIMINAR** — viola dos reglas a la vez: menciona antigüedad del negocio y afirma una cifra de visitantes ("cientos") no respaldada por el brief. |
| H1 real de la página (auto-generado por el tema desde el título): `Sarapiquí Race Park \| Go Karts Off-Road en Costa Rica` | Brief 4.1: "H1: 'Vive la Emoción del Off-Road en Sarapiquí Race Park'" | **CORREGIR** — el texto que el brief designa como H1 existe en la página, pero está marcado como `<h2>` dentro del contenido; el `<h1>` real que renderiza el navegador es el título SEO completo con el sufijo de marca. Hay que decidir con el tema si el H1 visible debe ser el titular de marketing (como pide el brief) en vez del title completo, o ajustar la spec. |
| "Go Karts de 270cc en una pista de 500m. Diversión extrema para toda la familia. Reserva tu experiencia hoy." | Bajada: "Go karts de 270cc en pista de 500m. Diversión extrema para toda la familia." | OK (coincide, con una frase adicional de CTA que no contradice nada). |
| "destino de aventura número uno en Horquetas de Sarapiquí... Ubicados sobre la Ruta 4" | Sección "Quiénes Somos": destino de aventura #1, ubicados sobre Ruta 4 | OK |
| Karts 270cc, pista ~500m, edad mínima 9 años solo, niños pequeños acompañados, horario sáb/dom/feriados 9am-4pm | Sección "Actividades Destacadas" del brief 4.1 | OK |
| Servicios adicionales: comidas y bebidas, duchas, "Hospedaje cercano (consultar)", paquetes grupales | Brief 4.1 pide listar exactamente estos 4 servicios | OK |
| "Precios competitivos (desde ₡2,000 por vuelta)", karts última generación, pista segura, personal experimentado, paquetes grupales, facilidades completas | Sección "Por Qué Elegirnos" del brief 4.1 | OK |
| CTA final: H2 "Reserva tu Carrera Ahora" + texto plano "Presiona «Contacto» o WhatsApp 7210-0389" (sin botón/enlace real detectado en el contenido) | Brief 4.1: "CTA final: ... → botón WhatsApp 7210-0389" | **CORREGIR** — el brief pide un botón de WhatsApp, no una instrucción en texto plano; no hay enlace `wa.me` en este bloque del contenido. |

---

## 2. Página Actividades (`/actividades/`, ID 11)

Contenido íntegro descargado:

> Experiencias de Karting en Sarapiquí Race Park [...] Los Mejores Karts de Costa Rica [...] Especificaciones: Motor 270cc, Diseño de carreras profesionales, Tamaño grande y cómodo, Mantenimiento regular, Seguridad: arneses y protección de última generación / Pista Off-Road Profesional (~500 metros, curvas, rectas, terreno variado) / Requisitos y Restricciones: edad mínima 9 años solo, menores de 9 acompañados, peso máximo 100kg adultos / 50kg niños, altura para alcanzar pedales, condición física adecuada / Seguridad: instrucciones previas, personal certificado / Horarios: sáb/dom/feriados 9am–4pm / Nota: reserva previa obligatoria, 50% de depósito.

| Dato publicado hoy | Lo que dice el brief | Veredicto |
|---|---|---|
| "Motor: 270cc" / "Diseño: Go karts de carreras profesionales" / "Seguridad: Arneses y protección de última generación" | Brief 4.2: "motor 270cc, diseño de carreras, y protección" | OK |
| "Nuestra pista de ~500 metros está diseñada [...] con curvas, rectas y terreno variado" | Brief 4.2: "pista off-road (~500m, curvas, rectas, terreno variado)" | OK |
| "Edad mínima: 9 años para conducir solo" / "Niños menores de 9: pueden ir acompañados" / "Peso máximo: 100kg (adultos), 50kg (niños)" / "Condición física: debe estar en condiciones de manejar" | Brief 4.2: edad mínima 9 (solo), menores acompañados, peso máx. 100kg/50kg, condición física adecuada | OK |
| "Altura recomendada: Ser capaz de alcanzar pedales" | No está en el brief textual, pero es coherente con "condición física adecuada" y no contradice nada | OK (dato razonable, no requiere corrección) |
| "Todos los pilotos reciben instrucciones de seguridad antes de cada sesión. Personal certificado supervisa en todo momento." | Brief 4.2: "instrucción previa obligatoria, personal certificado supervisando" | OK |
| "Sábado: 9am–4pm / Domingo: 9am–4pm / Feriados: 9am–4pm" | Brief 4.2 y sección 2: sáb/dom/feriados 9:00am–4:00pm | OK |
| "Reserva previa es obligatoria. Se requiere 50% de depósito para confirmar." | Brief 4.2: "reserva previa obligatoria, depósito del 50%" | OK |
| Enlazado interno: ningún enlace hacia Precios, Ubicación o Inicio dentro del contenido de esta página | Brief sección 6, punto 7: "enlazado interno coherente entre las 4 páginas" | **FALTA** — no hay ningún `<a>` interno hacia otra página núcleo en el contenido de Actividades. |

Esta página es la que **mejor** coincide con el brief de las cuatro: no se detectaron datos inventados ni contradictorios en las cifras técnicas, edades ni pesos.

---

## 3. Página Ubicación y Horarios (`/ubicacion-horarios/`, ID 13)

Contenido íntegro descargado:

> Dónde Encontrarnos / Dirección: "Horquetas de Sarapiquí, sobre Ruta 4 / Costa Rica" / Ver ubicación en Google Maps: https://maps.app.goo.gl/Rk2z39BCwLQFtY4A9 / Cómo Llegar: Desde San José: ~2 horas por Ruta 4 · Desde Puerto Viejo: ~45 minutos · Desde La Fortuna: ~1 hora 30 minutos · Desde Arenal: ~1 hora / Estamos ubicados sobre la Ruta 4 (carretera principal), fácil de acceder. / Horarios de Operación: sáb/dom/feriados 9:00am–4:00pm / Importante: Reserva previa obligatoria, depósito del 50% / Contacto y Reservas: WhatsApp +506 7210-0389, Email info@srp.cr / Cómo Reservar: 1) Contáctanos, 2) especifica fecha/hora/personas, 3) elige tu paquete, 4) depósito 50%, 5) ¡listo!

### 3.1 Verificación obligatoria de los 8 puntos de la sección 4.3 del brief

| # | Punto de la tabla 4.3 del brief | Estado en el contenido publicado | Veredicto |
|---|---|---|---|
| 1 | San José debe decir **~1.5 horas** | Dice: "Desde San José: ~2 horas por Ruta 4" | **CORREGIR** — publicado ~2h, debe ser ~1.5h |
| 2 | Puerto Viejo debe decir **~15 minutos** | Dice: "Desde Puerto Viejo: ~45 minutos" | **CORREGIR** — publicado ~45min, debe ser ~15min |
| 3 | La Fortuna debe decir **~1h30** (ya correcto) | Dice: "Desde La Fortuna: ~1 hora 30 minutos" | OK — coincide con el brief |
| 4 | Arenal debe **eliminarse** (no está en el brief) | Dice: "Desde Arenal: ~1 hora" — sigue publicado | **ELIMINAR** — la línea de Arenal sigue en el sitio |
| 5 | Guápiles debe **añadirse: ~30 minutos** | No aparece ninguna mención a Guápiles | **FALTA** — no está publicado |
| 6 | Cartago debe **añadirse: ~2 horas** | No aparece ninguna mención a Cartago | **FALTA** — no está publicado |
| 7 | Dirección debe incluir **"kilómetro 16"**: "Horquetas de Sarapiquí, sobre Ruta 4, kilómetro 16, Costa Rica" | Dice: "Horquetas de Sarapiquí, sobre Ruta 4 / Costa Rica" (sin "kilómetro 16") | **CORREGIR** — falta "kilómetro 16" |
| 8 | Debe **añadirse** la nota de transporte público (acceso en cualquier vehículo y también en transporte público) | No hay ninguna mención a transporte público en toda la página | **FALTA** — no está publicado. (La ruta/parada exacta de bus sigue como insumo PENDIENTE de Adrián según sección 11 del brief — solo se puede añadir la nota genérica de acceso, no una ruta específica.) |

Resultado: **6 de los 8 puntos están mal o ausentes**; solo La Fortuna está correcto.

### 3.2 Resto de la página contra las secciones 2 y 4.3

| Dato publicado hoy | Lo que dice el brief | Veredicto |
|---|---|---|
| "Ver ubicación en Google Maps: https://maps.app.goo.gl/Rk2z39BCwLQFtY4A9" (texto plano con el link) | Brief 4.3: "mapa embebido de Google Maps (usar el link ya provisto)" | **CORREGIR** — el link es correcto (coincide con sección 2), pero está publicado como texto plano, no como mapa embebido. Se confirmó con `grep` sobre el HTML renderizado que la página **no tiene ningún `<iframe>`** de Google Maps. |
| "Sábado: 9:00 am – 4:00 pm / Domingo: 9:00 am – 4:00 pm / Feriados: 9:00 am – 4:00 pm" | Sección 2: sábado, domingo y feriados 9:00am–4:00pm | OK |
| "Reserva previa obligatoria [...] depósito del 50%" | Brief 4.3 y 4.4: depósito 50% | OK |
| "WhatsApp: +506 7210-0389" | Sección 2: +506 7210-0389 | OK — coincide exactamente |
| "Email: info@srp.cr" | Sección 2: info@srp.cr | OK — coincide exactamente |
| Pasos "Cómo Reservar" (1. contactar, 2. fecha/hora/personas, 3. elegir paquete, 4. depósito 50%, 5. confirmado) | Brief 4.3: mismos 5 pasos | OK |
| Enlazado interno: ningún enlace hacia Inicio, Actividades o Precios en el contenido | Brief sección 6, punto 7 | **FALTA** |

---

## 4. Página Precios y Paquetes (`/precios/`, ID 15)

Contenido íntegro descargado:

> Precios Competitivos y Paquetes Especiales [...] Tarifa Individual: Vuelta Individual ₡2,000 por vuelta / Paquete 10 Minutos ₡6,000 (~5-6 vueltas, "Lo más popular") / Paquete 15 Minutos ₡7,000 (~8-9 vueltas, "Máxima adrenalina") / Paquetes para Grupos (mínimo 5 personas, máximo 5 por heat): Grupo 10 min ₡5,500/persona, Grupo 15 min ₡6,500/persona / Descuentos: grupos de 20+, descuento adicional (consultar) / Términos: reserva previa obligatoria, depósito 50% (se aplica al total) / Cancelación: 48h = reembolso completo, menos de 48h = depósito no reembolsable / Incluido: carrera en kart 270cc, instrucciones de seguridad, equipo de protección, uso de pista, acceso a duchas / No incluido: comidas, fotografías profesionales / Edad y requisitos: mínima 9 años (solo), menores acompañados, peso máx. 100kg/50kg.

| Dato publicado hoy | Lo que dice el brief | Veredicto |
|---|---|---|
| Vuelta suelta ₡2,000 / paquete 10 min ₡6,000 (~5-6 vueltas) / paquete 15 min ₡7,000 (~8-9 vueltas, "Máxima adrenalina") | Brief 4.4: exactamente estas cifras y etiquetas | OK — coincide cifra por cifra |
| Grupos: mínimo 5 personas, máx. 5 por heat; 10 min ₡5,500/persona; 15 min ₡6,500/persona; descuento adicional 20+ | Brief 4.4: mismas cifras | OK |
| Depósito 50% obligatorio; cancelación 48h = reembolso completo; menos de 48h = depósito no reembolsable | Brief 4.4: mismos términos | OK — coincide exactamente |
| Incluye: kart 270cc, instrucción de seguridad, equipo de protección, uso de pista, acceso a duchas | Brief 4.4: mismos 5 ítems | OK |
| No incluye: comidas, fotografías profesionales | Brief 4.4: mismos 2 ítems | OK |
| Edad mínima 9 años (solo), menores acompañados, peso máx. 100kg/50kg | Brief 4.4: mismos requisitos, "repetir brevemente, con link a Actividades para detalle completo" | **CORREGIR (parcial)** — las cifras de edad/peso son correctas, pero no hay ningún enlace hacia la página de Actividades como pide el brief. |
| Enlazado interno: ningún enlace hacia Inicio, Actividades o Ubicación en el contenido | Brief sección 6, punto 7 | **FALTA** |

Esta es la página con **mejor coincidencia numérica** de las cuatro: ningún precio, edad, peso o condición de depósito/cancelación publicado contradice el brief.

---

## 5. Jerarquía de encabezados (las 4 páginas)

Verificado sobre el HTML renderizado públicamente (no solo el campo `content` de la API):

| Página | H1 detectados | Texto del H1 real | H2/H3 del contenido | Veredicto |
|---|---|---|---|---|
| Inicio | 1 | `Sarapiquí Race Park \| Go Karts Off-Road en Costa Rica` (título SEO completo, generado automáticamente por el tema a partir del título de la página) | Empiezan en H2 ("Vive la Emoción del Off-Road...", "Quiénes Somos", "Actividades Destacadas", etc.), con H3 anidados correctamente bajo sus H2 | Jerarquía técnicamente válida (un solo H1, sin saltos de nivel), pero el H1 real no es el titular que pide el brief 4.1 — ver hallazgo en la sección 1 de esta auditoría |
| Actividades | 1 | `Go Karts Off-Road \| Actividades en Sarapiquí Race Park` | H2/H3 correctos y anidados | OK — un solo H1, jerarquía correcta |
| Ubicación y Horarios | 1 | `Ubicación y Horarios \| Sarapiquí Race Park` | H2/H3 correctos y anidados | OK — un solo H1, jerarquía correcta |
| Precios y Paquetes | 1 | `Precios y Paquetes \| Sarapiquí Race Park` | H2/H3 correctos y anidados | OK — un solo H1, jerarquía correcta |

Las 4 páginas tienen exactamente **un H1** (nunca cero ni más de uno) y no se detectaron saltos de nivel (p. ej. H2 seguido directamente de H4). El único hallazgo real de jerarquía es el de Inicio, ya anotado arriba.

## 6. Enlazado interno (las 4 páginas)

Se buscó, en el HTML renderizado de cada una de las 4 páginas, cualquier `<a href>` que apunte a otra de las 4 páginas núcleo (`/inicio/`, `/actividades/`, `/ubicacion-horarios/`, `/precios/`).

**Resultado: no se encontró ningún enlace interno entre páginas núcleo en ninguna de las 4.** Los únicos `href` que contienen esas rutas son el enlace canónico de la propia página hacia sí misma y los endpoints `wp-json/oembed` automáticos de WordPress — ninguno es un enlace de navegación real hacia otra página. Además, el menú de navegación del tema (`<nav class="...wp-block-navigation...">`) está **vacío** (sin ítems) en las 4 páginas.

Esto confirma un incumplimiento total del punto 7 de la sección 6 del brief ("enlazado interno coherente entre las 4 páginas... con anchor text descriptivo").

## 7. Verificación complementaria de SEO técnico (contexto, no pedida explícitamente pero relevante para priorizar)

Sobre el HTML renderizado de `/inicio/` (mismo patrón esperado en las otras 3, no se repitió la búsqueda en las 4 por no ser parte del encargo):
- No se encontró etiqueta `<meta name="description">`.
- No se encontraron etiquetas Open Graph (`<meta property="og:...">`).
- No se encontró ningún bloque `application/ld+json` (JSON-LD).
- El `<title>` de la página es `Sarapiquí Race Park | Go Karts Off-Road en Costa Rica – sarapiquiracepark.com`, confirmando el hallazgo de la sección 1.1 del brief (título del sitio sin corregir, agregado como sufijo).

Esto es consistente con lo que ya documenta el brief en la sección 1.1 ("SEO técnico al 0%") — se deja registrado aquí porque confirma, con evidencia propia de esta auditoría, que el diagnóstico del brief sigue vigente a la fecha de hoy.

---

## 8. Lista priorizada de correcciones (la más crítica primero)

1. **[CRÍTICO — viola regla explícita de la sección 9]** Eliminar de Inicio la frase "Con más de 7 meses operando, hemos brindado experiencias inolvidables a cientos de visitantes nacionales e internacionales." Menciona la antigüedad del negocio (prohibido) e inventa una cifra de visitantes no confirmada (prohibido).
2. **[CRÍTICO — dato de ubicación incorrecto, afecta SEO local y a los usuarios]** En Ubicación, corregir San José de "~2 horas" a "~1.5 horas" y Puerto Viejo de "~45 minutos" a "~15 minutos".
3. **[CRÍTICO — dato inexistente en el brief, debe eliminarse]** En Ubicación, eliminar la línea "Desde Arenal: ~1 hora".
4. **[CRÍTICO — faltan 2 de los 5 destinos de la tabla 4.3]** En Ubicación, añadir "Desde Guápiles: ~30 minutos" y "Desde Cartago: ~2 horas".
5. **[CRÍTICO — dirección incompleta]** En Ubicación, corregir la dirección a "Horquetas de Sarapiquí, sobre Ruta 4, kilómetro 16, Costa Rica" (falta "kilómetro 16").
6. **[CRÍTICO — falta nota obligatoria]** En Ubicación, añadir la nota de acceso en cualquier vehículo y también en transporte público (sin inventar ruta/parada específica: ese dato sigue PENDIENTE de confirmación de Adrián según la sección 11 del brief).
7. **[IMPORTANTE]** Reemplazar el link de texto plano de Google Maps en Ubicación por un mapa realmente embebido (`<iframe>`) — hoy no existe ningún iframe en la página.
8. **[IMPORTANTE]** Construir enlazado interno real entre las 4 páginas con anchor text descriptivo (hoy no existe ninguno) y poblar el menú de navegación del tema, que está vacío.
9. **[IMPORTANTE]** En Precios, añadir el enlace hacia Actividades que pide el brief para el detalle completo de edad/peso (hoy no existe).
10. **[IMPORTANTE]** En Inicio, convertir el CTA final ("Presiona «Contacto» o WhatsApp 7210-0389") en un botón/enlace real de WhatsApp, no solo texto instructivo.
11. **[MEDIO]** Definir con el tema/diseño si el H1 de Inicio debe ser el titular de marketing "Vive la Emoción del Off-Road en Sarapiquí Race Park" (como pide el brief 4.1) en vez del título SEO completo que hoy se autogenera como H1.
12. **[BAJO]** Unificar el formato del teléfono: Ubicación usa "+506 7210-0389" (coincide con el brief); Inicio y Actividades usan solo "7210-0389". No es un dato falso, pero conviene homogeneizar el formato en las 4 páginas.
13. **[FUERA DEL ENCARGO DE CONTENIDO, pero confirmado como contexto]** Las 4 páginas siguen sin meta description, Open Graph ni JSON-LD (0% SEO técnico), tal como ya diagnostica la sección 1.1 del brief — se deja constancia de que sigue así hoy.

---

## Lo que esta auditoría NO encontró mal

Para que quede explícito y no se recorrija lo que ya está bien: en Actividades y en Precios **no se detectó ningún dato inventado, contradictorio o desalineado** con las secciones 4.2 y 4.4 del brief (especificaciones de karts, requisitos de edad/peso, horarios, precios, condiciones de depósito y cancelación coinciden cifra por cifra). Los únicos hallazgos en esas dos páginas son la falta de enlazado interno y, en Precios, la falta del enlace hacia Actividades.
