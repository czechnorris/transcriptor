#!/bin/bash

file=$1
url=$2
read sourceLanguage targetLanguage < $file
sed 1d $file | while read from to; do
    content='
        {
            "rule": {
                "sourceLanguage": "'$sourceLanguage'",
                "targetLanguage": "'$targetLanguage'",
                "pattern": "'$from'",
                "replacement": "'$to'"
            }
        }'
    echo "Adding rule '$from' => '$to'"
    curl -XPOST -H 'Content-type: application/json' -H 'Accept: application/json'  -d "$content" $url"/api/v1/rules.json"

    content='
        {
            "rule": {
                "sourceLanguage": "'$targetLanguage'",
                "targetLanguage": "'$sourceLanguage'",
                "pattern": "'$to'",
                "replacement": "'$from'"
            }
        }'
    echo "Adding rule '$to' => '$from'"
    curl -XPOST -H 'Content-type: application/json' -H 'Accept: application/json'  -d "$content" $url"/api/v1/rules.json"
done