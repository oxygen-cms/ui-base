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
        $labelAttributes['class'] = 'Form-label';

        $labelAttributes['for'] = $label->getMeta()->name;

//        <b-tooltip multilined position="is-right" type="is-dark" label="May be displayed next to the item, or used as alt-text for vision-impaired.">
//                                <b-icon size="is-small" icon="question-circle"></b-icon>
//                            </b-tooltip>

        $return .= '<label ' . html_attributes($labelAttributes) . '>' . $label->getMeta()->label;

        if($label->getMeta()->hasDescription()) {
            $return .= '<span ' . html_attributes(['class' => 'Tooltip', 'data-tooltip' => $label->getMeta()->description]) . '>';
            $return .= '<span class="icon"><span class="fas fa-question-circle"></span></span>';
            $return .= '</span>';
        }

        $return .= '</label>';

        return $return;
    }
}
