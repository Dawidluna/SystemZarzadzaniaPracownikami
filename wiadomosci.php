<?php 
    include 'includes/db.php';
    include 'includes/login_check.php';
    include 'includes/admin_check.php';
    
    if(isset($_POST['selectUser'])) {
        setcookie('odbiorca', $_POST['odbiorca'], time() + 3600);
        header("Refresh:0");
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

        <h1 class="page-title">Wiadomości</h1>
        <div class="mx-auto w-75 border rounded p-4 mt-4">
            <div class="row">
                <div class="col-lg-4">
                <?php
                    $currentUser = $_SESSION['user'];
                    $result = mysqli_query($conn, "SELECT * FROM users WHERE login != '$currentUser'");
                    while($row = mysqli_fetch_array($result)) {
                        if(!isset($_COOKIE['odbiorca'])) {
                            setcookie('odbiorca', $row['id'], time() + 3600);
                            header("Refresh:0");
                        }
                        $wybrana = "";
                        if($row['id'] == $_COOKIE['odbiorca']) $wybrana = " wybrana";
                        echo "<div>
                            <form action='' method='post'>
                            <input class='hide' name='odbiorca' value='".$row['id']."'>
                            <button type='submit' name='selectUser' class='selectUser".$wybrana."'>
                            <img src='img/".$row['zdjecie']."' class='avatar me-3'>
                            ".$row['imie']." ".$row['nazwisko']."
                            </button>
                            </form>
                        </div>";
                    }
                ?>
                </div>
                <?php
                    if(isset($_POST['wyslij'])) {
                        $tresc = $_POST['wiadomosc'];
                        $odb = $_COOKIE['odbiorca'];
                        $user = $_SESSION['user'];
                        $result = mysqli_query($conn, "SELECT id FROM users WHERE login = '$user'");
                        $row = mysqli_fetch_assoc($result);
                        $nadawca = $row['id'];
                        mysqli_query($conn, "INSERT INTO wiadomosci VALUES('', $nadawca, $odb, '$tresc', NOW())");
                    }
                ?>
                <div class="col-lg-8 chatbox">
                    <form action="" method="post">
                        <textarea class="mt-2 w-75 trescW" name="wiadomosc" rows="1" onKeyUp="SetNewSize(this);" placeholder="Treść wiadomości"></textarea>
                        <button type="submit" name="wyslij" class="btn btn-info wyslijW">Wyślij</button>
                    </form>
                    <?php
                        $user = $_SESSION['user'];
                        $result = mysqli_query($conn, "SELECT id FROM users WHERE login = '$user'");
                        $row = mysqli_fetch_assoc($result);
                        $obecny = $row['id'];
                        $drugi = $_COOKIE['odbiorca'];
                        $result = mysqli_query($conn, "SELECT * FROM wiadomosci WHERE (id_nadawcy = $obecny AND id_odbiorcy = $drugi) OR (id_nadawcy = $drugi AND id_odbiorcy = $obecny) ORDER BY data DESC");
                        while($row = mysqli_fetch_assoc($result)) {
                            $nadawca = $row['id_nadawcy'];
                            $result2 = mysqli_query($conn, "SELECT imie, nazwisko FROM users WHERE id = $nadawca");
                            $row2 = mysqli_fetch_assoc($result2);
                            $nadawca = $row2['imie']." ".$row2['nazwisko'];
                            echo "<b>".$nadawca."</b> ".$row['tresc']." <span class='data'>".$row['data']."</span><br>";
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="navbar hide"><div class="navbar-collapse"></div></div>

        <script>
            function SetNewSize(textarea) {
                textarea.style.height = "0px";
                textarea.style.height = textarea.scrollHeight + "px";
            }
        </script>

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