<?php


namespace Oxygen\CoreViews\Renderer\Form\Editable;

use Oxygen\Core\Form\FieldMetadata;
use Oxygen\Core\Html\Form\EditableField;

class RelationshipField extends BaseField {

    /**
     * Renders the element.
     *
     * @param object $field    Object to render
     * @param array  $arguments Extra arguments to customize the element.
     * @return string
     */
    public function render($field, array $arguments) {
        $select = new FieldMetadata($field->getMeta()->name, 'select', true);
        $callable = $field->getMeta()->options['items'];
        $select->options = $callable();

        if($field->getValue() === null || $field->getValue() === '') {
            if(isset($field->getMeta()->options) && $field->getMeta()->options['allowNull']) {
                $select->options[''] = 'Null';
            }
            $value = null;
        } else {
            $value = $field->getValue()->getId();
        }

        $editable = new EditableField($select, $value);
        return $editable->render();
    }
}