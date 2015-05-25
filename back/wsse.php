<?php

$secret = "d5861828170c193e93ea5a3cd7967cdab03a15b9405e3d3780e453707089ecfdc353e031e8b87dbdba9f89c5dba3cb3f0e40d8ecfc99387901cd1ef48c6a763d";
$public = "947ecd75fcd9";
$createdAt = new \DateTime();
$createdAt = $createdAt->format(\DateTime::W3C);
$nonce = md5(time());
$digest = base64_encode(sha1($nonce.$createdAt.$secret));

$endpoint = $argv[1];
$data = $argv[2];

$command = <<<EOT
curl -i -H 'Content-Type: application/json' -H 'Authorization: WSSE profile="UsernameToken"' -H 'X-WSSE: UsernameToken Username="$public", PasswordDigest="$digest", Nonce="$nonce", Created="$createdAt"' $endpoint -X POST -d '$data'
EOT;

echo $command;
