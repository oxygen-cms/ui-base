<?php

namespace Oxygen\CoreViews\Renderer\Form\Display;

use Oxygen\Core\Html\RendererInterface;

class GenericField implements RendererInterface {

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
            (!empty($value)  ? $value : '<small><i>None</i></small>') .
            $this->endContainer();
    }

    protected function beginContainer() {
        return '<div class="Form-content flex-item">';
    }

    protected function endContainer() {
        return '</div>';
    }

}