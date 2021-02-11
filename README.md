# Final_Submit
My Technical challenge DOCUMENTATION

Files:

-index.php : First page to Login or register

-doclist.php: Page where documents Can be uploaded,dowloaded and deleted

-main.js: handles the server request for the Login and logout and register

-php/Upload.php: Server scripts to UPload,Download and delete files

-php/register.php: Server scripts to register a user

-php/login.php: Server scripts to login a user

-php/logout.php:  scripts to register a user

1- launch :https://www.gamesrup.com/Tech_challenge/index.php

2- register: Register your account and save credential to browser if asked. make sure the second password matches the other

3- Login: login with the credentials you just registered,if you had saved those in the previous step just load it in the fields

4- Add File : in the Navbar click on add file and its going to prompt and Upload form chose your files from your computer and click Upload.
   You should see your file in the list of documents.
5- Delete: only the files you Uploaded can be deleted

6- Dowload: you can Downlaod any file from the platform

Threat handling: I handled csrf by adding csrf token to my post and which needs to be validated on server side
                 For SQL injection i Used Prepared statement and Escaping strings before they are added to query
PHP 5.6.4
