<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
<style media="screen">
  body{
    display:flex;
    justify-content:center;
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
  justify-content:center;
  }

th {
  text-align:center;
}
</style>



<?php

$oslo_lat = '59.908559';
$oslo_lon = '10.734510';


$fromtime = new \DateTime('-8 days'); //"2017-04-14"; //date("Y-m-d");
$fromtime = $fromtime->format ("Y-m-d");
$totime = new \DateTime('-1 day'); //"2017-04-15";//date("Y-m-d");
$totime =  $totime->format ("Y-m-d");

$url = "http://api.sehavniva.no/tideapi.php?lat=".$oslo_lat."&lon=".$oslo_lon."&fromtime=".$fromtime."T00%3A00&totime=".$totime."T00%3A00&datatype=obs&refcode=cd&place=Oslo&file=&lang=en&interval=60&dst=0&tzone=&tide_request=locationdata";



$xmlstring=file_get_contents($url);
$xml = simplexml_load_string($xmlstring);

$waterlevel=$xml->xpath("/tide/locationdata/data/waterlevel");
$cur_waterlevel=$xml->xpath("/tide/locationdata/data/waterlevel/@value");

?>

<div class="container">
  <table class="table table-striped table-hover c_table">
    <tr>
      <th colspan="2"> </th>
    </tr>
    <tr>
      <th colspan="3" > HISTORY </th>
    </tr>
    <tr>
      <th class="info">OBS TIDE</th>
      <th class="info">TIME</th>
    </tr>
    <?php foreach ($waterlevel as $value) {
      echo "<tr><td>water level  is: ".$value['value']."cm </td><td> on ".$value['time']."</td></tr>";
    }
    ?>
  </table>
