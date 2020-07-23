<?php 

if(!empty($_POST['sub_domain'])){
//echo $_POST['sub_domain'];die;
$sudomain = $_POST['sub_domain'].".domain.com";
$dir1 = "/etc/nginx/sites-available/";
$dir2 = "/etc/nginx/sites-enabled/";
$dir_sub = "/var/www/html/".$sudomain;
$name_file_dir_sub = $dir_sub."/index.html";
$name = $dir1.$sudomain;
$uri = "$"."uri";
$args = "$"."args";
$content = "
	server {
	listen 80;
	listen [::]:80;
	root ".$dir_sub.";
	index index.php index.html index.htm index.nginx-debian.html;
	server_name ".$sudomain." wwww.".$sudomain.";
	location / {
	# First attempt to serve request as file, then
	# as directory, then fall back to displaying a 404.
	try_files $uri $uri/ =404;
	#try_files $uri $uri/ /index.php?$args ;
	}
	location ~ .php$ {
	include snippets/fastcgi-php.conf;
	fastcgi_pass unix:/run/php/php7.2-fpm.sock;
	}
}";
$myfile = fopen($name, "w") or die("Unable to open file!");
fwrite($myfile, $content);
fclose($myfile);
$ln = "ln -s ".$dir1.$sudomain." ".$dir2.$sudomain;
shell_exec($ln);
shell_exec("mkdir ".$dir_sub);

	$content_sub = "Subdomain:<h1 style='color:green'>".$sudomain."</h1>";
	$myfile2 = fopen($name_file_dir_sub, "w") or die("Unable to open file!");
	fwrite($myfile2, $content_sub);
	fclose($myfile2);
	//shell_exec("sudo /usr/sbin/service nginx reload");
	exec("sudo /usr/sbin/service nginx reload");
	//shell_exec("service nginx restart");
	$this->set('check',1);
}