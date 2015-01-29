<?php

    use Oxygen\CoreViews\Pagination\Presenter;

    $presenter = new Presenter($paginator);

?>

<?php if ($paginator->getLastPage() > 1): ?>
    <div class="Pagination">
        <?php
            echo $presenter->getPrevious(Lang::get('pagination.previous'));
            echo '<div class="Pagination-message">' . Lang::get('pagination.message', [
                'current' => $paginator->getCurrentPage(),
                'total' => $paginator->getLastPage()
            ]) . '</div>';
            echo $presenter->getNext(Lang::get('pagination.next'));
        ?>
    </div>
<?php endif; ?>