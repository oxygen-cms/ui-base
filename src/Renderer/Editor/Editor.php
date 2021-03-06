<?php

namespace Oxygen\UiBase\Renderer\Editor;

use Illuminate\Contracts\View\Factory as View;

use Oxygen\Core\Html\RendererInterface;
use Oxygen\Preferences\PreferenceNotFoundException;
use Oxygen\Preferences\PreferencesManager;

class Editor implements RendererInterface {

    /**
     * Include editor scripts if it will be displayed on the page.
     *
     * @var boolean
     */
    public static $includeScripts = false;

    /**
     * View Environment
     *
     * @var View
     */

    protected $view;

    /**
     * Preferences
     *
     * @var PreferencesManager
     */
    protected $preferences;

    /**
     * Injects dependencies into the Renderer.
     *
     * @param View $view View Environment
     * @param PreferencesManager $preferences user preferences
     */
    public function __construct(View $view, PreferencesManager $preferences) {
        $this->view = $view;
        $this->preferences = $preferences;
    }

    /**
     * Combines the default attributes with the custom ones.
     *
     * @param object $object Object to be rendered
     * @return void
     * @throws PreferenceNotFoundException
     */
    public function addDefaultAttributes($object) {
        if(isset($object->attributes['class'])) {
            $object->attributes['class'] .= ' Editor';
        } else {
            $object->attributes['class'] = 'Editor';
        }

        if($object->type == \Oxygen\Core\Html\Editor\Editor::TYPE_MAIN) {
            $object->attributes['class'] .= ' Editor--main';
        }

        if($this->preferences->get('user.editor::theme') === 'dark') {
            $object->attributes['class'] .= ' Editor--dark';
        }
    }

    /**
     * Returns the JavaScript code used to
     * initialise a Editor for the given information.
     *
     * @param \Oxygen\Core\Html\Editor\Editor $editor
     * @return string
     */
    public function getCreateScript(\Oxygen\Core\Html\Editor\Editor $editor) {
        static::$includeScripts = true;

        $text = '<script>';
        $text .= 'window.Oxygen = window.Oxygen || {};';
        $text .= 'window.Oxygen.editors = ( typeof window.Oxygen.editors != "undefined" && window.Oxygen.editors instanceof Array ) ? window.Oxygen.editors : [];';
        $text .= 'window.Oxygen.editors.push({';
        $text .= 'name: "' . $editor->name . '",';
        $text .= 'stylesheets: ' . json_encode($editor->stylesheets) . ',';

        foreach($editor->options as $key => $value) {
            $text .= $key . ': "' . $value . '",';
        }

        $text .= '});</script>';

        return $text;
    }

    /**
     * Renders the element.
     *
     * @param object $object Object to render
     * @param array $arguments Extra arguments to customize the element.
     * @return string Rendered HTML
     * @throws PreferenceNotFoundException
     */
    public function render($object, array $arguments) {
        $this->addDefaultAttributes($object);
        return $this->view->make(
            'oxygen/ui-base::editor.editor',
            ['editor' => $object, 'renderer' => $this]
        )->render();
    }

}
