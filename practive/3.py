from queue import Queue

my_queue = Queue()

def dl_mod():
    servo_angle = 30
    my_queue.put(servo_angle)
    pass

def servo_dc_mod():
    servo_angle = my_queue.get()
    # 서보모터 각도 조절
    pass
    # 자체적으로 락

for val in range(20, 31):
    my_queue.put(val)
    
while not my_queue.empty():
    print(my_queue.get())