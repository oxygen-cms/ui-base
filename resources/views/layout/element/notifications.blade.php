<!-- =========================================
                  Flash Messages
     ========================================= -->

<div class="Notification-container">
    @if (Session::has('adminMessage'))
        <div class="Notification Notification--{{{ Session::get('adminMessage')['status'] }}} is-hidden">
            {!! Session::get('adminMessage')['content'] !!}
            <span class="Notification-dismiss fas fa-times"></span>
        </div>
    @endif
</div>
