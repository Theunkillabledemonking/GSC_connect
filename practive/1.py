# Target Function

# Daemon vs non daemon

import threading

my_lock_1 = threading.Lock()

def bar():
    for _ in range(5):
        with my_lock_1:
            print(f"bar : {_}")


def foo():
    for _ in range(5):
        with my_lock_1:
            print(f"foo : {_}")
        
my_thread_1 = threading.Thread(target=bar) # Start # non daemon
my_thread_2 = threading.Thread(target=foo) # Start # non daemon

my_thread_1.start() # Runnanble
my_thread_1.join()


my_thread_2.start() # Runnanble
my_thread_2.join()


# Roop 
print("Finish")