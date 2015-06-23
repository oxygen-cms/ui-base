<?php

namespace Oxygen\UiBase\Renderer\Form\Display;

class TextareaField extends GenericField {

    /**
     * Renders the element.
     *
     * @param object $field     Object to render
     * @param array  $arguments Extra arguments to customize the element.
     * @return string
     */
    public function render($field, array $arguments) {
        $value = $field->getTransformedOutputValue();

        if(empty($value)) {
            return $this->beginContainer() . '<small><i>None</i></small>' . $this->endContainer();
        }

        return
            $this->beginContainer() .
            '<pre><code>' .
            e($value) .
            '</pre></code>' .
            $this->endContainer();
    }

}