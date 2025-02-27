<?php
    function is_admin($conn) {
        $zalogowany = $_SESSION["user"];
        $result = mysqli_query($conn, "SELECT czy_admin FROM users WHERE login = '$zalogowany'");
        $row = mysqli_fetch_assoc($result);
        return $row['czy_admin'];
    }
?>