#!/bin/bash
empty -f -i input.fifo -o output.fifo -p empty.pid ssh $1@$2
empty -w -i output.fifo -o input.fifo continue "yes\n"
killall ssh

