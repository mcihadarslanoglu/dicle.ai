from abc import ABC, abstractmethod

class IModel(ABC):

    #__metaclass__ =  ABCMeta

    @abstractmethod
    def buildNetwork(self):
        raise NotImplementedError
    
    
   