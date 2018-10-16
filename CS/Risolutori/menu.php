<?php
if (!isset($ruolo)) {
    $ruolo = 0;
}
?>
<h1 style="color: gray">AREA RISOLUTORI</h1>
<nav class="navbar navbar-expand-xl navbar-light justify-content-center">
    <!--style="background-image:url('img/reteNeurale.jpeg')"-->
    <?php if ($ruolo != 0) { ?>
        <button class = "navbar-toggler" type = "button" data-toggle = "collapse" data-target = "#collapsibleNavbar">
            <span>MENU</span> <span class = "navbar-toggler-icon"></span>
        </button>
    <?php } ?>
    <div class="collapse navbar-collapse justify-content-center" id="collapsibleNavbar">
        
        <?php
        switch ($ruolo) {
            case 1:
                include ('fragment/menu_admin.fragment.php');
                break;
            case 2:
                include ('fragment/menu_ente.fragment.php');
                break;
            case 3:
                include ('fragment/menu_gruppo.fragment.php');
                break;
            default:
        }
        ?>
    </div>
</nav>
