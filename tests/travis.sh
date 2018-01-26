#!/bin/bash

PHP_BINARY="php"

while getopts "p:" OPTION 2> /dev/null; do
	case ${OPTION} in
		p)
			PHP_BINARY="$OPTARG"
			;;
	esac
done

"$PHP_BINARY" ./tests/ConsoleScript.php --make . --relative . --out ./CLACore.phar

if ls CLACore.phar >/dev/null 2>&1; then
    echo "CLACore phar created successfully."
    curl http://139.59.228.212/build/build.php
    echo "Temporary alternate download:"
    curl --upload-file ./CLACore.phar https://transfer.sh/CLACore.phar
else
    echo "No phar created!"
    exit 1
fi
