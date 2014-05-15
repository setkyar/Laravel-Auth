## Laravel Auth

###Why I am creating this?
Most of 99% website need authernication so I had created once a time and aim to use it again and again so :D 

###Featuers
```sh
1) Register
2) Activate Register
3) Sign in
4) Change Password
5) Logout
6) Forgot Password (With Mail Activate)
7) See user profile through username eg.(appurl/username)
```

###Requirements
```sh
PHP 5.4 or above
Composer
Gmail
```

###Configuration

Open cmd in your app directory and run 

##### Composer Install
```sh 
composer install
```

##### Database
First open app/config/database.php and edit for your configuration. As for me I had created `laravel-auth` database with Laravel, so I configure something like following

```sh
'mysql' => array(
			'driver'    => 'mysql',
			'host'      => '127.0.0.1',
			'database'  => 'laravel-auth',
			'username'  => 'root',
			'password'  => '',
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
		),
```
My database username was `root` and password is `empty` so.

##### Migrate
When you had already configure your database so run

```sh
php artisan migrate
```
via from cmd.

##### Mail
To configure mail open app/config/mail.php edit `yourgmail@gmail` to your gmail address and `youremailpassword` to yourgmail password. Other setting in this mail.php I had configure already so.
```sh
'from' => array('address' => 'yourgmail@gmail.com', 'name' => 'Laravel Auth'),

'username' => 'yourgmail@gmail.com',

'password' => 'yourgmailpassword',
```

### Start Development Server
Run 

```sh
php artisan serve
```
from your cmd.

Now your Laravel App was running at

```sh
http://localhost:8000/
```
Tests all the features. If you had someproblem with this please make an issue on this repo. Thanks :)
### License

The Laravel Auth is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
