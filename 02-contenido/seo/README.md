# SEO - Metadatos y Marcado Estructurado para Sarapiquí Race Park

**Fecha generada:** 10 de septiembre de 2026  
**Especificación:** Brief técnico secciones 6 y 6.1  
**Responsable de implementación:** Tema a medida de WordPress (no plugin de SEO)

---

## Contenido de esta carpeta

### 1. `metadatos.json`
Contiene los títulos y meta descriptions para las 7 páginas del sitio:
- `inicio`
- `actividades`
- `ubicacion-horarios`
- `precios`
- `galeria`
- `faq`
- `sobre-nosotros`

**Especificaciones:**
- **Títulos:** 50–60 caracteres (conteo manual verificado)
- **Meta descriptions:** 140–160 caracteres (conteo manual verificado)
- **Open Graph:** imagen, título y descripción para cada página
- **Todos únicos:** cada título y description es diferente, e incluyen ubicación ("Horquetas de Sarapiquí", "Costa Rica") y palabra clave "go karts off-road" donde es relevante

### 2. `jsonld-localbusiness.json`
Schema.org `LocalBusiness` + `SportsActivityLocation` para el sitio principal.

**Campos implementados:**
- `name`: "Sarapiquí Race Park"
- `url`: "https://sarapiquiracepark.com"
- `address`: PostalAddress completo (Ruta 4 km 16, Horquetas de Sarapiquí, Heredia, CR)
- `telephone`: "+50672100389"
- `email`: "info@srp.cr"
- `openingHoursSpecification`: Sábado y domingo 09:00–16:00 (cerrado resto de semana)
- `priceRange`: "₡₡" (rango medio)

**NOTA IMPORTANTE:** El campo `aggregateRating` fue **removido deliberadamente** de esta versión porque viola la sección 9 del brief técnico ("No inventar reseñas, testimonios"). La versión anterior incluía un "rating de bootstrapping" con una reseña ficticia. Este campo no debe reintroducirse sin datos de reseñas reales confirmados.

**Campos PENDIENTE (dejados fuera, documentados en comentarios JSON):**
- `geo`: Coordenadas exactas (latitud y longitud) → Adrián debe proporcionar
- `sameAs`: URLs de Instagram, TripAdvisor y Google Business Profile → Activar cuando estén disponibles

### 3. `jsonld-offers.json`
Schema.org `AggregateOffer` con los 5 paquetes de precios reales.

**Paquetes incluidos:**
1. Vuelta Individual → ₡2,000
2. Paquete 10 Minutos (individual) → ₡6,000
3. Paquete 15 Minutos (individual) → ₡7,000
4. Paquete Grupo 10 Minutos (mín. 5 personas) → ₡5,500/persona
5. Paquete Grupo 15 Minutos (mín. 5 personas) → ₡6,500/persona

**Moneda:** CRC (colones costarricenses)

### 4. `jsonld-faqpage.json`
Schema.org `FAQPage` con 9 preguntas respondidas.

**Criterio de inclusión:** Solo preguntas cuyas respuestas se deducen del brief técnico (confirmas en sección 4 del brief).  
**Criterio de exclusión:** Preguntas marcadas como "pendientes de confirmar con Adrián" en el brief (ej: "¿Qué pasa si llueve?", "¿Hay comida en el lugar?", "¿Ruta de transporte público?").

**Preguntas incluidas:**
1. ¿Cuál es la edad mínima para conducir un go kart?
2. ¿Es obligatorio hacer una reserva previa?
3. ¿Cuál es la política de cancelación?
4. ¿Cuál es el horario de operación?
5. ¿Dónde están ubicados?
6. ¿Cuáles son los requisitos de peso?
7. ¿Qué incluye el paquete?
8. ¿Cómo hago una reserva?
9. ¿Cuáles son los datos de contacto?

---

## Cómo inyectar en WordPress

### En el tema a medida (archivos del tema):

#### 1. Meta tags y Open Graph en `<head>` de cada página
El tema debe incluir en cada plantilla de página (`page.php` o similar) código PHP que lea `metadatos.json` y genere:

```html
<title><?php echo get_page_title(); ?></title>
<meta name="description" content="<?php echo get_page_description(); ?>">
<meta property="og:title" content="<?php echo get_page_og_title(); ?>">
<meta property="og:description" content="<?php echo get_page_og_description(); ?>">
<meta property="og:image" content="<?php echo get_page_og_image_url(); ?>">
<meta property="og:type" content="<?php echo get_page_og_type(); ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:image" content="<?php echo get_page_og_image_url(); ?>">
```

O usar el campo `_seo_` personalizado de cada página en la base de datos de WordPress (si ya existe un mecanismo de campos personalizados).

#### 2. JSON-LD en `<head>` global (página de inicio)
Incluir `jsonld-localbusiness.json` como `<script type="application/ld+json">` en el `<head>` de la página de inicio (`/inicio/`):

```html
<script type="application/ld+json">
<?php echo file_get_contents( get_template_directory() . '/assets/jsonld-localbusiness.json' ); ?>
</script>
```

#### 3. JSON-LD `Offer` en la página de Precios
Incluir `jsonld-offers.json` en la página `/precios/`:

```html
<script type="application/ld+json">
<?php echo file_get_contents( get_template_directory() . '/assets/jsonld-offers.json' ); ?>
</script>
```

#### 4. JSON-LD `FAQPage` en la página de FAQ
Incluir `jsonld-faqpage.json` en la página `/faq/`:

```html
<script type="application/ld+json">
<?php echo file_get_contents( get_template_directory() . '/assets/jsonld-faqpage.json' ); ?>
</script>
```

---

## Validación

**Antes de publicar:** validar el JSON-LD con Google Rich Results Test:
https://search.google.com/test/rich-results

1. Navega a cada página del sitio (Inicio, Actividades, Ubicación, Precios, Galería, FAQ, Sobre Nosotros).
2. Ejecuta el test de Rich Results de Google.
3. Verifica que:
   - No hay errores de sintaxis JSON
   - LocalBusiness se detecta correctamente en Inicio
   - AggregateOffer se detecta correctamente en Precios
   - FAQPage se detecta correctamente en FAQ

**Línea de comandos alternativa (si tienes `jq` instalado):**
```bash
jq empty metadatos.json && echo "✓ metadatos.json es JSON válido"
jq empty jsonld-localbusiness.json && echo "✓ jsonld-localbusiness.json es JSON válido"
jq empty jsonld-offers.json && echo "✓ jsonld-offers.json es JSON válido"
jq empty jsonld-faqpage.json && echo "✓ jsonld-faqpage.json es JSON válido"
```

---

## Items PENDIENTE

### BLOQUEANTES (deben resolverse antes de publicar):
1. **Coordenadas GPS exactas** (`geo` en LocalBusiness)
   - Adrián debe proporcionar latitud y longitud del pin de Google Maps
   - Actualizar campo `geo` en `jsonld-localbusiness.json`
   - Prioridad: Alta (SEO local depende de esto)

2. **Respuestas de FAQ no deducibles del brief:**
   - ¿Qué pasa si llueve?
   - ¿Se puede reservar sin depósito anticipado?
   - ¿Hay servicio de comida en el parque?
   - ¿Cuál es la ruta exacta de transporte público?
   - Prioridad: Alta (FAQ debe ser completa para e-E-A-T)

### NO BLOQUEANTES (se pueden agregar después):
3. **Links de redes sociales y terceros** (`sameAs` en LocalBusiness)
   - Instagram del parque
   - Perfil de TripAdvisor
   - Google Business Profile
   - Prioridad: Media (mejorar cuando estén operativas)

4. **ID de Google Analytics 4**
   - Adrián debe proporcionar el ID de GA4
   - Insertar en el tema vía Google Tag Manager o directamente en `<head>`
   - Prioridad: Media (analítica no afecta SEO técnico)

5. **Confirmación de Google Search Console**
   - Verificar que Adrián tenga acceso a la propiedad en GSC
   - Enviar el sitemap
   - Prioridad: Media (fuera del alcance de Claude Code)

---

## Notas de implementación

- **No incluir campos inventados:** todos los valores de `metadatos.json` y los JSON-LD provienen del brief técnico. Ningún dato de coordenadas, redes, o políticas se ha inventado.
- **Open Graph:** se usa la misma imagen (`go-kart-270cc-salpicando-lodo-pista-off-road-sarapiqui-og-1200x630.webp`) para todas las páginas mientras no haya una imagen de portada específica por página.
- **Hreflang (multilenguaje):** cuando se implemente la versión en inglés (`/en/`), añadir etiquetas `hreflang` en cada página para relacionar la versión español e inglés.
- **Robots.txt:** ya no bloquea crawlers de IA (`GPTBot`, `ClaudeBot`, `PerplexityBot`, `Google-Extended`), cumpliendo con la sección 6.5 del brief.
- **Sitemap:** usar el sitemap nativo de WordPress (`wp-sitemap.xml`); incluir las páginas nuevas (Galería, FAQ, Sobre Nosotros) cuando se publiquen.

---

## Checklist para cerrar SEO técnico

- [ ] Meta descriptions implementadas en el tema para las 7 páginas
- [ ] Open Graph / Twitter Cards funcionando en todas las páginas
- [ ] `jsonld-localbusiness.json` inyectado en `/inicio/` con coordenadas confirmadas
- [ ] `jsonld-offers.json` inyectado en `/precios/` y validado
- [ ] `jsonld-faqpage.json` inyectado en `/faq/` y validado
- [ ] Google Rich Results Test: sin errores en LocalBusiness, AggregateOffer y FAQPage
- [ ] Página FAQ completada con respuestas PENDIENTES de Adrián
- [ ] Link `sameAs` actualizado con Instagram, TripAdvisor y Google Business Profile cuando estén disponibles
- [ ] GA4 ID configurado en el tema
- [ ] Hreflang implementado si versión en inglés está publicada

---

**Última actualización:** 10 de septiembre de 2026  
**Generado por:** Agente "seo-marcado"  
**Especificación:** Brief técnico Sarapiquí Race Park v1
