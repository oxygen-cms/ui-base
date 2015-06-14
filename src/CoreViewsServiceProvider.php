<?php namespace Oxygen\CoreViews;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
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
use Oxygen\CoreViews\Pagination\Presenter;
use Oxygen\CoreViews\Renderer\Form\Display\DatetimeField;
use Oxygen\CoreViews\Renderer\Form\Editable\CheckboxField;
use Oxygen\CoreViews\Renderer\Form\Editable\EditorField;
use Oxygen\CoreViews\Renderer\Form\Editable\GenericField;
use Oxygen\CoreViews\Renderer\Form\Editable\RadioField;
use Oxygen\CoreViews\Renderer\Form\Editable\RelationshipField;
use Oxygen\CoreViews\Renderer\Form\Editable\SelectField;
use Oxygen\CoreViews\Renderer\Form\Editable\TagsField;
use Oxygen\CoreViews\Renderer\Form\Editable\TextareaField;
use Oxygen\CoreViews\Renderer\Form\Editable\ToggleField;
use Oxygen\CoreViews\Renderer\Form\Row as RowRenderer;
use Oxygen\CoreViews\Renderer\Form\Label as LabelRenderer;
use Oxygen\CoreViews\Renderer\Form\Display\GenericField as StaticGenericField;
use Oxygen\CoreViews\Renderer\Form\Display\RelationshipField as StaticRelationshipField;
use Oxygen\CoreViews\Renderer\Form\Display\SelectField as StaticSelectField;
use Oxygen\CoreViews\Renderer\Form\Display\TextareaField as StaticTextareaField;
use Oxygen\CoreViews\Renderer\Toolbar\ButtonToolbarItem as ButtonToolbarItemRenderer;
use Oxygen\CoreViews\Renderer\Toolbar\DropdownToolbarItem as DropdownToolbarItemRenderer;
use Oxygen\CoreViews\Renderer\Toolbar\FormToolbarItem as FormToolbarItemRenderer;
use Oxygen\CoreViews\Renderer\Toolbar\SpacerToolbarItem as SpacerToolbarItemRenderer;
use Oxygen\CoreViews\Renderer\Toolbar\DisabledToolbarItem as DisabledToolbarItemRenderer;
use Oxygen\CoreViews\Renderer\Toolbar\SubmitToolbarItem as SubmitToolbarItemRenderer;
use Oxygen\CoreViews\Renderer\Toolbar\Toolbar as ToolbarRenderer;
use Oxygen\CoreViews\Renderer\Header\Header as HeaderRenderer;
use Oxygen\CoreViews\Renderer\Editor\Editor as EditorRenderer;
use Oxygen\CoreViews\Renderer\Dialog\Dialog as DialogRenderer;
use Oxygen\CoreViews\Renderer\Navigation\Navigation as NavigationRenderer;
use Oxygen\CoreViews\Renderer\Navigation\NavigationToggle as NavigationToggleRenderer;
use Oxygen\CoreViews\Renderer\Toolbar\VoidButtonToolbarItem as VoidButtonToolbarItemRenderer;

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
        $app = $this->app;
		ButtonToolbarItem::setRenderer(new ButtonToolbarItemRenderer($this->app['form'], $this->app['html'], $this->app['url']));
        VoidButtonToolbarItem::setRenderer(new VoidButtonToolbarItemRenderer($this->app['html']));
        FormToolbarItem::setRenderer(new FormToolbarItemRenderer($view));
        DropdownToolbarItem::setRenderer(new DropdownToolbarItemRenderer($view));
        SpacerToolbarItem::setRenderer(new SpacerToolbarItemRenderer());
        DisabledToolbarItem::setRenderer(new DisabledToolbarItemRenderer());
        SubmitToolbarItem::setRenderer(new SubmitToolbarItemRenderer());
        Header::setRenderer(new HeaderRenderer($view));
        Toolbar::setRenderer(new ToolbarRenderer());
        Editor::setRenderer(function() use($app, $view) {
            return new EditorRenderer($view, $app['auth']->user()->getPreferences());
        });
        Dialog::setRenderer(new DialogRenderer());
        Navigation::setRenderer(new NavigationRenderer($view));
        NavigationToggle::setRenderer(new NavigationToggleRenderer($view));

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
        StaticField::setRenderer('relationship', new StaticRelationshipField($app['oxygen.blueprintManager'], $app['url']));
        StaticField::setRenderer('date', new DatetimeField());
        StaticField::setRenderer('datetime', new DatetimeField());
        StaticField::setRenderer('select', new StaticSelectField());
        StaticField::setRenderer('textarea', new StaticTextareaField());
        StaticField::setRenderer('editor', new StaticTextareaField());
        StaticField::setRenderer('editor-mini', new StaticTextareaField());

        Row::setRenderer(new RowRenderer());
        Label::setRenderer(new LabelRenderer($app['html']));

        Paginator::presenter(function($paginator) {
            new Presenter($paginator, $this->app['lang'], $this->app['input']);
        });

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
