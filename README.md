# 🕊️ Memorial Digital

Un proyecto para crear y gestionar memoriales digitales para honrar la memoria de seres queridos que ya no están con nosotros, permitiendo compartir recuerdos, fotos, tributos y más.

## 📋 Acerca del Proyecto

Memorial Digital es una aplicación web completa que permite crear espacios virtuales dedicados a preservar y celebrar la memoria de personas fallecidas. La plataforma ofrece una experiencia conmovedora y respetuosa para las familias y amigos, permitiéndoles:

- Compartir la biografía y datos personales del ser querido
- Subir y organizar galerías de fotos de momentos especiales
- Registrar lugares importantes en la vida de la persona
- Crear una línea de tiempo con eventos significativos
- Recibir tributos y mensajes de condolencia de visitantes
- Personalizar completamente la apariencia visual del memorial
- Adaptar el contenido y estructura del memorial

## 🚀 Tecnologías Utilizadas

El proyecto está construido utilizando tecnologías modernas y robustas:

- **Backend**: [Laravel 12](https://laravel.com) - Framework PHP de alto rendimiento
- **Panel Admin**: [Filament 3](https://filamentphp.com) - Panel de administración elegante y funcional
- **Base de Datos**: MySQL/MariaDB
- **API**: RESTful API con Laravel para la comunicación con el frontend
- **Almacenamiento**: Sistema de archivos local o en la nube (configurable)
- **Personalización**: Sistema completo de estilos visuales con colores, fuentes y diseños adaptables

## 🛠️ Instalación y Configuración

### Requisitos Previos

- PHP 8.1 o superior
- Composer
- MySQL o MariaDB
- Node.js y NPM (opcional, para compilar activos)
- Servidor web (Apache, Nginx, etc.)

### Pasos de Instalación

1. **Clonar el repositorio**

```bash
git clone https://github.com/Samuel-tech22/memorial-digital.git
cd memorial-digital
```

2. **Instalar dependencias de PHP**

```bash
composer install
```

3. **Configurar variables de entorno**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Configurar la base de datos**

Editar el archivo `.env` con los datos de conexión a tu base de datos:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=memorial_digital
DB_USERNAME=root
DB_PASSWORD=
```

5. **Ejecutar migraciones y seeders**

```bash
php artisan migrate --seed
```

6. **Configurar almacenamiento**

```bash
php artisan storage:link
```

7. **Iniciar el servidor local**

```bash
php artisan serve
```

La aplicación estará disponible en http://localhost:8000

8. **Acceder al panel de administración**

URL: http://localhost:8000/admin
Usuario: admin@admin.com
Contraseña: password

## 🔍 Estructura y Funcionalidades

### Memorial Principal

El sistema está diseñado para gestionar un memorial principal (activo) con todas sus características:

- **Datos Biográficos**: Nombre, fechas, frase recordatoria, biografía
- **Galería de Fotos**: Imágenes organizadas por categorías
- **Lugares Importantes**: Mapa con ubicaciones relevantes
- **Línea de Tiempo**: Cronología de eventos significativos
- **Tributos**: Mensajes de condolencia y recuerdos de visitantes
- **Personalización Visual**: Colores, fuentes, estilos
- **Pie de Página Configurable**: Enlaces y elementos del footer

### API para Frontend

La aplicación expone una API RESTful completa para desarrollar un frontend personalizado:

- `/api/memorial` - Datos principales del memorial
- `/api/memorial/fotos` - Galería de fotos
- `/api/memorial/lugares` - Lugares importantes
- `/api/memorial/linea-tiempo` - Eventos cronológicos
- `/api/memorial/tributos` - Tributos y mensajes
- `/api/memorial/estilos` - Estilos visuales
- `/api/memorial/footer` - Configuración del pie de página

## 🤝 Contribución

Las contribuciones son bienvenidas. Para contribuir:

1. Haz un fork del proyecto
2. Crea tu rama de características (`git checkout -b feature/nueva-caracteristica`)
3. Haz commit de tus cambios (`git commit -m 'Añade alguna característica'`)
4. Haz push a la rama (`git push origin feature/nueva-caracteristica`)
5. Abre un Pull Request

## 📄 Licencia

Este proyecto está licenciado bajo la Licencia MIT - ver el archivo [LICENSE](LICENSE) para más detalles.

## ✉️ Contacto

Si tienes preguntas o sugerencias sobre este proyecto, por favor contacta a [scandia022@gmail.com].
