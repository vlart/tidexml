
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Simple xml</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
  <script src="js/fusioncharts.js"></script>
  <script src="js/fusioncharts.charts.js"></script>
  <script src="js/fusioncharts.gantt.js"></script>


  <style media="screen">
  body{
    display:flex;
  }
  a{
    width:200px;
    margin: 10px;

  }
  .c_table {
    width :500px;
  }
  .inp{
    width:200px;
  }
  .container {
  width: 940px;
  display:flex;
  align-items:center;
  flex-direction:column;

  }

  th {
  text-align:center;
  }
  </style>



</head>
<body>

  <?php


  $oslo_lat = '59.908559';
  $oslo_lon = '10.734510';

  $fromtime = date("Y-m-d"); //"2017-04-14"; //date("Y-m-d");
  $totime = new \DateTime('+1 day'); //"2017-04-15";//date("Y-m-d");
  $totime =  $totime->format ("Y-m-d");

  //$totime->modify('+1 day');

  $cur_date = "2017-04-16T19:00:00+01:00";// $cdate->format('Y-m-d\TH:00:00+01:00');

  $cdate = new \DateTime('-2 hours');
  $cur_date1 =  $cdate->format('Y-m-d\TH:00:00+01:00');
  //2017-04-14T17:00:00+01:00
  //echo $cur_date.'<br>';
  //echo $cur_date1.'<br>';


  $url = "http://api.sehavniva.no/tideapi.php?lat=".$oslo_lat."&lon=".$oslo_lon."&fromtime=".$fromtime."T00%3A00&totime=".$totime."T00%3A00&datatype=obs&refcode=cd&place=Oslo&file=&lang=en&interval=60&dst=0&tzone=&tide_request=locationdata";







  $xmlstring=file_get_contents($url);
  $xml = simplexml_load_string($xmlstring);

  $waterlevel=$xml->xpath("/tide/locationdata/data/waterlevel/@value");
  //$waterlevel=$xml->xpath("/tide/locationdata/data/waterlevel/@time");
  $cur_waterlevel=$xml->xpath("/tide/locationdata/data/waterlevel[@time=".$cur_date."]/@value");

  //$min_watl_time=$xml->xpath("/tide/locationdata/data/waterlevel[@value=".$waterlevel."]/@value");
  //$waterlevel=$xml->locationdata->data->waterlevel;
  //$value_list=$waterlevel->value[3]; // не работает





    $oslo_lat2 = '59.908559';
    $oslo_lon2 = '10.734510';

    $fromtime2 = date("Y-m-d"); //"2017-04-14"; //date("Y-m-d");
    $totime2 = new \DateTime('+1 day'); //"2017-04-15";//date("Y-m-d");
    $totime2 =  $totime2->format ("Y-m-d");

    $url2="http://api.sehavniva.no/tideapi.php?lat=".$oslo_lat2."&lon=".$oslo_lon2."&fromtime=".$fromtime2."T00%3A00&totime=".$totime2."T00%3A00&datatype=tab&refcode=cd&place=Oslo&file=&lang=nn&interval=60&dst=0&tzone=&tide_request=locationdata";


  $xmlstring2=file_get_contents($url2);
  $xml2 = simplexml_load_string($xmlstring2);
  $waterlevel2 = $xml2->xpath("/tide/locationdata/data/waterlevel");


  $low = "img/tidal_low_19x17.png";
  $high =  "img/tidal_high_19x17.png"


  ?>


  <div class="container">
    <table class="table table-striped table-hover c_table">
      <tr>
        <th> <?php echo date("Y M d");  ?></th  colspan="2">
        <th colspan="2"> <?php
        echo "last obs tide is ".min($waterlevel)." cm";

        ?></th>
      </tr>
       <tr>
        <th class="info">High/Low</th>
        <th class="info">Tides</th>
        <th class="info">Time</th>
      </tr>
      <tr>

        <?php

          foreach ($waterlevel2 as $value) {
            $flag = $value['flag'];
          //  echo $flag;
            $str= "<tr>
            <td>
            ";
              if ($flag=='low' ){
                $str.="<img src=".$low." alt='low'>";
              }
              else
//                echo '<img src="'.$low.'" alt="low">';

                $str.="<img src=".$high." alt='high'>";

              $str.="
              </td> <td>water level  was: ".$value['value']."cm </td>
            <td> on ".$value['time']."</td></tr>";
            echo $str;


          }
         ?>

    </table>



    <a href="history.php" class="btn btn-info">HISTORY</a>
    <a href="forecast.php" class="btn btn-success">FORECAST</a>


    <div class="form-wrapper">
      <p class="output-text" ></p>
      <form class="" action="hist.php" method="post"> <?php// $_SERVER['PHP_SELF']?>
        <label for="date-from" >FROM</label><br />
        <input type="date" class="form-control inp" id="date-from" name="date-from" value="<?php echo date("Y-m-d");?>"><br />
        <label for="date-to" >TO</label><br />
        <input type="date" class="form-control inp" id="date-to" name="date-to" value="<?php echo $totime; ?>"><br /><br />
        <input type="submit" name="sbmtbtn" value="REQUEST">
      </form>
    </div>



    <?php
    include("fusioncharts.php");

    $oslo_lat3 = '59.908559';
    $oslo_lon3 = '10.734510';

    $fromtime3 = date("Y-m-d"); //"2017-04-14"; //date("Y-m-d");
    $totime3 = new \DateTime('+1 day'); //"2017-04-15";//date("Y-m-d");
    $totime3 =  $totime3->format ("Y-m-d");

    $column2dChart = new FusionCharts("pie2d", "ex3", "700", "400", "chart-1", "xmlurl", PATHTOFILE . "http://api.sehavniva.no/tideapi.php?lat=".$oslo_lat3."&lon=".$oslo_lon3."&fromtime=".$fromtime3."T00%3A00&totime=".$totime3."T00%3A00&datatype=obs&refcode=cd&place=Oslo&file=&lang=en&interval=60&dst=0&tzone=&tide_request=locationdata");
    // Render the chart
    $column2dChart->render();

     ?>
    <div class="" id="chart-1">

    </div>


  </div>



</body>
</html>
