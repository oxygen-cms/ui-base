<?php

namespace Oxygen\UiBase\Renderer\Form\Editable;

class ToggleField extends BaseField {

    /**
     * Renders the element.
     *
     * @param object $field    Object to render
     * @param array  $arguments Extra arguments to customize the element.
     * @return string
     */
    public function render($field, array $arguments) {
        $attributes = $this->getFieldAttributes($field->getMeta());

        $labels = isset($attributes['labels']) ? $attributes['labels'] : ['on' => 'On', 'off' => 'Off'];
        unset($attributes['labels']);

        $options = $field->getMeta()->options;
        if(!isset($options['off'], $options['on'])) {
            $options['off'] = 'false';
            $options['on'] = 'true';
        }

        $hiddenAttributes = $attributes;
        unset($hiddenAttributes['id']);

        $return = '';

        $return .= $this->getInputTag('hidden', $options['off'], $hiddenAttributes);
        $attributes['class'] .= ' Form-toggle';
        $return .= $this->getInputTag('checkbox', $options['on'], array_merge($attributes, ['checked' => $this->isSelected($field, $options['on'])]));

        $return .= '<label for="' . $field->getMeta()->name . '" class="Form-toggle-label">';
        $return .= '<span class="on">' . $labels['on'] . '</span>';
        $return .= '<span class="off">' . $labels['off'] . '</span>';
        $return .= '</label>';

        return $return;
    }
}