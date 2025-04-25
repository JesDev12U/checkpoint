<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tu código de verificación</title>
  <style>
    body {
      background-color: #f4f4f7;
      font-family: "Segoe UI", Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 480px;
      margin: 40px auto;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
      padding: 32px 24px;
    }

    .logo {
      display: block;
      margin: 0 auto 24px auto;
      width: 80px;
      height: auto;
    }

    h2 {
      color: #333;
      text-align: center;
      margin-bottom: 16px;
    }

    p {
      color: #555;
      font-size: 16px;
      line-height: 1.5;
      text-align: center;
    }

    .code-box {
      background: #f0f4fa;
      color: #458c29;
      font-size: 28px;
      font-weight: bold;
      letter-spacing: 6px;
      padding: 18px 0;
      border-radius: 6px;
      text-align: center;
      margin: 24px 0;
      border: 1px dashed #acff9c;
    }

    .footer {
      text-align: center;
      color: #aaa;
      font-size: 13px;
      margin-top: 32px;
    }
  </style>
</head>

<body>
  <div class="container">
    <img src="cid:logoCID" alt="Logo" class="logo" />
    <h2>¡Bienvenido!</h2>
    <p>
      Para completar la creación de tu cuenta, por favor ingresa el siguiente
      código de verificación:
    </p>
    <div class="code-box">
      <?php echo $numeroAleatorio ?>
    </div>
    <p>Si no solicitaste este código, puedes ignorar este mensaje.</p>
    <div class="footer">
      © 2025 Checkpoint. Todos los derechos reservados.
    </div>
  </div>
</body>

</html>