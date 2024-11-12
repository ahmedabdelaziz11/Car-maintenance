<?php
$queryParams = $_GET;
unset($queryParams['page']);

function buildQueryString($params, $page) {
    $params['page'] = $page;
    return http_build_query($params);
}

$previousPage = max(1, $page - 1);
$nextPage = $page + 1;
?>

<nav aria-label="Page navigation" style="margin-top: 10px;">
    <ul class="pagination">
        <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>">
            <a class="page-link pagination-link" style="float: inline-start;" href="#" data-page="<?= $page - 1 ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo; Previous</span>
            </a>
        </li>

        <li class="page-item <?= ($hasNextPage) ? '' : 'disabled' ?>">
            <a class="page-link pagination-link" style="float: inline-end;" href="#" data-page="<?= $page + 1 ?>" aria-label="Next">
                <span aria-hidden="true">Next &raquo;</span>
            </a>
        </li>
    </ul>
</nav>