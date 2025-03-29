# 📌 Sistema de Monitoreo y Control de Flotas para Empresas de Transporte

## 📚 Materia
**Sistema de Información III**

## 👨‍🏫 Docente
**Ing. Jaime Zambrana Chacon**

## 👥 Estudiantes
- **Jose Miguel Fanola Caba**
- **Giorgio Sebastian Lopez Poiqui**
- **Ricardo Quiroz Guzman**
- **Jhamil Rocha Coca**

## 📌 Descripción del Proyecto
El **Sistema de Monitoreo y Control de Flotas para Empresas de Transporte** es una solución desarrollada con arquitectura **MVC** que permite gestionar eficientemente los vehículos de una empresa de transporte, permitiendo su monitoreo en tiempo real, asignación de rutas, gestión de mantenimiento y generación de reportes. 

Este sistema está diseñado para proporcionar una administración integral de la flota vehicular, facilitando la toma de decisiones basada en datos en tiempo real.

## 🛠️ Tecnologías Utilizadas
- **Frontend:** HTML, CSS (**Bootstrap**)
- **Backend:** PHP (**Modelo-Vista-Controlador - MVC**)
- **Base de Datos:** MySQL
- **Entorno de Desarrollo:** XAMPP (Apache, PHP, phpMyAdmin)

## 📂 Repositorio GitHub
🔗 [Repositorio en GitHub](https://github.com/JoseMiguel2508/SI3-Grupo3.git)

---

## 🚀 Instalación y Configuración en Local con XAMPP
Para ejecutar este proyecto en tu computadora, sigue los siguientes pasos:

### 1️⃣ **Clonar el Repositorio**
Ejecuta el siguiente comando en tu terminal o consola de Git Bash:
```bash
  git clone https://github.com/JoseMiguel2508/SI3-Grupo3.git
```

### 2️⃣ **Mover el Proyecto a la Carpeta de XAMPP**
Después de clonar el repositorio, mueve la carpeta del proyecto dentro del directorio `htdocs` de XAMPP:
```bash
  mv SI3-Grupo3 C:/xampp/htdocs/
```

### 3️⃣ **Configurar la Base de Datos**
1. Inicia **XAMPP** y asegúrate de que **Apache** y **MySQL** estén activos.
2. Abre tu navegador y accede a **phpMyAdmin**:  
   👉 `http://localhost:3306/phpmyadmin/` (si usas el puerto 3306) o `http://localhost/phpmyadmin/` (puerto por defecto).
3. Crea una nueva base de datos con el nombre `control_flotas`.
4. Importa el archivo SQL ubicado en:
   ```bash
   SI3-Grupo3/database/schema.sql
   ```

### 4️⃣ **Configurar el Proyecto**
1. Asegúrate de que XAMPP esté corriendo.
2. Accede a la carpeta del proyecto y busca el archivo de configuración de la base de datos:
   ```bash
   SI3-Grupo3/config/database.php
   ```
3. Modifica las credenciales según tu configuración local:
   ```php
   $host = "localhost";
   $user = "root";
   $password = "";
   $database = "control_flotas";
   $port = 3306; // Cambiar si usas otro puerto para MySQL
   ```

### 5️⃣ **Ejecutar el Proyecto**
Abre tu navegador y accede a:
```bash
  http://localhost/SI3-Grupo3/
```
¡Listo! Ahora puedes comenzar a usar el sistema. 🎉

---

## 📌 Contacto y Contribución
Si deseas contribuir o tienes alguna consulta, puedes abrir un **issue** en el repositorio o contactar con los desarrolladores.
