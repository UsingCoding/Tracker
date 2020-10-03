all: generate run

.PHONY: generate
generate:
	python3 -m grpc_tools.protoc -I /usr/src/config/ --python_out=/usr/src/app/server --grpc_python_out=/usr/src/app/server algorithm.proto > /dev/null

.PHONY: run
run:
	python3 main.py