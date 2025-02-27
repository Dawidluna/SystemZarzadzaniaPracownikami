<?php include 'includes/db.php';?>
<?php include 'includes/login_check.php';?>
<?php include 'includes/admin_check.php';?>
<?php
  if(!is_admin($conn)) header("Location: profil.php");
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="material/assets/img/apple-icon.png">
        <!--     Fonts and icons     -->   
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <!-- Nucleo Icons -->
        <link href="material/assets/css/nucleo-icons.css" rel="stylesheet" />
        <link href="material/assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <link href="material/assets/css/nucleo-svg.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
        <!-- CSS Files -->
        <link id="pagestyle" href="material/assets/css/material-dashboard.css" rel="stylesheet" />
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <?php include 'includes/header.php';?>

        <h1 class="page-title">Pracownicy</h1>
        <div class="d-flex justify-content-around"> 
          <div class="center-search"></div>
          <div class="search-bar">
              <form action="" method="get">
                  <div class="input-group input-group-outline input-group">
                      <input type="text" class="form-control bar" placeholder="Wyszukaj pracownika" aria-label="Wyszukaj pracownika" aria-describedby="button-addon" name="szukane">
                      <button class="btn btn-primary" type="submit" id="button-addon" name="szukaj">Szukaj</button>
                  </div>               
              </form>
          </div>
          <a class="btn btn-primary" role="button" href="dodaj_pracownika.php"><i class="material-icons">person_add</i> Dodaj pracownika</a>
        </div>

        <div class="card w-75 mx-auto mt-3">
  <div class="table-responsive">
    <table class="table align-items-center mb-0">
      <thead>
        <tr>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pracownik</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Stanowisko</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Data zatrudnienia</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $search = "";
          if(isset($_GET['szukaj'])) $search = $_GET['szukane'];
          $search = strtolower($search);
          $result = mysqli_query($conn, "SELECT `login`, imie, nazwisko, zdjecie, adres_email, stanowisko, data_zatrudnienia FROM users");
          while($row = mysqli_fetch_assoc($result)) {
            $imie_nazwisko = strtolower($row["imie"]." ".$row["nazwisko"]);
            if(str_contains($imie_nazwisko, $search)) {
              echo '
              <form id="'.$row["login"].'" action="profil.php" method="post">
              <input class="hide" value="'.$row["login"].'" name="user">
              <tr class="pracownik" onclick="pokaz('."'".$row["login"]."'".')">
              <td>
                <div class="d-flex px-2 py-1">
                  <div>
                    <img src="img/'.$row["zdjecie"].'" class="avatar avatar-sm me-3">
                  </div>
                  <div class="d-flex flex-column justify-content-center">
                  <h6 class="mb-0 text-xs">'.$row["imie"].' '.$row["nazwisko"].'</h6>
                    <p class="text-xs text-secondary mb-0">'.$row['adres_email'].'</p>
                  </div>
                </div>
              </td>
              <td>
                <p class="text-xs font-weight-bold mb-0">'.$row["stanowisko"].'</p>
              </td>
              <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-normal">'.$row['data_zatrudnienia'].'</span>
              </td>
            </tr>
            </form>';
            }
          }
        ?>
      </tbody>
    </table>
  </div>
</div>

        <!--   Core JS Files   -->
        <script src="material/assets/js/core/popper.min.js"></script>
        <script src="material/assets/js/core/bootstrap.min.js"></script>

        <!-- Plugin for the charts, full documentation here: https://www.chartjs.org/ -->
        <script src="material/assets/js/plugins/chartjs.min.js"></script>
        <script src="material/assets/js/plugins/Chart.extension.js"></script>

        <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="material/assets/js/material-dashboard.min.js"></script>
        <script>
            function pokaz(login) {
              console.log(login);
              document.getElementById(login).submit();
            }
        </script>
    </body>
</html>
<?php mysqli_close($conn);?>