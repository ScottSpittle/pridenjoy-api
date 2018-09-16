# Lumen API Starter

A starter project to develop API with Lumen 5.4.

The starter project has been updated and this is **version 2.0**. This is completely rewritten from the scratch and removed a few packages from the older version.
If you want to see the **version 1.0** then checkout [v1.0 branch](https://github.com/munza/lumen-api-starter/tree/v1.0).

### Included Packages
- [filp/whoops@^2.1](https://github.com/filp/whoops)
- [tymon/jwt-auth@1.0.0-beta.3](https://github.com/tymondesigns/jwt-auth)
- [league/fractal@^0.16.0](https://github.com/thephpleague/fractal)
- [barryvdh/laravel-cors@^0.9.2](https://github.com/barryvdh/laravel-cors)
- [flipbox/lumen-generator@^5.4](https://github.com/flipboxstudio/lumen-generator)

### Installation

- Clone the Repo:
    - `git clone git@github.com:munza/lumen-api-starter.git`
    - `git clone https://github.com/munza/lumen-api-starter.git`
- `cd lumen-api-starter`
- `composer create-project`
- `php artisan key:generate`
- `php artisan jwt:secret`
- `php artisan migrate`
- `php artisan serve`

#### Create new user

- `php artisan ti`
- `factory('App\User')->create(['email' => 'admin@lumen.dev', 'password' => 'secret'])`

### Configuration

- Edit `.env` file for database connection configuration.
- Edit `config/app.php`
    - `providers` to register service provider
    - `middlewares` to register request middlewares
    - `routeMiddlewares` to register route middlewares
- Edit `config/cors.php` for CORS configuration.
- Edit `config/jsw.php` for JWT-Auth configuration.
- Edit `config/exception.php` for registering exception handlers.

### Usage

#### Adding a new resource endpoint

- Add endpoint in `routes/api.php`.

    ```php
        $app->group(['middleware' => 'jwt.auth'], function() use ($app) {
            $app->get('/users', 'UserController@index');
        });
    ```

- Add controller with `php artisan make:controller {name}` command

- Add model at `php artisan make:model {name}`

- Add repository at `app/Repositories` directory.

    ```php
        <?php

        namespace App\Repositories;

        class UserRepository extends EloquentRepository
        {
            /**
             * Specify model instance.
             *
             * @return string
             */
            public function model()
            {
                return new \App\User;
            }
        }
    ```

- Add transformers at `app/Transformers` directory.

    ```php
        <?php

        namespace App\Transformers;

        user App\User;
        use League\Fractal\TransformerAbstract;

        class UserTransformer extends TransformerAbstract
        {
            /**
             * Transform object to array.
             *
             * @param  \App\User $user
             * @return array
             */
            public function transform(User $user)
            {
                return [
                    'id' => (int) $user->id,
                    'email' => (string) $user->email,
                ];
            }
        }
    ```

- Render JSON in controllers

    ```php
        <?php

        namespace App\Http\Controllers;

        user App\Repositories\UserRepository;

        class UserController extends Controller
        {
            /**
             * UserController constructor.

             * @param \App\Repositories\UserRepository $userRepository
             */
            public function __construct(UserRepository $userRepository)
            {
                $this->userRepository = $userRepository;
            }

            /**
             * List of all users.
             *
             * @return \Illuminate\Http\Response
             */
            public function index()
            {
                return response()->json(
                    $this->userRepository->all()
                );
            }
        }
    ```

- Add custom exception handler at `app/Exceptions\Handlers` directory.

    ```php
        <?php

        namespace App\Exceptions\Handlers;

        class CustomExceptionHandler extends BaseHandler
        {
            /**
             * Handle the exception.
             *
             * @return mixed
             */
            public function handle()
            {
                return response()->json([
                    'errors' => [
                        'status' => $this->exception->getStatusCode(),
                        'title' => $this->exception->getMessage() ?: "Custom Error Message",
                    ],
                ], $this->exception->getStatusCode());
            }

            /**
             * @inheritDoc
             */
            protected function isCatchable()
            {
                return $this->exception instanceof CustomException;
            }
        }
    ```

### Issues

Please create an issue if you find any bug or error.

### Contribution

Feel free to make a pull request if you want to add anything.

### License

MIT
