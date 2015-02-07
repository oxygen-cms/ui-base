<?php
    use Oxygen\Core\Html\Form\EditableField;

    if(!is_array($toolbarItem->fields)) {
        $closure = $toolbarItem->fields;
        $toolbarItem->fields = $closure();
    }
?>

{{ Form::open(['method' => $toolbarItem->action->getMethod(), 'route' => $toolbarItem->action->getName()]) }}

@foreach($toolbarItem->fields as $fieldMeta)
    <?php
        $field = new EditableField($fieldMeta, Input::get($fieldMeta->name), '');
        if($field->getMeta()->editable) {
            echo $field->render();
        }
    ?>
@endforeach

{{ Form::close() }}