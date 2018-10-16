
<div class="contenitoreTab">
    <div class="tab">
        <button  class="tablinks active" >Creazione Ente</button>

    </div>
    <div class="tabcontent">

        <label>Email ente: 
            <input type="text" placeholder="Email" id="emailente" name="emailente">
        </label>
        <label class="autocomplete"> Città: 
            <input autocomplete="off" type="text" placeholder="Citta'" id="cittaente" name="cittaente">
        </label>
        <label>Password: 
            <input type="password" placeholder="Password" name="passwordente" id="passwordente">
        </label>
        <label>Conferma password: 
            <input type="password" placeholder="Conferma password" name="cpasswordente" id="cpasswordente">
        </label>
        <input class="btn-green" type="button" value="Conferma" id="btncreaente" onclick="creaente()"> 

        <p id="risultatocreaente"></p>

    </div>
</div>
<script>
    invioSubmit("emailente", "btncreaente");
    invioSubmit("cittaente", "btncreaente");
    invioSubmit("passwordente", "btncreaente");
    invioSubmit("cpasswordente", "btncreaente");
    autocomplete(document.getElementById("cittaente"), elencoComuni);
</script>