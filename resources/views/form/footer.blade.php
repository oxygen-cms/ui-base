<div class="Row Form-footer">
    @foreach($footer->parameters as $button)
        @if($button['type'] === 'submit')
            <button
              type="submit"
              class="Button Button-color--{{ isset($button['color']) ? $button['color'] : 'green' }} Form-submit">
                {{{ $button['label'] }}}
            </button>
        @else
            <a
              href="{{{ isset($button['route']) ? URL::route($button['route']) : $button['url'] }}}"
              class="Button Button-color--{{ isset($button['color']) ? $button['color'] : 'white' }}">
                {{{ $button['label'] }}}
            </a>
        @endif
    @endforeach
</div>