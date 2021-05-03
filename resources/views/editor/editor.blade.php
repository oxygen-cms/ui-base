<?php
    use Oxygen\Core\Html\Editor\Editor;
?>

<div {!! html_attributes($editor->attributes) !!}>
    @if($editor->type == Editor::TYPE_MAIN)
        <div class="Editor-header">
            <button
              type="button"
              class="Button Button-color--black flex-item Editor--switchEditor Editor-header-item"
              data-editor="design"
              >
                @lang('oxygen/ui-base::editor.design')
            </button>
            <!---
                data-dialog-type="confirm"
                data-dialog-message="@lang('oxygen/ui-base::editor.switchToDesign')">
            -->
            <div class="ButtonTabGroup ButtonTabGroup--dark Editor-header-item">
                <button
                  type="button"
                  class="Button Button-color--black Editor--switchEditor"
                  data-editor="code">
                    @lang('oxygen/ui-base::editor.code')
                </button>
                <button
                  type="button"
                  class="Button Button-color--black Editor--switchEditor"
                  data-editor="split">
                    @lang('oxygen/ui-base::editor.split')
                </button>
                <button
                  type="button"
                  class="Button Button-color--black Editor--switchEditor"
                  data-editor="preview">
                    @lang('oxygen/ui-base::editor.preview')
                </button>
            </div>
            <div class="Row--spacer"></div>
            <button type="button" class="Button Button-color--black Editor--insertMediaItem Editor-header-item">
                <span class="icon"><span class="fas fa-photo-video"></span></span>
                <span>Insert Photo or File</span>
            </button>
            <button type="button" class="Button Button-color--black Editor--toggleFullscreen Editor-header-item">
                <span class="Toggle--ifDisabled">
                    <span class="fas fa-expand"></span>
                    <span class="Text--hidden">@lang('oxygen/ui-base::editor.fullscreen')</span>
                </span>
                <span class="Toggle--ifEnabled">
                    <span class="fas fa-times"></span>
                    <span class="Text--hidden">@lang('oxygen/ui-base::editor.exit')</span>
                </span>
            </button>
            <button type="submit" class="Button Button-color--black Form-submit Editor-header-item">
                @lang('oxygen/ui-base::editor.save')
            </button>
        </div>
    @endif
    <div class="Editor-content">
        <div id="{{{ $editor->name }}}-ace-editor"></div>
        <?php
            if(isset($editor->attributes['rows'])) {
                $rows = $editor->attributes['rows'];
            } else {
                $rows = ($editor->type == Editor::TYPE_MAIN) ? 20 : 5;
            }

            echo '<textarea ' . html_attributes(array(
                'name' => $editor->name,
                'id' => $editor->name . '-editor',
                'class' => 'Editor-textarea',
                'rows' => $rows
            )) . '>' . htmlspecialchars($editor->value) . '</textarea>';
        ?>
    </div>
    @if($editor->type == Editor::TYPE_MAIN)
        <input type="hidden" class="contentPreviewCSRFToken" value="{{{ csrf_token() }}}">
        <input type="hidden" class="contentPreviewURL" value="{{{ URL::route($blueprint->getAction('postContent')->getName()) }}}">
        <input type="hidden" class="contentPreviewMethod" value="{{{ $blueprint->getAction('postContent')->getMethod() }}}">
    @endif
</div>

{!! $renderer->getCreateScript($editor) !!}
