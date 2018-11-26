
## LaraVue Subscribers

A public *subscribers-manager* application based on Laravel 5.7, Vue 2 and Bootstrap 4.

The goal is to allow anyone to create and manage fields and subscribers.

![Preview Subscribers](https://i.imgur.com/QbMFB8s.png)

##### How to install?

- Clone this repository or install it through `composer create-project fullstackmx/laravue-subscribers`.
- Run `composer install --no-dev` for production or `composer install` for local environments.
- Run the migrations `php artisan migrate`.
- Run the seeders `php artisan db:seed`.
- Enjoy!

**Note:** This package is homestead ready so you can use `./vendor/bin/homestead make` to init the `Homestead.yaml` file. For local environments (Vagrant) the domain validation might not work, you need to point the `nameserver` value (`/etc/resolv.conf` file) on your *Virtual Machine* to the actual **router IP** (the same IP used by your host machine).

#### Features

- Unlimited fields supported.
- *NULL* values supported, because I know not all the fields are required.
- Basic validations.
- REST friendly.
- Production and *Homestead* ready.

![Preview Fields](https://i.imgur.com/uzIm17b.png)

## Contributing

Thank you for considering contributing to the project! Feel free to fork this project, work around your improvements or features and send me a PR.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
