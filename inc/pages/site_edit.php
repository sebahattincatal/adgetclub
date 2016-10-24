<?php if (!defined("idokey")) {
    exit();
} ?>

<?php

    $id = (int)$_GET["id"];

    if (empty($id)) {
        header("Location:index.php");
    }

    $user_type = $_SESSION["user_type"];

    if ($user_type < 1) {
        header("Location:index.php");
    }


    if ($_POST) {


        /*$telefon = filler($_POST["telefon"]);
        $siparis["mail"] = tts($_POST["mail"]);
        $siparis["telefon"] = tts($_POST["telefon"]);
        $siparis["name_surname"] = tts($_POST["name_surname"]);
        $siparis["user_type"] = tts($_POST["user_type"]);
        $siparis["login_case"] = tts($_POST["login_case"]);
        $siparis["sip_type"] = tts($_POST["sip_type"]);
        $siparis["agent"] = tts($_POST["agent"]);
        $siparis["extra_yetki"] = implode(",", $_POST["ozel_yetki"]);*/

        $site['kaynak_adres'] = tts($_POST["kaynak_adres"]);
        $site['kaynak_isim'] = tts($_POST["kaynak_isim"]);

        $where = "id='" . $id . "'";

        $degistir = update_array("kaynak", $site, $where);

        if ($degistir) {
            alert_yes("İşleminiz Başarılı");
        } else {
            alert_no("işleminiz Başarısız.");
        }

    }


    $row = $db->get_row("SELECT * FROM kaynak where id = '" . $id . "' ");


    if (!$row) {
        header("Location:index.php");
    }
    ?>


<div class="contentpanel">

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-btns">
                <a href="" class="panel-close">&times;</a>
                <a href="" class="minimize">&minus;</a>
            </div>
            <h4 class="panel-title">Site İşlemi</h4>

            <p>Site Detayları aşağıdaki gibidir</p>


        </div>
        <div class="panel-body panel-body-nopadding">

            <form class="form-horizontal form-bordered" method="post">

                <div class="form-group">
                    <label class="col-sm-3 control-label">Site Adres</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="http://akhbartr.com/" name="kaynak_adres"
                               value="<?= $row->kaynak_adres ?>" required class="form-control"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Site Ad</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="akhbartr.com" name="kaynak_isim"
                               value="<?= $row->kaynak_isim ?>" required class="form-control"/>
                    </div>
                </div>

        </div>
        <!-- panel-body -->

        <div class="panel-footer">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">


                    <button type="submit" class="btn btn-primary">Bitir</button>
                    &nbsp;


                </div>
            </div>
        </div>
        <!-- panel-footer -->
        </form>
    </div>
    <!-- panel -->


</div><!-- contentpanel -->


<script type="text/javascript">

    $("#siparis_durumu")
        .change(function () {
            var str = "";
            $("select option:selected").each(function () {
                str += $(this).text() + " ";
            });
            $("div").text(str);
        })
        .change();


</script>