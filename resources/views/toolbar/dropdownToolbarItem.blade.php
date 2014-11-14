<div class="{{{ ($insideMainNav ? 'MainNav-item ' : '') . 'Dropdown-container' }}}">
    <?php
        $buttonClasses = ['Dropdown-button'];
        if($insideMainNav) {
            $buttonClasses[] = 'MainNav-link';
        } else {
            $buttonClasses[] = 'Button Button-color--' . $toolbarItem->color;
        }
    ?>
    @if(is_string($toolbarItem->label))
        <button class="{{{ implode(' ', $buttonClasses) }}}">
            {{{ $toolbarItem->label }}}
            <span class="Icon Icon-{{{ $toolbarItem->icon }}} Icon--pushLeft"></span>
        </button>
    @else
        <div class="ButtonTabGroup">
            <?php
                echo $toolbarItem->label->render([
                    'model'          => $model,
                    'insideMainNav'  => $insideMainNav
                ]);
            ?>
            <span class="Icon Icon-{{{ $toolbarItem->icon }}} Icon--pushLeft Button Button-color--white"></span>
        </div>
    @endif
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