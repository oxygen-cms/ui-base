<?php

namespace Oxygen\UiBase\Renderer\Form\Editable;

use Oxygen\Core\Form\FieldMetadata;
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

}