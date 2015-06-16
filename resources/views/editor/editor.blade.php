<?php
    use Oxygen\Core\Html\Editor\Editor;
?>

<div {{ HTML::attributes($editor->attributes) }}>
    @if($editor->type == Editor::TYPE_MAIN)
        <div class="Editor-header">
            <button
              type="button"
              class="Button Button-color--white flex-item Editor--switchEditor"
              data-editor="design"
              data-dialog-type="confirm"
              data-dialog-message="@lang('oxygen/ui-base::editor.switchToDesign')">
                @lang('oxygen/ui-base::editor.design')
            </button>
            <div class="ButtonTabGroup flex-item">
                <button
                  type="button"
                  class="Button Button-color--white Editor--switchEditor"
                  data-editor="code">
                    @lang('oxygen/ui-base::editor.code')
                </button>
                <button
                  type="button"
                  class="Button Button-color--white Editor--switchEditor"
                  data-editor="split">
                    @lang('oxygen/ui-base::editor.split')
                </button>
                <button
                  type="button"
                  class="Button Button-color--white Editor--switchEditor"
                  data-editor="preview">
                    @lang('oxygen/ui-base::editor.preview')
                </button>
            </div>
            <div class="align-right flex-item">
                <button type="button" class="Button Button-color--white Editor--toggleFullscreen">
                    <span class="Toggle--ifDisabled">
                        @lang('oxygen/ui-base::editor.fullscreen')
                    </span>
                    <span class="Toggle--ifEnabled Toggle--isHidden">
                        @lang('oxygen/ui-base::editor.exit')
                    </span>
                </button>
            </div>
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

            echo '<textarea ' . HTML::attributes(array(
                'name' => $editor->name,
                'id' => $editor->name . '-editor',
                'class' => 'Editor-textarea',
                'rows' => $rows
            )) . '>' . htmlspecialchars($editor->value) . '</textarea>';
        ?>
    </div>
    @if($editor->type == Editor::TYPE_MAIN)
        <div class="Editor-footer">
            <button type="submit" class="Button Button-color--green align-right Form-submit">
                @lang('oxygen/ui-base::editor.save')
            </button>
        </div>
    @endif
</div>

{{ $editor->getCreateScript() }}