<?php

/*!

 * Glycon SMMPanel Script
 * https://www.glycon.org
 *
 * Glycon icin yazilmistir ve Glycon'adi altinda kopyalanabilir. 
 * Copyright (c) 2020 Glycon.
 */

/*!
 
 * Telif Hakki (c) 2020, Glycon adi altinda GlyconSMMScript icin lisanslanmistir.
 *
 * GLYCON.ORG IZNI OLMADAN HICBIR SEKILDE KOPYALANAMAZ VE YAPISTIRILAMAZ!
 */

/*******************************************************
 
 * Copyright (C) 2016-2020 Glycon info@glycon.org
 * 
 * This file is part of Glycon.
 * 
 * Glycon.org can not be copied and/or distributed without the express
 * permission of Glycon
 
*******************************************************/

require_once __DIR__.'/lib/autoload.php';
require_once __DIR__.'/system/update_funds.php';
use PHPMailer\PHPMailer\PHPMailer;
$mail = new PHPMailer;
   
require_once 'GlyconSMMScript.php';