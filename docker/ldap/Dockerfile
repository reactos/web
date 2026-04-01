FROM python:3.11-slim

RUN pip install --no-cache-dir ldaptor twisted

WORKDIR /app
COPY resources/ldaptest/testserver.py .

EXPOSE 389

CMD ["python", "testserver.py", "389"]
