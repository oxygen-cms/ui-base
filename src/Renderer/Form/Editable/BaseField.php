<?php

namespace Oxygen\UiBase\Renderer\Form\Editable;

use Oxygen\Core\Form\FieldMetadata;
use Oxygen\Core\Html\Form\Field;
use Oxygen\Core\Html\RendererInterface;

abstract class BaseField implements RendererInterface {

    protected function getFieldAttributes(FieldMetadata $meta) {
        $defaultAttributes = [];
        $defaultClass = 'Form-content flex-item';

        $attributes = array_merge($defaultAttributes, $meta->attributes);

        if(isset($attributes['class'])) {
            $attributes['class'] .= ' ' . $defaultClass;
        } else {
            $attributes['class'] = $defaultClass;
        }
        $attributes['id'] = $meta->name;
        $attributes['name'] = $meta->name;
        $attributes['placeholder'] = $meta->placeholder;

        if($meta->datalist !== null) {
            $attributes['list'] = $meta->name . '-datalist';
        }

        return $attributes;
    }

    protected function getPrefix(FieldMetadata $meta) {
        if($meta->datalist === null) {
            return '';

        }

        $return = '<datalist id="' . $meta->name . '-datalist">';
        foreach($meta->datalist as $value):
            $return .= '<option value="' .  $value . '">' . "\n";
        endforeach;
        $return .= '</datalist>';

        return $return;
    }

    protected function getInputTag($type, $value, array $attributes) {
        return '<input type="' . e($type) . '" value="' . e($value) . '" ' . html_attributes($attributes) . '>';
    }

    protected function getLabelTag($name, $value, array $attributes) {
        return '<label for="' . e($name) . '" ' . html_attributes($attributes) . '>' . e($value) . '</label>';
    }

    /**
     * Renders the HTML for a select tag, complete with all its options and the current value selected
     *
     * @param $options
     * @param $selected
     * @param $attributes
     * @return string
     */
    protected function getSelectTag(array $options, $selected, array $attributes) {
        $list = [];
        foreach ($options as $value => $display) {
            $list[] = $this->getSelectOption($display, $value, $selected);
        }

        $list = implode('', $list);

        return '<select' . html_attributes($attributes) . '>' . $list . '</select>';
    }

    protected function getSelectOption($displayName, $value, $selected) {
        if (is_array($displayName)) {
            return $this->getSelectOptionGroup($displayName, $value, $selected);
        }

        $selected = $this->getSelectedValue($value, $selected);
        $attributes = ['value' => $value, 'selected' => $selected];
        return '<option' . html_attributes($attributes) . '>' . e($displayName) . '</option>';
    }

    protected function getSelectOptionGroup($list, $label, $selected) {
        $html = [];
        foreach ($list as $value => $display) {
            $html[] = $this->getSelectOption($display, $value, $selected);
        }

        return '<optgroup label="'.e($label).'">' . implode('', $html) . '</optgroup>';
    }

    protected function getSelectedValue($value, $selected) {
        if (is_array($selected)) {
            return in_array($value, $selected) ? 'selected' : null;
        }
        return ((string) $value == (string) $selected) ? 'selected' : null;
    }

    protected function getTextareaTag($value, array $attributes) {
        $attributes = $this->setTextAreaSize($attributes);

        // Next we will convert the attributes into a string form. Also we have removed
        // the size attribute, as it was merely a short-cut for the rows and cols on
        // the element. Then we'll create the final textarea elements HTML for us.
        unset($attributes['size']);
        $attributes = html_attributes($attributes);
        return '<textarea' . $attributes .' >' . e($value) . '</textarea>';
    }

    protected function setTextareaSize($options) {
        if (isset($options['size'])) {
            return $this->setQuickTextAreaSize($options);
        }
        // If the "size" attribute was not specified, we will just look for the regular
        // columns and rows attributes, using sane defaults if these do not exist on
        // the attributes array. We'll then return this entire options array back.
        $cols = array_get($options, 'cols', 50);
        $rows = array_get($options, 'rows', 10);
        return array_merge($options, compact('cols', 'rows'));
    }

    protected function setQuickTextAreaSize($options) {
        $segments = explode('x', $options['size']);
        return array_merge($options, array('cols' => $segments[0], 'rows' => $segments[1]));
    }

    /**
     * Format the label value.
     *
     * @param  string  $name
     * @param  string|null  $value
     * @return string
     */
    protected function formatLabel($name, $value) {
        return $value ?: ucwords(str_replace('_', ' ', $name));
    }

    public function isSelected(Field $field, $onValue) {
        return $field->getTransformedOutputValue() == $onValue;
    }

}