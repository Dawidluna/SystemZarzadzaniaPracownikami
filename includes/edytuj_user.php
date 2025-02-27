<?php
            if(isset($_POST['edytuj2'])) {
                $email = $_POST["email"];
                $numer_telefonu = $_POST["numer_telefonu"];
                $adres = $_POST["adres"];
                $login = $_POST["login"];
                    $target_file = basename($_FILES["fileToUpload"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    if($target_file) {
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
                            mysqli_query($conn, "UPDATE users SET zdjecie='$newfilename' WHERE `login` = '$login'") or die("Błąd");
                        mysqli_query($conn, "UPDATE users SET adres_email = '$email', numer_telefonu = '$numer_telefonu', adres_zamieszkania = '$adres' WHERE `login` = '$login'");
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
                    header("Location: index.php");
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
                    
                    } else {
                        if(mysqli_query($conn, "UPDATE users SET adres_email = '$email', numer_telefonu = '$numer_telefonu', adres_zamieszkania = '$adres' WHERE `login` = '$login'")) {
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
                        }
                    }
                }
                ?>
                <div class="mx-auto w-75 border rounded p-4 mt-4">
            <form action="" method="post" enctype="multipart/form-data">
                <input class="hide" name="login" value="<?php echo $row['login'];?>">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-static my-3">
                            <label>Adres e-mail</label>
                            <input type="email" class="form-control" name="email" value="<?php echo $row['adres_email'];?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-static my-3">
                            <label>Numer telefonu</label>
                            <input type="tel" class="form-control" name="numer_telefonu" value="<?php echo $row['numer_telefonu'];?>" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-static my-3">
                            <label>Adres zamieszkania</label>
                            <input type="text" class="form-control" name="adres" value="<?php echo $row['adres_zamieszkania'];?>" required>
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
                    <button type="submit" name="edytuj2" class="btn btn-primary w-25 mx-auto mt-3">Edytuj</button>
                </div>
            </form>
        </div>