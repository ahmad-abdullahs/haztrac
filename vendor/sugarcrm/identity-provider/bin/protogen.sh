#!/bin/bash

if [ "$GOPATH" = "" ]; then
    echo "GOPATH not defined. Please configure Golang."
    exit 1;
fi
cd $(dirname "$0")
workDir=$(pwd)
echo "Installing required dependencies..."
go get -u -v github.com/grpc-ecosystem/grpc-gateway/protoc-gen-grpc-gateway
go get -u -v github.com/grpc-ecosystem/grpc-gateway/protoc-gen-swagger
go get -u -v github.com/golang/protobuf/protoc-gen-go

echo "Cleaning old files..."
cd /tmp
rm -rf /tmp/multiverse
rm -rf /tmp/grpc

echo "Installing multiverse..."
git clone git@github.com:sugarcrm/multiverse.git
echo "Installing grpc..."
git clone -b v1.13.x https://github.com/grpc/grpc
cd grpc && git submodule update --init && make install grpc_php_plugin

echo "Building PHP GRPC libraries..."
cd $workDir
mkdir ../grpc
find /tmp/multiverse/apis/iam /tmp/multiverse/apis/rpc -name "*.proto" -print | while read f; do
    protoc -I$GOPATH/src/github.com/grpc-ecosystem/grpc-gateway/third_party/googleapis \
    --proto_path=/tmp/multiverse  --php_out=../grpc --grpc_out=../grpc \
    --plugin=protoc-gen-grpc=/tmp/grpc/bins/opt/grpc_php_plugin $f
done