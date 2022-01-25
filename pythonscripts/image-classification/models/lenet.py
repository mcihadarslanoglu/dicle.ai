
from tensorflow.keras import layers
from .Imodel import IModel
from .model import BaseModel

class Model(IModel,BaseModel):
    def __init__(self, datas) -> None:
        super().__init__(datas)
        self.modelName = 'lenet'
        
    def buildNetwork(self):

        self.model.add(layers.Conv2D(filters=6 ,kernel_size=3,strides=1,activation='relu',padding='same'))
        self.model.add(layers.MaxPool2D(pool_size=(2,2),strides=(2,2)))

        self.model.add(layers.Conv2D(filters=16,kernel_size=3,strides=1,activation='relu',padding='same'))
        self.model.add(layers.MaxPool2D(pool_size=(2,2),strides=(2,2)))

        self.model.add(layers.Flatten())
        self.model.add(layers.Dense(120))
        self.model.add(layers.Dense(84))
        self.model.add(layers.Dense(self.datas.classCount,activation='softmax'))#Standar lenet için son katmandaki ağ sayısı 10'dur.

    

    
#test = Model(2,{'optimizer':{'learning_rate':0.1, 'name':'SGD'},'loss':{'name':'BinaryCrossentropy','from_logits':True}})
#test.setOptimizer()
#test.setLoss()
#print(test.loss)
        
        
