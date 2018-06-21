To create an instance of the volunteers project please take the following steps:

Step 1:

Install Node.js and Composer

Step 2 :  Via Composer Create-Project
Open command prompt (WIndows +C )and copy paste the command:

composer create-project --prefer-dist laravel/laravel volunteers "5.5.*"

Step 3 : run npm install

Step 4 :  Authentication
After execution of step 1, run the command in the same command prompt:

Php artisan make:auth

Step 5 :  Setup .env
Now we have to setup the database connection, for this, go to the following file of the newly created setup:

volunteers/.env

Change the database and email credentials to work in your local environment

Step 6 :  Run Migration
In the command prompt, run the migration to import the tables in the DB:

Php artisan migrate

Step 7 :  Update RegisterController.php

By default, we use NAME in LARAVEL, but we need to use FIRST and LAST NAME here, hence we need to change it in the controller, for this, we need to go to the following file location, and edit it:

volunteers\app\Http\Controllers\Auth\registerController.php

   protected function create(array $data)
   {
       return User::create([
           'first_name' => $data['first_name'],
           'last_name' => $data['last_name'],
           'user_level' => 1,
           'email' => $data['email'],
           'password' => Hash::make($data['password']),
       ]);
   }

 
Step 8 :  Update register.blade.php
To make Previous step take effect, we need to update the view file as well, which is in:

volunteers\resources\views\auth\register.blade.php

Step 9 :  Serve the project

Now run php artisan serve to run the project (or use XAMPP or WampServer)
