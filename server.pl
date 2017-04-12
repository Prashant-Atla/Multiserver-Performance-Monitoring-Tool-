use LWP::Simple;
use RRD::Simple();
use DBI;
use FindBin qw($Bin);

my $db_conf_path = substr($Bin,0,rindex($Bin,'/')+1)."db.conf";
open FILE, "$db_conf_path" or die $!;
my @data = <FILE>;
my @host = split('"', $data[0]);
my @port = split('"', $data[1]);
my @database = split('"', $data[2]);
my @username = split('"', $data[3]);
my @password = split('"', $data[4]);
$dsn = "dbi:mysql:$database[1];$host[1];$port[1]";
########perl DBI connect
$dbh = DBI->connect($dsn,$username[1],$password[1]) or die "unable to connect: $DBI::errstr\n";
$query1 = $dbh->prepare("select * from serverfish");
$query1->execute;
while (@row = $query1->fetchrow_array())#one one column table
 {
    my($server)=@row;#for sake of now 
my($link)= "http://$server/server-status?auto";
my($serverstatus)=get($link);
   print "$serverstatus rnjnejnjknrje\n";
my($total_accesses,$total_kbytes,$cpuload,$uptime, $reqpersec,$bytespersec,$bytesperreq,$busyservers, $idleservers);
if (! $serverstatus) {
print "Can't access $url\nCheck apache configuration\n\n";
#exit(1);
}

$cpuload = $1 if ($serverstatus =~ /CPULoad:\ ([\d|\.]+)/gi);
$uptime = $1 if ($serverstatus =~ /Uptime:\ ([\d|\.]+)/gi);
$reqpersec = $1 if ($serverstatus =~ /ReqPerSec:\ ([\d|\.]+)/gi);
$bytespersec = $1 if ($serverstatus =~ /BytesPerSec:\ ([\d|\.]+)/gi);
$bytesperreq = $1 if ($serverstatus =~ /BytesPerReq:\ ([\d|\.]+)/gi);
$cpuusage=$cpuload*$uptime/100;
#my $file = time();
#$file="server$server.rrd";
my $rrd = RRD::Simple->new(file => "$server.rrd", cf =>[qw(AVERAGE)], default_dstype => "GAUGE", on_missing_ds => "add");

if(! -e "$server.rrd")
{
$rrd->create("$server.rrd","hour",testDS=> "GAUGE");
}
#push(@data,("cpuusage" => "$cpuusage"), ("requestspersec" => "$reqpersec"),("transfbytespersec" => "$bytespersec"), ("bytesperrequest" => "$bytesperreq"));

my $time=time();
#print @data;
$rrd->update("$server.rrd",@data= map(("cpuusage" => "$cpuusage"), ("requestspersec" => "$reqpersec"),("transfbytespersec" => "$bytespersec"), ("bytesperrequest" => "$bytesperreq")));
}











