<div class="Row">

    <div class="Form-label flex-item">
        {{{ $field->getMeta()->label }}}:
    </div>

    @if($field->isPretty())
        <div class="Form-content flex-item">{{{ $field->getPresentedValue() }}}</div>
    @else
        <pre class="Form-content flex-item">{{{ $field->getValue() }}}</pre>
    @endif


</div>