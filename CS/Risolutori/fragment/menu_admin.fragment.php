<ul class="nav navbar-nav">
    <li style="border: 0px;">
        <img src="../img/CSmini.png" style="height: 60px; width: auto">
    </li>
    <li class="nav-item <?= (basename($_SERVER['PHP_SELF']) == 'index.php') ? "attivo" : ""; ?>" style="text-align: center">
        <a class="nav-link" href="./">CREAZIONE <br> ENTE</a>
    </li>
    <li class="nav-item <?= (basename($_SERVER['PHP_SELF']) == 'vediEnti.php') ? "attivo" : ""; ?>" style="text-align: center">
        <a class="nav-link" href="./vediEnti.php">ENTI <br> CREATI</a>
    </li>
</ul>
<ul class="navbar-nav ml-auto">
    <li class="nav-item nav-right" style="text-align: center">
        <?php if (isset($_SESSION['SESS_RUOLO'])) { ?>
            <p class="nav-link">
                <?php echo USERNAME; ?><br><a href="logout.php">logout</a>
            </p>
        <?php } else { ?>
            <a class="nav-link" href="accesso.php"> ACCEDI</a>
        <?php } ?>
    </li>
</ul>
