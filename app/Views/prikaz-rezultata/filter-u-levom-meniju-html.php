//**Jovana Jankovic 0586/17 - Staticki deo stranice koji se pojavljuje u levom meniju za pretragu */
//Ovo ce se u daljoj verziji generisati kroz php 

        <form name='ukus'>
            <table class='tabela' cellpadding='7'>
                <th class='naslov'>Ukus</th>
                <tr>
                    <td><input type='checkbox' name='slatko'>Slatko</td>
                </tr>
                <tr>
                    <td><input type='checkbox' name='slano'>Slano</td>
                </tr>
                <tr>
                    <td><input type='checkbox' name='ljuto'>Ljuto</td>
                </tr>
            </table>
        </form>
        <hr>
        <form name='dijetalni_zahtevi'>
            <table class='tabela' cellpadding='7'>
                <th class='naslov'>Dijetalni zahtevi</th>
                <tr>
                    <td><input type='checkbox' name='posno'>Posno</td>
                </tr>
                <tr>
                    <td><input type='checkbox' name='vegetarijansko'>Vegetarijansko</td>
                </tr>
                <tr>
                    <td><input type='checkbox' name='bez_glutena'>Bez glutena</td>
                </tr>
            </table>
        </form>
        <hr>
        <div class='container'>
        <div class='row'>
            <div class='col-sm-2'>
                 <img src=<?php echo '"'.base_url("assets/icons/sortiraj_rastuce.png").'"'; ?> alt="sortiraj_rasutce" width='25px'>
            </div>
            <div class='col-sm-2'>
                 <img src=<?php echo '"'.base_url("assets/icons/sortiraj_opadajuce.png").'"'; ?> alt="sortiraj_opadajuce" width='25px'>
            </div>
                 <div class='col-sm-2'> 
                      <img src=<?php echo '"'.base_url("assets/icons/sortiraj_alfabetski.png").'"'; ?> alt="sortiraj_alfabetski" width='25px'>
                 </div>
            <div class='col-sm-2'>
                 <img src=<?php echo '"'.base_url("assets/icons/sortiraj_cena.png").'"'; ?> alt="sortiraj_cena" width='25px'>
               </div>
            <div class='col-sm-4'>
               <img src=<?php echo '"'.base_url("assets/icons/sortiraj_favorite.png").'"'; ?> alt="sortiraj_favorite" width='25px'>  
            </div>
        </div>
        </div> 
        <hr>
        <div class="basket">
            <table id="basket"></table>
        </div>
        <hr>

        <div class='container'>
        <div class='row'>
            <div class='col-sm-12'>
                <form>
                <table class='text-center' cellpadding='5'>
                    <tr >
                        <td class='text-left'>
                            <input type='text' name='naziv_porudzbine' placeholder="Naziv porudzbine(opciono)"/>
                        </td>
                    </tr>
                    <tr>
                        <td class='text-left'>
                            <input type='text' size='6' style="margin-left: 0;" placeholder="Broj osoba"> 
                            <select style="min-height: 30px;">
                                <option>Povod</option>
                                <option>Rodjendan</option>
                                <option>Krstenje</option>
                                <option>Svadba</option>
                                <option>Zurka</option>
                                <option>Diplomski</option>
                                </select>
                        </td>
                    </tr>
                    <tr>
                        <td class='text-left'>
                            <input type='date' style="font-size: 11px;">
                            <input type='time'  style="font-size: 11px;">
                        </td>
                    </tr>
                    <tr>
                        <td class='text-left'>
                            <button type='submit' name='potvrdi' class='btn btn-danger' >Potvrdi</button>
                            <button type='submit' name='odustani' class='btn btn-light btn-sm'>Odustani</button>
                        </td>
                    </tr>
                    

                </table>
            </form>
            <br>
            <br>
            <br>
            </div>
        </div>
    </div>