<?php if (!defined("idokey")) { exit(); }?>
<?php

              $drm = (int)$_GET["drm"];
              $tip = (int)$_GET["tp"];
              $gd = (int)$_GET["g"];

              if(empty($drm)){header("Location:index.php");}

              $durum = $db->get_row("SELECT * FROM siparis_durumlari where durum_id='".$drm."' ");


?>

<div class="panel panel-default">
        <div class="panel-heading">
          <div class="panel-btns">
            <a href="" class="panel-close">&times;</a>
            <a href="" class="minimize">&minus;</a>
          </div><!-- panel-btns -->
          <h3 class="panel-title"> <?=$durum->name?> Sipariş Listesi</h3>
        </div>
        <div class="panel-body">
     
      
          <div class="table-responsive">
            <table class="table" id="table1">
              <thead>
                 <tr>
                    <th>ID</th>
                    <th>Ad Soyad</th>
                    <th>Telefon</th>
                    <th>Ürün</th>
                    <th>Fiyat</th>
                     <th>Kayıt Tarihi</th>
                    <!--<th>il/ilce</th>-->
                    <th>Durumu</th>
                    <th>Kilit</th>
                    <th>İşlem</th>
                    <th>Kaynak</th>
                 </tr>
              </thead>
              <tbody>


                 <?php

                     $id = (int)$_GET["id"];
                          if(!empty($id)){

                            log_save($id,$gd);
                            $e = $db->query("UPDATE  siparisler set siparis_durumu='".$gd."' AND iptal_user='".$_SESSION["admin_id"]."'  where siparis_id='".$id."' ");
                            if($e){
                                alert_yes("İşlem Başarıyla yerine getirildi.");

                            }else{
                                alert_no("İşlem Başarısız oldu.");
                            }
                          }


                    ?>

                <?php

              $e = $db->get_results("SELECT * FROM siparisler where siparis_durumu='".$drm."' AND siparis_tipi='".$tip."' order by siparis_id DESC ");
              foreach ($e as  $value) {

                
                  echo '
                  <tr class="odd gradeX">
                    <td>'.$value->siparis_id.'</td>
                    <td>'.$value->ad_soyad.'<br> <font style="color:green">Sip Kod : '.$value->siparis_id.'</font> </td>
                    <td>'.$value->Telefon_no.'</td>
                    <td>'.$value->urunun_adi.'</td>
                    <td>'.$value->fiyat.'</td>
                    <td>'.$value->kayit_tarihi.'</td>
                    <td > '.$durum->name.'  

                    ';

                    //<td>'.$value->il.' / '.$value->ilce.'<br> '.$value->update_date.'</td>

                    if($drm==9 or $drm==7){echo "<br>".date("d-m-Y", strtotime($value->satis_tarihi));}
                    echo'

                    </td>
                    ';

                    if($drm==9 or $drm==7){


                       $kilitci= 'Satış<br><font style="color:green"> '.personel("name_surname",$value->personel).'</font>';


                    }else{


                      if($value->kilit==1){
                        $kilitci =personel("name_surname",$value->kilit_pers);
                      }else{
                        $kilitci="-";
                      }
                    }



                    echo'
                    <td > '.$kilitci.'</td>
                    <td >

                    <a href="pages.php?ido=siparis&id='.$value->siparis_id.'" class="btn btn-info">Görüntüle</a>
                    <a style="display:none" href="pages.php?ido=siparis_listesi&drm='.$drm.'&tp='.$tip.'&id='.$value->siparis_id.'&g=4" class="btn btn-danger">Geçersiz</a>
                    
';

        if($drm==7 or $drm==9){
          echo '<a href="pages.php?ido=siparis_listesi&drm='.$drm.'&tp='.$tip.'&id='.$value->siparis_id.'&g=5" class="btn btn-danger">İptal</a>
';
        }

        if ($value->source == "http://marwablog.com/") {
          $source = "www.marwablog.com";
        } elseif ($value->source == "http://akhbartr.com/") {
          $source = "www.akhbartr.com";
        } elseif ($value->source == "http://shaearwasaf.com/") {
          $source = "www.shaearwasaf.com";
        } else {
          $source = "-";
        }
        
            echo '
                    </td>
                    <td > '.$source.'</td>
                 </tr>
                 ';
              }


              ?>
                 
               
              </tbody>
           </table>
          </div><!-- table-responsive -->
       
    
          
        </div><!-- panel-body -->
      </div><!-- panel -->
        