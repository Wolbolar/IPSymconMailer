<?php

// set base dir
define('__ROOT__', dirname(dirname(__FILE__)));

// load ips constants
require_once(__ROOT__ . '/libs/ips.constants.php');

require_once(__DIR__ . "/../bootstrap.php");


use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\POP3;
// use PHPMailer\PHPMailer\SMTP;

class HTMLMailer extends IPSModule
{

	public function Create()
	{
//Never delete this line!
		parent::Create();

		//These lines are parsed on Symcon Startup or Instance creation
		//You cannot use variables here. Just static values.

		$this->RegisterPropertyString("SMTP", "");
		$this->RegisterPropertyInteger("SMTP_Port", 587);
		$this->RegisterPropertyInteger("SMTPDebug", 2);
		$this->RegisterPropertyBoolean("SSL", false);
		$this->RegisterPropertyBoolean("authenticate", false);
		$this->RegisterPropertyString("username", "");
		$this->RegisterPropertyString("password", "");
		$this->RegisterPropertyString("adress_sender", "");
		$this->RegisterPropertyString("name_sender", "");
		$this->RegisterPropertyString("recipients", "");
		$this->RegisterPropertyString("adress_replyto", "");
		$this->RegisterPropertyString("name_replyto", "");
		$this->RegisterPropertyString("CC", "");
		$this->RegisterPropertyString("BCC", "");
		$this->RegisterPropertyString("Subject", "");
		$this->RegisterPropertyInteger("Body", 0);
		$this->RegisterPropertyInteger("AltBody", 0);
		$this->RegisterPropertyString("attachment_name", "");
		$this->RegisterPropertyString("attachment_path", "");
	}

	public function ApplyChanges()
	{
		//Never delete this line!
		parent::ApplyChanges();
		$this->ValidateConfiguration();

	}

	/**
	 * Die folgenden Funktionen stehen automatisch zur Verfügung, wenn das Modul über die "Module Control" eingefügt wurden.
	 * Die Funktionen werden, mit dem selbst eingerichteten Prefix, in PHP und JSON-RPC wiefolgt zur Verfügung gestellt:
	 *
	 *
	 */

	private function ValidateConfiguration()
	{
		$smtp = $this->ReadPropertyString("SMTP");
		$username = $this->ReadPropertyString("username");
		$password = $this->ReadPropertyString("password");
		$name_sender = $this->ReadPropertyString("name_sender");
		$adress_sender = $this->ReadPropertyString("adress_sender");
		if($smtp == "")
		{
			$this->SetStatus(201);
		}
		if($username == "")
		{
			$this->SetStatus(202);
		}
		if($password == "")
		{
			$this->SetStatus(203);
		}
		if($name_sender == "")
		{
			$this->SetStatus(204);
		}
		if($adress_sender == "")
		{
			$this->SetStatus(205);
		}
		if($smtp != "" && $username != "" && $password != "" && $name_sender != "" && $adress_sender != "")
		{
			// Status Aktiv
			$this->SetStatus(102);
		}
	}

	public function SendHTML_EMailEx(string $name_recipient, string $adress_recipient, string $subject, string $body, string $altbody)
	{
		$this->HTML_EMail($subject, $body, $altbody, $name_recipient, $adress_recipient);
	}

	public function SendHTML_EMail()
	{
		$this->HTML_EMail($subject = NULL, $body = NULL, $altbody = NULL, $name_recipient = NULL, $adress_recipient = NULL);
	}

	protected function HTML_EMail(string $subject = NULL, string $body = NULL, string $altbody = NULL, string $name_recipient = NULL, string $adress_recipient = NULL)
	{
		$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
		try {
			//Server settings
			$mail->SMTPDebug = $this->ReadPropertyInteger("SMTPDebug");                                 // Enable verbose debug output
			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = $this->ReadPropertyString("SMTP");  // Specify main and backup SMTP servers
			$mail->SMTPAuth = $this->ReadPropertyBoolean("authenticate");                               // Enable SMTP authentication
			$mail->Username = $this->ReadPropertyString("username");                 // SMTP username
			$mail->Password = $this->ReadPropertyString("password");                           // SMTP password
			$ssl = $this->ReadPropertyBoolean("SSL");
			if($ssl)
			{
				$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			}

			$mail->Port = $this->ReadPropertyInteger("SMTP_Port");                                    // TCP port to connect to

			// Recipients
			$mail->setFrom($this->ReadPropertyString("adress_sender"), $this->ReadPropertyString("name_sender"));
			if(empty($name_recipient) && empty($adress_recipient))
			{
				$list_json = $this->ReadPropertyString("recipients");
				$list = json_decode($list_json, true);
				foreach ($list as $recipient) {
					$adress = $recipient["adress"];
					$name = $recipient["name"];
					// Add a recipient
					$mail->addAddress($adress, $name);
				}
			}
			else{
				$mail->addAddress($adress_recipient, $name_recipient);     // Add a recipient, Name is optional
			}
			$mail->addReplyTo($this->ReadPropertyString("adress_replyto"), $this->ReadPropertyString("name_replyto"));
			if($this->ReadPropertyString("CC") != "")
			{
				$mail->addCC($this->ReadPropertyString("CC"));
			}
			if($this->ReadPropertyString("BCC") != "")
			{
				$mail->addBCC($this->ReadPropertyString("BCC"));
			}

			// Attachments
			if($this->ReadPropertyString("attachment_path") != "" && $this->ReadPropertyString("attachment_name") != "")
			{
				$mail->addAttachment( $this->ReadPropertyString("attachment_path"), $this->ReadPropertyString("attachment_name"));    // Add attachments and Optional name
			}
			if($this->ReadPropertyString("attachment_path") != "")
			{
				$mail->addAttachment( $this->ReadPropertyString("attachment_path"));    // Add attachments
			}


			//Content
			$mail->isHTML(true);                                  // Set email format to HTML
			if(empty($subject))
			{
				$mail->Subject = $this->ReadPropertyString("Subject");
			}
			else{
				$mail->Subject = $subject;
			}
			if(empty($body))
			{
				$body_scriptid = $this->ReadPropertyInteger("Body");
				// 'This is the HTML message body <b>in bold!</b>'
				$mail->Body    = IPS_GetScriptContent($body_scriptid);
			}
			else{
				// 'This is the HTML message body <b>in bold!</b>'
				$mail->Body    = $body;
			}
			if(empty($altbody))
			{
				$altbody_scriptid = $this->ReadPropertyInteger("AltBody");
				// 'This is the body in plain text for non-HTML mail clients'
				$mail->AltBody = IPS_GetScriptContent($altbody_scriptid);
			}
			else{
				// 'This is the body in plain text for non-HTML mail clients'
				$mail->AltBody = $altbody;
			}

			$mail->send();
			$this->SendDebug("HTMLEmail", "Message has been sent", 1);
		} catch (Exception $e) {
			$this->SendDebug("HTMLEmail", "Message could not be sent. Mailer Error: ". $mail->ErrorInfo, 1);
		}
	}

	//Profile
	protected function RegisterProfile($Name, $Icon, $Prefix, $Suffix, $MinValue, $MaxValue, $StepSize, $Digits, $Vartype)
	{

		if (!IPS_VariableProfileExists($Name)) {
			IPS_CreateVariableProfile($Name, $Vartype); // 0 boolean, 1 int, 2 float, 3 string,
		} else {
			$profile = IPS_GetVariableProfile($Name);
			if ($profile['ProfileType'] != $Vartype)
				$this->SendDebug("BMW:", "Variable profile type does not match for profile " . $Name, 0);
		}

		IPS_SetVariableProfileIcon($Name, $Icon);
		IPS_SetVariableProfileText($Name, $Prefix, $Suffix);
		IPS_SetVariableProfileDigits($Name, $Digits); //  Nachkommastellen
		IPS_SetVariableProfileValues($Name, $MinValue, $MaxValue, $StepSize); // string $ProfilName, float $Minimalwert, float $Maximalwert, float $Schrittweite
	}

	protected function RegisterProfileAssociation($Name, $Icon, $Prefix, $Suffix, $MinValue, $MaxValue, $Stepsize, $Digits, $Vartype, $Associations)
	{
		if (sizeof($Associations) === 0) {
			$MinValue = 0;
			$MaxValue = 0;
		}

		$this->RegisterProfile($Name, $Icon, $Prefix, $Suffix, $MinValue, $MaxValue, $Stepsize, $Digits, $Vartype);

		//boolean IPS_SetVariableProfileAssociation ( string $ProfilName, float $Wert, string $Name, string $Icon, integer $Farbe )
		foreach ($Associations as $Association) {
			IPS_SetVariableProfileAssociation($Name, $Association[0], $Association[1], $Association[2], $Association[3]);
		}

	}

	/***********************************************************
	 * Configuration Form
	 ***********************************************************/

	private $id = 0;

	/**
	 * return incremented position
	 * @return int
	 */
	private function _getID()
	{
		$this->id++;
		return $this->id;
	}

	/**
	 * build configuration form
	 * @return string
	 */
	public function GetConfigurationForm()
	{
		// return current form
		return json_encode([
			'elements' => $this->FormHead(),
			'actions' => $this->FormActions(),
			'status' => $this->FormStatus()
		]);
	}

	/**
	 * return form configurations on configuration step
	 * @return array
	 */
	protected function FormHead()
	{
		$form = [
			[
				'type' => 'Label',
				'label' => 'HTML E-Mail'
			],
			[
				'type' => 'Label',
				'label' => 'PHPMailer (https://github.com/PHPMailer/PHPMailer)'
			],
			[
				'type' => 'Button',
				'label' => 'PHP Mailer Github Documentation',
				'onClick' => 'echo "https://github.com/PHPMailer/PHPMailer";'
			],
			[
				'type' => 'Label',
				'label' => 'PHP Mailer License:'
			],
			[
				'type' => 'Button',
				'label' => 'PHP Mailer License',
				'onClick' => 'echo "https://github.com/PHPMailer/PHPMailer/blob/master/LICENSE";'
			],
			[
				'name' => 'SMTP',
				'type' => 'ValidationTextBox',
				'caption' => 'SMTP Server'
			],
			[
				'name' => 'SMTP_Port',
				'type' => 'NumberSpinner',
				'caption' => 'SMTP Port'
			],
			[
				'name' => 'SSL',
				'type' => 'CheckBox',
				'caption' => 'use SSL'
			],
			[
				'name' => 'authenticate',
				'type' => 'CheckBox',
				'caption' => 'authenticate'
			],
			[
				'name' => 'username',
				'type' => 'ValidationTextBox',
				'caption' => 'username'
			],
			[
				'name' => 'password',
				'type' => 'PasswordTextBox',
				'caption' => 'password'
			],
			[
				'type' => 'Label',
				'label' => 'standard values for e-mail'
			],
			[
				'name' => 'name_sender',
				'type' => 'ValidationTextBox',
				'caption' => 'name sender'
			],
			[
				'name' => 'adress_sender',
				'type' => 'ValidationTextBox',
				'caption' => 'adress sender'
			],
			[
				'type' => 'List',
				'name' => 'recipients',
				'caption' => 'recipient',
				'rowCount' => 5,
				'add' => true,
				'delete' => true,
				'sort' => [
					'column' => 'id',
					'direction' => 'ascending'
				],
				'columns' => [
					[
						'name' => 'id',
						'label' => 'ID',
						'width' => '100px',
						'save' => true,
						'visible' => true,
						'add' => $this->_getID()
					],
					[
						'name' => 'name',
						'label' => 'name',
						'width' => '100px',
						'edit' => [
							'type' => 'ValidationTextBox',
							'caption' => 'Name'
						],
						'save' => true,
						'visible' => true,
						'add' => ''
					],
					[
						'name' => 'adress',
						'label' => 'adress',
						'width' => 'auto',
						'edit' => [
							'type' => 'ValidationTextBox',
							'caption' => 'Adress'
						],
						'save' => true,
						'visible' => true,
						'add' => ''
					]
				]
			],
			[
				'type' => 'Label',
				'label' => 'replyto:'
			],
			[
				'name' => 'name_replyto',
				'type' => 'ValidationTextBox',
				'caption' => 'name'
			],
			[
				'name' => 'adress_replyto',
				'type' => 'ValidationTextBox',
				'caption' => 'adress'
			],
			[
				'name' => 'CC',
				'type' => 'ValidationTextBox',
				'caption' => 'CC'
			],
			[
				'name' => 'BCC',
				'type' => 'ValidationTextBox',
				'caption' => 'BCC'
			],
			[
				'name' => 'Subject',
				'type' => 'ValidationTextBox',
				'caption' => 'Subject'
			],
			[
				'name' => 'Body',
				'type' => 'SelectScript',
				'caption' => 'Body'
			],
			[
				'name' => 'AltBody',
				'type' => 'SelectScript',
				'caption' => 'AltBody'
			],
			[
				'name' => 'attachment_name',
				'type' => 'ValidationTextBox',
				'caption' => 'attachment name'
			],
			[
				'name' => 'attachment_path',
				'type' => 'ValidationTextBox',
				'caption' => 'attachment path'
			]
		];
		return $form;
	}

	/**
	 * return form actions
	 * @return array
	 */
	protected function FormActions()
	{
		$form = [
			[
				'type' => 'Label',
				'label' => 'Send HTML Email'
			],
			[
				'type' => 'Button',
				'label' => 'Send',
				'onClick' => 'PHPMailer_SendHTML_EMail($id);'
			]
		];

		return $form;
	}

	/**
	 * return from status
	 * @return array
	 */
	protected function FormStatus()
	{
		$form = [
			[
				'code' => 101,
				'icon' => 'inactive',
				'caption' => 'Creating instance.'
			],
			[
				'code' => 102,
				'icon' => 'active',
				'caption' => 'Device created.'
			],
			[
				'code' => 104,
				'icon' => 'inactive',
				'caption' => 'interface closed.'
			],
			[
				'code' => 201,
				'icon' => 'error',
				'caption' => 'smtp server must not be empty'
			],
			[
				'code' => 202,
				'icon' => 'error',
				'caption' => 'user name must not be empty'
			],
			[
				'code' => 203,
				'icon' => 'error',
				'caption' => 'password must not be empty'
			],
			[
				'code' => 204,
				'icon' => 'error',
				'caption' => 'sender name must not be empty'
			],
			[
				'code' => 205,
				'icon' => 'error',
				'caption' => 'sender adress must not be empty'
			]
		];

		return $form;
	}


	/**
	 * gets current IP-Symcon version
	 * @return float|int
	 */
	protected function GetIPSVersion()
	{
		$ipsversion = floatval(IPS_GetKernelVersion());
		if ($ipsversion < 4.1) // 4.0
		{
			$ipsversion = 0;
		} elseif ($ipsversion >= 4.1 && $ipsversion < 4.2) // 4.1
		{
			$ipsversion = 1;
		} elseif ($ipsversion >= 4.2 && $ipsversion < 4.3) // 4.2
		{
			$ipsversion = 2;
		} elseif ($ipsversion >= 4.3 && $ipsversion < 4.4) // 4.3
		{
			$ipsversion = 3;
		} elseif ($ipsversion >= 4.4 && $ipsversion < 5) // 4.4
		{
			$ipsversion = 4;
		} else   // 5
		{
			$ipsversion = 5;
		}

		return $ipsversion;
	}

	//Add this Polyfill for IP-Symcon 4.4 and older
	protected function SetValue($Ident, $Value)
	{

		if (IPS_GetKernelVersion() >= 5) {
			parent::SetValue($Ident, $Value);
		} else {
			SetValue($this->GetIDForIdent($Ident), $Value);
		}
	}
}

?>