<?php
/*--------
By      : Teysseire Guillaume
Date    : 12/03/2015
Update  : 21/12/2015
Licence : © Copyright
Version : 1.2
-------------------------
*/

require_once 'vendor/foxFW/FoxFWKernel.php';
//FoxFWKernel::scriptTimeStart();
FoxFWKernel::build( './config.json', './cache/config.json' );
//FoxFWKernel::scriptTimeStop();