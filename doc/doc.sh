#!/usr/bin/env sh

echo Shell de génération de la documentation pour l API v2

rm -Rf ./public/*
apidoc -i ../app/Http/Controllers -o public -t template
php cleanPublic.php
rm -Rf ./private/*
apidoc -i ../app/Http/Controllers -o private -t template
