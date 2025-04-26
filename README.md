# Checkpoint Game Store

Para configurar el correo para PHPMailer, es necesario poner las variables `EMAIL` y `PASSWORD_EMAIL` en un archivo `.env` colocado en la raíz del proyecto
También está implementado el Wallet de Mercado Pago, por lo que se necesita colocar también la key secreta `MERCADO_PAGO_SECRET_KEY`, la key pública `MERCADO_PAGO_PUBLIC_KEY` y la key del Webhook de Mercado Pago `MERCADO_PAGO_SECRET_KEY_HOOK`

Ejemplo del archvo `.env`

```txt
EMAIL=ejemplo@ejemplo.ejemplo
PASSWORD_EMAIL=password_ejemplo
MERCADO_PAGO_SECRET_KEY=<SECRET_KEY>
MERCADO_PAGO_PUBLIC_KEY=<PUBLIC_KEY>
MERCADO_PAGO_SECRET_KEY_HOOK=<SECRET_KEY_HOOK>
```

También es necesario darle permisos de escritura al directorio `uploads/` y `logs/` y a su contenido recursivamente para poder subir las Fotos que se suban en la página y los logs del Hook de Mercado Pago respectivamente.

```bash
sudo chmod 777 -R uploads && sudo chmod 777 logs
```
