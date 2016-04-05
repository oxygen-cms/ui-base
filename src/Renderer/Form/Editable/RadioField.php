<?php

namespace Oxygen\UiBase\Renderer\Form\Editable;

class RadioField extends BaseField {

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

        $return = '<div>';

        foreach($options as $value => $label) {
            $attributes['id'] = $field->getMeta()->name . '.' . $value;
            $return .= $this->getInputTag('radio', $value, array_merge($attributes, ['name' => $field->getMeta()->name, 'checked' => $this->isSelected($field, $value)]));
            $return .= $this->getLabelTag($field->getMeta()->name . '.' . $value, $label, ['class' => 'flex-item']);
            $return .= '<br>';
        }

        $return .= '</div>';

        return $return;
    }
}