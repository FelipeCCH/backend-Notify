@echo off
cd C:\laragon\www\notify
php artisan schedule:run >> storage\logs\schedule.log
