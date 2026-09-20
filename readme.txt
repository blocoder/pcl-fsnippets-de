=== PC'L Übersetzungen für FluentSnippets ===
Contributors: blocoder
Tags: fluentsnippets, snippets, deutsch, übersetzung
Requires at least: 6.5
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.2.1
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Eine vollständige deutsche Übersetzung für FluentSnippets, in Du und in Sie.

== Description ==

FluentSnippets bringt keine deutsche Übersetzung mit, und auf wordpress.org gibt es keine. Dieses Plugin liefert sie: 482 von 485 Zeichenketten, in beiden Anreden (`de_DE` und `de_DE_formal`). Offen sind nur Produktnamen und eine Adresse.

**Wie übersetzt wurde:** weitgehend ohne Anrede formuliert, damit Du- und Sie-Fassung sich kaum unterscheiden. Ein Snippet bleibt ein Snippet, der Safe Mode heißt „abgesicherter Modus“, Conditional Logic heißt „Bedingungen“.

**Relative Zeiten** in der Snippet-Liste stehen ebenfalls auf Deutsch („vor 4 Tagen“). FluentSnippets erzeugt sie im Browser mit einer Bibliothek, die keine Übersetzungsdatei erreicht; das Plugin ersetzt dort gezielt die fertigen Wendungen.

Das Plugin lädt seine Kataloge vor allen anderen und hält fremde deutsche Fassungen fern, falls einmal eine auftaucht.

Unabhängiges Projekt, keine Verbindung zu WPManageNinja.

== Installation ==

1. Das ZIP aus den GitHub-Releases herunterladen – aus dem Bereich „Releases“, nicht über „Code → Download ZIP“. Im Quellcode-Archiv fehlen die gebauten Kataloge.
2. Im Backend unter Plugins → Installieren → Plugin hochladen einspielen und aktivieren.

Die Seite muss auf `de_DE` oder `de_DE_formal` stehen. Ab Version 1.2.0 meldet sich jedes weitere Update von selbst.

== Frequently Asked Questions ==

= Welche Anrede bekomme ich? =

Die, auf der die Seite steht: `de_DE` duzt, `de_DE_formal` siezt. Fehlt die Datei zur eingestellten Sprache, lädt das Plugin nichts, statt auf die andere Anrede auszuweichen.

= Wird das Paket auf Echtheit geprüft? =

Nein. WordPress bringt dafür einen Rahmen mit, wendet ihn aber nur auf Downloads von wordpress.org an. Was das Paket schützt, ist HTTPS und GitHub.

= Warum erscheinen einzelne Texte englisch? =

Ein Katalog gehört zu einer Plugin-Version. Ändert der Hersteller einen englischen Text, ist das für gettext ein neuer Schlüssel. Einige Texte gibt FluentSnippets außerdem fest verdrahtet aus (die Fußzeile, das Status-Schild „published“); die sind beim Hersteller gemeldet.

== Changelog ==

= 1.2.1 =
* Hinweis in der Verwaltung und in der Plugin-Liste, wenn das Plugin aus dem Quellcode-Archiv statt aus den Releases installiert wurde und die gebauten Kataloge deshalb fehlen.

= 1.2.0 =
* Updates kommen jetzt von selbst, aus den Releases auf GitHub.

= 1.1.0 =
* Relative Zeiten in der Snippet-Liste auf Deutsch („vor 4 Tagen“ statt „4 days ago“).

= 1.0.0 =
* Erste Fassung: FluentSnippets 10.56, 482 von 485 Zeichenketten, Du und Sie.
