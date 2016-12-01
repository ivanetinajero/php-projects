#!/bin/bash
cd /var/www/kanbanboard/JSON_EXPORT_DIR
php moveCard.php "`ls -At *.json | tail -n 1`" >> trello.log
