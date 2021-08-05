
# VoteNest

A LAN-based voting system web application with facial recognition.

## Installation

Clone the repository first and then perform the steps below.

1. Copy **votingsystem** folder into C:/laragon/www for laragon, or C:/xampp/htdocs if you are using xampp.
2. Create a database named votesystem and import sql file inside votingsystem root. The default username and password is **“admin”**.
3. Edit config/config.php file and enter your database credentials.
4. If you wish to change the name of the folder of your app directory, you should also edit the **.htaccess** file inside the public folder.

```bash
  <IfModule mod_rewrite.c>
    Options -Multiviews
    RewriteEngine On
    RewriteBase /votingsystem/public #Edit this line
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule  ^(.+)$ index.php?url=$1 [QSA,L]
  </IfModule>
```
5. To run facial recognition module, you should install the requirements below:
- Visual Studio 2017 and up
- CMake
- Python 3.7 and up
- Dlib
Please refer to [@masoudr's Windows 10 installation guide (dlib + face_recognition)](https://github.com/ageitgey/face_recognition/issues/175#issue-257710508).

6. After installing python dependencies, open cmd from desktop and run the script:
```bash
  python -m pip install face_recognition
```
7. If you are having an issue about populating pdf forms, it is most likely that your pdf is damaged or corrupted. To fix this, go to the directory where your email is stored, open cmd and run:
```bash
  pdftk raw.pdf output fixed.pdf
```
