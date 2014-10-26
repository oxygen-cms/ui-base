<?php
    use Oxygen\CoreViews\Renderer\Toolbar\ButtonToolbarItem;
?>

<div class="{{{ ($insideMainNav ? 'MainNav-item ' : '') . 'Dropdown-container' }}}">
    <button class="{{{ $insideMainNav ? 'MainNav-link' : 'Button Button-color--' . $toolbarItem->color . ' Dropdown-button' }}}">
        {{{ $toolbarItem->label }}}
        <span class="Icon Icon-{{{ $toolbarItem->icon }}} Icon--pushLeft"></span>
    </button>
    <div class="{{{ (!$insideMainNav ? 'Dropdown--round ' : '') . 'Dropdown' }}}">
        <?php
            foreach($toolbarItem->itemsToDisplay as $item):
                echo $item->render([
                    'model'          => $model,
                    'insideDropdown' => true
                ]);
            endforeach;
        ?>
    </div>
</div>