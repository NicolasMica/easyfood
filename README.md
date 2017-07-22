# EasyFood experiment
### Setup
```shell
git clone https://github.com/NicolasMica/easyfood.git
cd ./easyfood
# Install composer dependencies
composer install
# Install npm dependencies
npm install
```
Update the **config/app.php** config file

Using laravel-mix
```shell
# Build dev assets
npm run dev
# Hot reloading
npm run hot
# Build production assets
npm run production
```
### Built with
- [PHP](http://php.net)
- [MySQL](https://mysql.com)
- [CakePHP 3.4.5](https://cakephp.org)
- [VueJs](https://vuejs.org)
- [Materialize](http://materializecss.com)
- [Flexbox Grid](http://flexboxgrid.com)
- [Laravel Mix](https://github.com/JeffreyWay/laravel-mix)

## Demonstration
Live demo https://nicolas.micallef.pro/easyfood (sorry the website isn't translated)
### Featuring
- Reactive (multi criteria) dishes filtering
- Cart managment
- Registering, login (/w cookies), logout, password recover, profile managment
- Order history, order reviews
- Restaurants CRUD (restaurant owner)
- Dishes CRUD (restaurant owner)
- Admin panel (validate reviews & dishes)
### Demo credentials

#### Customer
- **Login:** client@easyfood.dev
- **Password:** demodemo
#### Restaurant owner
- **Login:** restaurateur@easyfood.dev
- **Password:** demodemo
#### Moderator
- **Login:** moderateur@easyfood.dev
- **Password:** demodemo
#### Admin
- **Login:** admin@easyfood.dev
- **Password:** demodemo
