<?php

// Google Analytics 4 behind a cookie banner. GA is never requested until the
// visitor accepts, so no consent mode or cookie is needed before that.
// Without an `id` the snippets render nothing, so the plugin can stay
// installed in projects that don't use analytics.
Kirby::plugin('baalej/consent', [
  'options' => [
    'id' => null,
    'privacy' => null,
    'text' => 'Usamos cookies de Google Analytics para saber cómo se usa la web. Solo se activan si las aceptas.',
    'accept' => 'Aceptar',
    'reject' => 'Rechazar',
    'privacyLabel' => 'Política de privacidad',
    'settings' => 'Configurar cookies',
  ],
  'snippets' => [
    'consent/banner' => __DIR__ . '/snippets/banner.php',
    'consent/settings' => __DIR__ . '/snippets/settings.php',
  ],
]);
