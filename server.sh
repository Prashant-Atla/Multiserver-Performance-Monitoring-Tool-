#!/bin/sh
while true
do
start=`date +%s`
perl server.pl
end=`date +%s`
runtime=$((end-start))
sleep $((60-runtime))
done
