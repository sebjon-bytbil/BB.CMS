<?php
if (function_exists('bytbil_init_assortment')) {
    bytbil_init_assortment($assortment_alias, $assortment_string, $assortment_page, false, $assortment_id);
    bytbil_show_assortment($assortment_id);
}
?>




<div class="bb-accesspackage">
    <section class="white-bg align-center">
        <div class="container-fluid wrapper align-center">
            <div class="col-xs-12">
                <h2>Sök bland 235 olika fordon</h2>
                <p class="bigger-text">Letar du efter din nästa drömbil? Sök och hitta den bland våra lagerbilar!</p>
            </div>
            <div class="wrapper-960">
                <div class="row">
                    <div class="col-xs-12 col-sm-4">
                        <label class="selectpicker-label">Vad för bil?</label>
                        <select class="selectpicker">
                            <option>Nya och begagnade</option>
                            <option>Endast nya</option>
                            <option>Endast begagnade</option>
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <label class="selectpicker-label">Vilket märke?</label>
                        <select class="selectpicker">
                            <option>Alla märken</option>
                            <option>Volvo</option>
                            <option>Renault</option>
                            <option>Dacia</option>
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <label class="selectpicker-label">Vilken modell?</label>
                        <select class="selectpicker">
                            <option>Alla modeller</option>
                        </select>
                    </div>
                    <div class="col-xs-12">
                        <input type="submit" class="btn btn-blue big" value="Sök och hitta">
                        <br>
                        <a href="#" class="caps grey-text smaller-text">Visa fler sökalternativ</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>