#!/bin/sh

# 1. Init project
cd /var/www/html/tpc-store || exit
composer install --ignore-platform-reqs --no-dev
chmod -R 775 /var/

# 2. Limit docker logs
cd /etc/logrotate.d || exit
touch docker-logs
# shellcheck disable=SC2129
echo '/var/lib/docker/containers/*/*.log {' >>docker-logs
echo 'rotate 7' >>docker-logs
echo "daily" >>docker-logs
echo 'compress' >>docker-logs
echo 'size=50M' >>docker-logs
echo 'missingok' >>docker-logs
echo 'delaycompress' >>docker-logs
echo 'copytruncate' >>docker-logs
echo '}' >>docker-logs

# 3. Create auto-pull script
cd /var/www/html/tpc-store || exit
touch auto-pull.sh
# shellcheck disable=SC2129
echo '#!/bin/sh' >>auto-pull.sh
echo 'cd /var/www/html/tpc-store' >>auto-pull.sh
echo 'git pull' >>auto-pull.sh
echo 'composer install --ignore-platform-reqs' >>auto-pull.sh
echo 'php spark migrate' >>auto-pull.sh
chmod +x /var/www/html/tpc-store/auto-pull.sh

# 4. Create auto-build script
cd /var/www/html/tpc-store || exit
touch auto-build.sh
# shellcheck disable=SC2129
echo '#!/bin/sh' >>auto-build.sh
echo 'cd /var/www/html/tpc-store' >>auto-build.sh
echo 'docker-compose build --no-cache web' >>auto-build.sh
echo 'docker-compose up -d' >>auto-build.sh
echo 'docker image prune -f' >>auto-build.sh
chmod +x /var/www/html/tpc-store/auto-build.sh

# 4. Update crontab (Ubuntu)
echo "*/5 * * * * cd /var/www/html/tpc-store && /bin/sh ./auto-pull.sh" | tee -a /var/spool/cron/crontabs/root
echo "0 3 * * * cd /var/www/html/tpc-store && /bin/sh ./auto-build.sh" | tee -a /var/spool/cron/crontabs/root
