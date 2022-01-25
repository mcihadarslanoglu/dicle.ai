from tensorflow.keras import layers
from tensorflow.python.keras.utils import layer_utils
from .Imodel import IModel
from .model import BaseModel



class Model(IModel, BaseModel):
    
    def __init__(self, datas):
        super().__init__(datas)
        self.modelName = 'vgg16'

    def buildNetwork(self):
        
        self.model.add(layers.Conv2D(filters=64,kernel_size=3,strides=(1,1),padding = 'same'))
        self.model.add(layers.Conv2D(filters=64,kernel_size=3,strides=(1,1),padding = 'same'))
        self.model.add(layers.MaxPool2D(pool_size=(2,2)))

        self.model.add(layers.Conv2D(filters=128,kernel_size=3,strides=(1,1),padding = 'same'))
        self.model.add(layers.Conv2D(filters=128,kernel_size=3,strides=(1,1),padding = 'same'))
        self.model.add(layers.MaxPool2D(pool_size=(2,2)))

        self.model.add(layers.Conv2D(filters=256,kernel_size=3,strides=(1,1),padding = 'same'))
        self.model.add(layers.Conv2D(filters=256,kernel_size=3,strides=(1,1),padding = 'same'))
        self.model.add(layers.Conv2D(filters=256,kernel_size=3,strides=(1,1),padding = 'same'))
        self.model.add(layers.MaxPool2D(pool_size=(2,2)))

        self.model.add(layers.Conv2D(filters=512,kernel_size=3,strides=(1,1),padding = 'same'))
        self.model.add(layers.Conv2D(filters=512,kernel_size=3,strides=(1,1),padding = 'same'))
        self.model.add(layers.Conv2D(filters=512,kernel_size=3,strides=(1,1),padding = 'same'))
        self.model.add(layers.MaxPool2D(pool_size=(2,2)))

        self.model.add(layers.Conv2D(filters=512,kernel_size=3,strides=(1,1),padding = 'same'))
        self.model.add(layers.Conv2D(filters=512,kernel_size=3,strides=(1,1),padding = 'same'))
        self.model.add(layers.Conv2D(filters=512,kernel_size=3,strides=(1,1),padding = 'same'))
        self.model.add(layers.MaxPool2D(pool_size=(2,2)))

        self.model.add(layers.Flatten())
        self.model.add(layers.Dense(4096))
        self.model.add(layers.Dense(4096))
        
        self.model.add(layers.Dense(units = self.datas.classCount,activation='softmax'))
