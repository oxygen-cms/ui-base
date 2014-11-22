<?php

// defaults
$title = Lang::get('oxygen/core::app.name');
$description = '';
$tags = '';

if(!isset($htmlClasses) || !is_array($htmlClasses)) {
    $htmlClasses = [];
}
$htmlClasses[] = 'no-js';
$htmlClasses[] = 'no-flexbox';

if(Auth::check() && Auth::user()->getPreferences()->get('fontSize') !== '87.5%') {
    $fontSize = Auth::user()->getPreferences()->get('fontSize');
}

if(!isset($bodyClasses) || !is_array($bodyClasses)) {
    $bodyClasses = [];
}

if(!isset($pageClasses) || !is_array($pageClasses)) {
    $pageClasses = [];
}
$pageClasses[] = 'Page';

if(!isset($usePage)) {
    $usePage = true;
}

Event::fire('oxygen.layout.headers');

?>
<!DOCTYPE html>
<html class="{{{ implode($htmlClasses, ' ') }}}"{{ isset($fontSize) ? ' style="font-size: ' . $fontSize . ';"' : ''}}>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{{ $title }}}</title>
    <meta name="description" content="{{{ $description }}}">
    <meta name="keywords" content="{{{ $tags }}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php Event::fire('oxygen.layout.head'); ?>

</head>

<body class="{{{ implode($bodyClasses, ' ') }}}">

    <?php Event::fire('oxygen.layout.body.before'); ?>

    @if($usePage)
        <div class="{{{ implode($pageClasses, ' ') }}}">
    @endif

        <?php Event::fire('oxygen.layout.page.before'); ?>

        @yield('content')

        <?php Event::fire('oxygen.layout.page.after'); ?>

    @if($usePage)
        </div>
    @endif

    <?php Event::fire('oxygen.layout.body.after'); ?>

</body>
</html>
