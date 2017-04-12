#!/usr/bin/perl
use DBI;
use Net::SNMP ;
use RRD::Simple ;
use FindBin qw($Bin);
use Data::Dumper;
#connecting to database
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
$query1 = $dbh->prepare("select * from devicefish");
$query1->execute;
while (@row = $query1->fetchrow_array())#one one column table
 {
#my $sth = $dbh->prepare("SELECT ip, port, community, interfaces from 
@alloids = ();
$id= $row[0];
$ip= $row[1];
$port=$row[2];
$community=$row[3];
$interface=$row[4];

$session = Net::SNMP->session( -hostname => $ip, -port => $port, -community => $community, -timeout => 1, -nonblocking=>1);

if(!defined $session)
   {
print"error\n";

}
$interface =~ s/\s+$//g;
@intstore = split(",",$interface);

foreach $n(@intstore) {
			#$n=~ s/\s+$//g;
			push(@alloids,"1.3.6.1.2.1.2.2.1.10"."."."$n");
			push(@alloids,"1.3.6.1.2.1.2.2.1.16"."."."$n");
			}
 print Dumper(@alloids);
		if (scalar(@alloids) <= 50 ) {print "In less OID loop: $ip, $community\n";
		$system = $session->get_request(-varbindlist => \@alloids,-callback => [\&validgo, "$id", "$ip", "$port", "$community","$interface"]);
					}

		else {print "In greater OID loop: $ip, $community\n";
		push @ints, [splice @alloids, 0, 50] while @alloids;
		foreach $i (@ints){
		$system = $session->get_request(-varbindlist => \ @$i,-callback => [\&validgo, "$id", "$ip", "$port", "$community","$interface"]);
			}
		     }

$session->close;
}#while

			      
		snmp_dispatcher();
		

		sub validgo
		{
   		 ($session, $id, $ip, $port, $community,$interface) = @_;
	
			@intstore = split(",",$interface);
			@in = (); @out = ();
			$values = $session->var_bind_list();
			@x = keys(%{$session->var_bind_list});
			@y = sort @x;

		foreach $oid (@y) {
					#print $oid."\n";
					$fetch = $session -> var_bind_list -> {$oid};
					#print "$fetch"."\n";
#					print $oid."\n";
					@split = split(/\./,$oid);
					#print "@split"."\n";
#					@pop = pop @split;
					#print "$pop[0]"."\n";
					

					if($split[$#split-1] == 10)
					{
						$in[$split[$#split]]=$fetch;
#						push(@in,$fetch);
					}

					if($split[$#split-1] == 16)
					{
						$out[$split[$#split]]=$fetch;
#						push(@out,$fetch);
					}
				}
		

	
if($values)
	{
	$filename = "$Bin/rrdfiles/devices/$ip-$port-$community.rrd";
	$time = time();
	my $rrd = RRD::Simple->new( file => $filename, cf => [qw(AVERAGE)], default_dstype => "GAUGE", on_missing_ds => "add");
	unless (-e $filename) {
	$rrd->create($filename,"hour",testDS=>"GAUGE");
				}
	#$count=0;
	foreach $z(@intstore)
{
			push(@update,"in$z"=>"$in[$z]","out$z"=>"$out[$z]");
	#		$count++;
			}
	$rrd->update($filename,$time,@update);
		}
	
}
		






















