<?php

namespace Oxygen\UiBase\Renderer\Form;

use Oxygen\Core\Html\RendererInterface;

class Row implements RendererInterface {

    /**
     * Renders the element.
     *
     * @param object $row    Object to render
     * @param array  $arguments Extra arguments to customize the element.
     * @return string
     */
    public function render($row, array $arguments) {
        $return = '';

        $classes = ['Row'];
        if($row->isFooter) {
            $classes[] = 'Form-footer';
        }
        foreach($row->getExtraClasses() as $class) {
            $classes[] = $class;
        }

        $attributes = ['class' => implode(' ', $classes)];

        $return .= '<div ' . html_attributes($attributes) . '>';

        foreach($row->getItems() as $item) {

            $return .= is_string($item) ? $item : $item->render([]);
        }

        $return .= '</div>';

        return $return;
    }
}