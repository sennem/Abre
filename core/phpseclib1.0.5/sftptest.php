<?php
include('Net/SSH2.php');
include('Crypt/RSA.php');

$ssh = new Net_SSH2('upload.iepanywhere.com');
$key = new Crypt_RSA();
$key->loadKey(file_get_contents('../../../private/keys/id_rsa_hmltcs.ppk'));
if (!$ssh->login('username', $key)) {
    exit('Login Failed');
}

echo $ssh->exec('pwd');
echo $ssh->exec('ls -la');
?>