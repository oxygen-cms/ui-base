<?php

namespace Oxygen\UiBase\Renderer\Form;

use Illuminate\Session\Store;
use Illuminate\Contracts\Routing\UrlGenerator;
use Oxygen\Core\Html\RendererInterface;

class Form implements RendererInterface {

    /**
     * The form methods that should be spoofed, in uppercase.
     *
     * @var array
     */
    protected $spoofedMethods = ['DELETE', 'PATCH', 'PUT'];

    protected $url, $session;

    /**
     * Constructs the Form renderer
     *
     * @param \Illuminate\Contracts\Routing\UrlGenerator $url
     */
    public function __construct(UrlGenerator $url, Store $session) {
        $this->url = $url;
        $this->session = $session;
    }

    /**
     * Renders the element.
     *
     * @param object $form      The form to render
     * @param array  $arguments Extra arguments to customize the element.
     * @return string
     */
    public function render($form, array $arguments) {
        $method = $form->getAction()->getMethod();
        $attributes = [];
        $classes =  $form->getExtraClasses();

        // creates route parameters for the form `action`
        // for example my-website.com/update/{id}
        $route = array_merge(
            [$form->getAction()->getName()],
            $form->getAction()->getRouteParameters($form->getRouteParameters())
        );

        // We need to extract the proper method from the attributes. If the method is
        // something other than GET or POST we'll use POST since we will spoof the
        // actual method since forms don't support the reserved methods in HTML.
        $attributes['method'] = $this->getSupportedMethod($method);
        $attributes['action'] = $this->url->route($route);
        $attributes['accept-charset'] = 'UTF-8';

        // If the method is PUT, PATCH or DELETE we will need to add a spoofer hidden
        // field that will instruct the Symfony request to pretend the method is a
        // different method than it actually is, for convenience from the forms.
        $append = $this->getAppendage($method);

        if ($form->needsFiles()) {
            $options['enctype'] = 'multipart/form-data';
        }

        // Extra parameters
        if($form->isAsynchronous()) {
            $classes[] = 'Form--sendAjax';
        }
        if($form->shouldWarnBeforeExit()) {
            $classes[] = 'Form--warnBeforeExit';
        }
        if($form->shouldWarnBeforeExit()) {
            $classes[] = 'Form--warnBeforeExit';
        }
        if($form->shouldSubmitOnShortcutKey()) {
            $classes[] = 'Form--submitOnKeydown';
        }

        $attributes['class'] = implode($classes, ' ');

        // Finally, we will concatenate all of the attributes into a single string so
        // we can build out the final form open statement. We'll also append on an
        // extra value for the hidden _method field if it's needed for the form.
        $attributes = html_attributes($attributes);

        $content = '';
        foreach($form->getRows() as $row) {
            if(is_string($row)) {
                $content .= $row;
            } else {
                $content = $row->render();
            }
        }

        // Finally we're ready to create the final form HTML field. We will attribute
        // format the array of attributes. We will also add on the appendage which
        // is used to spoof requests for this PUT, PATCH, etc. methods on forms.
        return '<form' . $attributes . '>' . $append . $content . '</form>';
    }

    private function getSupportedMethod($method) {
        $method = strtoupper($method);
        return $method != 'GET' ? 'POST' : $method;
    }

    /**
     * Get the form appendage for the given method.
     *
     * @param  string  $method
     * @return string
     */
    protected function getAppendage($method) {
        list($method, $appendage) = [strtoupper($method), ''];
        // If the HTTP method is in this list of spoofed methods, we will attach the
        // method spoofer hidden input to the form. This allows us to use regular
        // form to initiate PUT and DELETE requests in addition to the typical.
        if (in_array($method, $this->spoofedMethods)) {
            $appendage .= $this->getHidden('_method', $method);
        }
        // If the method is something other than GET we will go ahead and attach the
        // CSRF token to the form, as this can't hurt and is convenient to simply
        // always have available on every form the developers creates for them.
        if ($method != 'GET') {
            $appendage .= $this->getHidden('_token', $this->session->getToken());
        }
        return $appendage;
    }

    protected function getHidden($name, $value) {
        $attributes = [
            'name' => $name,
            'type' => 'hidden',
            'value' => $value
        ];
        return '<input ' . html_attributes($attributes) . '>';
    }

}