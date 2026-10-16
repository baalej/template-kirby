<?php

// Debug follows the environment: DDEV sets KIRBY_DEBUG=true in
// .ddev/config.yaml, the production host doesn't, so it stays off there.
return [
  'debug' => filter_var(getenv('KIRBY_DEBUG'), FILTER_VALIDATE_BOOLEAN),
];
