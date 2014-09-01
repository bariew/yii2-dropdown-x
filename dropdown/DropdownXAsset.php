<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013
 * @package yii2-context-menu
 * @version 1.0.0
 */

namespace bariew\dropdown;

use yii\web\AssetBundle;

/**
 * DropdownX bundle for \bariew\dropdown\DropdownX
 *
 * @author Kartik Visweswaran <bariewv2@gmail.com>
 * @since 1.0
 */
class DropdownXAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bariew/yii2-dropdown-x/assets/';
    public $js = [
        'js/dropdown-x.js',
    ];
    public $css = [
        'css/dropdown-x.css',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}