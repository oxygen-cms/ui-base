<?php

namespace Oxygen\UiBase\Renderer\Toolbar;

use Illuminate\Contracts\View\Factory as View;

use Oxygen\Core\Html\Form\Form;
use Oxygen\Core\Html\Form\EditableField;
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
     * @param object $toolbarItem Object to render
     * @param array $arguments Extra arguments to customize the element.
     * @return string Rendered HTML
     * @throws \Exception
     */
    public function render($toolbarItem, array $arguments) {
        if(!is_array($toolbarItem->fields)) {
            $closure = $toolbarItem->fields;
            $toolbarItem->fields = $closure();
        }

        // Creates the form
        $form = new Form($toolbarItem->action);

        // Add all the fields
        foreach($toolbarItem->fields as $fieldMeta) {
            $field = new EditableField($fieldMeta, request()->get($fieldMeta->name, ''));
            $form->addContent($field);
        }

        return $form->render();
    }

}