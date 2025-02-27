<?php include 'includes/db.php';?>
<?php include 'includes/login_check.php';?>
<?php include 'includes/admin_check.php';?>
<?php
    if(isset($_POST["user"]) && is_admin($conn)) $user = $_POST["user"];
    else $user = $_SESSION["user"];
    $result = mysqli_query($conn, "SELECT * FROM users WHERE login = '$user'");
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

        <!-- Date Range Picker -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    </head>
    <body>
        <?php include 'includes/header.php';?>
        
        <?php
            function isThatDateWorkingDay($date) {
                $time = strtotime($date);
                $dayOfWeek = (int)date('w',$time);
                $year = (int)date('Y',$time);
             
                #sprawdzenie czy to nie weekend
                if( $dayOfWeek==6 || $dayOfWeek==0 ) {
                    return false;
                }
             
                #lista swiat stalych
                $holiday=array('01-01', '01-06','05-01','05-03','08-15','11-01','11-11','12-25','12-26');
             
                #dodanie listy swiat ruchomych
                #wialkanoc
                $easter = date('m-d', easter_date( $year ));
                #poniedzialek wielkanocny
                $easterSec = date('m-d', strtotime('+1 day', strtotime( $year . '-' . $easter) ));
                #boze cialo
                $cc = date('m-d', strtotime('+60 days', strtotime( $year . '-' . $easter) ));
                #Zesłanie Ducha Świętego
                $p = date('m-d', strtotime('+49 days', strtotime( $year . '-' . $easter) ));
             
                $holiday[] = $easter;
                $holiday[] = $easterSec;
                $holiday[] = $cc;
                $holiday[] = $p;
             
                $md = date('m-d',strtotime($date));
                if(in_array($md, $holiday)) return false;
             
                return true;
            }
            if(isset($_POST['urlopuj'])) {
                $start = $_POST['start'];
                $end = $_POST['end'];
                $ok = 1;
                if($start < date("Y-m-d")) {
                    $ok = 0;
                    echo '<div class="alert alert-danger alert-dismissible fade show text-light alert-top" role="alert">
                        <span class="alert-icon align-middle">
                            <span class="material-icons text-xl mt-1">
                            error
                            </span>
                        </span>
                        <span class="alert-text"><strong>Błąd!</strong> Urlop nie może zaczynać się w przeszłości.</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                }
                $period = new DatePeriod(
                    new DateTime($start),
                    new DateInterval('P1D'),
                    new DateTime($end)
                );
                $days = 0;
                foreach ($period as $key => $value) {
                    $value = $value->format('Y-m-d');
                    if(isThatDateWorkingDay($value)) $days++;
                }
                if($days == 0) {
                    $ok=0;
                    echo '<div class="alert alert-danger alert-dismissible fade show text-light alert-top" role="alert">
                        <span class="alert-icon align-middle">
                            <span class="material-icons text-xl mt-1">
                            error
                            </span>
                        </span>
                        <span class="alert-text"><strong>Błąd!</strong> Urlop nie zawiera dni pracujących.</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                }
                $user = $_SESSION['user'];
                $wszystkie = mysqli_fetch_assoc(mysqli_query($conn, "SELECT dni_urlopu FROM users WHERE login = '$user'"))['dni_urlopu'];
                $result = mysqli_query($conn, "SELECT id FROM users WHERE login = '$user'");
                $row = mysqli_fetch_assoc($result);
                $id = $row['id'];
                $uzyte = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(dni) as suma FROM urlopy WHERE id_pracownika = $id"))['suma'];
                if($days > ($wszystkie - $uzyte)) {
                    $ok = 0;
                    echo '<div class="alert alert-danger alert-dismissible fade show text-light alert-top" role="alert">
                        <span class="alert-icon align-middle">
                            <span class="material-icons text-xl mt-1">
                            error
                            </span>
                        </span>
                        <span class="alert-text"><strong>Błąd!</strong> Przekroczono liczbę dostępnych dni urlopu.</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                }
                if($ok) {
                    $result = mysqli_query($conn, "SELECT id FROM users WHERE login = '$user'");
                    $row = mysqli_fetch_assoc($result);
                    $id = $row['id'];
                    if(mysqli_query($conn, "INSERT INTO urlopy VALUES('', $id, '$start', '$end', $days)")) {
                        echo '<div class="alert alert-success alert-dismissible fade show text-light alert-top" role="alert">
                        <span class="alert-icon align-middle">
                        <span class="material-icons text-md">
                        thumb_up_off_alt
                        </span>
                        </span>
                        <span class="alert-text"><strong>Sukces!</strong> Wzięto urlop w dniach od '.$start.' do '.$end.'.</span>
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
                        <span class="alert-text"><strong>Błąd!</strong> Wystąpił nieoczekiwany błąd.</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                    }

                }
            }
        ?>

        <h1 class="page-title">Weź urlop</h1>
        <div class="mx-auto w-75 border rounded p-4 mt-4">
            <form action="" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mt-5">Dostępne dni urlopu:
                            <?php
                                $user = $_SESSION['user'];
                                $wszystkie = mysqli_fetch_assoc(mysqli_query($conn, "SELECT dni_urlopu FROM users WHERE login = '$user'"))['dni_urlopu'];
                                $result = mysqli_query($conn, "SELECT id FROM users WHERE login = '$user'");
                                $row = mysqli_fetch_assoc($result);
                                $id = $row['id'];
                                $uzyte = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(dni) as suma FROM urlopy WHERE id_pracownika = $id"))['suma'];
                                echo ($wszystkie - $uzyte). " (wszystkich ".$wszystkie.")";
                            ?>
                        </p> 
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-static my-3">
                            <label>Okres urlopu</label>
                            <input type="text" name="daterange" class="form-control" required>
                            <input class="hide" id="start" name="start">
                            <input class="hide" id="end" name="end">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <button type="submit" name="urlopuj" class="btn btn-primary w-25 mx-auto mt-3">Weź urlop</button>
                </div>
            </form>
        </div>
        <div class="navbar hide"><div class="navbar-collapse"></div></div>

        <script>
            $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left',
                locale: {
            format: 'YYYY-MM-DD'
        }
            }, function(start, end, label) {
                document.getElementById("start").value = start.format('YYYY-MM-DD');
                document.getElementById("end").value = end.format('YYYY-MM-DD');
            });
            });
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