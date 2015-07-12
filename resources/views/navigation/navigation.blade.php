<?php $lists = ['primary', 'secondary']; ?>

<nav id="navigation" class="MainNav">

    @foreach($lists as $list)
        <?php
            $items = Navigation::all($list)
        ?>
        @if(!empty($items))
            <ul class="MainNav-list MainNav-list--{{{ $list }}}">
                @foreach(Navigation::all($list) as $toolbarItem)
                    <li>
                        <?php
                            if($toolbarItem->shouldRender(['evenOnSamePage' => true])) {
                                echo $toolbarItem->render([
                                    'insideMainNav' => true
                                ]);
                            }
                        ?>
                    </li>
                @endforeach
            </ul>
        @endif
    @endforeach
</nav>

<div class="MainNav-spacer MainNav-spacer--main"></div>