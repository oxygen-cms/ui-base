<?php

namespace Oxygen\CoreViews\Renderer\Form\Editable;

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
        $editor = new Editor(
            $field->getMeta()->name,
            $field->getMeta()->getType()->transformOutput($field->getMeta(), $field->getValue()),
            $field->getMeta()->type,
            $this->getFieldAttributes($field->getMeta()),
            $field->getMeta()->options
        );

        return $editor->render();
    }
}