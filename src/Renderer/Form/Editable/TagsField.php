<?php

namespace Oxygen\UiBase\Renderer\Form\Editable;

class TagsField extends BaseField {

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
            '<div data-tags-input-name="' . $field->getMeta()->name . '" class="Form-taggable">' . implode(', ', (array) $field->getValue()). '</div>';
    }
}