# Catálogo de Productos - Laravel

Aplicación web desarrollada en **Laravel 12.x** con **PHP 8.3** y base de datos **MySQL/MariaDB**, que permite gestionar un catálogo de productos con:

- CRUD completo (crear, editar, eliminar)
- Subida y vista de imágenes
- Paginación dinámica vía **AJAX**
- Ordenamiento por fecha de ingreso
- Validaciones con **JavaScript/jQuery**
- Interfaz responsiva con Bootstrap 5
- Dockerizado y listo para levantar con `docker-compose`

---

## 🔧 Requisitos

- Docker + Docker Compose
- Git (opcional, si clonas desde GitHub)

---

## 🚀 Iniciar el proyecto (todo en un solo paso)

Clona el proyecto, construye los contenedores y levanta Laravel con migraciones y almacenamiento enlazado:

```bash
git clone https://github.com/crvini/catalogo-productos.git
cd catalogo-productos
docker-compose up -d --build
docker exec -it laravel_app bash -c "composer install && cp .env.example .env && php artisan key:generate && php artisan migrate && php artisan storage:link && exit"
```

Una vez iniciado, accede a la app en:  
👉 **[http://localhost:8000/productos](http://localhost:8000/productos)**

---

## 📁 Estructura del Proyecto

```
├── app/Http/Controllers/ProductController.php
├── database/migrations/xxxx_create_products_table.php
├── public/storage/             
├── resources/views/productos.blade.php
├── storage/app/public/fotos/  
├── docker-compose.yml
├── Dockerfile (opcional si deseas usar uno personalizado)
└── README.md
```

---

## ⚙️ Variables de entorno (.env)

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

## ✅ Funcionalidades implementadas

- Modal para agregar y editar productos sin recargar la página
- Validaciones en el cliente:

  - Código: alfanumérico obligatorio
  - Nombre: solo letras
  - Cantidad y precio: obligatorios y numéricos
  - Imagen:
    - Tipos válidos: `.jpg`, `.jpeg`, `.png`, `.gif`
    - Tamaño máximo: **1.5 MB**
  - Fechas:
    - Requiere ingreso y vencimiento
    - Deben ser posteriores al primer día del mes actual

- Paginación dinámica con AJAX
- Ordenamiento haciendo clic en “Fecha Ingreso”
- Visualización de miniaturas de las imágenes

---

## 🐳 Notas Docker

- El contenedor `app` instala automáticamente `pdo_mysql` y levanta el servidor de desarrollo
- Puedes conectarte a la base de datos usando:
  - **Host**: `localhost`
  - **Puerto**: `3306`
  - **Usuario**: `laravel`
  - **Contraseña**: `secret`

