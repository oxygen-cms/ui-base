<?php


namespace Oxygen\UiBase\Renderer\Form\Display;

use Illuminate\Routing\UrlGenerator;
use Oxygen\Core\Blueprint\Manager;

class RelationshipField extends GenericField {

    protected $blueprints;

    protected $url;

    /**
     * Constructs the renderer.
     *
     * @param \Oxygen\Core\Blueprint\Manager   $manager
     * @param \Illuminate\Routing\UrlGenerator $url
     */
    public function __construct(Manager $manager, URLGenerator $url) {
        $this->blueprints = $manager;
        $this->url = $url;
    }

    /**
     * Renders the element.
     *
     * @param object $field    Object to render
     * @param array  $arguments Extra arguments to customize the element.
     * @return string
     */
    public function render($field, array $arguments) {
        $blueprint = $this->blueprints->get($field->getMeta()->options['blueprint']);

        $hasRelationship = is_object($field->getValue());

        if(!$hasRelationship) {
            return '<em>None</em>';
        }

        return
            $this->beginContainer() .
            '<a
              href="' . e($this->url->route($blueprint->getRouteName('getInfo'), $field->getValue()->getId())) . '"
              class="Button Button-color--white">
                <span class="Icon Icon-external-link Icon--pushRight"></span>
                View ' . e($blueprint->getDisplayName()) . '
            </a>' .
            $this->endContainer();
    }
}