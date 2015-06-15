<?php

namespace Oxygen\UiBase\Renderer\Toolbar;

use Illuminate\Contracts\View\Factory as View;

use Oxygen\Core\Html\RendererInterface;

class DropdownToolbarItem implements RendererInterface {

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
    public function render($object, array $arguments = []) {
        if(empty($object->itemsToDisplay)) {
            $object->shouldRender();
        }

        return $this->view->make(
            'oxygen/core-views::toolbar.dropdownToolbarItem',
            [
                'toolbarItem'   => $object,
                'model'         => isset($arguments['model']) ? $arguments['model'] : null,
                'insideMainNav' => isset($arguments['insideMainNav']) ? $arguments['insideMainNav'] : null
            ]
        )->render();
    }

}