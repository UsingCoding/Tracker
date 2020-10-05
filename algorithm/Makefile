all: generate run

.PHONY: generate
generate:
	python3 -m grpc_tools.protoc -I /usr/src/config/ --python_out=/usr/src/app/src/Infrastructure/GRpcServer/Generated --grpc_python_out=/usr/src/app/src/Infrastructure/GRpcServer/Generated algorithm.proto > /dev/null

.PHONY: run
run:
	python3 src/main.py