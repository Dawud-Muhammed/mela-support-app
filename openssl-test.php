<?php
echo "PHP_VERSION=" . PHP_VERSION . PHP_EOL;
echo "OPENSSL_CONF=" . (getenv("OPENSSL_CONF") ?: "") . PHP_EOL;

$k = openssl_pkey_new([
  "private_key_type" => OPENSSL_KEYTYPE_EC,
  "curve_name" => "prime256v1",
]);

var_dump($k);

while ($e = openssl_error_string()) {
  echo $e, PHP_EOL;
}
