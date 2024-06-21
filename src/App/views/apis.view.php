@extends('main')
@section('title', '<?= __('APIs Management') ?>')
@section('content')
<div class="container my-5">
  <div class="api-container p-4 rounded shadow bg-white">
    <div class="api-header text-center mb-4">
      <h1><?= __('APIs Management') ?></h1>
    </div>
    <form method="POST">
      <div class="form-group mb-3">
        <label for="apiName"><i class="fas fa-key"></i> <?= __('API Name') ?></label>
        <div class="input-group">
          <input type="text" class="form-control" id="apiName" name='apiName'
            placeholder="<?= __('Enter API Name') ?>" />
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-plus"></i> <?= __('Create API') ?>
          </button>
        </div>
      </div>
    </form>

    <div class="table-container mt-4">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th><?= __('API Name') ?></th>
            <th><?= __('URL') ?></th>
            <th><?= __('Manage') ?></th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1;
          foreach ((array) $objs as $api): ?>
            <tr>
              <td><?= $i ?></td>
              <td><?= $api->name ?></td>
              <td>https://recap.droosplus.com/api-summarize/<?= $api->token ?></td>
              <td>
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $i ?>">
                  <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $i ?>">
                  <i class="fas fa-trash"></i>
                </button>
                <a class="btn btn-info" href='api/history?token=<?= $api->token ?>'>
                  <i class="fas fa-calendar-alt"></i>
                </a>
                <?php $status = $api->status == 0 ? 1 : 0 ?>
                <a class="btn btn-<?= $status ? 'secondary' : 'success' ?>"
                  href='api/edit?token=<?= $api->token ?>&status=<?= $status ?>'>
                  <i class="<?= $status ? 'fas fa-pause' : 'fa-solid fa-play' ?>"></i>
                </a>
              </td>
            </tr>
            <?php $i++; endforeach; ?>
          <!-- More rows can be added here -->
        </tbody>
      </table>
    </div>
  </div>


  <?php $i = 1;
  foreach ((array) $objs as $api): ?>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal<?= $i ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel<?= $i ?>"><?= __('Edit API') ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="GET" action="/api/edit">
              <input type="hidden" name="token" value="<?= $api->token ?>" />

              <div class="form-group mb-3">
                <label for="editApiName"><i class="fas fa-key"></i> <?= __('API Name') ?></label>
                <input type="text" class="form-control" id="editApiName<?= $i ?>" name="name" value="<?= $api->name ?>" />
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
              <?= __('Close') ?>
            </button>
            <button type="submit" class="btn btn-primary">
              <?= __('Save changes') ?>
            </button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal<?= $i ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel<?= $i ?>"><?= __('Delete API') ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <?= __('Are you sure you want to delete this API?') . "({$api->name})" ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
              <?= __('Cancel') ?>
            </button>
            <a href="/api/delete/<?= $api->token ?>" class="btn btn-danger"><?= __('Delete') ?></a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php $i++; endforeach; ?>
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