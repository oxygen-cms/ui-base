<div class="Dropdown-container">
    @if($toolbarItem->shouldRenderButton)
        <div class="ButtonTabGroup">
            <div class="control">
            <?php
                echo $toolbarItem->button->render([
                    'model'          => $model,
                    'insideMainNav'  => $insideMainNav
                ]);
            ?>
            </div>
            <div class="control">
            <span class="Button Button-color--white">
                <span class="fa fa-{{{ $toolbarItem->icon }}}"></span>
            </span>
            </div>
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
        <div class="dropdown-content">
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
</div>
