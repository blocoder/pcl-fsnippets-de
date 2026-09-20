# PC’L Übersetzungen für FluentSnippets

Eine vollständige deutsche Übersetzung für **FluentSnippets**, in Du und in
Sie – ausgeliefert als WordPress-Plugin, das seine Kataloge vor allen anderen
lädt.

> Unabhängiges Projekt. Keine Verbindung zu WPManageNinja, den Herstellern von
> FluentSnippets.

> [!IMPORTANT]
> **Nur das ZIP aus den [Releases](https://github.com/blocoder/pcl-fsnippets-de/releases/latest) installieren.**
> Das Quellcode-Archiv der Repo-Startseite („Code → Download ZIP“) enthält
> allein die `.po`-Dateien. Die daraus gebauten Kataloge (`.mo`, `.l10n.php`)
> stecken im Release-Archiv – ohne sie übersetzt das Plugin nichts, und in der
> Plugin-Liste steht „Keine Kataloge gefunden“.

---

## Warum eine eigene Übersetzung?

FluentSnippets bringt keine deutsche Übersetzung mit, und auf wordpress.org
gibt es auch keine. Die Oberfläche bleibt also englisch, auf jeder Seite, egal
welche Sprache WordPress spricht. Ich nutze FluentSnippets auf mehreren
Seiten, darunter solchen, die siezen, und wollte die Verwaltung dort genauso
deutsch haben wie den Rest des Backends.

Ausgeliefert wird die Übersetzung als eigenes Plugin statt über Loco
Translate. Damit liegen die Kataloge an einer Stelle, wandern mit dem Plugin
auf die nächste Installation und überstehen jedes Update von FluentSnippets.

---

## Was drin ist

Stand: 17.09.2026, abgeglichen mit FluentSnippets 10.56.

| Katalog | Anrede | übersetzt |
|---|---|---:|
| `easy-code-manager-de_DE` | Du | 482 von 485 |
| `easy-code-manager-de_DE_formal` | Sie | 482 von 485 |

Die Textdomain von FluentSnippets heißt `easy-code-manager`, so wie der
Plugin-Ordner. **Offen sind drei Einträge:** der Plugin-Name, „FluentCRM“ und
die Adresse des Herstellers. Jeder trägt einen Übersetzerkommentar, warum er
leer steht.

**Welche Anrede greift, entscheidet die Sprache der Seite:** `de_DE` duzt,
`de_DE_formal` siezt. Fehlt die Datei zur eingestellten Sprache, lädt das
Plugin nichts, statt auf die andere Anrede auszuweichen.

Ein Katalog gehört zu einer Plugin-Version. Ändert der Hersteller einen
englischen Text, ist das für gettext ein neuer Schlüssel, und der alte fällt
aus dem Katalog. Am besten erst FluentSnippets aktualisieren, dann dieses
Plugin.

---

## Wie übersetzt wurde

**Weitgehend ohne Anrede.** „Namen eingeben“ statt „Gib einen Namen ein“,
„Wirklich löschen?“ statt „Bist Du sicher …?“. Deshalb unterscheiden sich
Du- und Sie-Fassung nur in einem einzigen Satz. Die Sie-Fassung entsteht aus
der Du-Fassung und wird eigens auf stehengebliebene Du-Formen geprüft.

**Ein eigenes Glossar sorgt für Konsistenz.** Die wichtigsten Entscheidungen:

| Englisch | Deutsch |
|---|---|
| Snippet | Snippet |
| Where to run | Ausführungsort |
| Safe Mode | abgesicherter Modus |
| Standalone Mode | eigenständiger Modus |
| Conditional Logic | Bedingungen |
| fatal error | schwerwiegender Fehler |
| Styles / Scripts | Stile / Skripte |
| Header / Footer (auf der Seite) | Kopfbereich / Fußbereich |

Wo FluentSnippets dieselben Bausteine nutzt wie FluentCRM (Tags,
Bedingungs-Operatoren), folgen die Begriffe der deutschen Fassung dort.

Dazu die Hausregeln: typografische Anführungszeichen `„…“`, ein echtes
Auslassungszeichen `…` statt drei Punkten, kein Title Case, keine
Ausrufezeichen.

---

## Was das Plugin außerdem tut

**Relative Zeiten stehen auf Deutsch.** Die Spalte „Aktualisiert“ in der
Snippet-Liste und die Zeile „Aktualisiert am:“ in der gruppierten Ansicht
erzeugt FluentSnippets im Browser mit einer Datums-Bibliothek, die keine
Übersetzungsdatei erreicht – dort stand „4 days ago“. Das Plugin ersetzt
genau diese Wendungen durch „vor 4 Tagen“, „in einer Stunde“ und so weiter.
Es fasst nur Texte an, die vollständig einer solchen Wendung entsprechen, und
nur an diesen beiden Stellen. Abschalten:

```php
add_filter( 'pcl_fluentsnippets_de/relative_zeiten', '__return_false' );
```

**Fremde deutsche Kataloge bleiben draußen.** Sollte für FluentSnippets einmal
ein deutsches Sprachpaket erscheinen, füllt es nicht die bewusst offenen
Stellen dieses Katalogs. Wer das anders will:

```php
add_filter( 'pcl_fluentsnippets_de/keep_foreign_german', '__return_true' );
```

**In der Plugin-Liste steht, welcher Katalog tatsächlich greift.** Das
erspart die Suche, wenn eine Datei fehlt oder die Sprache nicht passt.

**Updates kommen von selbst** (ab 1.2.0), aus den Releases dieses Repos.

---

## Was englisch bleibt

Einiges gibt FluentSnippets fest verdrahtet aus, daran kommt keine
Übersetzung heran: die Fußzeile „Thank you for using Fluent Snippets“, das
Status-Schild „published“ bzw. „draft“. Auch die eingebauten Bedienelemente
(Seitenwahl, Datumswähler) bringen englische Standardtexte mit, die an
einzelnen Stellen auftauchen können. Das ist beim Hersteller gemeldet:
[easy-code-manager#57](https://github.com/WPManageNinja/easy-code-manager/issues/57).

---

## Installation

1. Das ZIP aus [Releases](https://github.com/blocoder/pcl-fsnippets-de/releases)
   herunterladen.
2. Im Backend unter *Plugins → Installieren → Plugin hochladen* einspielen und
   aktivieren.

Das ZIP steht unter *Releases* am rechten Rand der Repo-Startseite. Der grüne
Knopf *Code → Download ZIP* daneben liefert den Quellcode ohne die gebauten
Kataloge und damit ein Plugin, das nichts übersetzt.

Die Seite muss auf `de_DE` oder `de_DE_formal` stehen. Der Plugin-Ordner heißt
`pcl-fluentsnippets-de`, auch wenn dieses Repo einen kürzeren Namen trägt.

**Voraussetzungen:** WordPress 6.5+, PHP 7.4+, FluentSnippets.

---

## Mitmachen

Ein Wort, das nicht passt? Eine Zeichenkette, die im Zusammenhang falsch
klingt? [Ein Issue](https://github.com/blocoder/pcl-fsnippets-de/issues) mit
dem englischen Original und der Stelle, an der es auftaucht, hilft am meisten.

Die `.po`-Dateien liegen in `languages/` und lassen sich direkt bearbeiten –
auch mit Loco Translate im Backend, dafür ist die `loco.xml` da. Die
kompilierten `.mo`- und `.l10n.php`-Dateien stehen nur im Release-Archiv,
nicht im Repo: Sie sind Erzeugnisse.

---

## Lizenz

`GPL-2.0-or-later`, siehe [LICENSE](LICENSE).

Die Kataloge enthalten die Quellzeichenketten von FluentSnippets und sind
damit abgeleitete Werke GPL-lizenzierter Software. Nutzung, Änderung und
Weitergabe sind erlaubt, kommerziell eingeschlossen.

Mitgeliefert ist [plugin-update-checker](https://github.com/YahnisElsts/plugin-update-checker)
von Jānis Elsts (MIT-Lizenz, siehe `plugin-update-checker/license.txt`).
