## PageSpeed Insights Dashboard

PageSpeed Insights Dashboard es una aplicación web desarrollada en Laravel, que permite a los usuarios introducir URLs de sitios web para obtener métricas de rendimiento, accesibilidad, prácticas recomendadas y SEO utilizando la API de PageSpeed Insights. Los usuarios pueden visualizar los resultados en un formato amigable y guardar el historial de pruebas para futuras consultas.

## Descripción

Este proyecto nació de la necesidad de monitorear el rendimiento de varios sitios web de forma centralizada y amigable. Con PageSpeed Insights Dashboard, los usuarios pueden:

- **Ingresar URLs para obtener métricas de rendimiento en tiempo real.**
- **Seleccionar diferentes estrategias de análisis (móvil/desktop).**
- **Guardar y visualizar el historial de métricas para cada sitio.**

## Instalación

- **Requisitos Previos**

Asegúrate de tener instalado PHP (>=8.1), Composer y Laravel (10.x) en tu sistema.

- **Pasos de Instalación**

Para instalar y configurar el proyecto en tu entorno local, sigue estos pasos:

```sh
  # Clonar el repositorio
  git clone https://github.com/betancourtneidys/pagespeed-insights-dashboard.git

  # Cambiar al directorio del proyecto
  cd pagespeed-insights-dashboard

  # Instalar dependencias de PHP
  composer install

  # Copiar el archivo de entorno y configurar tus claves de API
  cp .env.example .env
  nano .env

  # Generar la clave de la aplicación
  php artisan key:generate

  # Ejecutar las migraciones de la base de datos (SQLite o MySQL)
  php artisan migrate

  # Iniciar el servidor de desarrollo de Laravel
  php artisan serve
```
Ahora puedes acceder al proyecto en http://localhost:8000

## Uso

Después de instalar el proyecto, visita http://localhost:8000 en tu navegador. Desde allí, puedes:

1. Ingresar la URL del sitio que deseas analizar.
2. Seleccionar las categorías de métricas que te interesan.
3. Elegir la estrategia de análisis (móvil o escritorio).
4. Hacer clic en "Obtener Métrica" para ver los resultados.
5. Opcionalmente, guardar los resultados para consultarlos más tarde.

## Configuración

Para personalizar el funcionamiento de la aplicación, puedes modificar las variables en el archivo .env, incluyendo tu propia clave API de PageSpeed Insights.

## Contacto

Neidys Betancourt - [https://www.linkedin.com/in/betancourtneidys](https://www.linkedin.com/in/betancourtneidys) - betancourtneidys@gmail.com

Link del Proyecto: [https://github.com/betancourtneidys/pagespeed-insights-dashboard](https://github.com/betancourtneidys/pagespeed-insights-dashboard).

## Licencia

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Créditos

[Google PageSpeed Insights API](https://developers.google.com/speed/docs/insights/rest?hl=es-419).