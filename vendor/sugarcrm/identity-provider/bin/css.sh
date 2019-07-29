#!/bin/bash

cd "$(dirname "$0")"
lessc ../src/App/Resources/less/idm/idm.config.less ../web/css/idm.css
cat ../web/css/idm.css