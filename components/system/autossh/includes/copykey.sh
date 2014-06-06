#!/bin/bash
empty -f -i input.fifo -o output.fifo -p empty.pid -L copy.log scp /root/.ssh/id_rsa.pub $1@$2:.ssh/authorized_keys
empty -w -i output.fifo -o input.fifo assword "$3\n"

