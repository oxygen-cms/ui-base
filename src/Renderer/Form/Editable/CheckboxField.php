<?php

namespace Oxygen\UiBase\Renderer\Form\Editable;

use Oxygen\Core\Html\Form\Field;

class CheckboxField extends BaseField {

    /**
     * Renders the element.
     *
     * @param object $field    Object to render
     * @param array  $arguments Extra arguments to customize the element.
     * @return string
     */
    public function render($field, array $arguments) {
        $options = $field->getMeta()->options;
        if(!isset($options['off'], $options['on'])) {
            $options['off'] = 'false';
            $options['on'] = 'true';
        }

        $attributes = $this->getFieldAttributes($field->getMeta());

        return
            $this->getInputTag('hidden', $options['off'], array_merge($attributes, ['id' => null])) .
            $this->getInputTag('checkbox', $options['on'], array_merge($attributes, ['checked' => $this->isSelected($field, $options['on'])])) .
            $this->getLabelTag($field->getMeta()->name, $field->getMeta()->label, ['class' => 'Form-checkbox-label flex-item']);
    }

}