<?php

namespace Oxygen\CoreViews\Renderer\Form\Editable;

use Form;

class CheckboxField extends BaseField {

    /**
     * Renders the element.
     *
     * @param object $field    Object to render
     * @param array  $arguments Extra arguments to customize the element.
     * @return string
     */
    public function render($field, array $arguments) {
        $options = $field->getMeta()->options;
        if(!isset($options['off'], $options['on'])) {
            $options['off'] = 'false';
            $options['on'] = 'true';
        }

        $attributes = $this->getFieldAttributes($field->getMeta());

        return
            Form::input('hidden', $field->getMeta()->name, $options['off'], null, $attributes) .
            Form::checkbox($field->getMeta()->name, $options['on'], null, $attributes) .
            Form::label($field->getMeta()->name, $field->getMeta()->label, ['class' => 'Form-checkbox-label flex-item']);
    }
}