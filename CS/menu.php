<nav class="navbar navbar-expand-xl navbar-light justify-content-center"> <!--style="background-image:url('img/reteNeurale.jpeg')"-->

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span>MENU</span>
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center" id="collapsibleNavbar">
        <ul class="nav navbar-nav">
            <li style="border: 0px;">
                <img src="img/CSmini.png" style="height: 60px; width: auto">
            </li>
            <li id="civicSense" class="nav-item" style="text-align: center">
                <a class="nav-link" href="civicSense.php">COS'E'<br>CIVIC SENSE?</a>
            </li>
            <li id="segnala" class="nav-item" >
                <a class="nav-link" href="segnala.php">SEGNALA!</a>
            </li>
            <li id="cerca" class="nav-item" style="text-align: center">
                <a class="nav-link" href="ricercaSegnalazione.php">CERCA<br>SEGNALAZIONI</a>
            </li>
            <li id="segSeguite" class="nav-item" style="text-align: center">
                <a class="nav-link" href="segnalazioniSeguite.php">SEGNALAZIONI<br>SEGUITE</a>
            </li>
            <li id="statistiche" class="nav-item nav-right" style="text-align: center">
                <a class="nav-link" href="statistiche.php"> STATISTICHE</a>
            </li>

        </ul>
        <ul class="nav navbar-nav ml-auto">
            <?php if ($aut) { ?>
                <li  class="nav-item nav-right user" style="text-align: center">
                    <p class="nav-link">utente:<br><?php echo USERNAME; ?><a href="php/logout.php">(logout)</a></p>
                    <p id="userS" style="display:none"><?php echo USERNAME; ?></p>
                <li id="accedi" class="nav-item nav-right accedi">
                    <a class="nav-link" href="accesso.php"> MODIFICA<br>PASSWORD</a>
                </li>
            <?php } else {
                ?>
                <li id="accedi" class="nav-item nav-right" style="text-align: center">
                    <a class="nav-link" href="accesso.php"> ACCEDI</a>
                </li>

            <?php } ?>
            <li class="nav-item nav-right" style="text-align: center">
                <a class="nav-link" href="Risolutori/index.php"> AREA<br>RISOLUTORI</a>
            </li>
        </ul>

    </div>  
</nav>
