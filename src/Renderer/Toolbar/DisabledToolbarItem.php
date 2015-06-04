<?php

namespace Oxygen\CoreViews\Renderer\Toolbar;

use HTML;

use Oxygen\Core\Html\RendererInterface;

class DisabledToolbarItem implements RendererInterface {

    /**
     * Renders the element.
     *
     * @param object $object Object to render
     * @param array arguments Extra arguments to customize the element.
     * @return string Rendered HTML
     */
    public function render($object, array $arguments) {
        $attributes = [
            'class' => 'Button',
            'disabled'
        ];

        if(isset($arguments['margin'])) {
            if($arguments['margin'] === 'vertical') {
                $attributes['class'] .= ' Button-margin--vertical';
            } else if($arguments['margin'] === 'horizontal') {
                $attributes['class'] .= ' Button-margin--horizontal';
            }
        }

        return '<button ' . HTML::attributes($attributes) . '>' . $object->label . '</button>';
    }

}