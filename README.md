
### 关于 Molsen

目前它是一套基于Laravel做的后台管理+博客系统

### 安装部署 Molsen

```
git clone project.git
cd project
composer install
chmod -R 777 storage/
ln -s /your_project/storage/app/public/ /your_project/public/storage
```
### 配置 nginx
```
server {
    listen          80;
    server_name     www.yourdomain.com;

    add_header      X-Frame-Options "SAMEORIGIN";
    add_header      X-XSS-Protection "1; mode=block";
    add_header      X-Content-Type-Options "nosniff";

    root            /your_project/public;
    index           index.html index.htm index.php;

    charset         utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page  404 /index.php;
    error_page  500 502 503 504 /50x.html;
    location = /50x.html {
        root    html;
    }

    location ~ \.php$ {
        fastcgi_pass    127.0.0.1:9000;
        fastcgi_index   index.php;
        fastcgi_param   SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include         fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```
