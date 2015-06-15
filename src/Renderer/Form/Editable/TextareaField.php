<?php


namespace Oxygen\UiBase\Renderer\Form\Editable;

use Form;

class TextareaField extends BaseField {

    /**
     * Renders the element.
     *
     * @param object $field    Object to render
     * @param array  $arguments Extra arguments to customize the element.
     * @return string
     */
    public function render($field, array $arguments) {
        return
            $this->getPrefix($field->getMeta()) .
            Form::textarea($field->getMeta()->name, $field->getMeta()->getType()->transformOutput($field->getMeta(), $field->getValue()), $this->getFieldAttributes($field->getMeta()));
    }
}