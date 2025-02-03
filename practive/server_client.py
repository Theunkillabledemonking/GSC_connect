import socket

# 서버 설정
HOST = '127.0.0.1' # 서버가 바인딩할 ip 주소 (로컬호스트)
PORT = 12345 # 사용할 포트 번호

# 소켓 생성 (IPv4, TCP 방식)
# TCP : socket.SOCK_STREAM
# UDP : socket.SOCK_DGRAM
server_socket_1 = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
server_socket_2 = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)

# IP 및 포트 바인딩
server_socket_1.bind((HOST,PORT))

# 클라이언트의 접속 요청을 받을 수 있도록 대기 상태 설정
# (최대 5개의 대기 큐 크기 설정)
server_socket_1.listen(5)
print(f"서버가 {HOST}:{PORT}에서 대기 중..")

# accept(), -> 사용자로부터 연결 요청을 받았을 때 -> 새로운 소켓 생성
server_socket_1.accept()

print("hello");
# while True:
#     # 클라이언트의 연결 요청을 수락하고,
#     # 새로운 소켓과 클라이언트 주소 반환 (블로킹 상태)
    