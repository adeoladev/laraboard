# Laraboard
Imageboard engine written in Laravel and Vue.<br /><br />

<p  align="center">
<img src="https://raw.githubusercontent.com/adeoladev/laraboard/main/public/files/readme.png" width="800" alt="Laraboard Screenshots">
</p>

## Features

* Admin:
    - Create or edit categories and boards
    - Delete or invite new moderators
* Admin & Moderators:
    - Pin, delete or archive threads
    - Browse and delete files
    - IP Banning
* Users:
    - Create threads
    - Reply to threads 
    - Reply to one or multiple other replies
    - Upload files or file links 
    - View files inside threads (Hover-Preview)
    - Search threads

## Cons
- No captcha system
- No greentext or spoilers
- Buggy video uploads (ffmpeg errors)

## Installation
```sh
git clone https://github.com/adeoladev/laraboard.git
cd Laraboard
php artisan migrate:fresh
php artisan laraboard:admin
php artisan serve
npm run build
```
Then navigate to ``http://127.0.0.1:8000/moderation`` in your browser and log into the admin dashboard with "Admin" for the username and "password" for the password to begin building your imageboard.

## License
MIT. Copyright (c) 2023 Adeola Boye.
