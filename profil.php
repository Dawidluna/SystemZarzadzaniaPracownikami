<?php include 'includes/db.php';?>
<?php include 'includes/login_check.php';?>
<?php include 'includes/admin_check.php';?>
<?php
    if(isset($_POST["user"]) && is_admin($conn)) $user = $_POST["user"];
    else $user = $_SESSION["user"];
    $result = mysqli_query($conn, "SELECT * FROM users WHERE login = '$user'");
    $row = mysqli_fetch_assoc($result);

    if(isset($_POST["wyslij"])) {
        $login = $_POST['user'];
        $result = mysqli_query($conn, "SELECT id FROM users WHERE login = '$login'");
        $row = mysqli_fetch_assoc($result);
        setcookie('odbiorca', $row['id'], time() + 3600);
        header("Location: wiadomosci.php");
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
        <?php include 'includes/header.php';?>

        <h1 class="page-title">Profil pracownika</h1>
        <div class="mx-auto w-75 border rounded p-4 mt-4">
            <div class="row">
                <div class="col-md-4 p-3">
                    <div class="d-flex justify-content-center">
                        <?php echo '<img src="img/'.$row["zdjecie"].'" class="avatar avatar-xxxl mb-3">'?>
                    </div>
                    <div class="h4 text-center mb-4">
                        <?php echo $row["imie"].' '.$row["nazwisko"];?>
                    </div>
                    <?php
                    if($user != $_SESSION['user']) {
                    echo '<div>
                        <form action="" method="post"> 
                            <input class="hide" name="user" value="'.$row['login'].'">
                            <button type="submit" name="wyslij" class="w-100 btn btn-info">Wyślij wiadomośc</button>
                        </form>
                    </div>';
                    }
                    if(is_admin($conn) || $user == $_SESSION['user']) {
                    echo '<div>
                        <form action="edytuj.php" method="post">
                            <input class="hide" name="user" value="'.$row['login'].'">
                            <button class="w-100 btn btn-info" type="submit" name="edytuj">Edytuj profil</button>
                        </form>
                    </div>';
                    }
                    if(is_admin($conn) && $user != $_SESSION['user']) {
                    echo '<div>
                        <button class="w-100 btn btn-primary" data-bs-toggle="modal" data-bs-target="#usun">Usuń pracownika</button>
                    </div>';
                    }
                    ?>
                </div>
                <div class="col-md-8 p-3 ps-md-7 pt-md-5">
                    <div class="row my-3">
                        <div class="col-xl-4 h6">
                            Data zatrudnienia:
                        </div>
                        <div class="col-xl-8">
                            <?php echo $row["data_zatrudnienia"];?>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-xl-4 h6">
                            Stanowisko:
                        </div>
                        <div class="col-xl-8">
                            <?php echo $row["stanowisko"];?>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-xl-4 h6">
                            Pensja:
                        </div>
                        <div class="col-xl-8">
                            <?php echo $row["pensja"];?>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-xl-4 h6">
                            Data urodzenia:
                        </div>
                        <div class="col-xl-8">
                            <?php echo $row["data_urodzenia"];?>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-xl-4 h6">
                            Adres e-mail:
                        </div>
                        <div class="col-xl-8">
                            <?php echo $row["adres_email"];?>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-xl-4 h6">
                            Numer telefonu:
                        </div>
                        <div class="col-xl-8">
                            <?php echo $row["numer_telefonu"];?>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-xl-4 h6">
                            Adres zamieszkania:
                        </div>
                        <div class="col-xl-8">
                            <?php echo $row["adres_zamieszkania"];?>
                        </div>
                    </div>
                    <div class="row my-4">
                    <div class="h5">Urlopy:</div>
                    <ul class="ms-4">
                        <?php
                            $id = $row["id"];
                            $result = mysqli_query($conn, "SELECT * FROM urlopy WHERE id_pracownika = $id");
                            while($row2 = mysqli_fetch_assoc($result)) {
                                echo "<li>".$row2['od']." - ".$row2['do']."</li>";
                            }
                        ?>
                        </ul>
                    </div>
                    <div class="row my-4">
                        <div class="h5">Dokumenty:</div>
                        <ul class="ms-4">
                        <?php
                            $result = mysqli_query($conn, "SELECT * FROM dokumenty WHERE id_pracownika=$id");
                            while($row2 = mysqli_fetch_assoc($result)) {
                                echo "<li><a href='dokumenty/".$row2['nazwa_pliku']."'>".$row2['nazwa']."</a></li>";
                            }
                        ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="usun" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Usunąć pracownika?</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Czy jesteś pewien, że chcesz usunąć pracownika <b><?php echo $row["imie"].' '.$row["nazwisko"];?></b>?
                </div>
                <div class="modal-footer">
                    <form action="usun.php" method="post">
                        <input class="hide" name="login" value="<?php echo $row['login']?>">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Anuluj</button>
                        <button type="submit" class="btn bg-gradient-primary">Tak</button>
                    </form>
                </div>
                </div>
            </div>
        </div>
        <div class="navbar hide"><div class="navbar-collapse"></div></div>
        <!--   Core JS Files   -->
        <script src="material/assets/js/core/popper.min.js"></script>
        <script src="material/assets/js/core/bootstrap.min.js"></script>

        <script src="material/assets/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="material/assets/js/plugins/smooth-scrollbar.min.js"></script>
        
        <!-- Plugin for the charts, full documentation here: https://www.chartjs.org/ -->
        <script src="material/assets/js/plugins/chartjs.min.js"></script>
        <script src="material/assets/js/plugins/Chart.extension.js"></script>
        <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="material/assets/js/material-dashboard.min.js"></script>
    </body>
</html>
<?php mysqli_close($conn);?>