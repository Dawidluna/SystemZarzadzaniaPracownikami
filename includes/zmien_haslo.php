<?php
    if(isset($_POST['zmien'])) {
        $ok = 1;
        if(md5($_POST['stare'])!=$row['haslo']) {
            $ok = 0;
            echo '<div class="alert alert-danger alert-dismissible fade show text-light alert-top" role="alert">
                    <span class="alert-icon align-middle">
                        <span class="material-icons text-xl mt-1">
                        error
                        </span>
                    </span>
                    <span class="alert-text"><strong>Błąd!</strong> Wprowadzono nieprawidłowe stare hasło.</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        }
        if($_POST['nowe']!=$_POST['nowe2']) {
            $ok = 0;
            echo '<div class="alert alert-danger alert-dismissible fade show text-light alert-top" role="alert">
                    <span class="alert-icon align-middle">
                        <span class="material-icons text-xl mt-1">
                        error
                        </span>
                    </span>
                    <span class="alert-text"><strong>Błąd!</strong> Wprowadzone hasła się nie zgadzają.</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        }
        if($ok) {
            $nowemd5 = md5($_POST['nowe']);
            $login = $_POST['login'];
            mysqli_query($conn, "UPDATE users SET haslo = '$nowemd5' WHERE `login` = '$login'");
            echo '<div class="alert alert-success alert-dismissible fade show text-light alert-top" role="alert">
                        <span class="alert-icon align-middle">
                        <span class="material-icons text-md">
                        thumb_up_off_alt
                        </span>
                        </span>
                        <span class="alert-text"><strong>Sukces!</strong> Zmieniono hasło pomyślnie.</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
        }
    }
?>
        <h2 class="text-center mt-4">Zmień hasło</h2>
        <div class="mx-auto w-75 border rounded p-4 mt-4">
            <form action="" method="post" enctype="multipart/form-data">
                <input class="hide" name="login" value="<?php echo $row['login'];?>">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-static my-3">
                            <label>Stare hasło</label>
                            <input type="password" class="form-control" name="stare" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-static my-3">
                            <label>Nowe hasło</label>
                            <input type="password" class="form-control" name="nowe" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-static my-3">
                            <label>Potwierdź nowe hasło</label>
                            <input type="password" class="form-control" name="nowe2" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <button type="submit" name="zmien" class="btn btn-primary w-25 mx-auto mt-3">Edytuj</button>
                </div>
            </form>
        </div>