<?php namespace Oxygen\UiBase;

use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Oxygen\Core\Blueprint\BlueprintManager;
use Oxygen\Core\Html\Form\Form;
use Oxygen\Core\Html\Form\Label;
use Oxygen\Core\Html\Form\Row;
use Oxygen\Core\Html\Toolbar\ButtonToolbarItem;
use Oxygen\Core\Html\Toolbar\DropdownToolbarItem;
use Oxygen\Core\Html\Toolbar\FormToolbarItem;
use Oxygen\Core\Html\Toolbar\SpacerToolbarItem;
use Oxygen\Core\Html\Toolbar\DisabledToolbarItem;
use Oxygen\Core\Html\Header\Header;
use Oxygen\Core\Html\Form\StaticField;
use Oxygen\Core\Html\Form\EditableField;
use Oxygen\Core\Html\Editor\Editor;
use Oxygen\Core\Html\Dialog\Dialog;
use Oxygen\Core\Html\Navigation\Navigation;
use Oxygen\Core\Html\Navigation\NavigationToggle;
use Oxygen\Core\Html\Toolbar\SubmitToolbarItem;
use Oxygen\Core\Html\Toolbar\Toolbar;
use Oxygen\Core\Html\Toolbar\VoidButtonToolbarItem;
use Oxygen\UiBase\Renderer\Form\Display\DatetimeField;
use Oxygen\UiBase\Renderer\Form\Editable\CheckboxField;
use Oxygen\UiBase\Renderer\Form\Editable\EditorField;
use Oxygen\UiBase\Renderer\Form\Editable\GenericField;
use Oxygen\UiBase\Renderer\Form\Editable\RadioField;
use Oxygen\UiBase\Renderer\Form\Editable\RelationshipField;
use Oxygen\UiBase\Renderer\Form\Editable\SelectField;
use Oxygen\UiBase\Renderer\Form\Editable\TagsField;
use Oxygen\UiBase\Renderer\Form\Editable\TextareaField;
use Oxygen\UiBase\Renderer\Form\Editable\ToggleField;
use Oxygen\UiBase\Renderer\Form\Row as RowRenderer;
use Oxygen\UiBase\Renderer\Form\Label as LabelRenderer;
use Oxygen\UiBase\Renderer\Form\Form as FormRenderer;
use Oxygen\UiBase\Renderer\Form\Display\GenericField as StaticGenericField;
use Oxygen\UiBase\Renderer\Form\Display\RelationshipField as StaticRelationshipField;
use Oxygen\UiBase\Renderer\Form\Display\SelectField as StaticSelectField;
use Oxygen\UiBase\Renderer\Form\Display\TextareaField as StaticTextareaField;
use Oxygen\UiBase\Renderer\Toolbar\ButtonToolbarItem as ButtonToolbarItemRenderer;
use Oxygen\UiBase\Renderer\Toolbar\DropdownToolbarItem as DropdownToolbarItemRenderer;
use Oxygen\UiBase\Renderer\Toolbar\FormToolbarItem as FormToolbarItemRenderer;
use Oxygen\UiBase\Renderer\Toolbar\SpacerToolbarItem as SpacerToolbarItemRenderer;
use Oxygen\UiBase\Renderer\Toolbar\DisabledToolbarItem as DisabledToolbarItemRenderer;
use Oxygen\UiBase\Renderer\Toolbar\SubmitToolbarItem as SubmitToolbarItemRenderer;
use Oxygen\UiBase\Renderer\Toolbar\Toolbar as ToolbarRenderer;
use Oxygen\UiBase\Renderer\Header\Header as HeaderRenderer;
use Oxygen\UiBase\Renderer\Editor\Editor as EditorRenderer;
use Oxygen\UiBase\Renderer\Dialog\Dialog as DialogRenderer;
use Oxygen\UiBase\Renderer\Navigation\Navigation as NavigationRenderer;
use Oxygen\UiBase\Renderer\Navigation\NavigationToggle as NavigationToggleRenderer;
use Oxygen\UiBase\Renderer\Toolbar\VoidButtonToolbarItem as VoidButtonToolbarItemRenderer;
use Illuminate\Contracts\Routing\ResponseFactory as ResponseFactoryContract;
use Oxygen\UiBase\Routing\ResponseFactory;
use Oxygen\Core\Contracts\Routing\ResponseFactory as ExtendedResponseFactoryContract;

class UiBaseServiceProvider extends ServiceProvider {

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
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'oxygen/ui-base');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'oxygen/ui-base');

        $this->loadMigrationsFrom(__DIR__ . '/../migrations');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/oxygen/ui-base'),
            __DIR__.'/../resources/lang' => base_path('resources/lang/vendor/oxygen/ui-base'),
        ]);

        Paginator::defaultView('oxygen/ui-base::pagination.default');
        Paginator::defaultSimpleView('oxygen/ui-base::pagination.simple');

		ButtonToolbarItem::setRenderer(function() { return new ButtonToolbarItemRenderer($this->app['url']); });
        VoidButtonToolbarItem::setRenderer(new VoidButtonToolbarItemRenderer());
        FormToolbarItem::setRenderer(function() { return new FormToolbarItemRenderer($this->app['view']); });
        DropdownToolbarItem::setRenderer(function() { return new DropdownToolbarItemRenderer($this->app['view']); });
        SpacerToolbarItem::setRenderer(new SpacerToolbarItemRenderer());
        DisabledToolbarItem::setRenderer(new DisabledToolbarItemRenderer());
        SubmitToolbarItem::setRenderer(new SubmitToolbarItemRenderer());
        Header::setRenderer(function() { return new HeaderRenderer($this->app['view']); });
        Toolbar::setRenderer(new ToolbarRenderer());
        Editor::setRenderer(function() { return new EditorRenderer($this->app['view'], auth()->guard()->user()->getPreferences()); });
        Dialog::setRenderer(new DialogRenderer());
//        Navigation::setRenderer(function() { return new NavigationRenderer($this->app['view']); });
//        NavigationToggle::setRenderer(function() { return new NavigationToggleRenderer($this->app['view']); });

        EditableField::setFallbackRenderer(new GenericField());
        EditableField::setRenderer('checkbox', new CheckboxField());
        EditableField::setRenderer('toggle', new ToggleField());
        EditableField::setRenderer('editor', new EditorField());
        EditableField::setRenderer('editor-mini', new EditorField());
        EditableField::setRenderer('radio', new RadioField());
        EditableField::setRenderer('relationship', new RelationshipField());
        EditableField::setRenderer('select', new SelectField());
        EditableField::setRenderer('tags', new TagsField());
        EditableField::setRenderer('textarea', new TextareaField());
        EditableField::setRenderer('toggle', new ToggleField());

        StaticField::setFallbackRenderer(new StaticGenericField());
        StaticField::setRenderer('relationship', function() { return new StaticRelationshipField($this->app[BlueprintManager::class], $this->app['url']); });
        StaticField::setRenderer('date', new DatetimeField());
        StaticField::setRenderer('datetime', new DatetimeField());
        StaticField::setRenderer('select', new StaticSelectField());
        StaticField::setRenderer('textarea', new StaticTextareaField());
        StaticField::setRenderer('editor', new StaticTextareaField());
        StaticField::setRenderer('editor-mini', new StaticTextareaField());

        Row::setRenderer(new RowRenderer());
        Form::setRenderer(function() { return new FormRenderer($this->app['url']); });
        Label::setRenderer(new LabelRenderer());

        $this->addNoticesToLayout();
        $this->addNotificationsToLayout();
	}

    /**
     * Adds the notices to the layout.
     *
     * @return void
     */

    protected function addNoticesToLayout() {
        $this->app['events']->listen('oxygen.layout.body.before', function() {
            echo $this->app['view']->make('oxygen/ui-base::layout.element.notices')->render();
        });
    }

    /**
     * Adds the notifications container to the layout.
     *
     * @return void
     */

    protected function addNotificationsToLayout() {
        $this->app['events']->listen('oxygen.layout.body.before', function() {
            echo $this->app['view']->make('oxygen/ui-base::layout.element.notifications')->render();
        });
    }

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register() {
        $this->app->singleton(ResponseFactoryContract::class, ResponseFactory::class);
        $this->app->singleton(ExtendedResponseFactoryContract::class, ResponseFactory::class);
        $this->app->bind(ResponseFactory::class, function($app) {
            // lazy load stuff
            return new ResponseFactory(
                $app['view'],
                $app['redirect'],
                $app['url'],
                request(),
                function() {
                    return $this->app['auth']->check() ? $this->app['auth']->user()->getPreferences()->get('pageLoad.smoothState.enabled') : true;
                }
            );
        });
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
