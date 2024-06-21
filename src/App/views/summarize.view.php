@extends('main')
@section('title', '<?= __('Summarizer') ?>')
@section('content')
<div class="container my-5">
  <div class="bg-light-subtle p-3 shadow p-3 mb-5 bg-body-tertiary rounded">
    <!-- Tab Navigation -->
    <ul class="nav nav-tabs d-md-none" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="fullText-tab" data-bs-toggle="tab" data-bs-target="#fullText-pane"
          type="button" role="tab" aria-controls="fullText-pane" aria-selected="true">
          <?= __('Full Text') ?>
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="summarizedText-tab" data-bs-toggle="tab" data-bs-target="#summarizedText-pane"
          type="button" role="tab" aria-controls="summarizedText-pane" aria-selected="false">
          <?= __('Summarized Text') ?>
        </button>
      </li>
    </ul>

    <form method="POST" enctype="multipart/form-data">
      <div class="row d-none d-md-flex">
        <div class="col-md-6">
          <div class="form-floating mb-3 position-relative">
            <textarea name="text" class="form-control bg-light-subtle" placeholder="<?= __('Full Text') ?>"
              id="fullText" style="height: calc(100vh - 400px)" oninput="handleInput()"
              dir="<?= checkLangDirection($text) ?>"><?= $text ?></textarea>
            <label for="fullText"><?= __('Full Text') ?></label>
            <div class="position-absolute bottom-0 start-0 m-1">
              <a class="rounded-circle btn btn-primary border-circle shadow me-1" title="Upload File">
                <input type="file" id="fileInput" accept=".txt, .pdf, audio/*, video/*" class="d-none" name="file"
                  onchange="handleFileUpload()" />
                <label for="fileInput" class="m-0 p-0">
                  <i class="fa-solid fa-file-upload"></i>
                </label>
              </a>
              <a class="rounded-circle btn btn-danger border-circle shadow" title="Clear All" onclick="clearAllText()">
                <i class="fa-solid fa-trash"></i>
              </a>
            </div>
            <a class="rounded-circle btn btn-secondary border-circle position-absolute top-50 start-50 translate-middle"
              title="Paste from Clipboard" id="pasteBtn" onclick="pasteText()">
              <i class="fa-solid fa-paste"></i>
            </a>
          </div>
          <div id="fileName" class="mb-2"></div>
          <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
              <b class="me-2"><?= __('Model:') ?></b>
              <select class="form-select me-3" id="modelSelection" name="model" onchange="toggleSummaryLengthInput()">
                <option value="mbartExtractive" <?= $model == 'mbartExtractive' ? 'selected' : '' ?>>MBart
                  <?= __('Extractive') ?>
                </option>
                <option value="mbartAbstractive" <?= $model == 'mbartAbstractive' ? 'selected' : '' ?>>MBart
                  <?= __('Abstractive') ?>
                </option>
                <option value="transformer" <?= $model == 'transformer' ? 'selected' : '' ?>>transformer
                  <?= __('Abstractive') ?>
                </option>
                <option value="pegasus" <?= $model == 'pegasus' ? 'selected' : '' ?>>pegasus <?= __('Abstractive') ?> (En)
                </option>
                <option value="textRank" <?= $model == 'textRank' ? 'selected' : '' ?>>Text Rank</option>
              </select>
              <div class="input-group" id="summaryLengthInput" style="display: none">
                <select class="form-select" id="summaryLengthSelect" name="summaryLength">
                  <option value="small" <?= $summaryLength == 'small' ? 'selected' : '' ?>><?= __('Small') ?></option>
                  <option value="medium" <?= $summaryLength == 'medium' ? 'selected' : '' ?>><?= __('Medium') ?></option>
                  <option value="large" <?= $summaryLength == 'large' ? 'selected' : '' ?>><?= __('Large') ?></option>
                </select>
              </div>
            </div>
            <button type="submit" class="btn btn-primary"><?= __('Summarize') ?></button>
          </div>
          <div class="d-flex justify-content-between align-items-center mt-3">
            <p><?= __('Word Count:') ?> <span id="wordCount1">0</span></p>
            <p><?= __('Sentence Count:') ?> <span id="sentenceCount1">0</span></p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating mb-3">
            <p class="overflow-auto form-control bg-light-subtle" placeholder="<?= __('Summarized Text') ?>"
              id="summarizedText" style="height: calc(100vh - 400px)" dir="<?= checkLangDirection($summary) ?>"
              disabled><?= $summary ?></p>
            <label for="summarizedText"><?= __('Summarized Text') ?></label>
          </div>
          <form id="feedbackForm" method="POST" action="/feedback">
            <input type="hidden" name="summaryId" id="summaryId" value="<?= $id ?>" />
            <div class="d-flex justify-content-between align-items-center">
              <button type="button" class="btn btn-success" onclick="submitFeedback('like')">
                <i class="fa-solid fa-thumbs-up"></i> <?= __('Like') ?>
              </button>
              <button type="button" class="btn btn-danger" onclick="submitFeedback('dislike')">
                <i class="fa-solid fa-thumbs-down"></i> <?= __('Dislike') ?>
              </button>
            </div>
          </form>
          <div class="d-flex justify-content-between align-items-center mt-3">
            <p><?= __('Word Count:') ?> <span id="wordCount2">0</span></p>
            <p><?= __('Sentence Count:') ?> <span id="sentenceCount2">0</span></p>
          </div>
        </div>
      </div>
      <div class="tab-content d-md-none" id="myTabContent">
        <div class="tab-pane fade show active" id="fullText-pane" role="tabpanel" aria-labelledby="fullText-tab">
          <div class="col-md-12">
            <div class="form-floating mb-3 position-relative">
              <textarea name="text" class="form-control bg-light-subtle" placeholder="<?= __('Full Text') ?>"
                id="fullText" style="height: calc(100vh - 400px)" oninput="handleInput()"
                dir="<?= checkLangDirection($text) ?>"><?= $text ?></textarea>
              <label for="fullText"><?= __('Full Text') ?></label>
              <div class="position-absolute bottom-0 start-0 m-1">
                <a class="rounded-circle btn btn-primary border-circle shadow me-1" title="Upload File">
                  <input type="file" id="fileInput" accept=".txt, .pdf, audio/*, video/*" class="d-none"
                    onchange="handleFileUpload()" />
                  <label for="fileInput" class="m-0 p-0">
                    <i class="fa-solid fa-file-upload"></i>
                  </label>
                </a>
                <a class="rounded-circle btn btn-danger border-circle shadow" title="Clear All"
                  onclick="clearAllText()">
                  <i class="fa-solid fa-trash"></i>
                </a>
              </div>
              <a class="rounded-circle btn btn-secondary border-circle position-absolute top-50 start-50 translate-middle"
                title="Paste from Clipboard" id="pasteBtn" onclick="pasteText()">
                <i class="fa-solid fa-paste"></i>
              </a>
            </div>
            <div id="fileName" class="mb-2"></div>
            <div class="d-flex justify-content-between align-items-center">
              <div class="d-flex align-items-center">
                <b class="me-2"><?= __('Model:') ?></b>
                <select class="form-select me-3" id="modelSelection" onchange="toggleSummaryLengthInput()">
                  <option value="mbartExtractive" <?= $model == 'mbartExtractive' ? 'selected' : '' ?>>MBart
                    <?= __('Extractive') ?>
                  </option>
                  <option value="mbartAbstractive" <?= $model == 'mbartAbstractive' ? 'selected' : '' ?>>MBart
                    <?= __('Abstractive') ?>
                  </option>
                  <option value="transformer" <?= $model == 'transformer' ? 'selected' : '' ?>>Transformer
                    <?= __('Abstractive') ?>
                  </option>
                  <option value="textRank" <?= $model == 'textRank' ? 'selected' : '' ?>>Text Rank</option>
                  <option value="pegasus" <?= $model == 'pegasus' ? 'selected' : '' ?>>pegasus <?= __('Abstractive') ?>
                    (En)
                  </option>
                </select>
                <div class="input-group" id="summaryLengthInput" style="display: none">
                  <select class="form-select" id="summaryLengthSelect">
                    <option value="small" <?= $summaryLength == 'small' ? 'selected' : '' ?>><?= __('Small') ?></option>
                    <option value="medium" <?= $summaryLength == 'medium' ? 'selected' : '' ?>><?= __('Medium') ?></option>
                    <option value="large" <?= $summaryLength == 'large' ? 'selected' : '' ?>><?= __('Large') ?></option>
                  </select>
                </div>
              </div>
              <button type="submit" class="btn btn-primary">
                <?= __('Summarize') ?>
              </button>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
              <p><?= __('Word Count:') ?> <span id="wordCount1">0</span></p>
              <p><?= __('Sentence Count:') ?> <span id="sentenceCount1">0</span></p>
            </div>
          </div>
        </div>

        <div class="tab-pane fade" id="summarizedText-pane" role="tabpanel" aria-labelledby="summarizedText-tab">
          <div class="col-md-12">
            <div class="form-floating mb-3">
              <p class="overflow-auto form-control bg-light-subtle" placeholder="<?= __('Summarized Text') ?>"
                id="summarizedText" style="height: calc(100vh - 400px)" dir="<?= checkLangDirection($summary) ?>"
                disabled><?= $summary ?>
              </p>
              <label for="summarizedText"><?= __('Summarized Text') ?></label>
            </div>
            <form id="feedbackForm" method="POST" action="/feedback">
              <input type="hidden" name="summaryId" id="summaryId" value="<?= $id ?>" />
              <div class="d-flex justify-content-between align-items-center">
                <button type="button" class="btn btn-success" onclick="submitFeedback('like')">
                  <i class="fa-solid fa-thumbs-up"></i> <?= __('Like') ?>
                </button>
                <button type="button" class="btn btn-danger" onclick="submitFeedback('dislike')">
                  <i class="fa-solid fa-thumbs-down"></i> <?= __('Dislike') ?>
                </button>
              </div>
            </form>
            <div class="d-flex justify-content-between align-items-center mt-3">
              <p><?= __('Word Count:') ?> <span id="wordCount2">0</span></p>
              <p><?= __('Sentence Count:') ?> <span id="sentenceCount2">0</span></p>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
@endSection