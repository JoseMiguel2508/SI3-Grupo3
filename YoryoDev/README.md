# 🚀 Guía de Git y Retos de Learn Git Branching  

Este documento es una guía para comprender Git y resolver los retos de [Learn Git Branching](https://learngitbranching.js.org/?locale=es_ES). Se explican los conceptos clave de Git junto con una descripción detallada de cada reto disponible en la plataforma.  

---

## 📌 Introducción a Git  

Git es un sistema de control de versiones distribuido que permite gestionar cambios en el código fuente de un proyecto. Algunas de sus funcionalidades clave incluyen:  

- **Rastrear cambios en los archivos** a lo largo del tiempo.  
- **Trabajar en equipo de manera eficiente**, permitiendo múltiples contribuyentes.  
- **Facilitar la fusión de cambios** entre diferentes versiones del proyecto.  
- **Mantener un historial de cambios**, permitiendo revertir errores.  

---

## 🏗 Conceptos Claves de Git  

| Comando | Descripción |
|---------|------------|
| `git init` | Inicializa un nuevo repositorio Git. |
| `git clone <url>` | Clona un repositorio remoto. |
| `git add <archivo>` | Agrega cambios al área de preparación. |
| `git commit -m "mensaje"` | Guarda los cambios en el historial. |
| `git status` | Muestra el estado del repositorio. |
| `git log` | Muestra el historial de commits. |
| `git branch <nombre>` | Crea una nueva rama. |
| `git checkout <rama>` | Cambia a una rama existente. |
| `git merge <rama>` | Fusiona una rama en la actual. |
| `git rebase <rama>` | Aplica commits de una rama sobre otra. |
| `git push` | Envía cambios al repositorio remoto. |
| `git pull` | Descarga y fusiona cambios del remoto. |

---

## 🚀 Retos de Learn Git Branching  

A continuación, se explican los retos junto con sus soluciones y conceptos aplicados.  

### 🔰 Nivel 1: Fundamentos de Git  

#### 1️⃣ *Iniciando con Git*  
📌 **Objetivo:** Entender los comandos `git commit` y `git branch`.  
💡 **Comandos clave:**  
```bash
git commit
git branch nueva-rama
git checkout nueva-rama
git commit
```
#### 🔍 *Explicación: Se crea una rama, se cambia a ella y se realizan commits.*

#### 2️⃣ *Ramas y fusiones*  
📌 **Objetivo:** Aprender a fusionar ramas con `git merge`.  
💡 **Comandos clave:**  
```bash
git merge rama-secundaria
```
#### 🔍 **Explicación:** Se crea una rama, se cambia a ella y se realizan commits.

#### 3️⃣ *Deshaciendo cambios*  
📌 **Objetivo:** Revertir y restablecer commits con `git reset` y `git revert`.  
💡 **Comandos clave:**  
```bash
git reset HEAD~1  # Deshacer el último commit sin eliminar cambios
git revert HEAD   # Crear un commit que revierte cambios previos
```
#### 🔍 **Explicación:** `reset` mueve la rama a un estado anterior, mientras que `revert` crea un nuevo commit para deshacer cambios.

#### 3️⃣ *Deshaciendo cambios*  
📌 **Objetivo:** Revertir y restablecer commits con `git reset` y `git revert`.  
💡 **Comandos clave:**  
```bash
git reset HEAD~1  # Deshacer el último commit sin eliminar cambios
git revert HEAD   # Crear un commit que revierte cambios previos
```
#### 🔍 **Explicación:** `reset` mueve la rama a un estado anterior, mientras que `revert` crea un nuevo commit para deshacer cambios.

### 🔥 Nivel 2: Avanzado en Git

#### 4️⃣ *Rebase en acción*  
📌 **Objetivo:** Aprender `git rebase` para reorganizar el historial.  
💡 **Comandos clave:**  
```bash
git rebase main
```
#### 🔍 **Explicación:** Se aplica una rama sobre otra para mantener un historial más limpio y lineal.

#### 5️⃣ *Cherry-picking*  
📌 **Objetivo:** Extraer commits específicos con `git cherry-pick`. 
💡 **Comandos clave:**  
```bash
git cherry-pick <id_commit>
```
#### 🔍 **Explicación:** Permite aplicar un commit de una rama a otra sin fusionar todo el contenido.

#### 6️⃣ *Trabajo con git stash*  
📌 **Objetivo:** Guardar cambios temporales con `git stash`. 
💡 **Comandos clave:**  
```bash
git stash
git stash pop
```
#### 🔍 **Explicación:** Se usa cuando se necesita cambiar de rama sin perder el progreso actual.