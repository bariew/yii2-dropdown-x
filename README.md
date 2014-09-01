yii2-dropdown-x
=================

An extended bootstrap dropdown widget for Yii Framework 2 with submenu drilldown. This widget extends the `\yii\bootstrap\Dropdown` widget
with some additional controls and adds CSS and JS for enabling a submenu drilldown. The dropdown menu style is optimized for both desktop 
and mobile devices. The drilldown is triggered on `active` instead of `hover` so that it works equally well on mobile devices.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

> Note: You must set the `minimum-stability` to `dev` in the **composer.json** file in your application root folder before installation of this extension.

Either run

```
$ php composer.phar require bariew/yii2-dropdown-x "dev-master"
```

or add

```
"bariew/yii2-dropdown-x": "dev-master"
```

to the ```require``` section of your `composer.json` file.

## Usage

### DropdownX

```php
use bariew\dropdown\DropdownX;
echo DropdownX::widget([
    'items' => [
        ['label' => 'Action', 'url' => '#'],
        ['label' => 'Submenu', 'items' => [
            ['label' => 'Action', 'url' => '#'],
            ['label' => 'Another action', 'url' => '#'],
            ['label' => 'Something else here', 'url' => '#'],
        ]],
        ['label' => 'Something else here', 'url' => '#'],
        '<li class="divider"></li>',
        ['label' => 'Separated link', 'url' => '#'],
    ],
]); 
```

## License

**yii2-dropdown-x** is released under the BSD 3-Clause License. See the bundled `LICENSE.md` for details.