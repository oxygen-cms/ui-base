<?php

namespace Oxygen\CoreViews\Renderer\Form\Display;

class TextareaField extends GenericField {

    /**
     * Renders the element.
     *
     * @param object $field     Object to render
     * @param array  $arguments Extra arguments to customize the element.
     * @return string
     */
    public function render($field, array $arguments) {
        $value = e($field->getMeta()->getType()->transformOutput($field->getMeta(), $field->getValue()));

        if(empty($value)) {
            return $this->beginContainer() . '<small><i>None</i></small>' . $this->endContainer();
        }

        return
            $this->beginContainer() .
            '<pre><code>' .
            $value .
            '</pre></code>' .
            $this->endContainer();
    }

}