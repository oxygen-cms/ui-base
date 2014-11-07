 <?php
    use Oxygen\Core\Action\Action;

    $method = $toolbarItem->action->getMethod();

    $insideMainNav = isset($arguments['insideMainNav']) && $arguments['insideMainNav'] === true;
    $insideDropdown = isset($arguments['insideDropdown']) && $arguments['insideDropdown'] === true;

    $renderLabel = function() use($toolbarItem, $insideMainNav) {
        if($toolbarItem->icon !== null && !$insideMainNav) {
            echo '<span class="Icon Icon-' . e($toolbarItem->icon) . ' Icon--pushRight"></span>';
        }
        echo e($toolbarItem->label);
    };

    $addMargins = function($arguments, &$attributes) {
        if(!isset($arguments['margin'])) {
            return;
        }
        if($arguments['margin'] === 'vertical') {
            $attributes['class'] .= ' Button-margin--vertical';
        } else if($arguments['margin'] === 'horizontal') {
            $attributes['class'] .= ' Button-margin--horizontal';
        }
    };

    if($method !== Action::METHOD_GET):

        $route = array_merge(
            [ $toolbarItem->action->getName() ],
            $toolbarItem->action->getRouteParameters($arguments)
        );

        $class = 'Form--sendAjax';
        if($insideMainNav)        { $class .= ' MainNav-item'; }
        else if($insideDropdown)  { $class .= ' Dropdown-itemContainer'; }

        $buttonAttributes = $toolbarItem->hasDialog() ? $toolbarItem->dialog->render() : [];

        $buttonAttributes['type'] = 'submit';

        if($insideMainNav) {
            $buttonAttributes['class'] = 'MainNav-link';
        } else if($insideDropdown) {
            $buttonAttributes['class'] = 'Dropdown-item';
        } else {
            $buttonAttributes['class'] = 'Button Button-color--' . $toolbarItem->color;
            $addMargins($arguments, $buttonAttributes);
        }

        echo Form::open([
            'route' => $route,
            'method' => $method,
            'class' => $class
        ]);

        echo '<button ' . HTML::attributes($buttonAttributes) . '>';
        echo $renderLabel();
        echo '</button>';

        echo Form::close();

    else:

        $linkAttributes = $toolbarItem->hasDialog() ? $toolbarItem->dialog->render() : [];

        $linkAttributes['href'] = URL::route(
            $toolbarItem->action->getName(),
            $toolbarItem->action->getRouteParameters($arguments)
        );

        if($insideMainNav) {
            $linkAttributes['class'] = 'MainNav-item MainNav-link';
        } else if($insideDropdown) {
            $linkAttributes['class'] = 'Dropdown-itemContainer Dropdown-item';
        } else {
            $linkAttributes['class'] = 'Button Button-color--' . $toolbarItem->color;
            $addMargins($arguments, $linkAttributes);
        }

        if($toolbarItem->action->useSmoothState) {
            $linkAttributes['class'] .= ' Link--smoothState';
        }

        echo '<a ' . HTML::attributes($linkAttributes) . '>';
        echo $renderLabel();
        echo '</a>';

    endif;