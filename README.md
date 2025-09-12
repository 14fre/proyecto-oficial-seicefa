<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 📌 SIBAF - Sistema de Bajas del Centro de Formación Agroindustrial

Este proyecto está desarrollado en **Laravel** y tiene como propósito **gestionar las solicitudes de baja de implementos del Centro de Formación Agroindustrial (SENA)**.  
El sistema permite que las solicitudes se hagan en línea, lleguen al almacén, y que el encargado del centro de acopio finalice el proceso de baja.  

---

## ⚙️ Requisitos del Sistema

- PHP >= 8.1
- Composer
- MySQL >= 5.7
- Node.js & NPM
- Extensiones habilitadas: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`

---

## 📂 Configuración del Proyecto

El archivo **.env** debe estar configurado de la siguiente manera:

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:ljZ0wabA2kK+W3SvFdt0m+nGTXGsqR/rSKTZvj6lK6I=
APP_DEBUG=true
APP_URL=127.0.0.1:8000

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3320
DB_DATABASE=sicefa
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DRIVER=local
QUEUE_CONNECTION=sync 
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=freimarespitia24@gmail.com
MAIL_PASSWORD=kfxpxsnrdpvvubiw
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=freimarespitia24@gmail.com
MAIL_FROM_NAME="Soporte SIBAF"

# SIBAF Support
SIBAF_SUPPORT_EMAIL=freimarespitia24@gmail.com
SIBAF_ADMIN_EMAIL=breinerjosellanoslopez@gmail.com

