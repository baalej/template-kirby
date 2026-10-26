# template-kirby

Plantilla para proyectos Kirby 5, en local con DDEV y desplegados por
rsync a hosting compartido. Las normas de código están en `AGENTS.md`.

## Proyectos nuevos

Se crean con `new-kirby <nombre>` (en `~/automation`). El script instala la
última versión etiquetada con Composer, fija el nombre en
`.ddev/config.yaml`, hace el primer commit y arranca DDEV.

## Desarrollo

```bash
colima start
ddev start
ddev launch           # la web
ddev launch /panel    # el Panel; la primera vez pide crear el usuario
```

Al terminar:

```bash
ddev poweroff
colima stop
```

## Google Analytics y banner de cookies

Viene en `site/plugins/consent` y está apagado mientras no haya `id`.
Para activarlo, en `site/config/config.php`:

```php
'baalej.consent' => [
  'id' => 'G-XXXXXXXXXX',
  'privacy' => 'privacidad', // id de página o URL; opcional
],
```

Los textos del banner (`text`, `accept`, `reject`, `privacyLabel`,
`settings`) se cambian con esas mismas claves. Los estilos usan
`--foreground` y `--background`; para adaptarlos al proyecto, se
sobrescriben las clases `.consent` y `.consent-settings` desde su CSS.

GA no se descarga hasta que se acepta, así que antes de elegir no hay
cookies ni hace falta Consent Mode. El botón «Configurar cookies» del
footer reabre el banner. Si se retira el consentimiento, se borran las
cookies `_ga*` y se recarga la página.

Para no contar las visitas de desarrollo, el `id` real va solo en la
config del dominio de producción, que Kirby carga encima de `config.php`
cuando el host coincide:

```php
// site/config/config.www.dominio.com.php
return [
  'baalej.consent' => ['id' => 'G-XXXXXXXXXX'],
];
```

Para probarlo en local se usa un ID de prueba en
`site/config/config.template-kirby.ddev.site.php` (con el nombre del
proyecto) y se borra al terminar.

## Decisiones que conviene no deshacer

**Solo se toca `name:` en `.ddev/config.yaml`.** `ddev config` regenera el
fichero entero con valores por defecto y cientos de líneas de comentarios.

**DDEV con Apache**, como el hosting. Así el `.htaccess` se usa también
en local: con nginx no se aplica, y `content/` o `site/` quedan accesibles
por URL sin que nada lo avise.

**DDEV sin base de datos.** Kirby guarda el contenido en ficheros
(`content/`), así que el contenedor de BD sobra.

**El modo debug sale del entorno.** DDEV define `KIRBY_DEBUG=true` y
`site/config/config.php` lo lee. El hosting no lo define, así que en
producción el debug queda apagado sin tener que acordarse.

**Composer resuelve como PHP 8.3** (`config.platform.php`), la misma
versión que DDEV, aunque el Mac tenga otra. Así `composer.lock` y
`vendor/` sirven igual en local, en DDEV y en el hosting.

**`kirby/`, `vendor/`, `media/` y `site/{accounts,cache,sessions}` no van
a git.** Los dos primeros los instala Composer; el resto lo genera Kirby.

## Mantener esta plantilla

Los proyectos creados **no** heredan cambios de aquí. Etiqueta con semver
cada versión que quieras que hereden los proyectos nuevos:

```bash
git tag v1.3.0 && git push && git push --tags
```

Composer solo ve los tags que están en GitHub; `new-kirby` avisa si hay
alguno sin subir.
