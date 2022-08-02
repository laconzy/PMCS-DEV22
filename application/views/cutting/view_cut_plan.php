<!DOCTYPE html>
<html>
    <head>
      <style>
        table {
          border-collapse: collapse;
          width: 100%;
        }

        th, td {
          text-align: left;
          padding: 8px;
        }

        tr:nth-child(even) {background-color: #f2f2f2;}
        </style>  

    </head>    

    <body style="display: block">    
        <div class="container" style="position: relative;">  
           
            <div class="row">
                <div style="width:100%">                    
                    

                    CUT PLAN # : <?= $cut_plan_id; ?>
                  
                    <table border="1">

                        <tr>
                            <th rowspan="2"><center>CUT NO</center></th>
                            <th rowspan="2"><center>RATIO</center></th>                         
                            <th rowspan="2"><center>PLICE</center></th>
                            <th colspan="<?= $cut_plan_size_count;?>"><center>SIZES</center></th>
                            <th rowspan="2"><center>TOTAL</center></th>
                            <th rowspan="2"><center>PCS</center></th>
                            <th rowspan="2"><center>CUM</center></th>


                        </tr>
                    
                         <tr>
                    <?php foreach($cut_plan_size as $row) { ?>
                           <td><?= $row['size_code'] ?></td>    
                    <?php } ?>                                                
                         </tr>
                    

                    <?php 
                    $cum_total = 0;
                    foreach($cut_plan_details['A'] as $row) { ?>
                         <tr>
                           <td><?= $row['line_no'] ?></td>
                           <td><?= $row['marker_ref'] ?></td>
                           
                           <td><?= $row['plies'] ?></td>
                           <?php 
                             $pieces = explode(",",$row['ratio']);
                             $total = 0;
                             foreach($pieces as $key) {    
                           ?>

                           <td><?= $key * $row['plies'] ?></td>

                          <?php 
                          $total += $key * $row['plies'];
                          $cum_total += $key * $row['plies'];   
                            }
                           ?>

                           <td><?= $total ?></td>
                           <td><?= $total/$row['plies'] ?></td>
                           <td><?= $cum_total ?></td>
                           
                         </tr>
                    <?php 


                    } ?>



                    </table>

                  
                                           
                </div>          
            </div>
        </div>  
           
    </body>
</html>
