<!--[if lte IE 8]>
    <div class="Notice Notice--ie">
            @lang('oxygen/ui-base::notices.ie')
    </div>
<![endif]-->

<div class="Notice Notice--jsDisabled">
    @lang('oxygen/ui-base::notices.jsDisabled')
</div>

<script>
    function bug(message) {
        window.alert('Bug: ' + message);
    }
    window.onerror = function(msg, url, line, col, error) {
        bug(msg);
    };
    window.addEventListener("unhandledrejection", function(event, promise) {
        bug(event.reason);
    });
</script>
