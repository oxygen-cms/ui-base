<?php

namespace Oxygen\CoreViews\Renderer\Toolbar;

use Oxygen\Core\Html\RendererInterface;

class SpacerToolbarItem implements RendererInterface {

    /**
     * Renders the element.
     *
     * @param object $object Object to render
     * @param array arguments Extra arguments to customize the element.
     * @return string Rendered HTML
     */
    public function render($object, array $arguments) {
        return '<span class="MainNav-item MainNav-border"></span>';
    }

}