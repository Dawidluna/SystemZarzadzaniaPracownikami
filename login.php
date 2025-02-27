<?php include 'includes/db.php';?>
<?php 
    session_start();
    if(isset($_SESSION["user"])) {
        header('Location: index.php');
    }
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
    <?php
            if(isset($_POST["zaloguj"])) {
                $login = $_POST['login'];
                $haslo = md5($_POST['haslo']);
                $result = mysqli_query($conn, "SELECT haslo FROM users WHERE login = '$login'");
                if(mysqli_num_rows($result) != 0) {
                    $poprawne_haslo = mysqli_fetch_assoc($result)["haslo"];
                    if($haslo == $poprawne_haslo) {
                        $_SESSION["user"] = $login;
                        header('Location: index.php');
                    }
                }
                echo  '<div class="alert alert-danger alert-dismissible fade show text-light alert-top" role="alert">
                            <span class="alert-icon align-middle">
                                <span class="material-icons text-xl mt-1">
                                error
                                </span>
                            </span>
                            <span class="alert-text"><strong>Błąd!</strong> Nieprawidłowa nazwa użytkownika lub hasło.</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
                
            }
        ?>
        <div class="mx-auto border rounded mt-10 p-4 logowanie">
            <form action="" method="post">
                <h2 class="text-center">Zaloguj się</h2>                  
                <div class="input-group input-group-outline my-3">
                    <label class="form-label">Login</label>
                    <input type="text" class="form-control" name="login">
                </div>
                <div class="input-group input-group-outline mt-3 mb-4">
                    <label class="form-label">Hasło</label>
                    <input type="password" class="form-control" name="haslo">
                </div>
                <div class="d-flex justify-content-around">
                    <div>
                        <button class="btn btn-primary" name="zaloguj" type="submit">Zaloguj się</button>
                    </div>
                    <div>
                        <button class="btn btn-primary" type="button">Nie pamiętam hasła</button>
                    </div>
                </div>
            </form>
        </div>

        <!--   Core JS Files   -->
        <script src="material/assets/js/core/popper.min.js"></script>
        <script src="material/assets/js/core/bootstrap.min.js"></script>

        <!-- Plugin for the charts, full documentation here: https://www.chartjs.org/ -->
        <script src="material/assets/js/plugins/chartjs.min.js"></script>
        <script src="material/assets/js/plugins/Chart.extension.js"></script>

        <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="material/assets/js/material-dashboard.min.js"></script>
    </body>
</html>
<?php mysqli_close($conn);?>