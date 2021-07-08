<?php


namespace Oxygen\UiBase\Renderer\Form\Editable;

use Oxygen\Core\Blueprint\BlueprintManager;
use Oxygen\Core\Form\FieldMetadata;
use Oxygen\UiBase\Renderer\Form\Display\RelationshipField as StaticRelationshipField;


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

        $repo = $field->getMeta()->options['repository'];
        $repo = is_callable($repo) ? $repo() : $repo;
        $select->options = $repo->listKeysAndValues('id', isset($field->getMeta()->options['nameField']) ? $field->getMeta()->options['nameField'] : 'name');

        if($field->getValue() === null || $field->getValue() === '') {
            if(isset($field->getMeta()->options) && $field->getMeta()->options['allowNull']) {
                $select->options[''] = 'Null';
            }
            $value = null;
        } else {
            $value = $field->getValue()->getId();
        }

        $display = new StaticRelationshipField(app(BlueprintManager::class), app('url'));

        return $this->getSelectTag($select->options, $value, $this->getFieldAttributes($select)) . '<br /><br />' . $display->render($field, $arguments);
    }
}
