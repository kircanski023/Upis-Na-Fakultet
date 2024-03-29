<?php

session_start();


if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: index.php");
  exit;
}


require_once "config.php";

$username = $password = "";
$username_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty(trim($_POST["username"]))) {
    $username_err = "Unesite korisničko ime";
  } else {
    $username = trim($_POST["username"]);
  }

  if (empty(trim($_POST["password"]))) {
    $password_err = "Unesite šifru";
  } else {
    $password = trim($_POST["password"]);
  }

  if (empty($username_err) && empty($password_err)) {

    $sql = "SELECT id_korisnika, korisnicko_ime, sifra FROM korisnik WHERE korisnicko_ime = ?";

    if ($stmt = mysqli_prepare($con, $sql)) {
      mysqli_stmt_bind_param($stmt, "s", $param_username);

      $param_username = $username;

      if (mysqli_stmt_execute($stmt)) {

        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 1) {
          mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
          if (mysqli_stmt_fetch($stmt)) {
            if (password_verify($password, $hashed_password)) {
              session_start();

              $_SESSION["loggedin"] = true;
              $_SESSION["id"] = $id;
              $_SESSION["username"] = $username;

              header("location: index.php");
            } else {
              $password_err = "Šifra koju ste uneli je pogrešna.";
            }
          }
        } else {

          $username_err = "Ne postoji nalog sa takvim korisničkim imenom.";
        }
      } else {
        echo "Greška!.";
      }
    }

    mysqli_stmt_close($stmt);
  }

  // Close connection
  mysqli_close($con);
}
?>


<!--Writing HTML Code here from bootstrap templates-->

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" href="images/favicon.png" />
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <title>Upis Na Fakultet</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#" style="font-size:30px;"><strong>Upis Na Fakultet</strong></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item dropdown">
        </li>
        <li class="nav-item">
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <a href="register.php" class="btn btn-success my-2 my-sm-0" type="submit">Novi Nalog</a>
      </form>
    </div>
  </nav>

  <div class="container my-4">

    <div class="card mx-auto" style="width: 20rem;"><br>
      <img class="card-img-top mx-auto" src="https://icon-library.com/images/admin-login-icon/admin-login-icon-15.jpg" style="width: 60%; " alt="Card image cap">
      <div class="card-body">

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label>Korisnicko ime</label>
            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
            <span class="help-block"><?php echo $username_err; ?></span>
          </div>
          <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Šifra</label>
            <input type="password" name="password" class="form-control">
            <span class="help-block"><?php echo $password_err; ?></span>
          </div>

          <button type="submit" class="btn btn-warning"><i class="fa fa-lock">&nbsp;</i> Potvrdi</button> &nbsp; &nbsp;
          <button type="reset" class="btn btn-danger "><i class="fa fa-repeat">&nbsp;</i> Resetuj</button>

        </form>
      </div>
    </div>

    <!--footer section-->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>