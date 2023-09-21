<?php


namespace Oxygen\UiBase\Renderer\Form\Display;

use Illuminate\Contracts\Routing\UrlGenerator;
use Oxygen\Core\Blueprint\BlueprintManager;

class RelationshipField extends GenericField {

    protected $blueprints;

    protected $url;

    /**
     * Constructs the renderer.
     *
     * @param BlueprintManager $manager
     * @param UrlGenerator $url
     */
    public function __construct(BlueprintManager $manager, UrlGenerator $url) {
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
        $hasRelationship = is_object($field->getValue());

        if(!$hasRelationship) {
            return '<em>None</em>';
        }

        if(!isset($field->getMeta()->options['blueprint'])) {
            return ($field->getMeta()->options['displayFn'])($field->getValue());
        }

        $blueprint = $this->blueprints->get($field->getMeta()->options['blueprint']);

        return
            $this->beginContainer() .
            '<a
              href="' . e($this->url->route($blueprint->getRouteName('getUpdate'), $field->getValue()->getId())) . '"
              class="Button Button-color--white">
                <span class="Icon Icon-external-link Icon--pushRight"></span>
                View ' . e($blueprint->getDisplayName()) . '
            </a>' .
            $this->endContainer();
    }
}
