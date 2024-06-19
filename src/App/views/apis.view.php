@extends('main')
@section('title', 'index view')
@section('content')
<div class="container my-5">
      <div class="api-container p-4 rounded shadow bg-white">
        <div class="api-header text-center mb-4">
          <h1>APIs Management Page</h1>
        </div>
        <form>
          <div class="form-group mb-3">
            <label for="apiName"><i class="fas fa-key"></i> API Name</label>
            <div class="input-group">
              <input
                type="text"
                class="form-control"
                id="apiName"
                placeholder="Enter API Name"
              />
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create API
              </button>
            </div>
          </div>
        </form>

        <div class="table-container mt-4">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>ID</th>
                <th>API Name</th>
                <th>URL</th>
                <th>Manage</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Example API</td>
                <td>https://example.com/api</td>
                <td>
                  <button
                    class="btn btn-warning"
                    data-bs-toggle="modal"
                    data-bs-target="#editModal"
                  >
                    <i class="fas fa-edit"></i>
                  </button>
                  <button
                    class="btn btn-danger"
                    data-bs-toggle="modal"
                    data-bs-target="#deleteModal"
                  >
                    <i class="fas fa-trash"></i>
                  </button>
                  <button
                    class="btn btn-info"
                    onclick="location.href='historical.html'"
                  >
                    <i class="fas fa-calendar-alt"></i>
                  </button>
                  <button class="btn btn-secondary" onclick="toggleIcon(this)">
                    <i class="fas fa-pause"></i>
                  </button>
                </td>
              </tr>
              <!-- More rows can be added here -->
            </tbody>
          </table>
        </div>
      </div>

      <!-- Edit Modal -->
      <div
        class="modal fade"
        id="editModal"
        tabindex="-1"
        aria-labelledby="editModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editModalLabel">Edit API</h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
              <form>
                <div class="form-group mb-3">
                  <label for="editApiName"
                    ><i class="fas fa-key"></i> API Name</label
                  >
                  <input
                    type="text"
                    class="form-control"
                    id="editApiName"
                    value="Example API"
                  />
                </div>
                <div class="form-group mb-3">
                  <label for="editApiURL"
                    ><i class="fas fa-link"></i> URL</label
                  >
                  <input
                    type="text"
                    class="form-control"
                    id="editApiURL"
                    value="https://example.com/api"
                  />
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
              >
                Close
              </button>
              <button type="button" class="btn btn-primary">
                Save changes
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Delete Modal -->
      <div
        class="modal fade"
        id="deleteModal"
        tabindex="-1"
        aria-labelledby="deleteModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="deleteModalLabel">Delete API</h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
              Are you sure you want to delete this API?
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
              >
                Cancel
              </button>
              <button type="button" class="btn btn-danger">Delete</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
      function toggleIcon(button) {
        const icon = button.querySelector("i");
        if (icon.classList.contains("fa-pause")) {
          icon.classList.remove("fa-pause");
          icon.classList.add("fa-play");
        } else {
          icon.classList.remove("fa-play");
          icon.classList.add("fa-pause");
        }
      }
    </script>@endSection