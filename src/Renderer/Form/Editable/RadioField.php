<?php

namespace Oxygen\UiBase\Renderer\Form\Editable;

use Form;

class RadioField extends BaseField {

    /**
     * Renders the element.
     *
     * @param object $field    Object to render
     * @param array  $arguments Extra arguments to customize the element.
     * @return string
     */
    public function render($field, array $arguments) {
        $options = $field->getMeta()->options;
        if(is_callable($options)) {
            $options = $options();
        }

        $return = '';

        foreach($options as $value => $label) {
            $attributes['id'] = $field->getMeta()->name . '.' . $value;
            $return .= Form::radio($field->getMeta()->name, $value, $field->getValue() === $value, $attributes);
            $return .= Form::label($field->getMeta()->name . '.' . $value, $label);
            $return .= '<br>';
        }

        return $return;
    }
}