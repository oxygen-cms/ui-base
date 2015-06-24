<?php
    use Oxygen\Core\Html\Header\Header;
    use Oxygen\Core\Html\Toolbar\ButtonToolbarItem;

    $classes = $header->getClasses();
    $classes[] = 'Header';
    if($header->getType() === Header::TYPE_TINY) {
        $classes[] = 'Header--tiny';
    }
    if($header->getType() === Header::TYPE_SMALL) {
        $classes[] = 'Header--small';
    }
    if($header->getType() === Header::TYPE_NORMAL) {
        $classes[] = 'Header--normal';
    }
    if($header->getType() === Header::TYPE_MAIN) {
        $classes[] = 'Header--main';
    }
    if($header->getType() === Header::TYPE_BLOCK) {
        $classes[] = 'Header--block Block';
        $arguments = $header->getArguments();
        if(isset($arguments['span'])) {
            $classes[] = 'Cell-' . $arguments['span'];
        }
    }

    if(!function_exists('getHeading')) {
        function getHeading($type) {
            switch($type) {
                case Header::TYPE_MAIN:
                    return 'heading-beta';
                    break;
                case Header::TYPE_NORMAL:
                case Header::TYPE_SMALL:
                case Header::TYPE_BLOCK:
                    return 'heading-gamma';
                    break;
                case Header::TYPE_TINY:
                    return 'heading-delta';
            }
            return null;
        };
    }

?>

<div class="{{{ implode(' ', $classes) }}}"<?php if($header->getIndex() !== null) { echo 'data-index="' . e($header->getIndex()) . '"'; } ?>>
    @if($header->getBackLink() !== null)
        <div class="Header-back flex-item">
            <a
                href="{{{ $header->getBackLink() }}}"
                class="Button Button--back Link--smoothState">
                @lang('oxygen/ui-base::ui.back')
            </a>
        </div>
    @endif
    @if($header->hasContent())
        <div class="Header-content flex-item">
            {!! $header->getContent() !!}
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
    @if($header->hasIcon())
        <h2 class="Header-icon flex-item">
            <span class="Icon Icon-{{{ $header->getIcon() }}}"></span>
        </h2>
    @endif
    <div class="Header-toolbar flex-item">
        {!! $header->getToolbar()->render($header->getArguments()); !!}
    </div>
</div>