<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package yii2-dropdown-x
 * @version 1.0.0
 */

namespace kartik\nav;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * An extended nav menu for Bootstrap 3 - that offers
 * submenu drilldown
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class NavX extends \yii\bootstrap\Nav
{
    /**
     * @var string the class name to render the Dropdown items.
     * Defaults to `\kartik\dropdown\DropdownX`.
     */
    public $dropdownClass = '\kartik\dropdown\DropdownX';
    
    /**
     * @var array the dropdown widget options
     */
    public $dropdownOptions = [];
    
    /**
     * @var string the caret indicator to display for dropdowns
     */
    public $dropdownIndicator = ' <span class="caret"></span>';
    
    /**
     * Renders a widget's item.
     * @param string|array $item the item to render.
     * @return string the rendering result.
     * @throws InvalidConfigException
     */
    public function renderItem($item)
    {
        if (is_string($item)) {
            return $item;
        }
        if (!isset($item['label'])) {
            throw new InvalidConfigException("The 'label' option is required.");
        }
        $label = $this->encodeLabels ? Html::encode($item['label']) : $item['label'];
        $options = ArrayHelper::getValue($item, 'options', []);
        $items = ArrayHelper::getValue($item, 'items');
        $url = ArrayHelper::getValue($item, 'url', '#');
        $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);

        if (isset($item['active'])) {
            $active = ArrayHelper::remove($item, 'active', false);
        } else {
            $active = $this->isItemActive($item);
        }

        if ($items !== null) {
            $linkOptions['data-toggle'] = 'dropdown';
            Html::addCssClass($options, 'dropdown');
            Html::addCssClass($linkOptions, 'dropdown-toggle');
            $label .= $this->dropdownIndicator;
            if (is_array($items)) {
                if ($this->activateItems) {
                    $items = $this->isChildActive($items, $active);
                }
                $dropdown = $this->dropdownClass;
                $items = $dropdown::widget([
                    'items' => $items,
                    'encodeLabels' => $this->encodeLabels,
                    'clientOptions' => false,
                    'view' => $this->getView(),
                ] + $this->dropdownOptions);
            }
        }

        if ($this->activateItems && $active) {
            Html::addCssClass($options, 'active');
        }

        return Html::tag('li', Html::a($label, $url, $linkOptions) . $items, $options);
    }
}