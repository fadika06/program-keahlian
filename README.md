# Program Keahlian

[![Join the chat at https://gitter.im/program-keahlian/Lobby](https://badges.gitter.im/program-keahlian/Lobby.svg)](https://gitter.im/program-keahlian/Lobby?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bantenprov/program-keahlian/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bantenprov/program-keahlian/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/bantenprov/program-keahlian/badges/build.png?b=master)](https://scrutinizer-ci.com/g/bantenprov/program-keahlian/build-status/master)
[![Latest Stable Version](https://poser.pugx.org/bantenprov/program-keahlian/v/stable)](https://packagist.org/packages/bantenprov/program-keahlian)
[![Total Downloads](https://poser.pugx.org/bantenprov/program-keahlian/downloads)](https://packagist.org/packages/bantenprov/program-keahlian)
[![Latest Unstable Version](https://poser.pugx.org/bantenprov/program-keahlian/v/unstable)](https://packagist.org/packages/bantenprov/program-keahlian)
[![License](https://poser.pugx.org/bantenprov/program-keahlian/license)](https://packagist.org/packages/bantenprov/program-keahlian)
[![Monthly Downloads](https://poser.pugx.org/bantenprov/program-keahlian/d/monthly)](https://packagist.org/packages/bantenprov/program-keahlian)
[![Daily Downloads](https://poser.pugx.org/bantenprov/program-keahlian/d/daily)](https://packagist.org/packages/bantenprov/program-keahlian)

Program Keahlian

### Install via composer

- Development snapshot

```bash
composer require bantenprov/program-keahlian:dev-master
```

- Latest release:

```bash
composer require bantenprov/program-keahlian
```

### Download via github

```bash
git clone https://github.com/bantenprov/program-keahlian.git

```

#### Edit `config/app.php` :

```php
'providers' => [
    /*
    * Laravel Framework Service Providers...
    */
    Illuminate\Auth\AuthServiceProvider::class,
    Illuminate\Broadcasting\BroadcastServiceProvider::class,
    Illuminate\Bus\BusServiceProvider::class,
    Illuminate\Cache\CacheServiceProvider::class,
    Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
    Illuminate\Cookie\CookieServiceProvider::class,
    //...
    Bantenprov\ProgramKeahlian\ProgramKeahlianServiceProvider::class,
    //...
],
```

#### Edit `app/Http/Kernel.php`

```php
protected $routeMiddleware = [
    'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
    'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
    'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
    'can' => \Illuminate\Auth\Middleware\Authorize::class,
    'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
    'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    //...
    'role' => \Laratrust\Middleware\LaratrustRole::class,
    'permission' => \Laratrust\Middleware\LaratrustPermission::class,
    'ability' => \Laratrust\Middleware\LaratrustAbility::class,
    //...
];
```

#### Lakukan migrate :

```bash
php artisan migrate
```

#### Lakukan publish semua komponen :

```bash
php artisan vendor:publish --tag=program-keahlian-publish
```

#### Lakukan auto dump :

```bash
composer dump-autoload
```

#### Lakukan seeding :

- Seeding semua seeder

```bash
php artisan db:seed --class=BantenprovProgramKeahlianSeeder
```

- Seeding secara individual

```bash
```

#### Edit menu `resources/assets/js/menu.js`

```javascript
{
    name: 'Dashboard',
    icon: 'fa fa-dashboard',
    childType: 'collapse',
    childItem: [
        //...
        // Program Keahlian
        {
            name: 'Program Keahlian',
            link: '/dashboard/program-keahlian',
            icon: 'fa fa-angle-double-right'
        },
        //...
    ]
},
```

```javascript
{
    name: 'Admin',
    icon: 'fa fa-lock',
    childType: 'collapse',
    childItem: [
        //...
        // Program Keahlian
        {
            name: 'Program Keahlian',
            link: '/admin/program-keahlian',
            icon: 'fa fa-angle-double-right'
        },
        //...
    ]
},
```

#### Tambahkan components `resources/assets/js/components.js` :

```javascript
//... Program Keahlian ...//

import ProgramKeahlianAdminShow from '~/components/bantenprov/program-keahlian/program-keahlian/ProgramKeahlianAdmin.show.vue';
Vue.component('program-keahlian-admin', ProgramKeahlianAdminShow);

//... Echarts Program Keahlian ...//

import ProgramKeahlian from '~/components/bantenprov/program-keahlian/program-keahlian/ProgramKeahlian.chart.vue';
Vue.component('program-keahlian-echarts', ProgramKeahlian);

import ProgramKeahlianKota from '~/components/bantenprov/program-keahlian/program-keahlian/ProgramKeahlianKota.chart.vue';
Vue.component('program-keahlian-echarts-kota', ProgramKeahlianKota);

import ProgramKeahlianTahun from '~/components/bantenprov/program-keahlian/program-keahlian/ProgramKeahlianTahun.chart.vue';
Vue.component('program-keahlian-echarts-tahun', ProgramKeahlianTahun);

//... Mini Bar Charts Program Keahlian ...//

import ProgramKeahlianBar01 from '~/components/views/bantenprov/program-keahlian/program-keahlian/ProgramKeahlianBar01.vue';
Vue.component('program-keahlian-bar-01', ProgramKeahlianBar01);

import ProgramKeahlianBar02 from '~/components/views/bantenprov/program-keahlian/program-keahlian/ProgramKeahlianBar02.vue';
Vue.component('program-keahlian-bar-02', ProgramKeahlianBar02);

import ProgramKeahlianBar03 from '~/components/views/bantenprov/program-keahlian/program-keahlian/ProgramKeahlianBar03.vue';
Vue.component('program-keahlian-bar-03', ProgramKeahlianBar03);

//... Mini Pie Charts Program Keahlian ...//

import ProgramKeahlianPie01 from '~/components/views/bantenprov/program-keahlian/program-keahlian/ProgramKeahlianPie01.vue';
Vue.component('program-keahlian-pie-01', ProgramKeahlianPie01);

import ProgramKeahlianPie02 from '~/components/views/bantenprov/program-keahlian/program-keahlian/ProgramKeahlianPie02.vue';
Vue.component('program-keahlian-pie-02', ProgramKeahlianPie02);

import ProgramKeahlianPie03 from '~/components/views/bantenprov/program-keahlian/program-keahlian/ProgramKeahlianPie03.vue';
Vue.component('program-keahlian-pie-03', ProgramKeahlianPie03);
```

#### Tambahkan route di dalam file : `resources/assets/js/routes.js` :

```javascript
{
    path: '/dashboard',
    redirect: '/dashboard/home',
    component: layout('Default'),
    children: [
        //...
        // Program Keahlian
        {
            path: '/dashboard/program-keahlian',
            components: {
                main: resolve => require(['~/components/views/bantenprov/program-keahlian/program-keahlian/ProgramKeahlianDashboard.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Program Keahlian"
            }
        },
        //...
    ]
},
```

```javascript
{
    path: '/admin',
    redirect: '/admin/dashboard/home',
    component: layout('Default'),
    children: [
        //...
        // Program Keahlian
        {
            path: '/admin/program-keahlian',
            components: {
                main: resolve => require(['~/components/bantenprov/program-keahlian/program-keahlian/ProgramKeahlian.index.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Program Keahlian"
            }
        },
        {
            path: '/admin/program-keahlian/create',
            components: {
                main: resolve => require(['~/components/bantenprov/program-keahlian/program-keahlian/ProgramKeahlian.add.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Add Program Keahlian"
            }
        },
        {
            path: '/admin/program-keahlian/:id',
            components: {
                main: resolve => require(['~/components/bantenprov/program-keahlian/program-keahlian/ProgramKeahlian.show.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "View Program Keahlian"
            }
        },
        {
            path: '/admin/program-keahlian/:id/edit',
            components: {
                main: resolve => require(['~/components/bantenprov/program-keahlian/program-keahlian/ProgramKeahlian.edit.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Edit Program Keahlian"
            }
        },
        //...
    ]
},
```
