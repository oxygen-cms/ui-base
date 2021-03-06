<?php

namespace Oxygen\UiBase\Renderer\Toolbar;

use Oxygen\Core\Html\RendererInterface;

class SpacerToolbarItem implements RendererInterface {

    /**
     * Renders the element.
     *
     * @param object $object Object to render
     * @param array $arguments Extra arguments to customize the element.
     * @return string Rendered HTML
     */
    public function render($object, array $arguments) {
        return '<span class="MainNav-border"></span>';
    }

}