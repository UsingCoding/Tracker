FROM python:3

RUN apt-get update && apt-get install -y make

RUN pip install grpcio && \
    pip install grpcio-tools && \
    pip install scikit-fuzzy && \
    pip install numpy && \
    pip install matplotlib

WORKDIR /usr/src/app