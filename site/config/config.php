<?php

// Debug follows the environment: DDEV sets KIRBY_DEBUG=true in
// .ddev/config.yaml, the production host doesn't, so it stays off there.
return [
  'debug' => filter_var(getenv('KIRBY_DEBUG'), FILTER_VALIDATE_BOOLEAN),

  // Google Analytics + cookie banner (site/plugins/consent). Without an
  // id nothing is rendered. `privacy` takes a page id or a URL; banner texts
  // can be overridden here too (see the plugin's index.php).
  'baalej.consent' => [
    'id' => null,
    'privacy' => null,
  ],
];
