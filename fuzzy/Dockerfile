FROM python:3

RUN apt-get update && apt-get install -y make

RUN pip install django && \
    pip install scikit-fuzzy && \
    pip install numpy

WORKDIR /usr/src/app

CMD [ "make" ]