<?php if (!defined("idokey")) { exit(); }?>

<div class="panel panel-default">
        <div class="panel-heading">
          <div class="panel-btns">
            <a href="" class="panel-close">&times;</a>
            <a href="" class="minimize">&minus;</a>
          </div><!-- panel-btns -->
          <h3 class="panel-title"> Site Listesi</h3>
        </div>
        <div class="panel-body">
     
      
          <div class="table-responsive">
            <table class="table" id="table1">
              <thead>
                 <tr>
                    <th>Site Adı</th>
                    <th>Site Adresi</th>
                    <th>İşlem</th>
                 </tr>
              </thead>
              <tbody>

            <?php

              /*if($_SESSION["yetki"]==0){
                 $e = $db->get_results("SELECT * FROM kaynak where   login_case=0  ".$sql_statu3." ");
               }else{
                 $e = $db->get_results("SELECT * FROM kaynak where user_type=0 AND login_case=0  ".$sql_statu3." ");
               }*/

               $e = $db->get_results("SELECT * FROM kaynak ");
             
              foreach ($e as  $value) {

                
                  echo '
                  <tr class="odd gradeX">
                    <td>'.$value->kaynak_isim.'</td>
                    <td>'.$value->kaynak_adres.'</td>
               
                    <td >

       <a href="pages.php?ido=site_edit&id='.$value->id.'" class="btn btn-info">Düzenle</a>
';

        
echo '


                    </td>
                 </tr>
                 ';
              }


              ?>
                 
               
              </tbody>
           </table>
          </div><!-- table-responsive -->
       
    
          
        </div><!-- panel-body -->
      </div><!-- panel -->
        