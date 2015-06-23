<?php

namespace Oxygen\UiBase\Renderer\Form\Display;

class SelectField extends GenericField {

    /**
     * Renders the element.
     *
     * @param object $field     Object to render
     * @param array  $arguments Extra arguments to customize the element.
     * @return string
     */
    public function render($field, array $arguments) {
        $value = $field->getTransformedOutputValue();
        $value = isset($field->getMeta()->options[$value]) ? $field->getMeta()->options[$value] : $value;

        return
            $this->beginContainer() .
            e($value) .
            $this->endContainer();
    }

}