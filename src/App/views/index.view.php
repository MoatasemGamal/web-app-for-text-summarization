@extends('main')
@section('title', '<?= __('Summarizer') ?>')
@section('content')

<main class="container mt-5 text-center">
    <section class="hero">
        <div class="jumbotron">
            <h1 class="display-4"><?= __('Welcome to the Web Text Summarization Tool') ?></h1>
            <p class="lead">
                <?= __('Summarize your texts efficiently with our state-of-the-art summarization models.') ?>
            </p>
            <a href="/summarize" class="btn btn-primary btn-lg"><i class="fa-solid fa-text-width"></i>
                <?= __('Get Started') ?></a>
        </div>
    </section>
    <section class="features my-5">
        <h2 class="text-center"><?= __('Features') ?></h2>
        <div class="row text-center">
            <div class="col-md-3">
                <i class="fas fa-language fa-3x mb-3"></i>
                <h3><?= __('Multi-language Support') ?></h3>
                <p><?= __('Our tool supports both English and Arabic languages for text summarization.') ?></p>
            </div>
            <div class="col-md-3">
                <i class="fas fa-file-upload fa-3x mb-3"></i>
                <h3><?= __('Upload Options') ?></h3>
                <p><?= __('Upload PDF or TXT files to get a summarized version of the text.') ?></p>
            </div>
            <div class="col-md-3">
                <i class="fas fa-sliders-h fa-3x mb-3"></i>
                <h3><?= __('Customizable Summaries') ?></h3>
                <p><?= __('Control the length of your summaries with ease.') ?></p>
            </div>
            <div class="col-md-3">
                <i class="fas fa-history fa-3x mb-3"></i>
                <h3><?= __('User History') ?></h3>
                <p><?= __('Track and manage your summarization history.') ?></p>
            </div>
        </div>
    </section>
    <section class="how-it-works my-5">
        <h2 class="text-center"><?= __('How It Works') ?></h2>
        <div class="row text-center">
            <div class="col-md-4">
                <i class="fas fa-upload fa-3x mb-3"></i>
                <h4><?= __('Step') ?> 1</h4>
                <p><?= __('Upload your text file.') ?></p>
            </div>
            <div class="col-md-4">
                <i class="fas fa-sliders-h fa-3x mb-3"></i>
                <h4><?= __('Step') ?> 2</h4>
                <p><?= __('Choose the desired summary length.') ?></p>
            </div>
            <div class="col-md-4">
                <i class="fas fa-file-alt fa-3x mb-3"></i>
                <h4><?= __('Step') ?> 3</h4>
                <p><?= __('Get your summarized text instantly.') ?></p>
            </div>
        </div>
    </section>
    <section class="about my-5">
        <h2 class="text-center"><?= __('About the Project') ?></h2>
        <p class="text-center">
            <?= __('This project is developed as a capstone project aiming to improve information accessibility and management through advanced text summarization techniques.') ?>
        </p>
    </section>
</main>

@endSection