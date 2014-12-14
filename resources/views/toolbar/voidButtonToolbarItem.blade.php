 <?php

    $insideMainNav = isset($arguments['insideMainNav']) && $arguments['insideMainNav'] === true;
    $insideDropdown = isset($arguments['insideDropdown']) && $arguments['insideDropdown'] === true;

    $renderLabel = function() use($toolbarItem, $insideMainNav) {
        if($toolbarItem->icon !== null && !$insideMainNav) {
            echo '<span class="Icon Icon-' . e($toolbarItem->icon) . ' Icon--pushRight"></span>';
        }
        echo e($toolbarItem->label);
    };

    $addMargins = function($arguments, &$attributes) {
        if(!isset($arguments['margin'])) {
            return;
        }
        if($arguments['margin'] === 'vertical') {
            $attributes['class'] .= ' Button-margin--vertical';
        } else if($arguments['margin'] === 'horizontal') {
            $attributes['class'] .= ' Button-margin--horizontal';
        }
    };

    $attributes = $toolbarItem->hasDialog() ? $toolbarItem->dialog->render() : [];
    $attributes['type'] = 'button';

    if($insideMainNav) {
        $attributes['class'] = 'MainNav-item MainNav-link';
    } else if($insideDropdown) {
        $attributes['class'] = 'Dropdown-itemContainer Dropdown-item';
    } else {
        $attributes['class'] = 'Button Button-color--' . $toolbarItem->color;
        $addMargins($arguments, $attributes);
    }

    echo '<button ' . HTML::attributes($attributes) . '>';
    echo $renderLabel();
    echo '</button>';