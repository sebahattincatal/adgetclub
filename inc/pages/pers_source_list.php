<?php if (!defined("idokey")) { exit(); }?>

<?php

    /*
     * author: @sebahattincatal
     * website: www.sebahattincatal.com
     * email: sebahattin.catal@yandex.com
     */

    if($_POST)
    {
      $start = str_replace("/", "-", $_POST["start"]); 
      $stop  = str_replace("/", "-", $_POST["stop"]); 

      if(empty($start)){$start = date("Y-m-d"); }
      if(empty($stop)){$stop   = date("Y-m-d"); }

    } else {
      $start = date("Y-m-d");
      $stop = date("Y-m-d");
    }

    $start_data = date("Y-m-d", strtotime($start));
    $stop_data =date("Y-m-d", strtotime($stop));

    $p1 = str_replace("-","/",date("d-m-Y", strtotime($start_data)));
    $p2 = str_replace("-","/",date("d-m-Y", strtotime($stop_data))); 
?>

<div class="col-md-12">
  <div class="panel panel-default">
    <div class="panel-heading">
      <div class="panel-btns">
        <a href="" class="panel-close">&times;</a>
        <a href="" class="minimize">&minus;</a>
      </div>
      <h4 class="panel-title">Tarih </h4>
    </div>
    <div class="panel-body">
    <form action="" method="post">
   
      
      <div class="input-group col-md-4" style="float:left; width:200px; ">
        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
        <input type="text" name="start" value="<?=$p1?>" placeholder="Başlangıç" id="date" class="form-control date" />
      </div>

      <div class="input-group col-md-4" style="float:left; margin-left:20px; width:200px;">
        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
        <input type="text" name="stop" value="<?=$p2?>" placeholder="Bitiş" id="date" class="form-control date" />
      </div>

        <div class="input-group col-md-4" style="float:left; margin-left:20px; width:200px;"> 
      <input type="submit" class="btn btn-info"></div>
    </form>  
                  
    </div>
  </div><!-- panel -->
</div><!-- col-md-6 -->

<div class="panel panel-default">
        <div class="panel-heading">
          <div class="panel-btns">
            <a href="" class="panel-close">&times;</a>
            <a href="" class="minimize">&minus;</a>
          </div><!-- panel-btns -->
          <h3 class="panel-title">Kaynak Satış Rapor</h3>
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table" id="table1">
              <thead>
                 <tr>
                    <th>Kaynak</th>
                    <th>Yeni</th>
                    <th>Satış</th>
                    <th>İptal</th>
                    <th>ulaşılamayan</th>
                    <th>İleri Tarihli</th>
                    <th>Geçersiz</th>
                    <th>Ürün Adeti</th>
                    <th>Sepet Ort.Adet</th>
                    <th>Sepet Ort.ciro</th>
                   <th>Ciro</th>
                   <th>Toplam</th>
                    <th>İşlem</th>
                 </tr>
              </thead>
              <tbody>

              <?php

                  // Geri Dönen, Onaylanan, Sonuçlanan Siparişler
                  $order_case = "(siparis_durumu = 6 OR siparis_durumu = 7 OR siparis_durumu = 8)";

                  // Yeni Siparişler
                  $new_order_case = "(siparis_durumu = 1)";

                  // Ulaşılamayan
                  $unreachable_order_case = "(siparis_durumu = 2)";

                  // İleri Tarihte Ara
                  $nextcall_order_case = "(siparis_durumu = 3)";

                  // Geçersiz
                  $invalid_order_case = "(siparis_durumu = 4)";

                  // iptal
                  $cancel_order_case = "(siparis_durumu = 5)";

                  $e = $db->get_results("SELECT * FROM kaynak");
                  

                  $Toplam = array();
                  foreach ($e as  $value) {

                  $ex = $db->get_results("SELECT DISTINCT siparis_id,  stop_case, count(*) AS adet FROM  action_log WHERE personel='".$value->admin_id."' AND add_date BETWEEN '".$start_data." 00:00:00' AND '".$stop_data." 23:59:59' AND stop_case in (2,3,4,5,7,88,9) GROUP BY stop_case  ");
                  unset($dizim);
                  foreach ($ex as $valuex) {
                    $dizim[$valuex->stop_case] = $valuex->adet;
                  }

                  #$satis = $db->get_row("SELECT sum(fiyat) as ciro, Sum(urun_adeti) as urunAdeti, count(*) as adet  FROM siparisler where  islem_tarihi  between '".$start_data." 00:00:00' AND '".$stop_data." 23:59:59' AND  personel='".$value->admin_id."' AND siparis_durumu in (7,9)  ".$sql_statu."   ");
                  /*$satis = $db->get_row("SELECT SUM(fiyat) as ciro, SUM(indirim) AS t_indirim, SUM(urun_adeti) AS urunAdeti, COUNT(*) AS adet  FROM siparisler WHERE  satis_tarihi  BETWEEN '".$start_data." 00:00:00' AND '".$stop_data." 23:59:59' AND  personel='".$value->admin_id."' AND ".$order_case);*/

                  /*$satis = $db->get_row("SELECT SUM(fiyat) as ciro, SUM(indirim) AS t_indirim, SUM(urun_adeti) AS urunAdeti, COUNT(*) AS adet  FROM siparisler WHERE  kayit_tarihi  BETWEEN '".$start_data." 00:00:00' AND '".$stop_data." 23:59:59' AND  kaynak_id='".$value->admin_id."' AND ".$order_case);

                  $yeni = $db->get_row("SELECT SUM(fiyat) as ciro, SUM(indirim) AS t_indirim, SUM(urun_adeti) AS urunAdeti, COUNT(*) AS adet  FROM siparisler WHERE  kayit_tarihi  BETWEEN '".$start_data." 00:00:00' AND '".$stop_data." 23:59:59' AND  kaynak_id='".$value->admin_id."' AND ".$new_order_case);*/

                  /*$kaynak = $db->get_results("SELECT * FROM kaynak");

                  print_r($kaynak);exit;*/
                  
                  $satis = $db->get_row("SELECT SUM(fiyat) as ciro, SUM(indirim) AS t_indirim, SUM(urun_adeti) AS urunAdeti, COUNT(*) AS adet  FROM siparisler WHERE  kayit_tarihi  BETWEEN '".$start_data." 00:00:00' AND '".$stop_data." 23:59:59' AND  kaynak_id='".$value->id."' AND ".$order_case);

                  $yeni = $db->get_row("SELECT SUM(fiyat) as ciro, SUM(indirim) AS t_indirim, SUM(urun_adeti) AS urunAdeti, COUNT(*) AS adet  FROM siparisler WHERE  kayit_tarihi  BETWEEN '".$start_data." 00:00:00' AND '".$stop_data." 23:59:59' AND  kaynak_id='".$value->id."' AND ".$new_order_case);
                  
                    $Toplam['yeni'] += $yeni->adet;
                    $Toplam["satis"] += $satis->adet;
                    $Toplam["ciro"] += ((float)$yeni->ciro-(float)$yeni->t_indirim);
                    $Toplam["urun_adet"] += $yeni->urunAdeti;
                    $Toplam["sepet_ortalama_ciro"] += ((float)$yeni->ciro/$yeni->adet);
                    $Toplam["sepet_ortalama_adet"] += ((float)$yeni->urunAdeti/$yeni->adet);
                    //$Toplam["ulasilamayan"] += $dizim[2];
                    //$Toplam["ileri_tarihli"] += $dizim[3];
                    //$Toplam["gecersiz"] += $dizim[4];
                    //$Toplam["iptal"] += $dizim[5];
                    $Toplam["iptal"] += $iptal;
                    $Toplam["ulasilamayan"] += $ulasilamayan;
                    $Toplam["ileri_tarihli"] += $ileri_tarihli;
                    $Toplam["gecersiz"] += $gecersiz;

                    $result = $yeni->adet + $satis->adet + $dizim[2] + $dizim[3] + $dizim[4] + $dizim[5];

                    $Toplam['result'] += $result;

                    if($yeni->ciro>0) {
                      echo '
                      <tr class="odd gradeX">
                        <td>'.$value->kaynak_adres.'</td>
                        <td>'.$yeni->adet.'</td>
                        <td>'.$satis->adet.'</td>
                        <td>'.(int)$iptal->adet.'</td>
                        <td>'.(int)$dizim[2].'</td>
                        <td>'.(int)$dizim[3].'</td>
                        <td>'.(int)$dizim[4].'</td>
                        <td>'.number_format($yeni->urunAdeti).' </td>
                        <td>'.number_format(($yeni->urunAdeti/$yeni->adet), 1, ',', '.').'</td>
                        <td>'.number_format(($yeni->ciro/$yeni->adet), 2, ',', '.').' ₺</td>
                        <td>'.number_format(($yeni->ciro-$yeni->t_indirim), 2, ',', '.').' ₺</td>
                        <td>'.$result.'</td>
                        ';
                        echo '<td ><a href="pages.php?ido=pers_source_sales_view&id='.$value->admin_id.'&start='.$start_data.'&stop='.$stop_data.'" class="btn btn-info">Satışları</a></td>
                     </tr>
                     ';
                  }
                }
              ?>
              </tbody>
                <tfoot>
                    <tr>
                        <td style="font-weight: bold;">Toplam</td>
                        <td style="font-weight: bold;"><?=$Toplam["yeni"];?></td>
                        <td style="font-weight: bold;"><?=$Toplam["satis"];?></td>
                        <td style="font-weight: bold;"><?=$Toplam["iptal"];?></td>
                        <td style="font-weight: bold;"><?=$Toplam["ulasilamayan"];?></td>
                        <td style="font-weight: bold;"><?=$Toplam["ileri_tarihli"];?></td>
                        <td style="font-weight: bold;"><?=$Toplam["gecersiz"];?></td>
                        <td style="font-weight: bold;"><?=$Toplam["urun_adet"];?></td>
                        <td style="font-weight: bold;"><?=$Toplam["sepet_ortalama_adet"];?></td>
                        <td style="font-weight: bold;"><?=number_format($Toplam["sepet_ortalama_ciro"], 2, ',', '.');?> ₺</td>
                        <td style="font-weight: bold;"><?=number_format($Toplam["ciro"], 2, ',', '.');?> ₺</td>
                        <td><?=$Toplam["result"];?></td>
                    </tr>
                </tfoot>
           </table>
          </div><!-- table-responsive -->
        </div><!-- panel-body -->
      </div><!-- panel -->
        