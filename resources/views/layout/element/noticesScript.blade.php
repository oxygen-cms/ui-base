<script>
    window.onerror = function (errorMsg, url, lineNumber) {
        errorElement = document.getElementsByClassName("Notice--jsError")[0];
        disabledElement = document.getElementsByClassName("Notice--jsDisabled")[0];
        disabledElement.classList.add("Notice--isHidden");
        errorElement.classList.remove("Notice--isHidden");
        document.documentElement.classList.remove("js");
        document.documentElement.classList.add("no-js");
    }
</script>
