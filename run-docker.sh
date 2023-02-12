#!/bin/sh
cp ChaoxingSign /www/wwwroot/website
docker-compose up -d
echo "*/3 * * * * /usr/bin/curl http://localhost/ChaoxingSign/index.php" | crontab -e