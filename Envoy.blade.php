@servers(['beget' => ['a022bdzr@5.101.152.59']])

@task('deploy')
cd /home/a/a022bdzr/__wildcard__.buldozer.pro
git stash
git pull
/usr/local/php/cgi/8.4/bin/php artisan queue:restart
/usr/local/php/cgi/8.4/bin/php artisan cache:clear
/usr/local/php/cgi/8.4/bin/php artisan view:clear
/usr/local/php/cgi/8.4/bin/php artisan optimize:clear
/usr/local/php/cgi/8.4/bin/php artisan clear-compiled
@endtask
