# Inventario de assets — Sarapiquí Race Park

Fuente única de verdad para nombres, descripciones y asignación: `01-spec/assets.json`. Este documento es el resumen legible para Adrián. No se inventó ninguna descripción, dato ni foto: las 15 fotografías y los 7 videos son material real del parque, revisado uno por uno con la herramienta de lectura de imágenes (no se trabajó por nombre de archivo).

---

## 1. Fotos (15/15 revisadas)

Las 15 fotos fueron abiertas y miradas individualmente. Cada una tiene en `assets.json`: nombre original, descripción de lo que se ve, slug en español, alt text específico, orientación real (post-corrección EXIF), y a qué página/sección queda asignada.

| # | Slug | Orientación | Asignación principal |
|---|---|---|---|
| 1 | `entrada-rotulo-sarapiqui-race-park-pilotos` | vertical | Ubicación y Horarios (encabezado) / Galería |
| 2 | `familia-feliz-nina-casco-go-kart-sarapiqui` | vertical | Inicio (Actividades Destacadas) / Galería |
| 3 | `piloto-cubierto-lodo-kart-frente-instalaciones` | vertical | Actividades / Galería |
| 4 | `salpicadura-lodo-alta-velocidad-go-kart` | vertical | Actividades (acción) / Galería |
| 5 | `go-kart-270cc-salpicando-lodo-pista-off-road-sarapiqui` | vertical | **HERO Inicio** + **Open Graph** / Galería |
| 6 | `grupo-cinco-go-karts-pista-tierra-sarapiqui` | horizontal | Actividades (grupo) / Galería |
| 7 | `fila-pilotos-go-kart-listos-carrera-grupal` | horizontal | Precios (paquete grupal) / Galería |
| 8 | `rociada-barro-cerca-piloto-casco-carrera` | vertical | Galería |
| 9 | `piloto-cruza-charco-lodo-go-kart-velocidad` | vertical | Actividades (terreno) / Galería |
| 10 | `go-kart-frente-bodega-lamina-roja-sarapiqui` | vertical | Ubicación y Horarios (instalaciones) / Galería |
| 11 | `amigos-sonrientes-lodo-fin-recorrido-karts` | horizontal | Sobre Nosotros (pendiente) / Inicio / Galería |
| 12 | `piloto-graba-video-celular-recorrido-kart` | vertical | Galería |
| 13 | `kart-estructura-roja-salpicadura-lodo-curva` | vertical | Actividades / Galería |
| 14 | `piloto-cruza-pozo-lodo-profundo-kart-off-road` | vertical | Actividades (terreno) / Galería |
| 15 | `piloto-camisa-azul-salpicadura-lodo-charco` | vertical | Galería |

**Hero de Inicio:** `go-kart-270cc-salpicando-lodo-pista-off-road-sarapiqui` (foto #5, `20260726_103159.jpg`) — acción nítida, lodo en el aire, buena luz.

**Imagen de Open Graph (1200×630):** recorte centrado de la misma foto #5, generado en `assets-web/go-kart-270cc-salpicando-lodo-pista-off-road-sarapiqui-og-1200x630.webp`.

**Nota de orientación:** 12 de las 15 fotos quedaron en orientación vertical (retrato) tras corregir la rotación EXIF con Pillow, y solo 3 (los dos grupos de 5 karts y la foto de los dos amigos) son horizontales. Esto es real, no un error de procesamiento — así se tomaron las fotos con el teléfono. El tema debe usar `object-fit: cover` o recortes controlados para los usos de banner ancho en escritorio; en mobile-first (prioridad del sitio) las verticales funcionan bien tal cual.

## 2. Conversión a WebP (Pillow, calidad 82)

Script usado: `convert_images.py` (ejecutado con `C:/Users/adria/.notebooklm-venv/Scripts/python`), no se convirtió ninguna imagen a mano. Anchos generados por foto: 480, 960 y 1600 px (proporción mantenida, sin upscaling). Total: 45 archivos WebP + 1 imagen Open Graph = 46 archivos en `assets-web/`.

**Peso antes/después (demuestra la optimización):**

| Concepto | Peso |
|---|---|
| 15 fotos originales (JPG de cámara) | 29 948 KB (≈ 29.25 MB) |
| 45 variantes WebP (480/960/1600) + 1 imagen Open Graph | 11 406 KB (≈ 11.14 MB) |
| **Reducción total** | **≈ 61.9 %** |

(Esto es peso combinado de las 3 resoluciones por foto, no solo una — la reducción real para el visitante es mayor porque el navegador solo descarga el tamaño que corresponde a su pantalla, normalmente el de 480 o 960 px.)

Detalle foto por foto (peso original vs. las 3 salidas) queda documentado en `assets.json`, campo `outputs` de cada foto y `peso_original_kb`.

## 3. Videos (7/7 inventariados, compresión BLOQUEADA)

No hay ffmpeg, ImageMagick ni cwebp instalados en esta máquina. **No se comprimió ni convirtió ningún video** — no existe una alternativa con Pillow (Pillow no procesa video). Registrar esto como bloqueo real, no como tarea completada.

| Archivo original | Peso |
|---|---|
| `20260823_104826.mp4` | 2.94 MB |
| `20260823_104959.mp4` | 4.97 MB |
| `20260823_105011.mp4` | 4.58 MB |
| `20260823_105522.mp4` | 10.34 MB |
| `20260823_152439.mp4` | 11.82 MB |
| `20260823_152600.mp4` | 7.20 MB |
| `20260823_154037.mp4` | 3.93 MB |

**Acción requerida antes de publicar la Galería con video:** instalar ffmpeg en esta máquina (por ejemplo `winget install Gyan.FFmpeg` o descarga manual desde ffmpeg.org) y luego re-ejecutar la conversión para generar versiones comprimidas (H.264 MP4 y/o WebM) con un poster de imagen en WebP, sin autoplay con sonido (regla de la sección 4.5 del brief). Mientras tanto, los videos originales sin comprimir **no deben subirse a producción** — varios superan los 10 MB.

## 4. Cobertura fotográfica — huecos reales (para que Adrián sepa qué pedir)

Con las 15 fotos disponibles se cubre bien: karts en acción, terreno/lodo, pista de tierra, grupos de pilotos, exterior de la bodega, entrada con rótulo, y momentos de familia/amigos. **No hay ninguna foto real de:**

- **Duchas** — mencionadas en el brief (4.1, 4.4) como servicio incluido; no hay imagen.
- **Zona de comidas** — mencionada como servicio adicional (4.1); no hay imagen.
- **Señalización de seguridad / instrucción previa obligatoria** — el brief (4.2) exige mencionar la instrucción de seguridad; no hay foto de personal dando instrucción, ni de rótulos de seguridad o reglas visibles (solo se ve un rótulo de marca, no de seguridad).
- **Equipo de protección de cerca** (cascos en estante, chalecos, etc.) — solo se ven cascos puestos en pilotos, no una toma de equipo/estación de préstamo.
- **Personal / staff certificado supervisando** — ninguna foto muestra personal del parque en labor de supervisión o instrucción, solo visitantes.
- **Vista aérea o mapa del trazado de la pista** — útil para la página de Actividades; no existe.
- **Hospedaje cercano** — mencionado como servicio adicional (4.1); no aplica al parque directamente, pero no hay material de apoyo.
- **Rótulo de carretera / kilómetro 16 sobre Ruta 4** — útil para la página de Ubicación; no hay foto del acceso desde la ruta, solo del rótulo de marca en la bodega.
- **Logo en alta resolución aislado** (fuera de los archivos `sarapiqui-01.png` / `sarapiqui-02.png` ya provistos, que no son parte de este inventario de fotos de parque).

Recomendación: si Adrián puede tomar 4-6 fotos adicionales enfocadas en duchas, zona de comidas, un momento de instrucción de seguridad y el acceso desde Ruta 4, se cerraría la cobertura completa del sitio sin depender de diseño para disimular esas secciones.

## 5. Archivos entregados por este agente

- `01-spec/assets.json` — inventario completo y estructurado (fuente de verdad).
- `01-spec/assets.md` — este resumen.
- `assets-web/` — 46 archivos WebP (45 responsivos + 1 Open Graph).
