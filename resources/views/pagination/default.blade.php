<?php

use \Oxygen\UiBase\Pagination\Presenter;

$presenter = new Presenter($paginator, request());

echo $presenter->render();