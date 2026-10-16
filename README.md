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
