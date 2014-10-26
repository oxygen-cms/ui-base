<?php namespace Oxygen\CoreViews;

use Illuminate\Support\ServiceProvider;

use Oxygen\Core\Html\Toolbar\ButtonToolbarItem;
use Oxygen\Core\Html\Toolbar\DropdownToolbarItem;
use Oxygen\Core\Html\Toolbar\FormToolbarItem;
use Oxygen\Core\Html\Toolbar\SpacerToolbarItem;
use Oxygen\Core\Html\Toolbar\DisabledToolbarItem;
use Oxygen\Core\Html\Header\Header;
use Oxygen\Core\Html\Form\StaticField;
use Oxygen\Core\Html\Form\EditableField;
use Oxygen\Core\Html\Form\Footer;
use Oxygen\Core\Html\Editor\Editor;
use Oxygen\Core\Html\Dialog\Dialog;
use Oxygen\Core\Html\Navigation\Navigation;
use Oxygen\Core\Html\Navigation\NavigationToggle;
use Oxygen\CoreViews\Renderer\Toolbar\ButtonToolbarItem as ButtonToolbarItemRenderer;
use Oxygen\CoreViews\Renderer\Toolbar\DropdownToolbarItem as DropdownToolbarItemRenderer;
use Oxygen\CoreViews\Renderer\Toolbar\FormToolbarItem as FormToolbarItemRenderer;
use Oxygen\CoreViews\Renderer\Toolbar\SpacerToolbarItem as SpacerToolbarItemRenderer;
use Oxygen\CoreViews\Renderer\Toolbar\DisabledToolbarItem as DisabledToolbarItemRenderer;
use Oxygen\CoreViews\Renderer\Header\Header as HeaderRenderer;
use Oxygen\CoreViews\Renderer\Form\StaticField as StaticFieldRenderer;
use Oxygen\CoreViews\Renderer\Form\EditableField as EditableFieldRenderer;
use Oxygen\CoreViews\Renderer\Form\Footer as FooterRenderer;
use Oxygen\CoreViews\Renderer\Editor\Editor as EditorRenderer;
use Oxygen\CoreViews\Renderer\Dialog\Dialog as DialogRenderer;
use Oxygen\CoreViews\Renderer\Navigation\Navigation as NavigationRenderer;
use Oxygen\CoreViews\Renderer\Navigation\NavigationToggle as NavigationToggleRenderer;

class CoreViewsServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */

	public function boot() {
		$this->package('oxygen/core-views', 'oxygen/core-views', __DIR__ . '/../resources');

		$view = $this->app['view'];
        $auth = $this->app['auth'];
		ButtonToolbarItem::setRenderer(new ButtonToolbarItemRenderer($view));
        FormToolbarItem::setRenderer(new FormToolbarItemRenderer($view));
        DropdownToolbarItem::setRenderer(new DropdownToolbarItemRenderer($view));
        SpacerToolbarItem::setRenderer(new SpacerToolbarItemRenderer());
        DisabledToolbarItem::setRenderer(new DisabledToolbarItemRenderer());
        Header::setRenderer(new HeaderRenderer($view));
        StaticField::setRenderer(new StaticFieldRenderer($view));
        EditableField::setRenderer(new EditableFieldRenderer($view));
        Footer::setRenderer(new FooterRenderer($view));
        Editor::setRenderer(new EditorRenderer($view, $auth->check() ? $auth->user()->getPreferences() : null));
        Dialog::setRenderer(new DialogRenderer());
        Navigation::setRenderer(new NavigationRenderer($view));
        NavigationToggle::setRenderer(new NavigationToggleRenderer($view));

        $this->app['oxygen.preferences']->loadDirectory(__DIR__ . '/../resources/preferences', [
            'user.general', 'user.editor'
        ]);

        $this->addNavigationToLayout();
        $this->addNoticesToLayout();
        $this->addNotificationsToLayout();
	}

    /**
     * Adds the navigation bar to the layout.
     *
     * @return void
     */

    protected function addNavigationToLayout() {
        $this->app['events']->listen('oxygen.layout.body.before', function() {
            if($this->app['auth']->check()) {
                echo $this->app['oxygen.navigation']->render();
            }
        });

        $this->app['events']->listen('oxygen.layout.page.before', function() {
            if($this->app['auth']->check()) {
                $toggle = new NavigationToggle();
                echo $toggle->render();
            }
        });
    }

    /**
     * Adds the notices to the layout.
     *
     * @return void
     */

    protected function addNoticesToLayout() {
        $this->app['events']->listen('oxygen.layout.body.before', function() {
            echo $this->app['view']->make('oxygen/core-views::layout.element.notices')->render();
        });

        $this->app['events']->listen('oxygen.layout.body.after', function() {
            echo $this->app['view']->make('oxygen/core-views::layout.element.noticesScript')->render();
        });
    }

    /**
     * Adds the notifications container to the layout.
     *
     * @return void
     */

    protected function addNotificationsToLayout() {
        $this->app['events']->listen('oxygen.layout.body.before', function() {
            echo $this->app['view']->make('oxygen/core-views::layout.element.notifications')->render();
        });
    }

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register() {

	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides() {
		return [];
	}

}
