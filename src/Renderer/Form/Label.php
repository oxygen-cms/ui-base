<?php

namespace Oxygen\UiBase\Renderer\Form;

use Oxygen\Core\Html\RendererInterface;

class Label implements RendererInterface {

    /**
     * Renders the element.
     *
     * @param object $label     Object to render
     * @param array  $arguments Extra arguments to customize the element.
     * @return string
     */
    public function render($label, array $arguments) {
        $return = '';

        $labelAttributes = [];
        if(!$label->getMeta()->hasDescription()) {
            $labelAttributes['class'] = 'Form-label';
        }

        $labelAttributes['for'] = $label->getMeta()->name;

        if($label->getMeta()->hasDescription()) {
            $return .= '<span ' . html_attributes(['class' => 'Form-label Tooltip', 'data-tooltip' => $label->getMeta()->description]) . '>';
        }

        $return .= '<label ' . html_attributes($labelAttributes) . '>' . $label->getMeta()->label . '</label>';

        if($label->getMeta()->hasDescription()) {
            $return .= '</span>';
        }

        return $return;
    }
}
