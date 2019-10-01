Installation notes:


Technology stack:

  These software must be at your system: Apache2 PHP7.xx MySQL 5.xx PHP Composer


 The installation step by step


 1.Download files of project to folder at the web server:

 /var/www/project


  2.Go to the terminal and print this command at the folder of project:

   cd app

  sudo chmod -R 777 storage  

  3. at the same folder:

   sudo composer install 

   4. Then launch there:

   sudo php artisan key:generate

   5. Then open at the editor file .env

   and edit there database connection settings:

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=yourdatabasename
   DB_USERNAME=yourdbusername
   DB_PASSWORD=yourdbpassword

   6. Run commands at the project folder:

   sudo php artisan make:auth

   sudo php artisan migrate 




   That's all