<!DOCTYPE html>
<html>
<head>

<h1><center>Assignment2</center></h1>
</head>
<body>
<body style="background-image:url('http://www.pptbackgrounds.net/uploads/bluewave-white-backgrounds-wallpapers.jpg');">
<a  href="index.html">Home</a>
<a  href="adddevice.php">adddevice</a>
<a  href="addserver.php">addserver</a>
<a  href="deletedevice.php">deletedevice</a>
<a  href="deleteserver.php">deleteserver</a>

 <h3 > SERVER GRAPH </h3>
<?php

if(!empty($_POST['serverlist'])) 
{
//print_r ($_POST['serverlist']);
if(!empty($_POST["server_time"])) 
							{
										foreach($_POST["server_time"] as $check3)
										 {
														#echo "$check3<br>"; 
										}
								}
								
								$options = array(
    "--slope-mode",
    "--start", "$check3",
    "--title=monitoring server",
					"--units=si", 
					"--grid-dash", "1:3", "--alt-autoscale-max","--lower-limit","0","COMMENT: \\t",
					"COMMENT: \\t\\tMAXIMUM\\t",
					"COMMENT:  AVERAGE\\t",
					"COMMENT:  LAST\\n");
					
echo "<br><br>";
				foreach($_POST['serverlist'] as $check1)
				{
				#echo "$check1<br>";
				list($servername,$ids)=explode("+",$check1);
				echo "<br>";
							if(!empty($_POST['server_parameter'])) 
							{
									foreach($_POST['server_parameter'] as $check2) 
									{
													#echo "$check2<br>";
													$hexa = "#".dechex(rand(16, 255)).dechex(rand(16,  255)).dechex(rand(16,  255)); 
													if (strcmp($check2, "bytesperrequest") == 0)
													{
													$l="SB";
													} 
													elseif (strcmp($check2, "requestspersec") == 0)
													{
													$l="Srps";
													} 
													elseif (strcmp($check2, "cpuusage") == 0)
													{
													$l='S%%';
													} 
													else 
													{
													$l="SBps";
													} 
													array_push($options,"DEF:$ids$check2=server$servername.rrd:$check2:AVERAGE","LINE1:$ids$check2$hexa:$servername$check2","GPRINT:$ids$check2:MAX: %6.2lf %$l","GPRINT:$ids$check2:AVERAGE: %6.2lf %$l","GPRINT:$ids$check2:LAST: %6.2lf %$l\\n");
									}
								}
								else
								{
								#echo "server_parameter<br>";
								}
				}
				#print_r ($options);
				$ret = rrd_graph("server.png", $options);
  if (! $ret) {
    echo "<b>Graph error: </b>"."\n".rrd_error()."\n";
  }
				echo "<center><img src='server.png' height='400' width='800' alt='Generated RRD image' ><center>";
				echo "<center><img src='device.png' height='400' width='800' alt='Generated RRD image' ></center>";
}
else
{
echo "nothing selected first select any server";
}
echo "<form action=monitor.php>";
#echo "<button type=submit  value='back to monitoring'>Back to monitoring</button></form>";

?>
