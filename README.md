# PressGrid Pro — WordPress Editorial Theme

[![Version](https://img.shields.io/badge/version-10.38.0--B2B-dc2626.svg)](https://solucionesgcm.com/pressgrid)
[![License: GPL v2](https://img.shields.io/badge/License-GPL%20v2-blue.svg)](https://www.gnu.org/licenses/gpl-2.0.html)
[![WordPress](https://img.shields.io/badge/WordPress-6.0%2B-0073aa.svg)](https://wordpress.org)

**PressGrid Pro** es un tema editorial de alto rendimiento diseñado para portales de noticias, medios de comunicación digitales y revistas especializadas. Inspirado en la arquitectura visual de grandes cadenas informativas internacionales como NBC News y Reuters, ofrece una maquetación limpia, optimizada para SEO y pensada para la máxima conversión e impacto visual.

---

## 🎨 Características Principales

- **Hero Grid (Split 3 Columnas):** Distribución de portada compuesta por Nota Principal Destacada, Stack de Noticias Secundarias y Módulo dinámico (Al Momento / Cobertura en Vivo).
- **Vista de Artículo Individual (Single Hero Dark):** Cabecera oscura con categoría en contraste, titular de gran impacto (`2.75rem`), subtítulo/bajada, reproductor de audio narrado por IA e imagen destacada flotante solapada.
- **Panel de Control Editorial Pro:** Dashboard de administración con barra lateral interna de navegación (estilo Rank Math / ACF Pro) sin dependencias de emojis y basado en íconos vectoriales **Lucide Icons**.
- **Control de Cobertura en Vivo:** Módulo configurable desde el panel de administración para conmutar la Columna 3 del Hero entre noticias "Al Momento" o un seguimiento en directo minuto a minuto.
- **Modo Multimedia:** Strip horizontal oscuro optimizado para reportajes en video y coberturas audiovisuales.
- **Optimización B2B:** Tipografías web de carga rápida (*Inter*, *Merriweather*, *DM Mono*), CSS ligero e integración limpia con Gutenberg.

---

## 📁 Estructura del Repositorio

```text
PressGridPro/
├── includes/
│   ├── enqueue.php        # Carga de estilos y scripts
│   ├── setup.php          # Soportes, menús y widgets
├── backend/
│   ├── admin-style.css     # Estilos del panel de administración
│   └── theme-options.php   # Opciones del tema (WordPress Settings API)
├── pressgrid-core/
│   └── pressgrid-core.php  # Plugin complementario: metadatos editoriales
├── templates/
│   ├── home/               # Componentes de la portada
│   ├── sidebar/            # Componentes de barras laterales
│   └── single/
│       ├── components/     # Partes reutilizables del artículo
│       └── layouts/        # Diseños completos de artículo
├── footer.php              # Pie de página global
├── front-page.php          # Plantilla de portada principal
├── functions.php           # Carga los módulos del tema
├── header.php              # Encabezado HTML y navegación
├── index.php               # Fallback principal
├── single.php              # Plantilla de artículo individual (Single Dark Hero)
└── style.css               # Hoja de estilos principal y cabecera del tema
```

## PressGrid Core

La lógica editorial de las entradas vive en el plugin complementario `pressgrid-core/`. Administra las metaboxes de nota principal, secundaria, alerta, kicker, bajada, URL de audio, pie y crédito de foto. Conserva las claves `_pgp_*` y puede leer las claves antiguas `_gcm_*` compatibles.

### Instalación

1. En WordPress, abre **Plugins → Añadir nuevo → Subir plugin**.
2. Comprime la carpeta `pressgrid-core/` en un archivo ZIP (el ZIP debe contener `pressgrid-core/pressgrid-core.php`) y súbelo.
3. Activa **PressGrid Core** desde **Plugins instalados**.

El despliegue de GitHub Actions también sincroniza el tema con `wp-content/themes/PressGridPro/` y el plugin, por separado, con `wp-content/plugins/pressgrid-core/`. Después del primer despliegue, activa el plugin desde el administrador de WordPress. No copies `pressgrid-core/` dentro de la carpeta del tema.
