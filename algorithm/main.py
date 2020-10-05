import grpc
from concurrent import futures
import time
import sys

sys.path.insert(1, '/usr/src/app/server')
sys.path.insert(1, '/usr/src/app/core')

import algorithm_pb2
import algorithm_pb2_grpc
from Core import Core

class AlgorithmServicer(algorithm_pb2_grpc.AlgorithmServicer):

    def SquareRoot(self, request, context):
        response = algorithm_pb2.Number()
        response.value = request.value
        return response


if __name__ == '__main__':
#     server = grpc.server(futures.ThreadPoolExecutor(max_workers=10))
#
#     algorithm_pb2_grpc.add_AlgorithmServicer_to_server(AlgorithmServicer(), server)
#
#     print('Starting server. Listening on port 50051.')
#     server.add_insecure_port('[::]:50051')
#     server.start()

    core = Core()

    try:
        while True:
            time.sleep(20)
    except KeyboardInterrupt:
        pass