<?php

namespace Oxygen\UiBase\Renderer\Toolbar;

use Oxygen\Core\Html\RendererInterface;

class VoidButtonToolbarItem implements RendererInterface {

    /**
     * Renders the element.
     *
     * @param object $toolbarItem Object to render
     * @param array $arguments Extra arguments to customize the element.
     * @return string Rendered HTML
     */
    public function render($toolbarItem, array $arguments) {
        $insideMainNav = isset($arguments['insideMainNav']) && $arguments['insideMainNav'] === true;
        $insideDropdown = isset($arguments['insideDropdown']) && $arguments['insideDropdown'] === true;

        $renderLabel = function() use($toolbarItem, $insideMainNav) {
            $return = '';

            if($toolbarItem->icon !== null && !$insideMainNav) {
                $return .= '<span class="fa fa-' . e($toolbarItem->icon) . ' Icon--pushRight"></span>';
            }
            $return .= e($toolbarItem->label);
            return $return;
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
            $attributes['class'] = 'MainNav-link';
        } else if($insideDropdown) {
            $attributes['class'] = 'Dropdown-itemContainer Dropdown-item';
        } else {
            $attributes['class'] = 'Button Button-color--' . $toolbarItem->color;
            $addMargins($arguments, $attributes);
        }

        $return = '';

        $return .= '<button ' . html_attributes($attributes) . '>';
        $return .= $renderLabel();
        $return .= '</button>';

        return $return;
    }

}