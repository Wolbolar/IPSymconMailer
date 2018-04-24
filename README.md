# IPSymconMailer

Modul für IP-Symcon ab Version 4.3 dient zum einfachen Versenden von HTML E-Mail.

## Dokumentation

**Inhaltsverzeichnis**

1. [Funktionsumfang](#1-funktionsumfang)  
2. [Voraussetzungen](#2-voraussetzungen)  
3. [Installation](#3-installation)  
4. [Funktionsreferenz](#4-funktionsreferenz)
5. [Konfiguration](#5-konfiguartion)  
6. [Anhang](#6-anhang)  

## 1. Funktionsumfang

Das Modul nutzt [PHPMailer](https://github.com/PHPMailer/PHPMailer "PHPMailer") ([LGPL-2.1](https://github.com/PHPMailer/PHPMailer/blob/master/LICENSE "LGPL-2.1")) und stellt ein Konfigurationsformular in IP-Symcon zur Verfügung um aus IP-Symcon einfach HTML Emails versenden zu können. 

## 2. Voraussetzungen

 - IPS 4.3

## 3. Installation

### a. Laden des Moduls

Die IP-Symcon (min Ver. 4.3) Konsole öffnen. Im Objektbaum unter Kerninstanzen die Instanz __*Modules*__ durch einen doppelten Mausklick öffnen.

![Modules](docs/Modules.png?raw=true "Modules")

In der _Modules_ Instanz rechts oben auf den Button __*Hinzufügen*__ drücken.

![Modules](docs/Hinzufuegen.png?raw=true "Hinzufügen")
 
In dem sich öffnenden Fenster folgende URL hinzufügen:

	
    `https://github.com/Wolbolar/IPSymconMailer`  
    
und mit _OK_ bestätigen. 

	
### b. Einrichtung in IPS

In IP-Symcon im Objektbaum eine neue Instanz mit CTRL+1 hinzufügen als Hersteller __*PHPMailer*__ auswählen.


## 4. Funktionsreferenz

### PHPMailer:

Sendet HTML Emails


## 5. Konfiguration:

### HTMLMailer:



## 6. Anhang

###  a. Funktionen:

#### HTMLMailer:

```php
PHPMailer_SendHTML_EMail(int $InstanceID)
```
Sendet eine HTML Email mit der in der Instanz hinterlegeten Werten

```php
PHPMailer_SendHTML_EMail(int $InstanceID, string $name_recipient, string $adress_recipient, string $subject, string $body, string $altbody)
```
Sendet eine HTML Email


###  b. GUIDs und Datenaustausch:

#### HTMLMailer:

GUID: `{76CFE854-477D-9316-224D-94999B59C855}` 


