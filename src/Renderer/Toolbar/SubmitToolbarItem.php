<?php

namespace Oxygen\UiBase\Renderer\Toolbar;

use Oxygen\Core\Html\RendererInterface;

class SubmitToolbarItem implements RendererInterface {

    /**
     * Renders the element.
     *
     * @param object $button    Object to render
     * @param array  $arguments Extra arguments to customize the element.
     * @return string
     */
    public function render($button, array $arguments) {
        $classes = ['Button', 'Button-color--' . $button->color, 'Form-submit'];
        if($button->stretch) {
            $classes[] = 'Button--stretch';
        }
        $attributes = $button->hasDialog() ? $button->dialog->render() : [];

        $attributes['type'] = 'submit';
        $attributes['class'] = implode(' ', $classes);
        return '<button ' . html_attributes($attributes) . '>' . e($button->label) . '</button>';
    }
}