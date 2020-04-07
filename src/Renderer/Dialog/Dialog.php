<?php

namespace Oxygen\UiBase\Renderer\Dialog;

use Oxygen\Core\Html\RendererInterface;

class Dialog implements RendererInterface {

    /**
     * Renders the element.
     *
     * @param object $object Object to render
     * @param array $arguments Extra arguments to customize the element.
     * @return array
     */
    public function render($object, array $arguments) {
        return [
            'data-dialog-type' => $object->type,
            'data-dialog-message' => $object->message
        ];
    }

}