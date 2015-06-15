<?php

namespace Oxygen\UiBase\Renderer\Form\Display;

class DatetimeField extends GenericField {

    /**
     * Renders the element.
     *
     * @param object $field     Object to render
     * @param array  $arguments Extra arguments to customize the element.
     * @return string
     */
    public function render($field, array $arguments) {
        $value = e($field->getMeta()->getType()->transformOutput($field->getMeta(), $field->getValue()));

        return
            $this->beginContainer() .
            '<code>' .
            (!empty($value)  ? $value : '<small><i>None</i></small>') .
            '</code>' .
            $this->endContainer();
    }

}