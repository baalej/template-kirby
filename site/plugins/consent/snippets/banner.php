<?php

$id = option('baalej.consent.id');

if (empty($id)) {
  return;
}

$plugin = $kirby->plugin('baalej/consent');
$privacy = option('baalej.consent.privacy');
$privacyUrl = $privacy ? (page($privacy)?->url() ?? $privacy) : null;
?>
<?= css($plugin->asset('banner.css')->url()) ?>
<section class="consent" aria-label="<?= esc(option('baalej.consent.settings'), 'attr') ?>" data-consent data-consent-id="<?= esc($id, 'attr') ?>" hidden>
  <p class="consent__text">
    <?= esc(option('baalej.consent.text')) ?>
    <?php if ($privacyUrl): ?>
      <a class="consent__link" href="<?= esc($privacyUrl, 'attr') ?>"><?= esc(option('baalej.consent.privacyLabel')) ?></a>
    <?php endif ?>
  </p>
  <div class="consent__actions">
    <button class="consent__button" type="button" data-consent-choice="denied"><?= esc(option('baalej.consent.reject')) ?></button>
    <button class="consent__button" type="button" data-consent-choice="granted"><?= esc(option('baalej.consent.accept')) ?></button>
  </div>
</section>
<?= js($plugin->asset('banner.js')->url(), ['defer' => true]) ?>
