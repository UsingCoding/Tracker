import algorithm_pb2_grpc

class AlgorithmServicer(algorithm_pb2_grpc.AlgorithmServicer):

    def SquareRoot(self, request, context):
        response = algorithm_pb2.Number()
        response.value = request.value
        return response
