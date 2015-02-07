<?php

namespace Oxygen\CoreViews\Renderer\Form\Editable;

use Form;

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
            Form::input($field->getMeta()->type, $field->getMeta()->name, $field->getMeta()->getType()->transformOutput($field->getMeta(), $field->getValue()), $this->getFieldAttributes($field->getMeta()));
    }

}