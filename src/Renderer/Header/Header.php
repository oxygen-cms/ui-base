<?php

namespace Oxygen\UiBase\Renderer\Header;

use Illuminate\Contracts\View\Factory as View;

use Oxygen\Core\Html\RendererInterface;

class Header implements RendererInterface {

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
        return $this->view->make('oxygen/core-views::header.header', array(
            'header' => $object
        ))->render();
    }

}