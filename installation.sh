rm -rf ./{*,.*}
git clone https://github.com/MuhammadHurairaAamir/Agency-Plus.git .
sudo chown -R :www-data core/app/Providers/AppServiceProvider.php
sudo chown -R :www-data core/bootstrap/cache
sudo chown -R :www-data core/storage
sudo chown -R :www-data core/.env

sudo chown -R $USER:$USER core/.env
sudo chown -R $USER:$USER core/app/Providers/AppServiceProvider.php


Change Password: $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi
