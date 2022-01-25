#import augmentation
moduleName = 'zoom'
module =__import__('augmentation')
module = __import__("augmentation."+moduleName)
#print(dir(module))
#module.__init__()
module = getattr(module,moduleName)
module = getattr(module,moduleName)
image = cv2.zeros((3,3,3))
module([image,2])
print(dir(module))

