<?php

namespace Oxygen\UiBase\Renderer\Toolbar;

use Illuminate\Contracts\View\Factory as View;

use Oxygen\Core\Html\RendererInterface;

class FormToolbarItem implements RendererInterface {

    /**
     * View Environment
     *
     * @var View
     */

    protected $view;

    /**
     * Injects dependencies into the Renderer.
     *
     * @param View $view View Environment
     */
    public function __construct(View $view) {
        $this->view = $view;
    }

    /**
     * Renders the element.
     *
     * @param object $object Object to render
     * @param array $arguments Extra arguments to customize the element.
     * @return string Rendered HTML
     */
    public function render($object, array $arguments) {
        return $this->view->make(
            'oxygen/ui-base::toolbar.formToolbarItem',
            [
                'toolbarItem'    => $object,
                'arguments'      => $arguments
            ]
        )->render();
    }

}