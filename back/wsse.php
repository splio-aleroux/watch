<?php

$secret = "bar";
$public = "foo";
$createdAt = new \DateTime();
$createdAt = $createdAt->format(\DateTime::W3C);
$nonce = md5(time());
$digest = base64_encode(sha1($nonce.$createdAt.$secret, true));

$command = <<<EOT
curl -i -H 'Authorization: WSSE profile="UsernameToken"' -H 'X-WSSE: UsernameToken Username="$public", PasswordDigest="$digest", Nonce="$nonce", Created="$createdAt"' http://127.0.0.1:8000/app_dev.php/links
EOT;

echo $command;
