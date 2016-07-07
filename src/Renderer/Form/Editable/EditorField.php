<?php

namespace Oxygen\UiBase\Renderer\Form\Editable;

use Oxygen\Core\Html\Editor\Editor;

class EditorField extends BaseField {

    /**
     * Renders the element.
     *
     * @param object $field    Object to render
     * @param array  $arguments Extra arguments to customize the element.
     * @return string
     */
    public function render($field, array $arguments) {
        $attributes = array_merge(
            [
                'id' => $field->getMeta()->name,
                'class' => 'flex-item'
            ],
            $field->getMeta()->attributes
        );
        $editor = new Editor(
            $field->getMeta()->name,
            $field->getTransformedOutputValue(),
            $field->getMeta()->type,
            $attributes,
            $field->getMeta()->options
        );

        return $editor->render();
    }
}
