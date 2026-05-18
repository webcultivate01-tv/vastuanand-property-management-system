<?php $view->extend('layouts.main'); ?>
<?php $view->section('content'); ?>

<section style="padding:140px 0 60px">
  <div class="container" data-reveal>
    <span class="eyebrow">CLIENT STORIES</span>
    <h1 class="display" style="font-size:clamp(44px,5vw,72px);margin:18px 0 16px">In the words of <span class="gold" style="font-style:italic">our clients</span>.</h1>
  </div>
</section>

<section style="padding-top:0">
  <div class="container-lg">
    <div class="grid cols-3">
      <?php foreach ($items as $t) $view->include('components.testimonial', ['t' => $t]); ?>
    </div>
  </div>
</section>

<?php $view->endSection(); ?>
