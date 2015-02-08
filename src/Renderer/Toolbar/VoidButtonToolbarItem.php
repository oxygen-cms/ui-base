<?php

namespace Oxygen\CoreViews\Renderer\Toolbar;

use Illuminate\Html\HtmlBuilder;
use Illuminate\View\Factory as View;

use Oxygen\Core\Html\RendererInterface;

class VoidButtonToolbarItem implements RendererInterface {

    /**
     * The Laravel HTML Builder
     *
     * @var HtmlBuilder
     */

    protected $html;

    /**
     * Injects dependencies into the Renderer.
     *
     * @param HtmlBuilder $html
     */

    public function __construct(HtmlBuilder $html) {
        $this->html = $html;
    }

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
                $return .= '<span class="Icon Icon-' . e($toolbarItem->icon) . ' Icon--pushRight"></span>';
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
            $attributes['class'] = 'MainNav-item MainNav-link';
        } else if($insideDropdown) {
            $attributes['class'] = 'Dropdown-itemContainer Dropdown-item';
        } else {
            $attributes['class'] = 'Button Button-color--' . $toolbarItem->color;
            $addMargins($arguments, $attributes);
        }

        $return = '';

        $return .= '<button ' . $this->html->attributes($attributes) . '>';
        $return .= $renderLabel();
        $return .= '</button>';

        return $return;
    }

}