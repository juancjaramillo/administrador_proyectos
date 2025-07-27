# Administrador de Proyectos

Un pequeño panel administrativo en Symfony para gestionar **Usuarios**, **Proyectos**, **Tareas** y **Tarifas**. Incluye:

- **Autenticación** (solo `ROLE_ADMIN` puede acceder).
- **CRUD** completo de Usuarios, Proyectos y Tareas.
- **Tarifa por hora** configurable en cada tarea.
- **Endpoints API** para obtener tareas de un usuario.
- **Fixtures** para poblar datos de prueba (Admin, Users, Projects, Tasks, Rates).

---

## ⚙️ Requisitos

- PHP 8.1+  
- Composer  
- MySQL / MariaDB (u otra BD soportada por Doctrine)  
- Extensiones PHP: pdo_mysql, mbstring, xml, etc.  
- (Opcional) Symfony CLI  

---

## 🚀 Instalación

```bash
# 1. Clonar el repositorio
git clone https://github.com/juancjaramillo/administrador_proyectos.git
cd administrador_proyectos

# 2. Instalar dependencias
composer install

# 3. Configurar variables de entorno
cp .env .env.local
# Edita DATABASE_URL en .env.local con tus credenciales de BD

# 4. Crear/actualizar el esquema
php bin/console doctrine:schema:update --force

# 5. Cargar datos de prueba (fixtures)
php bin/console doctrine:fixtures:load
# Usuario admin: admin@example.com / admin123

# 6. Ejecutar servidor de desarrollo
symfony serve
# o
php -S localhost:8000 -t public
```

---

## 🔐 Login y roles

- **URL**: `http://localhost:8000/login`  
- **Admin por defecto**:  
  - Email: `admin@example.com`  
  - Password: `admin123`  

Solo los usuarios con `ROLE_ADMIN` pueden acceder a las rutas de `/users`, `/project` y `/task`.

---

## 📋 Rutas principales

| Ruta                         | Método    | Descripción                          |
|------------------------------|-----------|--------------------------------------|
| `/login`                     | GET/POST  | Formulario de inicio de sesión       |
| `/logout`                    | GET       | Cerrar sesión                        |
| `/users`                     | GET       | Listado de usuarios                  |
| `/project/`                  | GET       | Listado de proyectos                 |
| `/project/new`               | GET/POST  | Crear nuevo proyecto                 |
| `/project/{id}`              | GET       | Ver detalle de proyecto              |
| `/project/{id}/edit`         | GET/POST  | Editar proyecto                      |
| `/project/{id}`              | POST      | Eliminar proyecto                    |
| `/task/`                     | GET       | Listado de tareas                    |
| `/task/new`                  | GET/POST  | Crear nueva tarea                    |
| `/task/{id}`                 | GET       | Ver detalle de tarea                 |
| `/task/{id}/edit`            | GET/POST  | Editar tarea                         |
| `/task/{id}`                 | POST      | Eliminar tarea                       |
| `/api/users/{id}/tasks`      | GET       | API: tareas de un usuario (JSON)     |

---

## 🛠️ Estructura del proyecto

```
config/
src/
  Controller/
  Entity/
  Form/
  Security/
  DataFixtures/
templates/
  base.html.twig
  security/login.html.twig
  user/
  project/
  task/
migrations/
public/
tests/
```

---

## ✨ Personalización

- **Bootstrap 5**: CDN incluido en `base.html.twig`.  
- **Formularios**: ajusta `src/Form/TaskType.php` (por ejemplo, orden de campos, step de `hourlyRate`).  
- **Seguridad**: revisa `config/packages/security.yaml` para roles/firewall.  
- **Migrations** (opción avanzada):
  ```bash
  php bin/console doctrine:migrations:sync-metadata-storage
  php bin/console make:migration
  php bin/console doctrine:migrations:migrate
  ```

---

## 🤝 Contribuir

1. Haz un fork de este repositorio.  
2. Crea tu rama feature: `git checkout -b feature/fooBar`  
3. Haz tus cambios y commitea: `git commit -am 'Add fooBar'`  
4. Empuja a la rama: `git push origin feature/fooBar`  
5. Abre un Pull Request.

---

## 📄 Licencia

Este proyecto está bajo la licencia **MIT**. Consulta el archivo `LICENSE` para más detalles.
