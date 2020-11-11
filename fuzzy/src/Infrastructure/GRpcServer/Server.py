import grpc
from concurrent import futures
import time
import sys

from Service import AlgorithmServicer

import algorithm_pb2
import algorithm_pb2_grpc

class Server:

    port = 50051

    def __init__(self):
        pass

    def start(self):
        server = grpc.server(futures.ThreadPoolExecutor(max_workers=10))

        algorithm_pb2_grpc.add_AlgorithmServicer_to_server(AlgorithmServicer(), server)

        print('Starting server. Listening on port 50051.')
        server.add_insecure_port('[::]:50051')
        server.start()

        server.start()