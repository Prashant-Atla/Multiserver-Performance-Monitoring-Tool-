# Multiserver-Performance-Monitoring-Tool-
In this tool we evaluate the performance of web servers and the network elements that provide the servers with internet access. Performance metrics like CPU usage requests/s, transferred bytes/s and number of bytes/request for web server. And bit/s per interface difference between in and out as well as aggregated bit rate over all interfaces.  The aim is to build a tool that allows us to correlate performance metrics from both the network and the application. The tool should allow a visual comparison between server and link layer performance metrics. The tool also have the functionality of add/remove devices to monitor. The user will be able to select what metric and device that he wants to compare. The Tool has a simple web Gui that allows the user to interact with the Tool. 


corelation of bitrates of device and server

pre-requisites

install the required configuration
	mysql-server
	apache2
	snmpd
	snmp
	php5
permission are to be given

the web server should have read and write permissions on directory et2536-prat15

Snmp permissions should be given to both device and server you are monitoring

to retrive data from http the parsing should be made available in the server which is to be monitored and changes should be made in the configeration file of the server.

ie in the  directory /etc/apache2/ open the file apache2.conf add the lines
<Location /server-status>
setHandler server-status
order deny.allow
Deny from none
Allow from all
</Location>

for omly one device to be probed type the device ip in the  'Allow from <IP adress>'
the server must be restarted after the changes are done 

sudo service apache2 restart
##################################
installation
 the above are the modules to be installed 


sudo apt-get install libdbi-perl
sudo apt-get install libpango1.0-dev 
sudo apt-get install  libxml2-dev
sudo apt-get install libsnmp-perl 
sudo apt-get install libsnmp-dev 
sudo apt-get install libnet-snmp-perl
sudo apt-get install rrdtool
sudo apt-get install rrdtool-dbg
sudo apt-get install php5-rrd
sudo apt-get install liblwp-useragent-determined-perl
perl -MCPAN -e 'install Net::SNMP'
perl -MCPAN -e 'install Net::SNMP::Interfaces'
perl -MCPAN -e 'install RRD::Simple'	

instructions

1 from the browser go to the assignment2 

2 now for the device needed for probing is selected by the add/delete option
3 And then select the required interfaces to which the probing to be done in each individual device and the graphs are are shown in single graph

then run the shell script device.sh so the probing is done.
it is done by perl <path of the folder>/et2536-prat15/assignment2/device.sh

4 similar to device select the server to be probed and select the metric to be displayed on graph.
then run the shell script to do the probing of the servers.
it is done by perl <path of the folder>/et2536-prat15/assignment2/server.sh

with the help of the GUI the graphs of the perticular device with the interface can be seen





