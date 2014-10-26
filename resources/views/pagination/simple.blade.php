<?php

    use Oxygen\CoreViews\Pagination\Presenter;

    $presenter = new Presenter($paginator);

?>

<?php if ($paginator->getLastPage() > 1): ?>
    <ul class="Pagination">
        <?php
            echo $presenter->getPrevious(Lang::get('pagination.previous'));
            echo '<li class="Pagination-message">' . Lang::get('pagination.message', [
                'current' => $paginator->getCurrentPage(),
                'total' => $paginator->getLastPage()
            ]) . '</li>';
            echo $presenter->getNext(Lang::get('pagination.next'));
        ?>
    </ul>
<?php endif; ?>