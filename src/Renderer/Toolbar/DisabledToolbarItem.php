<?php

namespace Oxygen\UiBase\Renderer\Toolbar;

use Oxygen\Core\Html\RendererInterface;

class DisabledToolbarItem implements RendererInterface {

    /**
     * Renders the element.
     *
     * @param object $object Object to render
     * @param array $arguments Extra arguments to customize the element.
     * @return string Rendered HTML
     */
    public function render($object, array $arguments) {
        $attributes = [
            'class' => 'Button',
            'disabled' => true
        ];

        if(isset($arguments['margin'])) {
            if($arguments['margin'] === 'vertical') {
                $attributes['class'] .= ' Button-margin--vertical';
            } else if($arguments['margin'] === 'horizontal') {
                $attributes['class'] .= ' Button-margin--horizontal';
            }
        }

        return '<button ' . html_attributes($attributes) . '>' . $object->label . '</button>';
    }

}