<?php
$actualPage = basename($_SERVER['PHP_SELF']);
$active = "attivo";
?>
<ul class="nav navbar-nav">
    <li style="border: 0px;">
        <img src="../img/CSmini.png" style="height: 60px; width: auto">
    </li>
    <li class="nav-item <?= ($actualPage == 'index.php') ? $active : ""; ?>" style="text-align: center">
        <a class="nav-link" href="./">SEGNALAZIONI</a>
    </li>
    <li class="nav-item <?= ($actualPage == 'vediGruppi.php') ? $active : ""; ?>">
        <a class="nav-link" href="vediGruppi.php">GRUPPI<br>ASSOCIATI</a>
    </li>	
    <li class="nav-item <?= ($actualPage == 'creaGruppo.php') ? $active : ""; ?>">
        <a class="nav-link" href="creaGruppo.php">CREA<br>GRUPPO</a>
    </li>
    <li class="nav-item <?= ($actualPage == 'statisticheEnte.php') ? $active : ""; ?>">
        <a class="nav-link" href="statisticheEnte.php">STATISTICHE</a>
    </li>
    <li class="nav-item <?= ($actualPage == 'vediInformazioni.php') ? $active : ""; ?>">
        <a class="nav-link" href="vediInformazioni.php">IL MIO PROFILO</a>
    </li>
</ul>
<ul class="navbar-nav ml-auto">
    <?php if (isset($_SESSION['SESS_RUOLO'])) { ?>
        <li class="nav-item nav-right" style="text-align: center">
            <p class="nav-link">
                <?php echo USERNAME; ?><br><a href="logout.php">logout</a>
            </p>
        </li>
        <p id="userS" style="display: none"><?php echo USERNAME; ?></p>

        <li class="nav-item nav-right <?= ($actualPage == 'modificapwd.php') ? $active : ""; ?>" style="text-align: center">
            <a class="nav-link" href="modificapwd.php"> MODIFICA<br>PASSWORD</a>
        </li>
    <?php } else { ?>
        <li class="nav-item nav-right" style="text-align: center">
            <a class="nav-link" href="accesso.php"> ACCEDI</a>
        </li>
    <?php } ?>
</ul>
