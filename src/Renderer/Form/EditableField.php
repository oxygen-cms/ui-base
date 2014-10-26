<?php

namespace Oxygen\CoreViews\Renderer\Form;

use Illuminate\View\Factory as View;

use Oxygen\Core\Html\RendererInterface;

class EditableField implements RendererInterface {

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
     * Renders the Object.
     *
     * @param object $object Object to render
     * @param array arguments Extra arguments to customize the element.
     * @return string Rendered HTML
     */

    public function render($object, array $arguments) {
        if($object->getMeta()->editable) {
            return $this->view->make(
                'oxygen/core-views::form.editableField',
                [
                    'field' => $object,
                    'entireRow' => isset($arguments['entireRow']) ? $arguments['entireRow'] : true
                ]
            )->render();
        } else {
            return '';
        }
    }

}