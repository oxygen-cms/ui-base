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
            $this->getTextareaTag($field->getTransformedOutputValue(), $this->getFieldAttributes($field->getMeta()));
    }
}