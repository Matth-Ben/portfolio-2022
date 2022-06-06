#!/bin/bash
# Abort on error
set -e
# Check if lftp is installed
command -v lftp >/dev/null 2>&1 || { echo >&2 "Install lftp first."; exit 1; }
# Check if all variables are set
if [ -z ${user} ] || [ -z ${host} ] || [ -z ${pwd} ] || [ -z ${dir} ] || [ -z ${branch} ]; then
  echo "Missing variables.";
  exit 1;
fi
# Checkout right branch: master=preprod prod=prod
git checkout $branch
# Build assets in dist folder
yarn build:production
# Mirror files using lftp
echo "Uploading..."
lftp -d -u $user,$pwd -e "set ssl:verify-certificate no ; mirror --use-pget-n=10 -e -p -R ./dist/ $dir ; quit" ftp://$host
echo "Uploaded!"
# Clean
yarn run rmdist