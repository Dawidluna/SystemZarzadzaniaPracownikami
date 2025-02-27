<?php include 'includes/db.php';?>
<?php include 'includes/login_check.php';?>
<?php include 'includes/admin_check.php';?>
<?php 
    if(isset($_POST['edytuj'])) {
        setcookie('userprofile', $_POST['user'], time() + 3600);
        header("Refresh:0");
    }
    $user = $_COOKIE['userprofile'];
    $result = mysqli_query($conn, "SELECT * FROM users WHERE `login` = '$user'");
    $row = mysqli_fetch_assoc($result);
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

        <?php
            
            if(isset($_POST['dodaj'])) {
                $nazwa = $_POST['nazwa'];
                $id = $_POST['id'];
                $target_file = basename($_FILES["dokument"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    if($target_file) {
                     $temp = explode(".", $_FILES["dokument"]["name"]);
                    $newfilename = round(microtime(true)) . '.' . end($temp);
                    if (move_uploaded_file($_FILES["dokument"]["tmp_name"], "dokumenty/" . $newfilename)) {
                        mysqli_query($conn, "INSERT INTO dokumenty VALUES('', $id, '$nazwa', '$newfilename')") or die("Błąd");
                        echo '<div class="alert alert-success alert-dismissible fade show text-light alert-top" role="alert">
                        <span class="alert-icon align-middle">
                        <span class="material-icons text-md">
                        thumb_up_off_alt
                        </span>
                        </span>
                        <span class="alert-text"><strong>Sukces!</strong> Dodawanie dokumentu zakończone pomyślnie.</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                    header("Location: index.php");
                        } else {
                            echo '<div class="alert alert-danger alert-dismissible fade show text-light alert-top" role="alert">
                        <span class="alert-icon align-middle">
                            <span class="material-icons text-xl mt-1">
                            error
                            </span>
                        </span>
                        <span class="alert-text"><strong>Błąd!</strong> Błąd przesyłania dokumentu</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                        }
                    
                    } else {
                        if(mysqli_query($conn, "UPDATE users SET imie = '$imie', nazwisko = '$nazwisko', pensja = '$pensja', data_zatrudnienia = '$data_zatrudnienia', data_urodzenia = '$data_urodzenia', adres_email = '$email', numer_telefonu = '$numer_telefonu', adres_zamieszkania = '$adres', czy_admin = '$admin' WHERE `login` = '$login'")) {
                            echo '<div class="alert alert-success alert-dismissible fade show text-light alert-top" role="alert">
                        <span class="alert-icon align-middle">
                        <span class="material-icons text-md">
                        thumb_up_off_alt
                        </span>
                        </span>
                        <span class="alert-text"><strong>Sukces!</strong> Edycja zakończona pomyślnie.</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                        } else {
                            echo '<div class="alert alert-danger alert-dismissible fade show text-light alert-top" role="alert">
                        <span class="alert-icon align-middle">
                            <span class="material-icons text-xl mt-1">
                            error
                            </span>
                        </span>
                        <span class="alert-text"><strong>Błąd!</strong> Błąd edycji danych pracownika</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                    header("Location: index.php");
                        }
                    }
                }
        ?>
        <h1 class="page-title">Edytuj profil</h1>
        <?php if(is_admin($conn)) include 'includes/edytuj_admin.php';
        else include 'includes/edytuj_user.php';?>
        <h2 class="text-center mt-4">Dodaj dokument</h2>
        <div class="mx-auto w-75 border rounded p-4 mt-4">
            <form action="" method="post" enctype="multipart/form-data">
                <input class="hide" name="id" value="<?php echo $row['id'];?>">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-static my-3">
                            <label>Nazwa dokumentu</label>
                            <input type="text" class="form-control" name="nazwa" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="custom-file mt-5">
                        <input type="file" class="custom-file-input" name="dokument" id="validatedCustomFile" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <button type="submit" name="dodaj" class="btn btn-primary w-25 mx-auto mt-3">Dodaj</button>
                </div>
            </form>
        </div>
        <?php if($user == $_SESSION['user']) include 'includes/zmien_haslo.php'?>
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