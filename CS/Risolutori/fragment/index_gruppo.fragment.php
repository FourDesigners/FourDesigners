<table class="mt-4 mb-4" border='0'>
    <tr>
        <td>Titolo</td>
        <td>Dal giorno</td>
        <td>Priorità</td>
        <td>Stato</td>
    </tr>

    <tr>
        <td><input type="text" id="titolo" value="" onkeyup="ricercaGruppo()"></td>
        <td><input type="date" id="dataInizio" onkeyup="ricercaGruppo()"></td>
        <td><select id="priorita" onchange="ricercaGruppo()">
                <option value="null" selected>Tutto</option>
                <option value="Bassa">Bassa</option>
                <option value="Media">Media</option>
                <option value="Alta">Alta</option>
            </select></td>
        <td><select id="stato" onchange="ricercaGruppo()">
                <option value="null" selected>Tutto</option>
                <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Solved">Solved</option>
                <option value="Closed">Closed</option>
            </select></td>
    </tr>
</table>
<div class="contTabella mb-0" >
    <table id="tabella">                
        <thead>
            <tr>
                <td>Id</td><td>Data Segnalazione</td><td>Data chiusura</td><td>Titolo</td><td>Indirizzo</td><td>Priorità</td><td>Stato</td><td>Tipologia</td><td>Commento</td><td></td>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

</div>
<p id="demo"></p>
<script>ricercaGruppo();</script>