<ul class="nav navbar-nav">
    <li style="border: 0px;">
        <img src="../img/CSmini.png" style="height: 60px; width: auto">
    </li>
    <li class="nav-item <?= (basename($_SERVER['PHP_SELF']) == 'index.php') ? "attivo" : ""; ?>" style="text-align: center">
        <a class="nav-link" href="./">ELENCO SEGNALAZIONI</a>
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
        <li class="nav-item nav-right <?= (basename($_SERVER['PHP_SELF']) == 'modificapwd.php') ? "attivo" : ""; ?>" style="text-align: center">
            <a class="nav-link" href="modificapwd.php"> MODIFICA<br>PASSWORD</a>
        </li>
    <?php } else { ?>
        <li class="nav-item nav-right" style="text-align: center">
            <a class="nav-link" href="accesso.php"> ACCEDI</a>
        </li>
    <?php } ?>
</ul>
