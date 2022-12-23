# Open-Vehicle and Passenger Counter
## Web-Seite die das Zäheln von Fahrzeugen und Passgieren unterstützt.

# Vorbemerkung

Es handelt sich um eien Quick and Dirty Lösung und nicht alles - besser fast nichts ist fertig und ausgereift.

# Zweck

Diese Web-Seite hilft bein Zählen von Fahrzeugen und Insassen

# Installation

1. Download des git mit *git clonegit@github.com:Byggvir/Open-Vehicle-and-Pax-Counter.git*
2. Anpassen der Datei *lib/config.conf* mit der Adresse der SITE und der Datenbankverbindung und des Password.
3. Anpassen des Passsword ggf. Datenbank in der Datein *sql/setup.sql*
4. Kopieren des Inhaltes des Ordners *html* ins (Wurzel-)Verzeichnis des Host. Beispiel: *sudo cp -ru html/* /var/www/html*
5. Ausführen des *mysql --user=root --password < sql/setup.sql* zum Anlegen der Datenbank.