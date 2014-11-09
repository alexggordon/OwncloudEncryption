<?php

require_once 'crypt.php';
 
// first get users private key and decrypt it
$encryptedUserKey = file_get_contents("AlexGordon.private.key");
$decryptedUserKey = OCA\Encryption\Crypt::decryptPrivateKey($encryptedUserKey, "password");
 
// now we need to decrypt the file-key, therefore we use our private key and the share key
$shareKey = file_get_contents("text.rtf.AlexGordon.shareKey");
$encryptedKeyfile = file_get_contents("text.rtf.key");

echo $shareKey;
echo $encryptedKeyfile;

$decryptedKeyfile = OCA\Encryption\Crypt::multiKeyDecrypt($encryptedKeyfile, $shareKey, $decryptedUserKey);
 

echo $decryptedKeyfile;

// finally we can use the decrypted file-key to decrypt the file
$encryptedContent = file_get_contents("text.rtf");
$decryptedContent = OCA\Encryption\Crypt::symmetricDecryptFileContent($encryptedContent, $decryptedKeyfile);
 
echo "result: " . $decryptedContent . "\n";

?>
