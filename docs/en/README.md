# IP-Symcon HTML Mailer
[![Version](https://img.shields.io/badge/Symcon-PHPModule-red.svg)](https://www.symcon.de/service/dokumentation/entwicklerbereich/sdk-tools/sdk-php/)
[![Version](https://img.shields.io/badge/Symcon%20Version-%3E%205.1-green.svg)](https://www.symcon.de/en/service/documentation/installation/)

The module uses [PHPMailer](https://github.com/PHPMailer/PHPMailer "PHPMailer") ([LGPL-2.1](https://github.com/PHPMailer/PHPMailer/blob/master/LICENSE "LGPL-2.1")) and provides a configuration form in IP-Symcon in order to be able to easily send HTML emails from IP-Symcon.

## Documentation

**Table of Contents**

1. [Features](#1-features)
2. [Requirements](#2-requirements)
3. [Installation](#3-installation)
4. [Function reference](#4-functionreference)
5. [Configuration](#5-configuration)
6. [Annex](#6-annex)

## 1. Features

The module can control Nanoleaf from IP Symcon.

## 2. Requirements

- On / off
- color selection
- hue
- saturation
- brightness
- color temperature
- set effect

## 3. Installation

### a. Loading the module

Open the IP Console's web console with _http://{IP-Symcon IP}:3777/console/_.

Then click on the module store (IP-Symcon > 5.1) icon in the upper right corner.

![Store](img/store_icon.png?raw=true "open store")

In the search field type

```
Nanoleaf
```  


![Store](img/module_store_search_en.png?raw=true "module search")

Then select the module and click _Install_

![Store](img/install_en.png?raw=true "install")


#### Install alternative via Modules instance

_Open_ the object tree.

![Objektbaum](img/object_tree.png?raw=true "object tree")	

Open the instance _'Modules'_ below core instances in the object tree of IP-Symcon (>= Ver 5.x) with a double-click and press the _Plus_ button.

![Modules](img/modules.png?raw=true "modules")	

![Plus](img/plus.png?raw=true "Plus")	

![ModulURL](img/add_module.png?raw=true "Add Module")
 
Enter the following URL in the field and confirm with _OK_:


```	
https://github.com/Wolbolar/IPSymconMailer
```
    
and confirm with _OK_.    
    
Then an entry for the module appears in the list of the instance _Modules_

By default, the branch _master_ is loaded, which contains current changes and adjustments.
Only the _master_ branch is kept current.

![Master](img/master.png?raw=true "master") 

If an older version of IP-Symcon smaller than version 5.1 (min 4.3) is used, click on the gear on the right side of the list.
It opens another window,

![SelectBranch](img/select_branch_en.png?raw=true "select branch") 

here you can switch to another branch, for older versions smaller than 5.1 (min 4.3) select _Old-Version_ .

### b.  Setup in IP-Symcon

In IP-Symcon _add Instance_ (_rightclick -> add object -> instance_) under the category under which you want to add the PHPMailer instance,
and select _PHPMailer_.

## 4. Function reference

### PHPMailer:

Send HTML Emails

## 5. Configuration:

### HTML Mailer:

## 6. Annex

###  a. Functions:

#### HTMLMailer:

```php
PHPMailer_SendHTML_EMail(int $InstanceID)
```
Sends an HTML email with the values stored in the instance

```php
PHPMailer_SendHTML_EMailEx(int $InstanceID, string $name_recipient, string $adress_recipient, string $subject, string $body, string $altbody)
```
Sends an HTML Email


###  b. GUIDs and data exchange:

#### HTMLMailer:

GUID: `{76CFE854-477D-9316-224D-94999B59C855}` 

