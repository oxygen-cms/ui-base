<div class="Dropdown-container">
    @if($toolbarItem->shouldRenderButton)
        <div class="ButtonTabGroup">
            <?php
                echo $toolbarItem->button->render([
                    'model'          => $model,
                    'insideMainNav'  => $insideMainNav
                ]);
            ?>
            <span class="fa fa-{{{ $toolbarItem->icon }}} Icon--pushLeft Button Button-color--white"></span>
        </div>
    @else
        <?php
            $buttonClasses = ['Dropdown-button'];
            if($insideMainNav) {
                $buttonClasses[] = 'MainNav-link';
            } else {
                $buttonClasses[] = 'Button Button-color--' . $toolbarItem->color;
            }
        ?>
        <button class="{{{ implode(' ', $buttonClasses) }}}">
            {{{ $toolbarItem->label }}}
            <span class="fa fa-{{{ $toolbarItem->icon }}} Icon--pushLeft"></span>
        </button>
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