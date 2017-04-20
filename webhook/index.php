<?php

$result = system("sudo /bin/sh ./pull.sh", $status);

echo $result;

if ($status == 'true') {
    echo "hello!";
} else {
    echo "Failed!";
}
