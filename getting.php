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
<a  href="monitor.php">Monitor</a>

 <h3> DEVICE GRAPH </h3>
<?php

if(!empty($_POST['check_list1'])) {

if(!empty($_POST['check_listtime'])) 
							{#$timestack=array();
									
										foreach($_POST['check_listtime'] as $value)
										 {
														#echo "$value<br>"; 
														#list($time,$value)=explode("+",$check3);
										}
										#print "<br>$value<br>";
								}
$options = array(
    "--slope-mode",
    "--start", "$value",
    "--title=monitoring devices",
					"--units=si", 
					"--grid-dash", "1:3", "--alt-autoscale-max","--lower-limit","0","--vertical-label=Bytes per Second");
					
				foreach($_POST['check_list1'] as $check1)
				{
				#echo "<br>$check1<br>";
							
							
							if(!empty($_POST["$check1-check_list2"])) 
							{
							
							$interfacestack=array();
									foreach($_POST["$check1-check_list2"] as $check2) 
									{
													#echo "<br>$check2<br>"; 
													list($device,$id,$ip,$port,$community,$interface) = explode("+", $check2);
													echo "device:$device";
													#echo "id:$id";
													#echo "name:$ip";
													#echo "interface:$interface<br>";
													array_push($interfacestack, "$interface");

									}
									$file="$device$ip$port$community.rrd";
									#echo "<br>$file<br>";
									#print_r($interfacestack);
									#$hexa = "#".dechex(rand(16, 255)).dechex(rand(16,  255)).dechex(rand(16,  255));
									#$hexa1 = "#".dechex(rand(16,255)).dechex(rand(16,  255)).dechex(rand(16,  255));
					#array_push($options,"DEF:inBytestotal$id=$file:bytesIntotal:AVERAGE","DEF:outBytestotal$id=$file:bytesOuttotal:AVERAGE","COMMENT: \\t",
					#"COMMENT: \\t\\tMAXIMUM\\t",
					#"COMMENT:  AVERAGE\\t",
					#"COMMENT:  LAST\\n","LINE1:inBytestotal$id$hexa:inBytestotal-$ip","GPRINT:inBytestotal$id:MAX: %6.2lf ","GPRINT:inBytestotal$id:AVERAGE: %6.2lf ","GPRINT:inBytestotal$id:LAST: %6.2lf \\n","LINE2:outBytestotal$id$hexa1:outBytestotal-$ip","GPRINT:outBytestotal$id:MAX: %6.2lf ","GPRINT:outBytestotal$id:AVERAGE: %6.2lf ","GPRINT:outBytestotal$id:LAST: %6.2lf \\n");
									
							}
							$all=array();
							foreach($interfacestack as $in)
									{
									#echo "$in";
									$hexa = "#".dechex(rand(16, 255)).dechex(rand(16,  255)).dechex(rand(16,  255));
									$hexa1 = "#".dechex(rand(16,255)).dechex(rand(16,  255)).dechex(rand(16,  255));
									array_push($options,"DEF:inBytes$id$in=$file:bytesIn$in:AVERAGE","DEF:outBytes$id$in=$file:bytesOut$in:AVERAGE",
									"VDEF:last_in$id$in=inBytes$id$in,LAST",
					"VDEF:last_out$id$in=outBytes$id$in,LAST",
#"CDEF:aggIn$id$n=inBytes$id$n,+",
#"CDEF:aggOut$id$n=outBytes$id$n,+",
									"LINE1:inBytes$id$in$hexa:inbytes-$ip-$in","GPRINT:inBytes$id$in:MAX: %6.2lf %SBps","GPRINT:inBytes$id$in:AVERAGE: %6.2lf %SBps","GPRINT:inBytes$id$in:LAST: %6.2lf %SBps\\n","LINE2:outBytes$id$in$hexa1:Outbytes-$ip-$in","GPRINT:outBytes$id$in:MAX: %6.2lf %SBps ","GPRINT:outBytes$id$in:AVERAGE: %6.2lf %SBps","GPRINT:outBytes$id$in:LAST: %6.2lf %SBps\\n");#"GPRINT:addIn$id$in:LAST: %6.2lf %SBps\\n","GPRINT:aggOut$id$in:LAST: %6.2lf %SBps\\n"#);
									array_push($all,"inBytes$id$in");
								}
								#print_r ($all);
								#$comma_separated = implode("+", $all);
								#echo "$comma_separated";
								list($r,$t)=(explode('+', $comma_separated, 2));
								#print_r($r);
								#print_r($t);
								#array_push($options,"CDEF:allin-$ip=$comma_separated","LINE1:allin-$ip#ffffff");
								
				}				
				echo "<br><br>";
								#print_r ($options);
								$ret = rrd_graph("device.png", $options);
  if (! $ret) {
    echo "<b>Graph error: </b>"."\n".rrd_error()."\n";
  }
				echo "<center><img src='device.png' height='400' width='800' alt='Generated RRD image' ></center>";
				#echo "<center><img src='server.png' height='400' width='800' alt='Generated RRD image' ></center>";
				
}
else
{
echo "nothing selected first select any device";
}
echo "<form action=monitor.php>";
#echo "<button type=submit  value='back to monitoring'>Back to monitoring</button></form>";

?>
