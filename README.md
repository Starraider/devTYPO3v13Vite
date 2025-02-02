# TYPO3 CMS Base Distribution

Get going quickly with TYPO3 CMS.

## Prerequisites

* PHP 8.3
* [Composer](https://getcomposer.org/download/)


## Rector/Fractor

### Vorschau anzeigen

```bash
vendor/bin/rector process --dry-run

vendor/bin/rector process packages/leseohren --dry-run
vendor/bin/rector process packages/skombase13 --dry-run
```

### Änderungen durchführen lassen

```bash
vendor/bin/rector process
vendor/bin/fractor process
```

## CLI

### Cache leeren

```bash
ddev typo3 cache:flush
```

### reference-index aktualisieren

```bash
ddev typo3 referenceindex:update
```

### language files aktualisieren

```bash
ddev typo3 language:update
```

### DB-Updates

```bash
ddev typo3 database:updateschema
```

### DB-Backup
```bash
ddev typo3 database:export -c Default > ./Quellen/backup/2025-01-21_db.sql

cat ./Quellen/backup/2025-01-21_db.sql | ddev typo3 database:import --connection Default
```

### DB-Health

```bash
ddev typo3 dbdoctor:health
```
Wenn ein Fehler gefunden wird, gibt es folgende Optionen:

e - EXECUTE suggested changes!

s - SIMULATE suggested changes, no execution

a - ABORT now

r - RELOAD this check

p - SHOW records by page

d - SHOW record details

? - HELP

## License

GPL-2.0 or later
