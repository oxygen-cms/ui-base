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
        var notification = document.createElement("div");
        notification.classList.add("Notification");
        notification.classList.add("Notification--bug");
        notification.innerHTML = "<h2><strong>Bug:</strong></h2><code>" + message + "</code>"; document.querySelector(".Notification-container").appendChild(notification);
    }
    window.onerror = function(errorMsg, url, lineNumber) {
        bug(errorMsg);
    };
    window.addEventListener("unhandledrejection", function(event, promise) {
        bug(event.reason);
    });
</script>
