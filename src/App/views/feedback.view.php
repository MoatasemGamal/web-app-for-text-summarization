@extends('main')
@section('title', 'feedback')
@section('content')
<div class="container mt-5">
    <div class="jumbotron text-center">
        <h1 class="display-4"><?= __('Thanks for Your Feedback! 🙌') ?></h1>
        <p class="lead"><?= __('We appreciate your input and will take it into consideration.') ?></p>
        <hr class="my-4">
        <a class="btn btn-primary btn-lg" href="/summarize" role="button"><?= __('Summarize another one') ?></a>
    </div>
</div>
@endSection