import multiprocessing


"""def setMultiProcessor(func,args):
    process = multiprocessing.Process(target=func,args=(args,))
    print(args)
    process.start()
    process.join()
    pass"""
""""""


def decorator(*args, **kwargs):
    print("Inside decorator")
     
    def inner(func):
        print(kwargs)
        process = multiprocessing.Process(target=func,args=(args,))
            
        process.start()
        process.join()
        # code functionality here
        print("Inside inner function")
        print("I like", kwargs['like'])
         
        func()
         
    # returning inner function   
    return inner
 
@decorator(like = "geeksforgeeks")
def my_func():
    print("Inside actual function")