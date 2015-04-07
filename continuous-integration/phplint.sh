#!/bin/bash

# print version to see against which PHP version is tested
php --version

# find all .php files and run them through PHP's syntax check
find ./ -name '*.php' | xargs -i php --syntax-check {}
if [[ $? -ne 0 ]]
then
  echo "Some scripts contain syntax errors!"
  exit 1
else
  echo "Syntax seems to be correct."
  exit 0
fi
