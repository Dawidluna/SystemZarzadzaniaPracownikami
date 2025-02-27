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

        <?php
            if(isset($_POST['dodaj'])) {
                $login = $_POST["login"];
                $haslo = $_POST["haslo"];
                $imie = $_POST["imie"];
                $nazwisko = $_POST["nazwisko"];
                $pensja = $_POST["pensja"];
                $stanowisko = $_POST["stanowisko"];
                $data_zatrudnienia = $_POST["data_zatrudnienia"];
                $data_urodzenia = $_POST["data_urodzenia"];
                $email = $_POST["email"];
                $numer_telefonu = $_POST["numer_telefonu"];
                $adres = $_POST["adres"];
                $urlop = $_POST["urlop"];
                $admin = $_POST["admin"];
                $md5haslo = md5($haslo);
                



                $login_query = mysqli_query($conn, "SELECT * from users WHERE login = '$login'");
                if(mysqli_num_rows($login_query) > 0) {
                    echo '<div class="alert alert-danger alert-dismissible fade show text-light alert-top" role="alert">
                    <span class="alert-icon align-middle">
                        <span class="material-icons text-xl mt-1">
                        error
                        </span>
                    </span>
                    <span class="alert-text"><strong>Błąd!</strong> Użytkownik z podanym loginem już istnieje.</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
                } else {
                    $target_file = basename($_FILES["fileToUpload"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                    // Check if image file is a actual image or fake image
                    if(isset($_POST["submit"])) {
                    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                    if($check !== false) {
                        $uploadOk = 1;
                    } else {
                        echo '<div class="alert alert-danger alert-dismissible fade show text-light alert-top" role="alert">
                    <span class="alert-icon align-middle">
                        <span class="material-icons text-xl mt-1">
                        error
                        </span>
                    </span>
                    <span class="alert-text"><strong>Błąd!</strong> Plik nie jest zdjęciem.</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
                        $uploadOk = 0;
                    }
                    }

                    // Check file size
                    if ($_FILES["fileToUpload"]["size"] > 500000) {
                        echo '<div class="alert alert-danger alert-dismissible fade show text-light alert-top" role="alert">
                        <span class="alert-icon align-middle">
                            <span class="material-icons text-xl mt-1">
                            error
                            </span>
                        </span>
                        <span class="alert-text"><strong>Błąd!</strong> Maksymalny rozmiar pliku wynosi 500KB</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                    $uploadOk = 0;
                    }

                    // Allow certain file formats
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                        echo '<div class="alert alert-danger alert-dismissible fade show text-light alert-top" role="alert">
                        <span class="alert-icon align-middle">
                            <span class="material-icons text-xl mt-1">
                            error
                            </span>
                        </span>
                        <span class="alert-text"><strong>Błąd!</strong> Nieprawidłowy typ pliku. Wybierz plik JPG, JPEG lub PNG.</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                    $uploadOk = 0;
                    }

                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk != 0) {
                        $temp = explode(".", $_FILES["fileToUpload"]["name"]);
                        $newfilename = round(microtime(true)) . '.' . end($temp);
                        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "img/" . $newfilename)) {
                            mysqli_query($conn, "INSERT INTO users VALUES('', '$login', '$md5haslo', '$imie', '$nazwisko', '$stanowisko', '$pensja', '$newfilename', '$data_zatrudnienia', '$data_urodzenia', '$email', '$numer_telefonu', '$adres', '$admin', $urlop)") or die("Błąd");
                        echo '<div class="alert alert-success alert-dismissible fade show text-light alert-top" role="alert">
                        <span class="alert-icon align-middle">
                        <span class="material-icons text-md">
                        thumb_up_off_alt
                        </span>
                        </span>
                        <span class="alert-text"><strong>Sukces!</strong> Dodano pracownika pomyślnie</span>
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
                        <span class="alert-text"><strong>Błąd!</strong> Błąd przesyłania zdjęcia</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                        }
                    }
                    
                }
            }
        ?>

        <h1 class="page-title">Dodaj pracownika</h1>
        <div class="mx-auto w-75 border rounded p-4 mt-4">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Imię</label>
                            <input type="text" class="form-control" name="imie" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Nazwisko</label>
                            <input type="text" class="form-control" name="nazwisko" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Stanowisko</label>
                            <input type="text" class="form-control" name="stanowisko" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Pensja</label>
                            <input type="number" step="0.01" min="0" class="form-control" name="pensja" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-static my-3">
                            <label>Data zatrudnienia</label>
                            <input type="date" class="form-control" name="data_zatrudnienia" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-static my-3">
                            <label>Data urodzenia</label>
                            <input type="date" class="form-control" name="data_urodzenia" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Adres e-mail</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Numer telefonu</label>
                            <input type="tel" class="form-control" name="numer_telefonu" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Adres zamieszkania</label>
                            <input type="text" class="form-control" name="adres" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-static">
                            <label for="exampleFormControlSelect1" class="ms-0">Typ konta</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="admin">
                                <option value="0">Użytkownik</option>
                                <option value="1">Administrator</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Login</label>
                            <input type="text" class="form-control" name="login" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Hasło</label>
                            <input type="password" class="form-control" name="haslo" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <div class="input-group input-group-static my-3">
                            <label>Dni urlopu rocznie</label>
                            <input type="number" step="1" min="0" class="form-control" value="<?php echo $row['dni_urlopu'];?>" name="urlop" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group form-file-upload form-file-simple">
                <input type="text" class="form-control inputFileVisible" placeholder="Zdjęcie">
                    <input type="file" name="fileToUpload" id="fileToUpload" class="inputFileHidden">
                    </div>
                    </div>   
                </div>
                <div class="row">
                    <button type="submit" name="dodaj" class="btn btn-primary w-25 mx-auto mt-3">Dodaj</button>
                </div>
            </form>
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