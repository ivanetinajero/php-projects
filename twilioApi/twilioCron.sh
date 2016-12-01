#!/bin/bash
cd /var/www/kanbanboard/twilioApi
php sendMessage.php >> twilioApi.log
