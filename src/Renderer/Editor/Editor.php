<?php

namespace Oxygen\UiBase\Renderer\Editor;

use Illuminate\Contracts\View\Factory as View;

use Oxygen\Core\Html\RendererInterface;
use Oxygen\Preferences\Repository as Preferences;

class Editor implements RendererInterface {

    /**
     * View Environment
     *
     * @var View
     */

    protected $view;

    /**
     * Preferences Repository
     *
     * @var Preferences
     */

    protected $preferences;

    /**
     * Injects dependencies into the Renderer.
     *
     * @param View $view View Environment
     * @param Preferences $preferences Preferences Repository
     */
    public function __construct(View $view, Preferences $preferences = null) {
        $this->view = $view;
        $this->preferences = $preferences;
    }

    /**
     * Combines the default attributes with the custom ones.
     *
     * @param object $object Object to be rendered
     * @return void
     */
    public function addDefaultAttributes($object) {
        if(isset($object->attributes['class'])) {
            $object->attributes['class'] .= ' Editor';
        } else {
            $object->attributes['class'] = 'Editor';
        }

        if($this->preferences !== null && $this->preferences->get('editor.theme') == 'dark') {
            $object->attributes['class'] .= ' Editor--dark';
        }

        //$object->attributes['data-field'] = $object->name;
    }

    /**
     * Renders the element.
     *
     * @param object $object Object to render
     * @param array $arguments Extra arguments to customize the element.
     * @return string Rendered HTML
     */
    public function render($object, array $arguments) {
        $this->addDefaultAttributes($object);
        return $this->view->make(
            'oxygen/ui-base::editor.editor',
            ['editor' => $object]
        )->render();
    }

}
