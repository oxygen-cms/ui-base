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
