# IP-Symcon HTML Mailer
[![Version](https://img.shields.io/badge/Symcon-PHPModul-red.svg)](https://www.symcon.de/service/dokumentation/entwicklerbereich/sdk-tools/sdk-php/)
[![Version](https://img.shields.io/badge/Symcon%20Version-%3E%205.1-green.svg)](https://www.symcon.de/service/dokumentation/installation/)

Das Modul nutzt [PHPMailer](https://github.com/PHPMailer/PHPMailer "PHPMailer") ([LGPL-2.1](https://github.com/PHPMailer/PHPMailer/blob/master/LICENSE "LGPL-2.1")) und stellt ein Konfigurationsformular in IP-Symcon zur Verfügung um aus IP-Symcon einfach HTML Emails versenden zu können. 

## Dokumentation

**Inhaltsverzeichnis**

1. [Funktionsumfang](#1-funktionsumfang)  
2. [Voraussetzungen](#2-voraussetzungen)  
3. [Installation](#3-installation)  
4. [Funktionsreferenz](#4-funktionsreferenz)
5. [Konfiguration](#5-konfiguration)  
6. [Anhang](#6-anhang)  

## 1. Funktionsumfang

Modul für IP-Symcon ab Version 4.3 dient zum einfachen Versenden von HTML E-Mail.
	  
## 2. Voraussetzungen

 - IP-Symcon 

## 3. Installation

### a. Laden des Moduls

Die Webconsole von IP-Symcon mit _http://{IP-Symcon IP}:3777/console/_ öffnen. 


Anschließend oben rechts auf das Symbol für den Modulstore (IP-Symcon > 5.1) klicken

![Store](img/store_icon.png?raw=true "open store")

Im Suchfeld nun

```
HTML Email
```  

eingeben

![Store](img/module_store_search.png?raw=true "module search")

und schließend das Modul auswählen und auf _Installieren_

![Store](img/install.png?raw=true "install")

drücken.


#### Alternatives Installieren über Modules Instanz

Den Objektbaum _Öffnen_.

![Objektbaum](img/objektbaum.png?raw=true "Objektbaum")	

Die Instanz _'Modules'_ unterhalb von Kerninstanzen im Objektbaum von IP-Symcon (>=Ver. 5.x) mit einem Doppelklick öffnen und das  _Plus_ Zeichen drücken.

![Modules](img/Modules.png?raw=true "Modules")	

![Plus](img/plus.png?raw=true "Plus")	

![ModulURL](img/add_module.png?raw=true "Add Module")
 
Im Feld die folgende URL eintragen und mit _OK_ bestätigen:

```
https://github.com/Wolbolar/IPSymconMailer
```  
	
Anschließend erscheint ein Eintrag für das Modul in der Liste der Instanz _Modules_    

Es wird im Standard der Zweig (Branch) _master_ geladen, dieser enthält aktuelle Änderungen und Anpassungen.
Nur der Zweig _master_ wird aktuell gehalten.

![Master](img/master.png?raw=true "master") 

Sollte eine ältere Version von IP-Symcon die kleiner ist als Version 5.1 (min 4.3) eingesetzt werden, ist auf das Zahnrad rechts in der Liste zu klicken.
Es öffnet sich ein weiteres Fenster,

![SelectBranch](img/select_branch.png?raw=true "select branch") 

hier kann man auf einen anderen Zweig wechseln, für ältere Versionen kleiner als 5.1 (min 4.3) ist hier
_Old-Version_ auszuwählen. 


### b. Einrichtung in IP-Symcon
	
In IP-Symcon nun _Instanz hinzufügen_ (_Rechtsklick -> Objekt hinzufügen -> Instanz_) auswählen unter der Kategorie, unter der man PHPMailer hinzufügen will,
und _PHPMailer_ auswählen.

## 4. Funktionsreferenz

### PHPMailer:

Sendet HTML Emails


## 5. Konfiguration:

### HTML Mailer:


## 6. Anhang

###  a. Funktionen:

#### HTMLMailer:

```php
PHPMailer_SendHTML_EMail(int $InstanceID)
```
Sendet eine HTML Email mit der in der Instanz hinterlegten Werten

```php
PHPMailer_SendHTML_EMailEx(int $InstanceID, string $name_recipient, string $adress_recipient, string $subject, string $body, string $altbody)
```
Sendet eine HTML Email


###  b. GUIDs und Datenaustausch:

#### HTMLMailer:

GUID: `{76CFE854-477D-9316-224D-94999B59C855}` 