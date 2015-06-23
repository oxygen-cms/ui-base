<?php


namespace Oxygen\UiBase\Renderer\Form\Editable;

use Form;

class SelectField extends BaseField {

    /**
     * Renders the element.
     *
     * @param object $field    Object to render
     * @param array  $arguments Extra arguments to customize the element.
     * @return string
     */
    public function render($field, array $arguments) {
        $options = $field->getMeta()->options;
        if(is_callable($options)) {
            $options = $options();
        }

        return $this->getSelectTag($options, $field->getValue(), $this->getFieldAttributes($field->getMeta()));
    }

}