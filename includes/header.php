<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Nazwa strony</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon material-icons">menu</span>
    </button>
    <div class="collapse navbar-collapse flex-row-reverse" id="navbarNav">
      <ul class="navbar-nav">
        <?php
        if(is_admin($conn)) {
        echo '<li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Pracownicy</a>
        </li>';
        }
        ?>
        <li class="nav-item">
          <a class="nav-link" href="urlopy.php">Urlopy</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="wiadomosci.php">Wiadomości</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Moje konto
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item d-flex" href="profil.php"><i class="material-icons"><span class="material-symbols-outlined">
account_circle
</span></i>Zobacz profil</a></li>
            <li><a class="dropdown-item d-flex" href="./logout.php"><i class="material-icons">logout</i>Wyloguj się</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>