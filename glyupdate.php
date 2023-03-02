<?php
require __DIR__.'/lib/autoload.php';
require __DIR__.'/system/update_funds.php';
require __DIR__.'/system/9e178207c6510af84d51d649472c7cfb.php';
$site_version = VERSION_NUMBER;
$lisan_key_dinamik = DINAMICLISANCE;
error_reporting(-1);
ini_set('display_errors', '1');
if(!isset($_GET['key'])){
    echo "Lisans Kodu Girilmedi";
    exit();
}
if($_GET['key'] != $keys_key_moto){
    echo "Lisans Kodu Yanlış";
    exit();
    
}
function copy_dir($src, $dst, $url = null)
{
    echo $url;
    if (!file_exists($url)) {
        $sonuc = mkdir($url, '0777');
        chmod($sonuc, 0777);
    }
    if (is_dir($src)) {
        if (!is_dir($dst)) mkdir($dst);
        $files = scandir($src);
        foreach ($files as $file) {
            if ($file != "." and $file != ".." && $file != "uploads" && $file != "images" && $file != "cache" && $file != "img") {
                copy_dir("$src/$file", "$dst/$file", $url);
            }
        }
    } else if (file_exists($src)) {
        copy($src, $dst);
    }
}

function folder_bul($folder, $ver, $folder_s = null,$folder_real = null)
{

    if (is_null($folder_s)) {
        $uzanti = realpath($_SERVER["DOCUMENT_ROOT"]) . "/version/" . $ver . "/";
        $uzanti_real = realpath($_SERVER["DOCUMENT_ROOT"])."/";
       
        $klasor_g = opendir($uzanti);
    } else {
        $uzanti = $folder_s;
        $uzanti_real = $folder_real;
        $klasor_g = opendir($uzanti);

    }
    while ($dosya_g = readdir($klasor_g)) {

        if (is_dir($uzanti . $dosya_g) && $dosya_g != ".." && $dosya_g != "." && $dosya_g != "backup") {
            //echo $dosya_g."<br>";
            folder_bul($dosya_g, $ver,$uzanti . $dosya_g."/", $uzanti_real . $dosya_g."/");
    //        echo $dosya_g;
            copy_dir($uzanti . $dosya_g."/",$uzanti_real.$dosya_g."/",$uzanti_real);
        } else {

        }
    }
    closedir($klasor_g);
   return 1;
}

    //  Initiate curl
    $ch = curl_init();
    // Will return the response, if false it print the response
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Set the url
    curl_setopt($ch, CURLOPT_URL, "https://lisans.glycon.com.tr/version_check?key=$lisan_key_dinamik");
    // Execute
    $result = curl_exec($ch);
    // Closing
    curl_close($ch);
    
    // Will dump a beauty json :3
    $sonuc = json_decode($result, true);

if (isset($sonuc['status']) && $sonuc['status'] == 200):
    $version = $sonuc['version'];
    if ($site_version != $version) {
        $file = $sonuc['file'];
        $yolcuk = "version/" . $file;
        $curl = curl_init("https://lisans.glycon.com.tr/assets/download_zip.php?key=$lisan_key_dinamik");
       $fopen = fopen($yolcuk, 'w');
   curl_setopt($curl, CURLOPT_TIMEOUT, 5040);
curl_setopt($curl, CURLOPT_HEADER, 0);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); 
curl_setopt($curl, CURLOPT_SSLVERSION, 3); 
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
                   // curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($curl, CURLOPT_FILE, $fopen);

        $res = curl_exec($curl);
        curl_close($curl);
        fclose($fopen);

        $filename = $sonuc['file'];
        $path = 'version/';
        $zip = new ZipArchive;
        $res = $zip->open($path . $filename);
        if ($res === TRUE) {
            $zip->extractTo(realpath($_SERVER["DOCUMENT_ROOT"]).'/version/' . str_replace(".", "_", $sonuc['version']));
            $zip->close();

            unlink($path . $filename);
            $klasor = opendir(realpath($_SERVER["DOCUMENT_ROOT"])."/" ); //klasörü aç
            $ver = str_replace(".", "_", $sonuc['version']);
           //Yedek
           /*
            while ($dosya = readdir($klasor)) { //klasördeki dosyalar taranıyor
                if (is_dir($dosya) && $dosya != ".." && $dosya != "." && $dosya != "backup") { //dosya değişkenindeki değer klasör değilse
                  //  echo $dosya . '<br>'; //alt alta yazdır
                    copy_dir(realpath($_SERVER["DOCUMENT_ROOT"]) . "/" . $dosya, realpath($_SERVER["DOCUMENT_ROOT"]) . "/backup/" . $ver . "/" . $dosya, realpath($_SERVER["DOCUMENT_ROOT"]) . "/backup/" . $ver);
                }
            }
            */
            
            $klasor_g = opendir(realpath($_SERVER["DOCUMENT_ROOT"])."/version/" . $ver . "/"); //klasörü aç
            
            while ($dosya_g = readdir($klasor_g)) {
                if (is_dir($dosya_g) && $dosya_g != ".." && $dosya_g != "." && $dosya_g != "backup") {
                     
                    folder_bul($dosya_g, $ver);
                }else {
                    copy_dir(realpath($_SERVER["DOCUMENT_ROOT"]) . "/" . $dosya_g, realpath($_SERVER["DOCUMENT_ROOT"]) . "/" . $dosya_g, realpath($_SERVER["DOCUMENT_ROOT"]) . "/backup/");

                }
            }


        }
    }

endif;
?>