<?php

namespace Oxygen\UiBase\Renderer\Toolbar;

use Illuminate\Html\FormBuilder;

use Illuminate\Routing\UrlGenerator;
use Oxygen\Core\Html\RendererInterface;
use Oxygen\Core\Http\Method;

class ButtonToolbarItem implements RendererInterface {

    /**
     * Injects dependencies into the Renderer.
     *
     * @param FormBuilder $form the laravel form builder
     * @param UrlGenerator $url the URL generator
     */
    public function __construct(FormBuilder $form, UrlGenerator $url) {
        $this->form = $form;
        $this->url = $url;
    }

    /**
     * Renders the element.
     *
     * @param object $toolbarItem Object to render
     * @param array  $arguments Extra arguments to customize the element.
     * @return string Rendered HTML
     */
    public function render($toolbarItem, array $arguments) {
        $method = $toolbarItem->action->getMethod();

        $return = '';

        $insideMainNav = isset($arguments['insideMainNav']) && $arguments['insideMainNav'] === true;
        $insideDropdown = isset($arguments['insideDropdown']) && $arguments['insideDropdown'] === true;

        $renderLabel = function () use ($toolbarItem, $insideMainNav) {
            return
                (($toolbarItem->icon !== null && !$insideMainNav)
                    ? '<span class="Icon Icon-' . e($toolbarItem->icon) . ' Icon--pushRight"></span>'
                    : '')
                . e($toolbarItem->label);
        };

        $addMargins = function ($arguments, &$attributes) {
            if(!isset($arguments['margin'])) {
                return;
            }
            if($arguments['margin'] === 'vertical') {
                $attributes['class'] .= ' Button-margin--vertical';
            } else {
                if($arguments['margin'] === 'horizontal') {
                    $attributes['class'] .= ' Button-margin--horizontal';
                }
            }
        };

        if($method !== Method::GET) {

            $route = array_merge(
                [$toolbarItem->action->getName()],
                $toolbarItem->action->getRouteParameters($arguments)
            );

            $class = 'Form--sendAjax';
            if($insideMainNav) {
                $class .= ' MainNav-item';
            } else {
                if($insideDropdown) {
                    $class .= ' Dropdown-itemContainer';
                }
            }
            if(isset($arguments['inline']) && $arguments['inline'] === true) {
                $class .= ' Form--inline';
            }

            $buttonAttributes = $toolbarItem->hasDialog() ? $toolbarItem->dialog->render() : [];

            $buttonAttributes['type'] = 'submit';

            if($insideMainNav) {
                $buttonAttributes['class'] = 'MainNav-link';
            } else {
                if($insideDropdown) {
                    $buttonAttributes['class'] = 'Dropdown-item';
                } else {
                    $buttonAttributes['class'] = 'Button Button-color--' . $toolbarItem->color;
                    $addMargins($arguments, $buttonAttributes);
                }
            }

            $return .= $this->form->open([
                'route' => $route,
                'method' => $method,
                'class' => $class
            ]);

            $return .= '<button ' . html_attributes($buttonAttributes) . '>';
            $return .= $renderLabel();
            $return .= '</button>';

            $return .= $this->form->close();

        } else {

            $linkAttributes = $toolbarItem->hasDialog() ? $toolbarItem->dialog->render() : [];

            $linkAttributes['href'] = $this->url->route(
                $toolbarItem->action->getName(),
                $toolbarItem->action->getRouteParameters($arguments)
            );

            if($insideMainNav) {
                $linkAttributes['class'] = 'MainNav-item MainNav-link';
            } else {
                if($insideDropdown) {
                    $linkAttributes['class'] = 'Dropdown-itemContainer Dropdown-item';
                } else {
                    $linkAttributes['class'] = 'Button Button-color--' . $toolbarItem->color;
                    $addMargins($arguments, $linkAttributes);
                }
            }

            if($toolbarItem->action->useSmoothState) {
                $linkAttributes['class'] .= ' Link--smoothState';
            }

            $return .= '<a ' . html_attributes($linkAttributes) . '>';
            $return .= $renderLabel();
            $return .= '</a>';

        }

        return $return;
    }

}