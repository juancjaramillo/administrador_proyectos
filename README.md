# Administrador de Proyectos

Aplicación para administración de proyectos y tareas desarrollada en **Symfony 7**, que permite gestionar:

* **Usuarios**, **Proyectos**, **Tareas** y **Tarifas por hora**
* Autenticación con `ROLE_ADMIN`
* Cálculo automático de **total por tarea** (`horas * tarifa`)
* **Fixtures** para cargar datos de prueba (Admin, Usuarios, Proyectos, Tareas, Tarifas)
* **API JSON** para consultar tareas de un usuario

---

## ⚙️ Requisitos

* PHP 8.1 o superior
* Composer
* MySQL
* Extensiones PHP


---

## 🚀 Instalación (Opción Rápida)

```bash
# 1. Clonar el repositorio
git clone https://github.com/juancjaramillo/administrador_proyectos.git
cd administrador_proyectos

# 2. Instalar dependencias
composer install

# 3. Configurar entorno
cp .env .env.local
# Edita .env.local y configura DATABASE_URL

# 4. Crear la base de datos
docker-compose up -d  # (o tu MySQL local)
php bin/console doctrine:database:create

# 5. Crear esquema directamente  
#    Generar todas las tablas
php bin/console doctrine:schema:update --force

# 6. Cargar datos de prueba
docker exec -it <app_container> php bin/console doctrine:fixtures:load
# Responde "yes" para purgar y recargar

# 7. Iniciar el servidor
symfony serve
# o
php -S localhost:8000 -t public
```

> ⚠️ Para producción, utiliza migraciones:
>
> ```bash
> php bin/console doctrine:migrations:sync-metadata-storage
> php bin/console make:migration
> php bin/console doctrine:migrations:migrate
> php bin/console doctrine:fixtures:load
> ```

---

## 🔐 Login por defecto

* URL: `http://localhost:8000/login`
* Usuario: `admin@admin.com`
* Contraseña: `admin123`

Solo usuarios con `ROLE_ADMIN` pueden acceder a los módulos Listar Proyecto y Listar Tareas.

---

## 📋 Rutas principales

| Ruta                    | Método   | Descripción                      |
| ----------------------- | -------- | -------------------------------- |
| `/login`                | GET/POST | Formulario de inicio de sesión   |
| `/logout`               | GET      | Cerrar sesión                    |
| `/users`                | GET      | Listado de usuarios              |
| `/project/`             | GET      | Listado de proyectos             |
| `/project/new`          | GET/POST | Crear nuevo proyecto             |
| `/project/{id}`         | GET      | Ver detalle de proyecto          |
| `/project/{id}/edit`    | GET/POST | Editar proyecto                  |
| `/task/`                | GET      | Listado de tareas                |
| `/task/new`             | GET/POST | Crear nueva tarea                |
| `/task/{id}`            | GET      | Ver detalle de tarea             |
| `/task/{id}/edit`       | GET/POST | Editar tarea                     |
| `/api/users/{id}/tasks` | GET      | API: tareas de un usuario (JSON) |

---

## 📊 Cálculo de total por tarea

El total se calcula automáticamente como:

```php
$total = $task->getHours() * $task->getHourlyRate();
```

---

## 🧪 Datos de prueba incluidos

* Usuario admin: `admin@admin.com` / `admin123`
* 2 usuarios (`Alicia`, `Ricardo`)
* 2 proyectos (`Proyecto Symfony`, `Proyecto EmberJs`)
* Tarifas asignadas por usuario/proyecto
* 3 tareas de ejemplo

---


## 📄 Licencia

Este proyecto está bajo la licencia **MIT**.
