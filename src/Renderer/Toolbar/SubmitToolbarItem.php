<?php

namespace Oxygen\UiBase\Renderer\Toolbar;

use Oxygen\Core\Html\RendererInterface;

class SubmitToolbarItem implements RendererInterface {

    /**
     * Renders the element.
     *
     * @param object $button    Object to render
     * @param array  $arguments Extra arguments to customize the element.
     * @return string
     */
    public function render($button, array $arguments) {
        return '<button
                  type="submit"
                  class="Button Button-color--' . e($button->color) . ' Form-submit">
                ' . e($button->label) . '
                </button>';
    }
}