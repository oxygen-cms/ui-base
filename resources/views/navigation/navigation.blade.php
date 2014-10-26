<?php $lists = ['primary', 'secondary']; ?>

<nav id="navigation" class="MainNav">

    @foreach($lists as $list)
        @if(!empty(Navigation::all($list)))
            <ul class="MainNav-list MainNav-list--{{{ $list }}}">
                @foreach(Navigation::all($list) as $toolbarItem)
                    <?php
                        if($toolbarItem->shouldRender(['evenOnSamePage' => true])) {
                            echo $toolbarItem->render([
                                'insideMainNav' => true
                            ]);
                        }
                    ?>
                @endforeach
            </ul>
        @endif
    @endforeach
</nav>

<div class="MainNav-spacer MainNav-spacer--main"></div>