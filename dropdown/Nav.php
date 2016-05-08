<?php
/**
 * Nav class file.
 * @copyright (c) 2016, Pavel Bariev
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\dropdown;

use yii\base\InvalidConfigException;
use \yii\bootstrap\Nav as MainNav;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Generates multiple level dropdown menu.
 * @author Pavel Bariev <bariew@yandex.ru>
 */
class Nav extends MainNav
{
    public $options = ['class' => ''];
    public $direction = 'right';
    public $itemOptions = [];

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->direction == 'left') {
            $this->options['class'] .= ' drop-left';
        }
        $itemTree = $this->generateItemsTree($this->items);
        $this->items = $this->createItems($itemTree);
        return parent::run();
    }

    /**
     * Recursively generates menu items.
     * @param array $items Menu Items array
     * @return array menu items
     */
    protected function createItems($items)
    {
        $result = [];
        foreach ($items as $item) {
            $data = [
                'label' => $item['name'],
                'url'   => [$item['url']],
                'options' => $this->itemOptions
            ];
            if (isset($item['childrenTree']) && $item['childrenTree']) {
                $data['items'] = $this->createItems($item['childrenTree']);
            }
            $result[] = $data;
        }
        return $result;
    }

    /**
     * Makes tree from menu items.
     * @param array $items menu items.
     * @return array menu items tree.
     */
    protected function generateItemsTree($items)
    {
        $result = [];
        foreach ($items as $key => $item) {
            $items[$key]['childrenTree'] = @$items[$key]['childrenTree'] ? : [];
            if(!$item['parent_id']) {
                $result[$key] = &$items[$key];
            } else if(isset($items[$item['parent_id']])) {
                $items[$item['parent_id']]['childrenTree'] = @$items[$item['parent_id']]['childrenTree'] ? : [];
                $children = $items[$item['parent_id']]['childrenTree'];
                $children[$key] = &$items[$key];
                $items[$item['parent_id']]['childrenTree'] = $children;
            }
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function renderItem($item)
    {
        if (is_string($item)) {
            return $item;
        }
        if (!isset($item['label'])) {
            throw new InvalidConfigException("The 'label' option is required.");
        }
        $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
        $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
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
            $label .= ' ' . Html::tag('b', '', ['class' => 'caret']);
            if (is_array($items)) {
                if ($this->activateItems) {
                    $items = $this->isChildActive($items, $active);
                }
                // here is the difference
                $items = DropdownX::widget([
                    'items' => $items,
                    'encodeLabels' => $this->encodeLabels,
                    'clientOptions' => false,
                    'view' => $this->getView(),
                ]);
            }
        }

        if ($this->activateItems && $active) {
            Html::addCssClass($options, 'active');
        }

        return Html::tag('li', Html::a($label, $url, $linkOptions) . $items, $options);
    }

    /**
     * @inheritdoc
     */
    protected function isChildActive($items, &$active)
    {
        foreach ($items as $i => $child) {
            if (ArrayHelper::remove($items[$i], 'active', false) || $this->isItemActive($child)) {
                Html::addCssClass($items[$i]['options'], 'active');
                if ($this->activateParents) {
                    $active = true;
                }
            }
            if (isset ($items[$i]['items'])) {
                $items[$i]['items'] = $this->isChildActive($items[$i]['items'], $child);
            }
        }
        return $items;
    }
}
