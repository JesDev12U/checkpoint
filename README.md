# Checkpoint Game Store

Para configurar el correo para PHPMailer, es necesario poner las variables `EMAIL` y `PASSWORD_EMAIL` en un archivo `.env` colocado en la raíz del proyecto

Ejemplo del archvo `.env`

```txt
EMAIL=ejemplo@ejemplo.ejemplo
PASSWORD_EMAIL=password_ejemplo
```

También es necesario darle permisos de escritura al directorio `uploads/` y a su contenido recursivamente para poder subir las Fotos que se suban en la página

```bash
sudo chmod 777 -R uploads
```
