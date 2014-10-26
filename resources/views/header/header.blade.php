<?php
    use Oxygen\Core\Html\Header\Header;
    use Oxygen\Core\Html\Toolbar\ButtonToolbarItem;

    $classes = ['Header'];
    if($header->getType() === Header::TYPE_TINY) {
        $classes[] = 'Header--tiny';
    }
    if($header->getType() === Header::TYPE_SMALL) {
        $classes[] = 'Header--small';
    }
    if($header->getType() === Header::TYPE_MAIN) {
        $classes[] = 'Header--main';
    }

    if(!function_exists('getHeading')) {
        function getHeading($type) {
            switch($type) {
                case Header::TYPE_MAIN:
                    return 'heading-beta';
                    break;
                case Header::TYPE_NORMAL:
                case Header::TYPE_SMALL:
                    return 'heading-gamma';
                    break;
                case Header::TYPE_TINY:
                    return 'heading-delta';
            }
            return null;
        };
    }

?>

<div class="{{{ implode(' ', $classes) }}}">
    @if($header->getBackLink() !== null)
        <div class="Header-back flex-item">
            <a
                href="{{{ $header->getBackLink() }}}"
                class="Button Button--back Link--smoothState">
                @lang('oxygen/core-views::ui.back')
            </a>
        </div>
    @endif
    <h2 class="Header-title {{{ getHeading($header->getType()) }}} flex-item">
        {{{ $header->getTitle() }}}
    </h2>
    @if($header->hasSubtitle())
        <h2 class="Header-subtitle {{{ getHeading($header->getType()) }}} flex-item">
            {{{ $header->getSubtitle() }}}
        </h2>
    @endif
    <div class="Header-toolbar flex-item">
        <?php
            foreach($header->getToolbar()->getItems() as $item) {
                if($item->shouldRender($header->getArguments())) {
                    echo $item->render($header->getArguments());
                }
            }
        ?>
    </div>
</div>