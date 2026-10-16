<!DOCTYPE html>
<html lang="<?= $kirby->languageCode() ?? 'es' ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $page->isHomePage()
    ? $site->title()->esc()
    : $page->title()->esc() . ' | ' . $site->title()->esc() ?></title>
  <meta name="description" content="<?= $page->description()->or($site->description())->esc() ?>">
  <link rel="canonical" href="<?= $page->url() ?>">
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?= $page->title()->esc() ?>">
  <meta property="og:description" content="<?= $page->description()->or($site->description())->esc() ?>">
  <meta property="og:url" content="<?= $page->url() ?>">
  <?= css(['assets/css/index.css']) ?>
</head>
<body>
  <header>
    <a href="<?= $site->url() ?>"><?= $site->title()->esc() ?></a>
  </header>
  <main>
    <?= $slot ?>
  </main>
  <footer>
    Footer
  </footer>
</body>
</html>
