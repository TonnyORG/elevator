## Elevator

This is an *improved Elevator test* based on [Laravel 5.5](https://laravel.com/docs/5.5). The idea of this project is to support multiple elevators in a single building and let them handle the guest's request based on an optime response.

#### Technologies

- [Laravel 5.5](https://laravel.com)
- [Bootstrap 4](https://getbootstrap.com)
- [VueJS 2](https://vuejs.org)

### Installation

In order to install this project after clonning it, just execute the following instructions:

1. Create a copy of the *.env* through `cp .env.example .env`.
2. Configure the new *.env* file with your own settings.
3. Install composer vendors through `composer install`.
4. Create the laravel key with `php artisan key:generate`.

## Contribute

Feel free to contribute with any ideas or improvements. In order to do that, you just need to fork this repository under your own GitHub account and send me a pull request so I can merge your changes on the main repository.

### To-Do

There are a few things I would like to add into this project, and a few basic things are a way to view all the requests in real time through an visual panel or something. Based on that, here is the list of To-Dos I can think right now:

- [ ] Build UI to visualize the queue and real time elevator requests.
- [ ] Build tests for models and controllers.

## License

This Elevator project is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
