<link rel="stylesheet" href="<?php echo base_url("assets/css/pages/auth.css") ?>">

<body>
  <div id="auth">
    <div class="row h-100">
      <div class="col-lg-5 col-12 p-xxl-5">
        <div id="auth-left">
          <div class="auth-logo">
            <img src="<?php echo base_url("assets/images/logo.jpeg") ?>" alt="Logo" />
          </div>
          <h1 class="auth-title">Inicio de Sesión</h1>
          <p class="auth-subtitle mb-5">
            Ingrese sus credenciales para iniciar sesión.
          </p>

          <?php

          $form_attr = [
            "method" => "POST"
          ];

          echo form_open("/login", $form_attr);


          ?>
          <div class="form-group position-relative has-icon-left mb-4">
            <input type="text" class="form-control form-control-xl" placeholder="Correo Electrónico" name="email" />
            <div class="form-control-icon">
              <i class="bi bi-envelope-fill"></i>
            </div>
          </div>
          <div class="form-group position-relative has-icon-left mb-4">
            <input type="password" class="form-control form-control-xl" placeholder="Contraseña" id="password" name="password" />
            <div class="form-control-icon">
              <i class="bi bi-eye-slash" id="icon_pwd"></i>
            </div>
          </div>
          <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">
            Iniciar Sesión
          </button>
          <?php echo form_close(); ?>

        </div>
      </div>
      <div class="col-lg-7 d-none d-lg-block">
        <div id="auth-right"></div>
      </div>
    </div>
  </div>

  <?php if (isset($error) && $error == 1) : ?>
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Atención!',
        text: 'Credenciales inválidas, intente nuevamente',
      }).then(() => {
        window.location.replace("<?php echo base_url() ?>");
      })
    </script>
  <?php endif ?>

  <script>
    const password_icon = document.getElementById("icon_pwd")

    password_icon.addEventListener("click", togglePassword)

    function togglePassword() {
      const type = document.getElementById("password").getAttribute("type")
      if (type == "password") {
        password.setAttribute("type", "text");
        password_icon.classList.remove("bi-eye-slash")
        password_icon.classList.add("bi-eye")
      } else {
        password.setAttribute("type", "password");
        password_icon.classList.remove("bi-eye")
        password_icon.classList.add("bi-eye-slash")
      }
    }
  </script>
</body>