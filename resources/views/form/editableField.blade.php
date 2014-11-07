<?php

    use Oxygen\Core\Html\Editor\Editor;
    use Oxygen\Core\Form\Field;use Oxygen\Core\Html\Form\EditableField;

    $meta = $field->getMeta();

    $defaultAttributes = array();
    $defaultClass = 'Form-content flex-item';

    $attributes = array_merge($defaultAttributes, $meta->attributes);

    if(isset($attributes['class'])) {
        $attributes['class'] .= ' ' . $defaultClass;
    } else {
        $attributes['class'] = $defaultClass;
    }
    $attributes['id'] = $meta->name;
    $attributes['placeholder'] = $meta->placeholder;

?>

@if($entireRow)
    <div class="Row">

    <?php

        $labelAttributes = [];
        if(!$meta->hasDescription()) {
            $labelAttributes['class'] = 'Form-label flex-item';
        }
        if($meta->type !== Field::TYPE_TOGGLE && $meta->type !== Field::TYPE_CHECKBOX) {
            $labelAttributes['for'] = $meta->name;
        }

        if($meta->hasDescription()) {
            echo '<span ' . HTML::attributes(['class' => 'Form-label Tooltip flex-item', 'data-tooltip' => $meta->description]) . '>';
        }

        echo '<label ' . HTML::attributes($labelAttributes) . '>' . $meta->label . '</label>';

        if($meta->hasDescription()) {
            echo '</span>';
        }

    ?>

@endif

@if($meta->datalist !== null)
    <datalist id="{{ $meta->name }}-datalist">
        @foreach($meta->datalist as $value)
            <option value="{{ $value }}">
        @endforeach
    </datalist>

    <?php $attributes['list'] = $meta->name . '-datalist'; ?>
@endif

    <?php

        switch($meta->type):
            case Field::TYPE_TEXT:
                echo Form::text($meta->name, $field->getValue(), $attributes);
                break;
            case Field::TYPE_TEXTAREA:
                echo Form::textarea($meta->name, $field->getValue(), $attributes);
                break;
            case Field::TYPE_EDITOR:
            case Field::TYPE_EDITOR_MINI:
                $editor = new Editor(
                    $meta->name,
                    $field->getEncodedValue(),
                    $meta->type,
                    $attributes,
                    $meta->options
                );
                echo $editor->render();
                break;
            case Field::TYPE_PASSWORD:
                echo Form::password($meta->name, $field->getValue(), $attributes);
                break;
            case Field::TYPE_EMAIL:
                echo Form::email($meta->name, $field->getValue(), $attributes);
                break;
            case Field::TYPE_CHECKBOX:
                $options = $meta->options;
                if(!isset($options['off'], $options['on'])) {
                    $options['off'] = 'false';
                    $options['on'] = 'true';
                }
                echo Form::hidden($meta->name, $options['off'], null, $attributes);
                echo Form::checkbox($meta->name, $options['on'], null, $attributes);
                echo Form::label($meta->name, $meta->label, ['class' => 'Form-checkbox-label flex-item']);
                break;
            case Field::TYPE_TOGGLE:
                $labels = isset($attributes['labels']) ? $attributes['labels'] : ['on' => 'On', 'off' => 'Off'];
                unset($attributes['labels']);

                $options = $meta->options;
                if(!isset($options['off'], $options['on'])) {
                    $options['off'] = 'false';
                    $options['on'] = 'true';
                }

                echo Form::hidden($meta->name, $options['off'], $attributes);
                $attributes['class'] .= ' Form-toggle';
                echo Form::checkbox($meta->name, $options['on'], $field->getValue(), $attributes);

                echo '<label for="' . $meta->name . '" class="Form-toggle-label">';
                echo '<span class="on">' . $labels['on'] . '</span>';
                echo '<span class="off">' . $labels['off'] . '</span>';
                echo '</label>';
                break;
            case Field::TYPE_SELECT:
                $options = $meta->options;
                if(is_object($options) && ($options instanceof Closure)) {
                    $options = $options();
                }
                echo Form::select($meta->name, $options, $field->getValue(), $attributes);
                break;
            case Field::TYPE_RADIO:
                $options = $meta->options;
                if(is_object($options) && ($options instanceof Closure)) {
                    $options = $options();
                }

                foreach($options as $value => $label) {
                    $attributes['id'] = $meta->name . '.' . $value;
                    echo Form::radio($meta->name, $value, $field->getValue() === $value, $attributes);
                    echo Form::label($meta->name . '.' . $value, $label);
                    echo '<br>';
                }
                break;
            case Field::TYPE_TAGS:
                echo '<div data-tags-input-name="' . $meta->name . '" class="Form-taggable">' . implode(', ', (array) $field->getValue()). '</div>';
                break;
            case Field::TYPE_RELATIONSHIP:
                $select = new Field($meta->name, Field::TYPE_SELECT, true);
                $callable = $meta->options['items'];
                $select->options = $callable();

                if($field->getValue() === null) {
                    if(isset($meta->options) && $meta->options['allowNull']) {
                        $select->options[''] = 'Null';
                    }
                    $value = null;
                } else {
                    $value = $field->getValue()->getId();
                }

                $editable = new EditableField($select, $value);
                echo $editable->render(['entireRow' => false]);

                break;
            default:
                echo Form::input($meta->type, $meta->name, $field->getValue(), $attributes);
        endswitch;
    ?>

@if($entireRow)
    </div>
@endif