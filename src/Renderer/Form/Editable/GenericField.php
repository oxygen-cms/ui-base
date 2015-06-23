<?php

namespace Oxygen\UiBase\Renderer\Form\Editable;

class GenericField extends BaseField {

    /**
     * Renders the element.
     *
     * @param object $field     Object to render
     * @param array  $arguments Extra arguments to customize the element.
     * @return string
     */
    public function render($field, array $arguments) {
        return
            $this->getPrefix($field->getMeta()) .
            $this->getInputTag(
                $field->getMeta()->type, // eg: text
                $field->getTransformedOutputValue(),
                html_attributes($this->getFieldAttributes($field->getMeta()))
            );
    }

}