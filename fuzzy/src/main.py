import grpc
from concurrent import futures
import time
import sys

sys.path.insert(1, '/usr/src/app/src/Domain')
sys.path.insert(1, '/usr/src/app/src/Infrastructure/GRpcServer')
sys.path.insert(1, '/usr/src/app/src/Infrastructure/GRpcServer/Generated')

import algorithm_pb2
import algorithm_pb2_grpc
from FuzzyService import FuzzyService
from Server import Server

if __name__ == '__main__':
    service = FuzzyService()

    print(service.calculate(5, 40))

#     server = Server()
#     server.start()

    try:
        while True:
            time.sleep(20)
    except KeyboardInterrupt:
        pass