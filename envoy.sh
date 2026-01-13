#npm run build
git add -A
git commit -m "Update"
git push
php vendor/bin/envoy run deploy
