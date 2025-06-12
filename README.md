#  Catálogo de Productos - Laravel

Aplicación web desarrollada en **Laravel 12.x** con **PHP 8.3** y base de datos **MySQL/MariaDB**, que permite gestionar un catálogo de productos con:

* CRUD completo (crear, editar, eliminar)
* Subida y vista de imágenes
* Paginación dinámica vía **AJAX**
* Ordenamiento por fecha de ingreso
* Validaciones con **JavaScript nativo**
* Interfaz responsiva con Bootstrap 5
*  Dockerizado y listo para levantar con `docker-compose`

---

##  Requisitos

* Docker + Docker Compose
* Git (opcional, si clonas desde GitHub)

---

##  Iniciar el proyecto (todo en un solo paso)

Clona el proyecto, construye los contenedores y levanta Laravel con migraciones:

```bash
git clone https://github.com/crvini/catalogo-productos.git
cd catalogo-productos
docker-compose up -d --build
docker exec -it laravel_app bash -c "composer install && cp .env.example .env && php artisan key:generate && php artisan migrate && php artisan storage:link && exit"
```

Luego en el navegador en:
 **[http://localhost:8000](http://localhost:8000)**

---

## Estructura del Proyecto

```
├── app/Http/Controllers/ProductController.php
├── public/storage/             
├── resources/views/productos.blade.php
├── storage/app/public/fotos/  
├── docker-compose.yml
└── README.md
```

---

## Variables de entorno .env

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret

SESSION_DRIVER=file
CACHE_STORE=file
FILESYSTEM_DISK=public
```

---

## Funcionalidades implementadas

* Modal para agregar y editar productos
* Validaciones en el cliente:

  * Código único alfanumérico (sin caracteres especiales)
  * Nombre solo con letras
  * Imágenes solo en formato `.jpeg`, `.jpg`, `.png`, `.gif`
  * Tamaño máximo permitido: 1.5MB
  * Fechas en formato `DD/MM/YYYY`
  * La fecha de ingreso y vencimiento debe ser posterior al inicio del mes actual
* Paginación dinámica con AJAX
* Ordenamiento al hacer clic en el encabezado "Fecha de ingreso"
* Visualización de las imágenes en la tabla


