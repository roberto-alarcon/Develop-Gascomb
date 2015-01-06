<?php
/**
*
* SMTP4PHP :  PHP powerful tool for sending e-mails fast and easily.
*
* SMTP4PHP is a collection of PHP classes, dedicated for composing and sending 
* multipart/mixed email messages quickly and easily, with or without embedded 
* images and/or attachments.
*
* Copyright (c) 2011 - 2012, Raul IONESCU <ionescu.raul@gmail.com>, 
* Bucharest, ROMANIA
*
* Licensed under The MIT License
* Redistributions of files must retain the above copyright notice.
*
* @package      SMTP4PHP
* @author       Raul IONESCU <ionescu.raul@gmail.com>
* @copyright    Copyright (c) 2011 - 2012, Raul IONESCU.
* @license      http://www.opensource.org/licenses/mit-license.php The MIT License
* @version      2011, 14th release  
* @link         https://plus.google.com/u/0/109110210502120742267
* @access       public
*
* PHP versions 5.3 or greater
*/
/*///////////////////////////////////////////////////////////////////////////////////////*/
/*///////////////////////////////////////////////////////////////////////////////////////*/
/*///////////////////////////////////////////////////////////////////////////////////////*/

namespace 
        { 
         /*///////////////////////////////////////////////////////////////////////////////////////*/
         function exception_error_handler($errno, $errstr, $errfile, $errline, $errcontext ) 
         { throw new ErrorException($errstr, $errno, 0, $errfile, $errline); }
         /*///////////////////////////////////////////////////////////////////////////////////////*/
         set_error_handler("exception_error_handler");
         /*///////////////////////////////////////////////////////////////////////////////////////*/
        }

/*///////////////////////////////////////////////////////////////////////////////////////*/
/*///////////////////////////////////////////////////////////////////////////////////////*/
/*///////////////////////////////////////////////////////////////////////////////////////*/

namespace SMTP4PHP 
        {
         const VERSION = 2011;
         const RELEASE = 14;
         
         
         use \Exception, \stdClass;
         /*///////////////////////////////////////////////////////////////////////////////////////*/
         /*///////////////////////////////////////////////////////////////////////////////////////*/
         /*///////////////////////////////////////////////////////////////////////////////////////*/
         
         abstract class Toolbox
          {
           const EOL = "\r\n";
           /*///////////////////////////////////////////////////////////////////////////////////////*/
           protected function _intValue($v) { return abs(intval(preg_replace('/[^0-9]/','',$v))); }
           /*///////////////////////////////////////////////////////////////////////////////////////*/
           protected function _toSingleDimensionalArray(array $a)
           {
            $values = new stdClass();
            $values->values = array();
            array_walk_recursive($a, create_function('$value, $key, $obj', 'array_push($obj->values, $value);'), $values);  
            return $values = $values->values;           
           }
           /*///////////////////////////////////////////////////////////////////////////////////////*/
          }
         
         /*///////////////////////////////////////////////////////////////////////////////////////*/
         /*///////////////////////////////////////////////////////////////////////////////////////*/
         /*///////////////////////////////////////////////////////////////////////////////////////*/
         
         class User
         {
          protected $name;
          protected $email;
          /*///////////////////////////////////////////////////////////////////////////////////////*/
          public function __construct($name = NULL, $email = NULL) 
          { 
           if($email) { $this->email = self::validateEmail($email); }
           if($name)  { $this->name = trim($name); }
          }
          /*///////////////////////////////////////////////////////////////////////////////////////*/
          public function __get($property) 
          {
           switch($property = strtoupper(trim($property)))
                {
                 case 'ADDRESS':
                 case 'EMAIL':
                        return $this->email;
                        
                 case 'NAME':
                        return $this->name;
                        
                 default:
                        return NULL;
                }
          }
          /*///////////////////////////////////////////////////////////////////////////////////////*/
          public function __set($property, $value)
          {
           switch($property = strtoupper(trim($property)))
                {
                 case 'NAME':
                        return $this->name = trim($value);
                
                 case 'ADDRESS':
                 case 'EMAIL':
                        return $this->email = self::validateEmail($value);
                        
                 default:
                        return NULL;
                }
          }
          /*///////////////////////////////////////////////////////////////////////////////////////*/
          public static function __callStatic($name, $arguments)
          {
           switch(strtoupper(trim($name)))
                {
                        case 'VALIDATEEMAIL':
                                return self::validateEmail((isset($arguments[0]))?($arguments[0]):(NULL));
                }
          
          }
          /*///////////////////////////////////////////////////////////////////////////////////////*/
          public function __toString()   { return (($this->name)?('"'.$this->name.'" '):('')).(($this->email)?('<'.$this->email.'>'):('')); }
          public function __invoke()     { return $this->__toString(); }
          /*///////////////////////////////////////////////////////////////////////////////////////*/
          public static function validateEmail($email)  
          { 
           if(filter_var(($email = strtolower(trim($email))), FILTER_VALIDATE_EMAIL)) { return $email; } 
           else { throw new Exception('Invalid e-mail address: "'.$email.'" !'); }
          }
          /*///////////////////////////////////////////////////////////////////////////////////////*/
         }
         
         class_alias(__NAMESPACE__.'\User', __NAMESPACE__.'\eMailUser');
         
         /*///////////////////////////////////////////////////////////////////////////////////////*/
         /*///////////////////////////////////////////////////////////////////////////////////////*/
         /*///////////////////////////////////////////////////////////////////////////////////////*/
         
         class eMail extends Toolbox
         {
          const PRIORITY_LOW = 5;
          const PRIORITY_NORMAL = 3;
          const PRIORITY_HIGH = 1;
          
          const CONTENT_TRANSFER_ENCODING_TEXT = 1;
          const CONTENT_TRANSFER_ENCODING_BASE64 = 64;

          protected $mixedBoundary;
          protected $altBoundary;
          protected $returnPath;
          protected $returnReceipt;
          protected $from;
          protected $replyTo;
          protected $to;
          protected $cc;
          protected $bcc;
          protected $priority;
          protected $charset;
          protected $contentTransferEncoding;
          protected $subject;
          protected $htmlMessage;
          protected $textMessage;
          protected $images;
          protected $attachments;



          protected function _generateRandomString() { return md5(uniqid(rand(),true)); }
          protected function _generateBoundary()     { return $this->_generateRandomString().(($this->from) && (preg_match('/(@.+)$/i',$this->from->email, $m) && is_array($m) && ($m = $m[0]))?($m):($this->_generateRandomString())); }
          public function __construct(User $from = NULL, $to = NULL, $subject = NULL, $htmlMessage = NULL, $textMessage = NULL)
          {
           $this->From = $from;
           $this->To = $to;
           $this->priority = self::PRIORITY_NORMAL;
           $this->charset = 'iso-8859-1';
           $this->contentTransferEncoding = self::CONTENT_TRANSFER_ENCODING_BASE64;
           $this->Subject = $subject;
           $this->HTMLMessage = $htmlMessage;
           $this->TXTMessage = $textMessage;
           $this->images = array();
           $this->attachments = array();
           $this->mixedBoundary = '--=_'.$this->_generateBoundary();
           $this->altBoundary  = '--=_'.$this->_generateBoundary();
          }
          /*///////////////////////////////////////////////////////////////////////////////////////*/
          public function __get($property)
          {
           switch(strtoupper(trim($property)))
                {
                        case 'PRIORITY':
                                return $this->priority;
                        
                        case 'TRANSFERENCODING':
                        case 'CONTENTTRANSFERENCODING': 
                                return $this->contentTransferEncoding;
                        
                        case 'RETURNPATH':
                                return $this->returnPath;
                        
                        case 'RETURNRECEIPT':
                                return $this->returnReceipt;
                        
                        case 'FROM':
                                return $this->from;
                        
                        case 'REPLYTO':
                                return $this->replyTo;
                        
                        case 'TO':
                                return $this->to;
                        
                        case 'CC':
                                return $this->cc;
                        
                        case 'BCC':
                                return $this->bcc;
                        
                        case 'SUBJECT':
                                return $this->subject;
                        
                        case 'HTMLMESSAGE':
                                return $this->htmlMessage;
                        
                        case 'TEXTMESSAGE':
                        case 'TXTMESSAGE':
                                return $this->textMessage; 
                        
                        case 'RAWMESSAGE':
                                return $this->__toString();
                        
                        case 'CHARSET':
                                return $this->charset;
                                
                        default:
                                return NULL;
                }
          }
          /*///////////////////////////////////////////////////////////////////////////////////////*/
          protected function _set(&$property,&$value)
          {
           try
                {
                 if($value)
                        { 
                         if($value instanceof User) { return $property = array($value); }
                         else if(is_array($value))
				{
                                 for($values = $this->_toSingleDimensionalArray($value), $i = count($values) - 1; $i > -1; --$i)
                                        { if(!($values[$i] instanceof User)) { unset($values[$i]); } }
                                 return $property = $values; 
                                }
                        }
                 else { if(empty($property)) { return $property = array(); } }
                }
           catch(Exception $e) { return NULL; }
          }
          /*///////////////////////////////////////////////////////////////////////////////////////*/
          public function __set($property, $value)
          {
           switch(strtoupper(trim($property)))
                {
                        case 'PRIORITY':
                                return $this->priority = ((($value == self::PRIORITY_HIGH) || ($value == self::PRIORITY_LOW))?($value):(self::PRIORITY_NORMAL));
                        
                        case 'TRANSFERENCODING':
                        case 'CONTENTTRANSFERENCODING':
                                return $this->contentTransferEncoding = (($value == self::CONTENT_TRANSFER_ENCODING_BASE64)?(self::CONTENT_TRANSFER_ENCODING_BASE64):(self::CONTENT_TRANSFER_ENCODING_TEXT));
                        
                        case 'RETURNPATH':
                                return ($value && ($value instanceof User))?($this->returnPath = $value):(NULL);
                        
                        case 'RETURNRECEIPT':
                                return ($value && ($value instanceof User))?($this->returnReceipt = $value):(NULL);
                        
                        case 'FROM':
                                return ($value && ($value instanceof User))?($this->from = $value):(NULL);
                        
                        case 'REPLYTO':
                                return ($value && ($value instanceof User))?($this->replyTo = $value):(NULL);
                        
                        case 'TO':
                                return $this->_set($this->to, $value);
                        
                        case 'CC':
                                return $this->_set($this->cc, $value);
                        
                        case 'BCC':
                                return $this->_set($this->bcc, $value);
                        
                        case 'SUBJECT':
                                return $this->subject = trim(strip_tags($value));
                        
                        case 'HTMLMESSAGE':
                                return $this->htmlMessage = trim($value);
                        
                        case 'TEXTMESSAGE':
                        case 'TXTMESSAGE':
                                return $this->textMessage = preg_replace('/[\f\t ]{2,}/mS', ' ', trim(strip_tags($value)));
                        
                        default:
                                return NULL;
                }
          }
          /*///////////////////////////////////////////////////////////////////////////////////////*/
          public function __call($name, $arguments)
          {
           switch(strtoupper(trim($name)))
                {
                        case 'IMG':
                        case 'IMAGE':
                        case 'ADDIMAGE':
                                return $this->addImage((isset($arguments[0]))?($arguments[0]):(NULL));
                        
                        case 'FILE':
                        case 'ATTACHMENT':
                        case 'ADDATTACHMENT':
                        case 'ADDFILE':
                                return $this->addAttachment((isset($arguments[0]))?($arguments[0]):(NULL));
                                
                        default:
                                return (string)$this;
                                
                }
          }
          /*///////////////////////////////////////////////////////////////////////////////////////*/
          public function addImage($imageURI)
          {
           try
                {
                 $info = getimagesize($imageURI);         
                 $cid = $this->_generateRandomString();

                 $msg  = '--'.$this->mixedBoundary.self::EOL;
                 $msg .= 'Content-Location: "'.basename($imageURI).'"'.self::EOL;
                 $msg .= 'Content-Type: '.image_type_to_mime_type($info[2]).self::EOL; 
                 $msg .= 'Content-Transfer-Encoding: base64'.self::EOL;
                 $msg .= 'Content-ID: <'.$cid.'>'.self::EOL;
                 $msg .= 'Content-Disposition: inline; filename="'.basename($imageURI).'"'.self::EOL.self::EOL;

                 $msg .= chunk_split(base64_encode(file_get_contents($imageURI))).self::EOL;
                 $this->images[$cid] = $msg;
                 return 'cid:'.$cid;
                }
           catch(Exception $e) { return NULL; }
          }
          /*///////////////////////////////////////////////////////////////////////////////////////*/
          public function addAttachment($attachmentURI)
          {
           try
                {
                 $cid = $this->_generateRandomString();
         
                 $msg  = '--'.$this->mixedBoundary.self::EOL;
                 $msg .= 'Content-Type: binary/octet-stream'.self::EOL; 
                 $msg .= 'Content-Transfer-Encoding: base64'.self::EOL;
                 $msg .= 'Content-ID: <'.$cid.'>'.self::EOL;
                 $msg .= 'Content-Disposition: attachment; filename="'.basename($attachmentURI).'"'.self::EOL.self::EOL;
         
                 $msg .= chunk_split(base64_encode(file_get_contents($attachmentURI))).self::EOL;
                 $this->attachments[$cid] = $msg;
                 return $cid;
                }
           catch(Exception $e) { return NULL; }
          }
          /*///////////////////////////////////////////////////////////////////////////////////////*/
          public function __toString() 
          {
           try
                {
                 $msg = '';
                 if($this->returnPath) { $msg .= 'Return-Path: <'.$this->returnPath->email.'>'.self::EOL; }
                 if($this->replyTo)    { $msg .= 'Reply-To: '.$this->replyTo.self::EOL; }
                 $msg .= 'From: '.$this->from.self::EOL; 
                 if(($this->to)  && is_array($this->to) && count($this->to))    { $msg .= 'To: '.implode(', ',$this->to).self::EOL; }
                 if(($this->cc)  && is_array($this->cc) && count($this->cc))    { $msg .= 'Cc: '.implode(', ',$this->cc).self::EOL; }
                 $msg .= 'Subject: '.$this->subject.self::EOL;
                 $msg .= 'X-Priority: '.$this->priority.self::EOL;				
                 $msg .= 'X-MSMail-Priority: '.(($this->priority == self::PRIORITY_HIGH)?('High'):(($this->priority == self::PRIORITY_LOW)?('Low'):('Normal'))).self::EOL;
                 $msg .= 'X-Mailer: SMTP4PHP '.(VERSION).', '.(RELEASE).'th release / PHP '.phpversion().self::EOL;
                 if($this->returnReceipt) { $msg .= ' X-Confirm-Reading-To: '.$this->returnReceipt.self::EOL; }
                 $msg .= 'MIME-Version: 1.0'.self::EOL;
                 $msg .= 'Content-Type: multipart/mixed; boundary="'.$this->mixedBoundary.'"'.self::EOL; 
                 $msg .= 'Date: '.date('r').self::EOL;
                 if($this->returnReceipt) { $msg .= 'Disposition-Notification-To: '.$this->returnReceipt.self::EOL; }
                 if($this->returnReceipt) { $msg .= 'Return-Receipt-To: '.$this->returnReceipt.self::EOL; }
                 $msg .= self::EOL;
                 $msg .= '--'.$this->mixedBoundary.self::EOL;
                 $msg .= 'Content-Type: multipart/alternative; boundary="'.$this->altBoundary.'"'.self::EOL.self::EOL;       
                 $msg .= '--'.$this->altBoundary.self::EOL;
                 /*/////////////////////////////////////////*/
                 /* text message */
                 /*/////////////////////////////////////////*/
                 $msg .= 'Content-Type: text/plain; charset="'.$this->charset.'"'.self::EOL;
                 if($this->contentTransferEncoding == self::CONTENT_TRANSFER_ENCODING_BASE64)
                        {
                         $msg .= 'Content-Transfer-Encoding: base64'.self::EOL.self::EOL;
                         $msg .= chunk_split(base64_encode($this->textMessage));
                        }
                 else   {
                         $this->textMessage = preg_replace('/^\.$/imsSU','..',$this->textMessage);
                         $msg .= 'Content-Transfer-Encoding: 8bit'.self::EOL.self::EOL;
                         $msg .= $this->textMessage;
                        }         
                 $msg .= self::EOL.self::EOL;
                 $msg .= '--'.$this->altBoundary.self::EOL;
                 /*/////////////////////////////////////////*/         
                 /* html message */
                 /*/////////////////////////////////////////*/
                 if(empty($this->htmlMessage))
                        { $this->htmlMessage = nl2br($this->TXTMessage); }
                 $msg .= 'Content-type: text/html; charset="'.$this->charset.'"'.self::EOL; 
                 if($this->contentTransferEncoding == self::CONTENT_TRANSFER_ENCODING_BASE64)
                        { $msg .= 'Content-Transfer-Encoding: base64'; }
                 else   { $msg .= 'Content-Transfer-Encoding: 8bit'; }       
                 $msg .= self::EOL.self::EOL;
                 if(preg_match('/<\/{0,1}(html|head|body.*)>/imsSU',$this->htmlMessage))
                        { 
                         $htmlMsg = $this->htmlMessage; 
                         if($this->contentTransferEncoding == self::CONTENT_TRANSFER_ENCODING_BASE64)
                                { $htmlMsg = chunk_split(base64_encode($htmlMsg));  }
                        }
                 else
                        {
                         $htmlMsg  = '<html>'.self::EOL;
                         $htmlMsg .= '<head>'.self::EOL;
                         $htmlMsg .= '<meta http-equiv="content-type" content="text/html; charset="'.$this->charset.'">'.self::EOL;
                         $htmlMsg .= '</head>'.self::EOL;
                         $htmlMsg .= '<body style="margin-top:0px; margin-bottom:0px; margin-right:0px; margin-left:0px;">'.self::EOL;
                         $htmlMsg .= $this->htmlMessage.self::EOL;
                         $htmlMsg .= '<br><br></body></html>'; 
                         if($this->contentTransferEncoding == self::CONTENT_TRANSFER_ENCODING_BASE64)
                                { $htmlMsg = chunk_split(base64_encode($htmlMsg));  }
                        } 
                 $msg .= $htmlMsg; unset($htmlMsg);         
                 $msg .= self::EOL.self::EOL;
                 $msg .= '--'.$this->altBoundary."--".self::EOL.self::EOL;
                 /*/////////////////////////////////////////*/
                 /* add images */
                 /*/////////////////////////////////////////*/
                 $msg .= implode('',$this->images); 
                 /*/////////////////////////////////////////*/
                 /* add attachments */
                 /*/////////////////////////////////////////*/
                 $msg .= implode('',$this->attachments); 
                 $msg .= '--'.$this->mixedBoundary.'--'.self::EOL;
                 $msg .= '.'.self::EOL; 
         
                 return $msg;
                } 
           catch(Exception $e) { return NULL; }
          }
         }
         
         /*///////////////////////////////////////////////////////////////////////////////////////*/
         /*///////////////////////////////////////////////////////////////////////////////////////*/
         /*///////////////////////////////////////////////////////////////////////////////////////*/
         
         class SMTP extends Toolbox
         {
          const AUTH_AUTO_DETECT = '';
          const AUTH_CRAM_SHA1   = 'CRAM-SHA1';
          const AUTH_CRAM_MD5    = 'CRAM-MD5';          
          const AUTH_PLAIN       = 'PLAIN';
          const AUTH_LOGIN       = 'LOGIN';
          
          const ENCRYPTION_SSL   = 'ssl';
          const ENCRYPTION_TLS   = 'tls';
                   
          private $bufferSize = 8192;
          private $ip;
          private $authenticationMethods = array(self::AUTH_CRAM_SHA1, self::AUTH_CRAM_MD5, self::AUTH_LOGIN, self::AUTH_PLAIN);

          protected $SMTPlog;
          protected $SMTPserver;
          protected $SMTPport;
          protected $SMTPuser;
          protected $SMTPpassword;
          protected $SMTPauthenticationMethod;
          protected $SMTPconnectionTimeout;
          protected $encryption;
          protected $esmtp;
          protected $smtpConnect;
          
          /*///////////////////////////////////////////////////////////////////////////////////////*/
          public function __construct($SMTPserver = '', $SMTPport = 25, $SMTPuser = '', $SMTPpassword = '', $SMTPauthenticationMethod = self::AUTH_AUTO_DETECT)
          {
           $this->Server               = $SMTPserver;
           $this->Port                 = $SMTPport;
           $this->User                 = $SMTPuser;
           $this->Password             = $SMTPpassword;
           $this->AuthenticationMethod = $SMTPauthenticationMethod;
           $this->ConnectionTimeout    = 30;
           $this->ip                   = (isset($_SERVER['LOCAL_ADDR']))?($_SERVER['LOCAL_ADDR']):(gethostbyname(gethostbyaddr('127.0.0.1')));
           $this->esmtp                = FALSE;
           }
          /*///////////////////////////////////////////////////////////////////////////////////////*/
          public function __destruct()
          { $this->_disconnect(); }
          /*///////////////////////////////////////////////////////////////////////////////////////*/
          public function __sleep()
          { 
           $this->_disconnect();
           return array('SMTPserver', 'SMTPport', 'SMTPuser', 'SMTPpassword', 'SMTPauthenticationMethod', 'SMTPconnectionTimeout', 'encryption', 'esmtp', 'ip' ); 
          }
          /*///////////////////////////////////////////////////////////////////////////////////////*/                        
          public function __clone() 
          { $this->_disconnect(); }
          /*///////////////////////////////////////////////////////////////////////////////////////*/              
          public function __invoke()
          { $this->send(func_get_args()); }
          /*///////////////////////////////////////////////////////////////////////////////////////*/    
          public function __get($property)
          {
           switch(strtoupper(trim($property)))
                {
                        case 'SERVER':
                        case 'SMTPSERVER':
                                return $this->SMTPserver;
                        
                        case 'PORT':
                        case 'SMTPPORT':
                                return $this->SMTPport;
                        
                        case 'TIMEOUT':
                        case 'CONNECTIONTIMEOUT':
                        case 'SMTPCONNECTIONTIMEOUT':
                                return $this->SMTPconnectionTimeout;
                        
                        case 'USER':
                        case 'SMTPUSER':
                                return $this->SMTPuser;

                        case 'PASSWD':                        
                        case 'PASSWORD':
                        case 'SMTPPASSWD':
                        case 'SMTPPASSWORD':
                                return $this->SMTPpassword;
                        
                        case 'AUTH':
                        case 'AUTHENTICATION':
                        case 'AUTHENTICATIONMETHOD':
                        case 'SMTPAUTH':
                        case 'SMTPAUTHENTICATION':                        
                        case 'SMTPAUTHENTICATIONMETHOD':
                                return $this->SMTPauthenticationMethod;
                        
                        case 'LOG':
                        case 'SMTPLOG':
                                return implode('', $this->SMTPlog);
                        
                        case 'ENCRYPTION':
                        case 'SMTPENCRYPTION':
                                return $this->encryption;
                        
                        default:
                                return NULL;
                }
          }
          /*///////////////////////////////////////////////////////////////////////////////////////*/
          public function __set($property, $value)
          {
           switch(strtoupper(trim($property)))
                {
                        case 'SERVER':
                        case 'SMTPSERVER':
                                $this->encryption = (preg_match('/^('.self::ENCRYPTION_SSL.'|'.self::ENCRYPTION_TLS.'):\/\//i',($value = trim($value)),$m) && is_array($m) && isset($m[1]))?(strtolower($m[1])):('');
                                return $this->SMTPserver = preg_replace('/^.*:\/\//','',$value,1); 
                        
                        case 'PORT':
                        case 'SMTPPORT':
                                return $this->SMTPport = ($value = $this->_intValue($value))?($value):(25);
                        
                        case 'TIMEOUT':
                        case 'CONNECTIONTIMEOUT':
                        case 'SMTPCONNECTIONTIMEOUT':
                                return $this->SMTPconnectionTimeout = ($value = $this->_intValue($value))?($value):(30);
                        
                        case 'USER':
                        case 'SMTPUSER':
                                return $this->SMTPuser = trim($value);
                        
                        case 'PASSWD':                        
                        case 'PASSWORD':
                        case 'SMTPPASSWD':
                        case 'SMTPPASSWORD':
                                return $this->SMTPpassword = $value;
                                
                        case 'AUTH':
                        case 'AUTHENTICATION':
                        case 'AUTHENTICATIONMETHOD':
                        case 'SMTPAUTH':
                        case 'SMTPAUTHENTICATION':                        
                        case 'SMTPAUTHENTICATIONMETHOD':
                                return $this->SMTPauthenticationMethod = (in_array($value, $this->authenticationMethods))?($value):(self::AUTH_AUTO_DETECT);
                        
                        default:
                                return NULL;
                }
          }
          /*///////////////////////////////////////////////////////////////////////////////////////*/
          public function __call($name, $arguments)
          {
           switch(strtoupper(trim($name)))
                {
                        case 'SEND':
                        case 'SENDMAIL':
                        case 'SENDMAILS':
                        case 'SENDEMAIL':
                        case 'SENDEMAILS':
                        case 'SMTPSEND':
                        case 'SMTPSENDMAIL':
                        case 'SMTPSENDMAILS':
                        case 'SMTPSENDEMAIL':
                        case 'SMTPSENDEMAILS':
                                return $this->send($arguments);
                }
          }
          /*///////////////////////////////////////////////////////////////////////////////////////*/
          protected function _read()
          { 
           $response='';
           while($chunk = fread($this->smtpConnect,$this->bufferSize))
                { 
                 $response .= $chunk;
                 if(preg_match('/^\d{3}[^-]/mSU',trim($chunk)) || feof($this->smtpConnect)) { break; }
                }
           return $this->SMTPlog[] = trim($response);        
          }
          /*///////////////////////////////////////////////////////////////////////////////////////*/
          protected function _write($smtpCommand)
          { return fputs($this->smtpConnect, ($this->SMTPlog[] = trim($smtpCommand).self::EOL)); }
          /*///////////////////////////////////////////////////////////////////////////////////////*/
          protected function _exec($smtpCommand, $expectedResponse = NULL)
          {
           //print 'C: '.trim($smtpCommand).PHP_EOL;
           $this->_write($smtpCommand); 
           $smtpResponse = $this->_read();
           //print 'S: '.trim($smtpResponse).PHP_EOL;
           if($expectedResponse && (!preg_match('/^'.$expectedResponse.'/S', $smtpResponse))) 
                { throw new Exception('Unexpected SMTP error! (SMTP command: "'.trim($smtpCommand).'" SMTP response: "'.$smtpResponse.'")',(preg_match('/^(\d{3})/mSU',$smtpResponse,$m) && is_array($m) && isset($m[0]))?($m[0]):(NULL)); }
           return $smtpResponse;
          }
          /*///////////////////////////////////////////////////////////////////////////////////////*/
          protected function _disconnect()
          {
           if(!empty($this->smtpConnect)) 
                { 
                 try { $this->_exec('QUIT'); }       catch(Exception $e) { }
                 try { fclose($this->smtpConnect); } catch(Exception $e) { } 
                }
           $this->smtpConnect = NULL;
          }
          /*///////////////////////////////////////////////////////////////////////////////////////*/
          protected function _authenticate($smtpResponse = self::AUTH_AUTO_DETECT)
          {

           if($this->SMTPuser)
                { 
                 if(empty($this->SMTPauthenticationMethod))
                        {
                         if(preg_match('/^250\-?AUTH.*\b('.self::AUTH_CRAM_SHA1.')(?=\b|$)/mSU',$smtpResponse))
                                { $this->SMTPauthenticationMethod = self::AUTH_CRAM_SHA1; }
                         else       
                         if(preg_match('/^250\-?AUTH.*\b('.self::AUTH_CRAM_MD5.')(?=\b|$)/mSU',$smtpResponse))
                                { $this->SMTPauthenticationMethod = self::AUTH_CRAM_MD5; }
                         else
                         if(preg_match('/^250\-?AUTH.*\b('.self::AUTH_LOGIN.')(?=\b|$)/mSU',$smtpResponse))
                                { $this->SMTPauthenticationMethod = self::AUTH_LOGIN; } 
                         else
                         if(preg_match('/^250\-?AUTH.*\b('.self::AUTH_PLAIN.')(?=\b|$)/mSU',$smtpResponse))
                                { $this->SMTPauthenticationMethod = self::AUTH_PLAIN; } 
                         else   { $this->SMTPauthenticationMethod = self::AUTH_AUTO_DETECT; }     
                        }
                                
                 switch($this->SMTPauthenticationMethod)
                        {
                                case self::AUTH_CRAM_SHA1:
                                case self::AUTH_CRAM_MD5:
                                        $this->_exec(base64_encode($this->SMTPuser.' '.hash_hmac( preg_replace('/^cram\-/','',strtolower($this->SMTPauthenticationMethod)) , /* challenge */base64_decode(preg_replace('/^334 /','',trim($this->_exec('AUTH '.$this->SMTPauthenticationMethod,'334')))) ,$this->SMTPpassword)), 235); 
                                        break;
                                                
                                case self::AUTH_LOGIN:
                                        $this->_exec('AUTH '.self::AUTH_LOGIN,'334');
                                        $this->_exec(base64_encode($this->SMTPuser),'334');
                                        $this->_exec(base64_encode($this->SMTPpassword),'235');
                                        break;
                                        
                                case self::AUTH_PLAIN:
                                        $this->_exec('AUTH '.self::AUTH_PLAIN.' '.base64_encode("\0".$this->SMTPuser."\0".$this->SMTPpassword),'235'); 
                                        break;
                                      
                                case self::AUTH_AUTO_DETECT:
                                        foreach($this->authenticationMethods as $auth)
                                                {
                                                 $this->SMTPauthenticationMethod = $auth;
                                                 try { $this->_authenticate(); }
                                                 catch(Exception $e) 
                                                        { 
                                                         if($e->getCode() == 504/* 504 Authentication mechanism not supported. */) { continue; }
                                                         $this->SMTPauthenticationMethod = self::AUTH_AUTO_DETECT;
                                                         throw $e;       
                                                        }
                                                 return;
                                                }
         
                                default:
                                        $this->SMTPauthenticationMethod = self::AUTH_AUTO_DETECT;
                                        throw new Exception('Authentication mechanism not supported.',504);       
                        }
                }          
          }
          /*///////////////////////////////////////////////////////////////////////////////////////*/
          protected function _connect()
          {
           if(empty($this->smtpConnect))
                {
                 $this->smtpConnect = stream_socket_client((($this->encryption == self::ENCRYPTION_SSL)?($this->encryption):('tcp')).'://'.$this->SMTPserver.(($this->SMTPport)?(':'.$this->SMTPport):('')), $errno, $errstr, $this->SMTPconnectionTimeout, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT);
                 if(empty($this->smtpConnect))  { throw new Exception('SMTP connection error!'.($errstr)?(' ('.$errstr.')'):('')); }
                 stream_set_blocking($this->smtpConnect, true);
                 
                 $smtpResponse = trim($this->_read());
                 $xxLO = ($this->esmtp = (stripos($smtpResponse,'ESMTP') !== FALSE))?('EHLO'):('HELO'); 
                 $smtpResponse = trim($this->_exec($xxLO.' '.$this->ip,'250'));

                 if($this->encryption == self::ENCRYPTION_TLS)
                        {
                         $this->_exec('STARTTLS','220');
                         if(!stream_socket_enable_crypto($this->smtpConnect, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) { throw new Exception('Unexpected TLS encryption error!'); }
                        }
                        
                 $this->_authenticate($smtpResponse);
                }        
          }
          /*///////////////////////////////////////////////////////////////////////////////////////*/
          public function send()
          { 
           try
                {
                 $this->SMTPlog = array();
                 
                 for($emails = $this->_toSingleDimensionalArray(func_get_args()), $i = count($emails) - 1; $i > -1; --$i)
                        { if(!($emails[$i] instanceof eMail)) { unset($emails[$i]); } }
                 
                 if(count($emails))
                        {
                         $this->_connect();
                
                         foreach($emails as $e)
                                {
                                 try { $this->_exec('MAIL FROM: <'.$e->from->email.'>','250'); }
                                 catch(Exception $e) { $this->_exec('RSET'); throw $e; }

                                 if(is_array($e->to))   { foreach($e->to  as $rcpt) { $this->_exec('RCPT TO: <'.$rcpt->email.'>','250'); } }
                                 if(is_array($e->cc))   { foreach($e->cc  as $rcpt) { $this->_exec('RCPT TO: <'.$rcpt->email.'>','250'); } }
                                 if(is_array($e->bcc))  { foreach($e->bcc as $rcpt) { $this->_exec('RCPT TO: <'.$rcpt->email.'>','250'); } }
                                
                                 try { $this->_exec('DATA','354'); }
                                 catch(Exception $e) { $this->_exec('RSET'); throw $e; }

                                 try { $this->_exec($e->RawMessage,'250'); }
                                 catch(Exception $e) { $this->_exec('RSET'); throw $e; }

                                 try { $this->_exec('NOOP','250'); } 
                                 catch(Exception $e) { }
                                }
                        }        
                }
           catch(Exception $e)
                {
                 $this->_disconnect();
                 throw $e;
                }
          }
          /*///////////////////////////////////////////////////////////////////////////////////////*/          
         }
         
         /*///////////////////////////////////////////////////////////////////////////////////////*/
         /*///////////////////////////////////////////////////////////////////////////////////////*/
         /*///////////////////////////////////////////////////////////////////////////////////////*/
        }
        
/*///////////////////////////////////////////////////////////////////////////////////////*/
/*///////////////////////////////////////////////////////////////////////////////////////*/
/*///////////////////////////////////////////////////////////////////////////////////////*/
?>
