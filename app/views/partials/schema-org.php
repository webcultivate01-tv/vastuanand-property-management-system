<?php /** @var array $brand */ $brand = config('app.brand'); ?>
<script type="application/ld+json">
{
  "@context":"https://schema.org",
  "@type":"RealEstateAgent",
  "name":"<?= e($brand['legal_name']) ?>",
  "image":"<?= asset('images/og.jpg') ?>",
  "url":"<?= config('app.url') ?>",
  "telephone":"<?= e($brand['phone']) ?>",
  "email":"<?= e($brand['email']) ?>",
  "description":"<?= e($brand['description']) ?>",
  "areaServed": ["Mumbai","Bandra","Powai","BKC","Worli","Andheri","Juhu","Lower Parel","Navi Mumbai","Thane","Panvel","Kalyan","Amravati"],
  "address":{ "@type":"PostalAddress", "addressLocality":"Mumbai", "addressRegion":"Maharashtra", "addressCountry":"IN" },
  "sameAs":[
    "<?= e($brand['social']['facebook']) ?>",
    "<?= e($brand['social']['instagram']) ?>",
    "<?= e($brand['social']['linkedin']) ?>"
  ]
}
</script>
