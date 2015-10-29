<?php
// generateur de CLEF de sécuriter
/*--------
By      : Teysseire Guillaume
Date    : 12/03/2015
Update  : 24/09/2015
Licence : © Copyright
Version : 1.0
-------------------------
*/
/*
FoxFWCrypte::generateRandomString($length = 20);
FoxFWCrypte::crypte($Texte, $Cle);
FoxFWCrypte::decrypte($Texte,$Cle);
*/
//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
//
//
//
//--------------------------------------------------------------------------------

class FoxFWCrypte
{
  //--------------------------------------------------------------------------------
  //--------------------------------------------------------------------------------
  //
  //
  //
  //--------------------------------------------------------------------------------
  public static function randomString($length = 20)
  {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++)
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      return $randomString;
  }

  //--------------------------------------------------------------------------------
  //--------------------------------------------------------------------------------
  //
  //
  //
  //--------------------------------------------------------------------------------
  private static function generationCle($Texte,$CleDEncryptage)
  {
    $CleDEncryptage = md5($CleDEncryptage);
    $Compteur=0;
    $VariableTemp = "";
    for ($Ctr=0;$Ctr<strlen($Texte);$Ctr++)
    {
      if ($Compteur==strlen($CleDEncryptage))
        $Compteur=0;
      $VariableTemp.= substr($Texte,$Ctr,1) ^ substr($CleDEncryptage,$Compteur,1);
      $Compteur++;
    }
    return $VariableTemp;
  }

  //--------------------------------------------------------------------------------
  //--------------------------------------------------------------------------------
  //
  //
  //
  //--------------------------------------------------------------------------------
  public static function crypte($Texte, $Cle)
  {
    srand((double)microtime()*1000000);
    $CleDEncryptage = md5(rand(0,32000) );
    $Compteur=0;
    $VariableTemp = "";
    for ($Ctr=0;$Ctr<strlen($Texte);$Ctr++)
    {
      if ($Compteur==strlen($CleDEncryptage))
        $Compteur=0;
      $VariableTemp.= substr($CleDEncryptage,$Compteur,1).(substr($Texte,$Ctr,1) ^ substr($CleDEncryptage,$Compteur,1) );
      $Compteur++;
    }
    return base64_encode( FoxFWCrypte::generationCle($VariableTemp,$Cle) );
  }


  //--------------------------------------------------------------------------------
  //--------------------------------------------------------------------------------
  //
  //
  //
  //--------------------------------------------------------------------------------
  public static function decrypte($Texte,$Cle)
  {
    $Texte = FoxFWCrypte::generationCle(base64_decode($Texte),$Cle);
    $VariableTemp = "";
    for ($Ctr=0;$Ctr<strlen($Texte);$Ctr++)
    {
      $md5 = substr($Texte,$Ctr,1);
      $Ctr++;
      $VariableTemp.= (substr($Texte,$Ctr,1) ^ $md5);
    }
    return $VariableTemp;
  }

};