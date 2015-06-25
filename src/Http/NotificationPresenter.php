<?php

namespace Oxygen\UiBase\Http;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Session\Store as Session;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\UrlGenerator;

use Oxygen\Core\Contracts\Http\NotificationPresenter as NotificationPresenterContract;
use Oxygen\Core\Http\Notification;
use Symfony\Component\HttpFoundation\Response;

class NotificationPresenter implements NotificationPresenterContract {

    /**
     * Dependencies for the NotificationResponseCreator.
     */
    protected $session, $request, $redirector, $url, $useSmoothState;

    /**
     * Injects dependencies for the NotificationResponseCreator.
     *
     * @param Session  $session
     * @param Request  $request
     * @param Redirector $redirector
     * @param UrlGenerator $url
     * @param bool     $useSmoothState
     */
    public function __construct(Session $session, Request $request, Redirector $redirector, UrlGenerator $url, $useSmoothState) {
        $this->session = $session;
        $this->request = $request;
        $this->redirect = $redirector;
        $this->url = $url;
        $this->useSmoothState = $useSmoothState;
    }

    /**
     * Creates a response to an API call that handles AJAX requests as well.
     *
     * The $redirect parameter will redirect the user to the given route name.
     * The
     *
     * @param Notification $notification   Notification to display.
     * @param array        $parameters     Extra parameters
     * @return mixed
     */
    public function present(Notification $notification, array $parameters = []) {
        $notification = $this->arrayFromNotification($notification);

        if($this->request->ajax()) {
            if($this->wantsRedirect($parameters)) {
                return $this->createJsonRedirectResponse($notification, $parameters);
            } else if($this->wantsRefresh($parameters)) {
                return $this->createJsonRedirectResponse($notification, $parameters, true);
            } else {
                return $this->createJsonSmoothResponse($notification, $parameters);
            }
        } else {
            return $this->createBasicResponse($notification, $parameters);
        }
    }

    /**
     * Returns a json response with a reload command.
     * If $refresh is true then the user will be sent to the previous page.
     * If $refresh is false then the user will be sent to the specified page.
     *
     * @param mixed     $notification   Notification to display.
     * @param array     $parameters     Extra parameters
     * @param boolean   $refresh        Whether to refresh
     * @return Response
     */
    protected function createJsonRedirectResponse($notification, $parameters, $refresh = false) {
        if($refresh) {
            $url = $this->url->previous();
        } else {
            $url = $this->urlFromRoute($parameters['redirect']);
        }

        $return = [
            'redirect' => $url
        ];

        if(isset($parameters['hardRedirect'])) {
            $return['hardRedirect'] = $parameters['hardRedirect'];
            $hardRedirect = true;
        }

        // display the message on the new page
        if($this->useSmoothState && !isset($hardRedirect)) {
            $return = array_merge($return, $notification);
        } else {
            $this->session->flash('adminMessage', $notification);
        }

        // send the redirect command
        return $this->makeCustomResponse(new JsonResponse($return), $parameters);
    }

    /**
     * Returns a JSON response.
     *
     * @param mixed     $notification   Notification to display.
     * @param array     $parameters     Extra parameters
     * @return Response
     */
    private function createJsonSmoothResponse($notification, $parameters) {
        return $this->makeCustomResponse(new JsonResponse($notification), $parameters);
    }

    /**
     * Returns a basic response.
     *
     * @param mixed $notification Flash message to display.
     * @param array $parameters
     * @return Response
     */
    public function createBasicResponse($notification, $parameters) {
        if($this->wantsRedirect($parameters)) {
            $url = $this->urlFromRoute($parameters['redirect']);
        } else if(isset($parameters['fallback'])) {
            $url = $this->urlFromRoute($parameters['fallback']);
        } else {
            $url = $this->url->previous();
        }

        // flash data to the session
        $this->session->flash('adminMessage', $notification);

        return $this->makeCustomResponse($this->redirect->to($url), $parameters);
    }

    /**
     * Decode the route argument into a URL.
     *
     * @param mixed $route
     * @return array
     */
    protected function urlFromRoute($route) {
        if(is_array($route)) {
            return $this->url->route($route[0], $route[1]);
        } else {
            return $this->url->route($route);
        }
    }

    /**
     * Get the raw array from the notification.
     *
     * @param mixed $notification
     * @return array
     */
    protected function arrayFromNotification($notification) {
        if(!is_array($notification)) {
            return $notification->toArray();
        } else {
            return $notification;
        }
    }

    /**
     * Determine if the user should be redirected.
     *
     * @param array $parameters
     * @return boolean
     */
    protected function wantsRedirect($parameters) {
        return isset($parameters['redirect']);
    }

    /**
     * Determine if the page should be refreshed.
     *
     * @param array $parameters
     * @return boolean
     */
    protected function wantsRefresh($parameters) {
        return isset($parameters['refresh']) && $parameters['refresh'] === true;
    }

    /**
     * Runs the response through the custom response callback, if it exists.
     *
     * @param Response $response
     * @param array $parameters
     * @return Response
     */
    protected function makeCustomResponse(Response $response, $parameters) {
        if(isset($parameters['input']) && $parameters['input'] === true && $response instanceof RedirectResponse) {
            return $response->withInput();
        } else if(isset($parameters['customResponse'])) {
            return $parameters['customResponse']();
        } else {
            return $response;
        }
    }

}
