<p align="center">
    <h1 align="center">Test task for LEADS</h1>
    <br>
</p>

REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 5.4.0.


INSTALLATION
------------

Create folder `/var/html/test-leads.my` and clone this repository there 

Create MySQL db and set db credentials in `/var/html/test-leads.my/config/db.php` file

Run this commands in `/var/html/test-leads.my`:
~~~
php composer.phar install
php ./yii migrate/up
~~~

Now you should configure frontend and api domains in apache `httpd-vhosts.conf` file.
Please add following lines

~~~
<VirtualHost *:80>
    ServerName test-leads.my
	ServerAlias www.test-leads.my
    DocumentRoot "/var/html/test-leads.my/web"
    <Directory "/var/html/test-leads.my/web">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>

<VirtualHost *:80>
    ServerName api.test-leads.my
    DocumentRoot "/var/html/test-leads.my/api/web"
    <Directory "/var/html/test-leads.my/api/web">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
~~~

### Add .htaccess file

Add .htaccess file to both apps paths `/var/html/test-leads.my/web` and `/var/html/test-leads.my/api/web`
```php
<IfModule mod_rewrite.c>
    # use mod_rewrite for pretty URL support
    RewriteEngine on
    
    # If a directory or a file exists, use the request directly
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    # Otherwise forward the request to index.php
    RewriteRule . index.php

    # ...other settings...
</IfModule>
```

You can then access the application through the following URL:

~~~
http://test-leads.my
~~~

### API requests

After you register user in frontend you can access api using token.
Here api request is example. Replace access token GET variable to your user token

~~~
POST /api/withdraw?access-token=rV6LuPQafl_4JHaqWArXAWYWt-_Tjp5c HTTP/1.1
Host: api.test-leads.my
Content-Type: application/json
Cache-Control: no-cache

{
	"sum": 100
}
~~~

Response example

~~~
{
	"sum": 100,
	"balance": 900
}
~~~

Here is the same request PHP code example using curl library

~~~
<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://api.test-leads.my/api/withdraw?access-token=rV6LuPQafl_4JHaqWArXAWYWt-_Tjp5c",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\n\t\"sum\": 100\n}",
  CURLOPT_HTTPHEADER => array(
    "Cache-Control: no-cache",
    "Content-Type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
~~~