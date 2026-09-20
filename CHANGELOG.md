# Änderungen

Die Versionsnummer steigt bei **jeder** Katalogänderung, auch wenn sich am
Plugin-Code nichts tut. Ein Archiv, dessen Name nichts über seinen Inhalt
sagt, ist beim Weitergeben wertlos.

Frühere Fassungen liefen nicht öffentlich; diese Liste nennt sie trotzdem, weil
das erste veröffentlichte Archiv ihren Stand enthält.

## 1.2.1

**Ein Hinweis, wenn die gebauten Kataloge fehlen.** Wer das Plugin aus dem
Quellcode-Archiv von GitHub installiert („Code → Download ZIP“) statt aus den
Releases, bekommt nur die `.po`-Dateien und damit ein Plugin, das nichts
übersetzt. Von außen war das nicht zu erkennen – die Plugin-Liste meldete
lediglich „Keine Kataloge gefunden“, was nach einem Problem mit der Sprache
aussieht. Jetzt benennt das Plugin die Ursache, in der Plugin-Liste und als
Hinweis in der Verwaltung, samt Link auf das richtige Archiv.

An den Katalogen ändert sich nichts.

## 1.2.0

**Updates kommen jetzt von selbst.** Das Plugin bringt
[plugin-update-checker](https://github.com/YahnisElsts/plugin-update-checker)
mit und holt neue Versionen aus den Releases dieses Repos. Diese Fassung muss
einmal von Hand eingespielt werden, jede weitere meldet sich im Backend.

Die Kataloge sind unverändert. Erste öffentliche Fassung.

## 1.1.0

**Relative Zeiten auf Deutsch.** Die Spalte „Aktualisiert“ der Snippet-Liste
und die Zeile „Aktualisiert am:“ in der gruppierten Ansicht zeigen „vor 4
Tagen“ statt „4 days ago“. Abschaltbar über den Filter
`pcl_fluentsnippets_de/relative_zeiten`.

## 1.0.0

Erste Fassung, abgeglichen mit FluentSnippets 10.56: 482 von 485
Zeichenketten, in Du (`de_DE`) und Sie (`de_DE_formal`).
