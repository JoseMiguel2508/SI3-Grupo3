# Grupo_3_SIII

## Instrucciones de uso Git

### 1️⃣ Crear repositorio

- Dirigirse a la ruta del archivo y abrir la terminal (`cmd` o `Git Bash`).  
  - Para abrir la terminal en Windows: `Win + R`, escribir `cmd` y presionar `Enter`.
- Crear un repositorio público:
  ```bash
  gh repo create nombre-del-repo --public
  ```
- Autenticarse:
  ```bash
  gh auth login
  ```
- Acceso a los integrantes del **Grupo_3_SIII**:
  - En la interfaz de **GitHub**, ir a **Configuraciones**.
  - En **Colaboradores**, agregar los nombres de usuario de cada integrante.
  - Cada integrante debe aceptar la invitación por correo.

---

### 2️⃣ Cada integrante clona el repositorio
```bash
git clone [URL_DEL_REPO]
```

---

### 3️⃣ Crear una rama por integrante
```bash
git checkout -b feature-[nombre]
```

---

### 4️⃣ Subir archivo de avances de práctica Git

📌 **Enlace:** [learngitbranching.js.org](https://learngitbranching.js.org/)

---

### 5️⃣ Comandos para subir a la rama
```bash
git add .
git status
git commit -m "Comentario de lo que se está subiendo"
git push origin feature-[nombre]
```

---

✅ **Listo!** Ahora cada integrante puede trabajar en su rama y luego hacer merge con `main` cuando corresponda. 🚀
