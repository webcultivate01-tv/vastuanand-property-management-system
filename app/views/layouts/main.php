<?php /** @var \App\Core\View $view */ ?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="theme-color" content="#C9A35B">
<title><?= e($title ?? 'Vastu Anand — Luxury Real Estate Mumbai') ?></title>
<meta name="description" content="<?= e($description ?? 'Curated luxury and investment-ready properties in Mumbai with Vastu Anand.') ?>">

<!-- Open Graph -->
<meta property="og:title" content="<?= e($title ?? 'Vastu Anand') ?>">
<meta property="og:description" content="<?= e($description ?? '') ?>">
<meta property="og:image" content="<?= asset('images/og.jpg') ?>">
<meta property="og:type" content="website">
<meta property="og:locale" content="en_IN">

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- CSS libs -->
<link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?= asset('css/luxury.css') ?>">

<!-- Tailwind CDN (utility-class support only — not used as design system) -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: { extend: {
      colors: { gold:'#C9A35B', ink:'#050505', pearl:'#F5F2EC', graphite:'#131313' },
      fontFamily: { serif: ['Cormorant Garamond','serif'], sans: ['Inter','sans-serif'] },
    }}
  };
</script>

<link rel="icon" href="<?= asset('images/favicon.svg') ?>" type="image/svg+xml">

<?php $view->include('partials.schema-org'); ?>
</head>
<body>

<!-- Loader -->
<div id="vaLoader" class="va-loader"><span class="va-loader__monogram">Va</span></div>
<script>
  // Belt-and-braces: dismiss the loader no matter what the rest of the page does.
  (function () {
    var killLoader = function () {
      var l = document.getElementById('vaLoader');
      if (l) l.classList.add('hidden');
    };
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', function(){ setTimeout(killLoader, 250); });
    } else {
      setTimeout(killLoader, 100);
    }
    setTimeout(killLoader, 1200);
  })();
</script>

<?php $view->include('partials.navbar'); ?>

<main><?= $view->yield('content') ?></main>

<?php $view->include('partials.footer'); ?>
<?php $view->include('partials.whatsapp'); ?>
<?php $view->include('partials.chatbot'); ?>

<!-- JS libs (deferred so they don't block first paint on the dev server) -->
<script defer src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/@studio-freight/lenis@1.0.42/dist/lenis.min.js"></script>
<script defer src="<?= asset('js/luxury.js') ?>"></script>

<?= $view->yield('scripts') ?>
</body>
</html>
