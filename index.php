<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="styles.css"
    />
    <title>PHP AUTH</title>
  </head>
  <body>
    <nav class="navbar bg-body-tertiary">
      <div class="container-fluid my-container">
        <span class="navbar-brand mb-0 h1 remove-lr-margin"
          >PHP Authentication</span
        >
      </div>
    </nav>
    <div class="my-container home-section">
    <h1>Welcome</h1>
    <?php
      session_start();
      if(isset($_POST['logout'])) {
        session_unset();
        session_destroy();
      }
      if(isset($_SESSION) and isset($_SESSION['name'])) {
        echo "<div>
        <p>Name: {$_SESSION['name']}</p>
        <p>Email: {$_SESSION['email']}</p>
        </div>";
      } else {
        header('Location: signin.html');
      }
    ?>
    <div class="logout-container">
      <form method="POST" action="index.php">
        <input type="submit" class="btn btn-danger" name="logout" value="Log Out">
      </form>
    </div>
  </div>
    <script src="scripts.js"></script>
  </body>
</html>
