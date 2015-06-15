<?php

namespace Oxygen\UiBase\Renderer\Form\Editable;

use Form;

class ToggleField extends BaseField {

    /**
     * Renders the element.
     *
     * @param object $field    Object to render
     * @param array  $arguments Extra arguments to customize the element.
     * @return string
     */
    public function render($field, array $arguments) {
        $attributes = $this->getFieldAttributes($field->getMeta());

        $labels = isset($attributes['labels']) ? $attributes['labels'] : ['on' => 'On', 'off' => 'Off'];
        unset($attributes['labels']);

        $options = $field->getMeta()->options;
        if(!isset($options['off'], $options['on'])) {
            $options['off'] = 'false';
            $options['on'] = 'true';
        }

        $hiddenAttributes = $attributes;
        unset($hiddenAttributes['id']);

        $return = '';

        $return .= Form::input('hidden', $field->getMeta()->name, $options['off'], $hiddenAttributes);
        $attributes['class'] .= ' Form-toggle';
        $return .= Form::checkbox($field->getMeta()->name, $options['on'], $field->getValue(), $attributes);

        $return .= '<label for="' . $field->getMeta()->name . '" class="Form-toggle-label">';
        $return .= '<span class="on">' . $labels['on'] . '</span>';
        $return .= '<span class="off">' . $labels['off'] . '</span>';
        $return .= '</label>';

        return $return;
    }
}