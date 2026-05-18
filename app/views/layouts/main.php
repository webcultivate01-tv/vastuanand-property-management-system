<?php /** @var \App\Core\View $view */ ?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="theme-color" content="#B08947">
<title><?= e($title ?? 'Vastu Anand — Premium Real Estate Mumbai') ?></title>
<meta name="description" content="<?= e($description ?? 'Curated luxury and investment-ready properties in Mumbai with Vastu Anand.') ?>">

<!-- Open Graph -->
<meta property="og:title" content="<?= e($title ?? 'Vastu Anand') ?>">
<meta property="og:description" content="<?= e($description ?? '') ?>">
<meta property="og:image" content="<?= asset('images/og.jpg') ?>">
<meta property="og:type" content="website">
<meta property="og:locale" content="en_IN">

<!-- Fonts (Inter only — preconnect speeds up first paint) -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<!-- Swiper styles (testimonials carousel) -->
<link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet">

<link rel="stylesheet" href="<?= asset('css/luxury.css') ?>">

<link rel="icon" href="<?= asset('images/favicon.svg') ?>" type="image/svg+xml">

<?php $view->include('partials.schema-org'); ?>
</head>
<body>

<!-- Loader -->
<div id="vaLoader" class="va-loader"><span class="va-loader__monogram">Va</span></div>
<script>
  (function () {
    var killLoader = function () {
      var l = document.getElementById('vaLoader');
      if (l) l.classList.add('hidden');
    };
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', killLoader);
    } else {
      killLoader();
    }
    setTimeout(killLoader, 600);
  })();
</script>

<?php $view->include('partials.navbar'); ?>

<main><?= $view->yield('content') ?></main>

<?php $view->include('partials.footer'); ?>
<?php $view->include('partials.whatsapp'); ?>
<?php $view->include('partials.chatbot'); ?>

<!-- Swiper for testimonials (defer so it doesn't block first paint) -->
<script defer src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script defer src="<?= asset('js/luxury.js') ?>"></script>

<?= $view->yield('scripts') ?>
</body>
</html>
