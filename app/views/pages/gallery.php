<?php $view->extend('layouts.main'); ?>
<?php $view->section('content'); ?>

<section style="padding:140px 0 40px">
  <div class="container" data-reveal>
    <span class="eyebrow">GALLERY</span>
    <h1 class="display" style="font-size:clamp(44px,5vw,72px);margin:18px 0 16px">Inside our <span class="gold" style="font-style:italic">portfolio</span></h1>
    <p class="muted" style="max-width:680px;font-size:17px;line-height:1.7">A visual tour through the homes, neighbourhoods and experiences Vastu Anand has had the privilege of curating.</p>
  </div>
</section>

<section style="padding-top:0">
  <div class="container-lg">
    <div class="grid cols-4" style="gap:14px">
      <?php foreach ($items as $i => $g): ?>
        <div data-reveal data-reveal-delay="<?= ($i % 4) * 100 ?>" style="aspect-ratio:<?= $i % 3 === 0 ? '3/4' : '4/3' ?>;border-radius:14px;overflow:hidden;background:#111">
          <img src="<?= e($g['image']) ?>" alt="<?= e($g['caption'] ?? '') ?>"
               style="width:100%;height:100%;object-fit:cover;transition:transform 1s var(--ease)"
               onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'"
               onerror="this.src='https://picsum.photos/600/600?random=<?= $i ?>'">
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php $view->endSection(); ?>
