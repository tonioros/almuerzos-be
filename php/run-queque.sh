#!/bin/sh

echo "Queue Starting" > /var/log/queuecron.log 2>&1
# Command to start Laravel Queue using CronJobs
echo "Queue End" > /var/log/queuecron.log 2>&1
