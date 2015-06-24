<?php
    use Oxygen\Core\Html\ImageEditor\ImageEditor;
?>

<div {{ html_attributes($editor->attributes) }}>
    @if($editor->type == ImageEditor::TYPE_MAIN)
        <div class="ImageEditor-toolbar">
            <button
              type="button"
              class="Button Button-color--white flex-item js-editor-switch"
              data-editor="design">
                Design
            </button>
            <div class="ButtonTabGroup flex-item">
                <button
                  type="button"
                  class="Button Button-color--white js-editor-switch"
                  data-editor="code">
                    Code
                </button>
                <button
                  type="button"
                  class="Button Button-color--white js-editor-switch"
                  data-editor="split">
                    Split
                </button>
                <button
                  type="button"
                  class="Button Button-color--white js-editor-switch"
                  data-editor="preview">
                    Preview
                </button>
            </div>
            <div class="align-right flex-item">
                <button type="button" class="Button Button-color--white js-editor-fullscreen">
                    <span class="if-disabled">Fullscreen</span>
                    <span class="if-enabled is-hidden">Close</span>
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
            )) . '>' . $editor->value . '</textarea>';
        ?>
    </div>
    @if($editor->type == Editor::TYPE_MAIN)
        <div class="ImageEditor-footer">
            <button type="submit" class="Button Button-color--green">Save</button>
        </div>
    @endif
</div>

{{ $editor->getCreateScript() }}