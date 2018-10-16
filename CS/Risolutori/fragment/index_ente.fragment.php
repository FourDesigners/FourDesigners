<h3 class="mb-3 mt-3">SEGNALAZIONI</h3>
<div class="contTabella mb-0">
    <table class="mb-3" border='0'>
        <tr>
            <td>Titolo</td>
            <td>Dal giorno</td>
            <td>Priorità</td>
            <td>Stato</td>
            <td>Tipologia</td>
        </tr>

        <tr>
            <td><input type="text" id="titolo" value="" onkeyup="ricerca()"></td>
            <td><input type="date" id="dataInizio" onkeyup="ricerca()"></td>
            <td><select id="priorita" onchange="ricerca()">
                    <option value="null" selected>Tutto</option>
                    <option value="Bassa">Bassa</option>
                    <option value="Media">Media</option>
                    <option value="Alta">Alta</option>
                </select></td>
            <td><select id="stato" onchange="ricerca()">
                    <option value="null" selected>Tutto</option>
                    <option value="Discarded">Discarded</option>
                    <option value="Pending">Pending</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Solved">Solved</option>
                    <option value="Closed">Closed</option>
                </select></td>
            <td><select id="tipologia" onchange="ricerca()">
                    <option value="null">Tutto</option>
                    <option value="Acqua">Acqua</option>
                    <option value="Luce">Luce</option>
                    <option value="Spazzatura">Spazzatura</option>
                    <option value="Urbano">Urbano</option>
                    <option value="Altro" selected>Altro (Da assegnare)</option>
                </select></td>
        </tr>
    </table>
</div>
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
<script>ricerca();</script>