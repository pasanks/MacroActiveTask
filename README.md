<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Setup Information

Project is being uploaded to github. The setup instructions as follows.
- Clone the repository from - https://github.com/pasanks/MacroActiveTask.git.
- Navigate to the cloned project.
- Run "composer install.
- Add the .env file and change DB information accordingly.
- Run "php artisan migrate".
- Run "php artisan key:generate".
- To work emails properly you have to update related SMTP settings in the .env  
- You may need to configure some permissions. Directories within the storage and the bootstrap/cache directories should be writable by your web server or Laravel will not run.



## Known Limitations and Issues

There are some known limitations and issues that SHOULD be addressed.
- When user uploading the file we need to validate it for a compatible audio format 
  (Ex : trying to convert an image will throw errors).
- Currently, I have only implemented required field validation (need to work on backend validations for form fields).  
- In cloud convert service live account there is a rate limit concern and also sometimes it may take a while to convert 
  the file.
- This delay and rate limits will directly affect to user experience therefore, I'm suggesting to dispatch all user 
  convert requests to a queue and process them accordingly and notify users after the job completion for better user
  experience.
- At the moment for failed jobs users don't have any option to re-run them.
- For output files, it is better to upload them to a cloud storage and store other than storing it inside our laravel
  project.
- Unit tests should be implemented.
- Since I'm not that familiar with JS frontend frameworks, I used bootstrap for the frontend.


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
