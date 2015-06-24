<?php

// defaults
$title = isset($title) ? $title . ' - ' : '';
$title .= Lang::get('oxygen/core::app.name');
$description = '';
$tags = '';

if(!isset($htmlClasses) || !is_array($htmlClasses)) {
    $htmlClasses = [];
}

if(!isset($bodyClasses) || !is_array($bodyClasses)) {
    $bodyClasses = [];
}

if(!isset($pageClasses) || !is_array($pageClasses)) {
    $pageClasses = [];
}

if(!isset($usePage)) {
    $usePage = true;
}

Event::fire('oxygen.layout.headers');

Event::fire('oxygen.layout.classes', [&$htmlClasses, &$bodyClasses, &$pageClasses]);

$htmlAttributes = empty($htmlClasses) ? [] : ['class' => implode(' ', $htmlClasses)];
$bodyAttributes = empty($bodyClasses) ? [] : ['class' => implode(' ', $bodyClasses)];
$pageAttributes = empty($pageClasses) ? [] : ['class' => implode(' ', $pageClasses)];

Event::fire('oxygen.layout.attributes', [&$htmlAttributes, &$bodyAttributes, &$pageAttributes]);

?>
<!DOCTYPE html>
<html {{ html_attributes($htmlAttributes) }}>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{{ $title }}}</title>
    <meta name="description" content="{{{ $description }}}">
    <meta name="keywords" content="{{{ $tags }}}">

    <?php Event::fire('oxygen.layout.head'); ?>

</head>

<body {{ html_attributes($bodyAttributes) }}>

    <?php Event::fire('oxygen.layout.body.before'); ?>

    @if($usePage)
        <div {{ html_attributes($pageAttributes) }}>
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
