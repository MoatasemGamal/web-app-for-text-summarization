@extends('main')
@section('title', '<?= __('History') ?>')
@section('content')
<div class="container my-5">
    <div class="historical-container">
        <div class="api-header">
            <h1><?= __('Welcome,') ?> <?= $name ?></h1>
        </div>

        <div class="table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><?= __('Text') ?></th>
                        <th><?= __('Cleaned Text') ?></th>
                        <th><?= __('Summary') ?></th>
                        <th><?= __('Length') ?></th>
                        <th><?= __('Model') ?></th>
                        <th><?= __('Date') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($objs as $his): ?>
                        <tr dir="<?= checkLangDirection($his->text) ?>">
                            <td><?= $his->text ?></td>
                            <td><?= $his->cleaned_text ?></td>
                            <td><?= $his->summary ?></td>
                            <td><?= $his->length ?></td>
                            <td><?= $his->model ?></td>
                            <td><?= $his->created_at ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <!-- More rows can be added here -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="pagination justify-content-center">
    <ul class="pagination">
        <!-- Previous Page Link -->
        <li class="page-item <?php echo $current <= 1 ? 'disabled' : ''; ?>">
            <a class="page-link" href="?page=<?php echo ($current - 1); ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only"><?= __('Previous') ?></span>
            </a>
        </li>

        <!-- Pagination Links -->
        <?php for ($i = 1; $i <= $pages; $i++): ?>
            <li class="page-item <?php echo $i == $current ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>

        <!-- Next Page Link -->
        <li class="page-item <?php echo $current >= $pages ? 'disabled' : ''; ?>">
            <a class="page-link" href="?page=<?php echo ($current + 1); ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only"><?= __('Next') ?></span>
            </a>
        </li>
    </ul>
</div>

@endSection