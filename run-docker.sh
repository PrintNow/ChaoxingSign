#!/bin/sh
# dependence list: curl, cron, docker-compose,docker
# 此脚本只需执行一次
cd .
mkdir -p /www/wwwroot/website
cp -r www/wwwroot/config /www/wwwroot
cp -r ChaoxingSign /www/wwwroot/website
docker-compose up -d
echo "*/3 * * * * /usr/bin/curl http://localhost/ChaoxingSign/index.php > /dev/null" > /var/spool/cron/crontabs/root
systemctl restart cron
