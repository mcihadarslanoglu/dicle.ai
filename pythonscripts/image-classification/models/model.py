from tensorflow.keras.models import Sequential
from .config.optimizers import *
from .config.loss import *
from .config.metrics import * 
from tensorflow import expand_dims
import time
import os 
import json
import matplotlib.pyplot as plt
import seaborn
from sklearn.metrics import classification_report
from pandas import DataFrame
class BaseModel():
    """
    Bütün derin öğrenme modelleri bu ana sınıfı baz alınarak oluşturulur. Buradaki bütün sınıflar ve değişkenler bütün modeller için ortaktır.

    """
    
    
    def __init__(self, datas):
        
        """
        parameters = {'optimizer':{'learning_rate':0.1, 'name':'SGD'},'loss':{'name':'BinaryCrossentropy','from_logits':True}, 'metric':{'name':'accuracy'}}

        """
        #print(parameters)
        
        self.datas = datas
        self.parameters = self.datas.parameters
        
        if len(self.datas.trainImages.shape) != 4:
        
            self.datas.trainImages = expand_dims(self.datas.trainImages,axis=3)# Veriler tek kanalda yani gri tonda okunursa kullanılacak, bgr olursa kullanılmayacak. 
            self.datas.valImages = expand_dims(self.datas.valImages,axis=3)#
            self.datas.testImages = expand_dims(self.datas.testImages, axis=3)
        self.model = Sequential()

        self.setOptimizer()
        self.setLoss()
        self.setMetrics()
        self.initSave()
 
    def setOptimizer(self):
        
        self.optimizerParameters = self.parameters['trainingParameters']['optimizer']
        self.optimizerParameters['learning_rate'] = float(self.optimizerParameters['learning_rate'])
        self.optimizer = optimizers[self.optimizerParameters['name']]
        self.optimizer = self.optimizer(**self.optimizerParameters)
        
      
    
    def setLoss(self):
        
        self.lossParameters = self.parameters['trainingParameters']['loss']
        self.loss = losses[self.lossParameters['name']]
        self.loss = self.loss(**self.lossParameters)

    def setMetrics(self):
        
        self.metricParameters = self.parameters['trainingParameters']['metrics']
        self.metrics = metrics[self.metricParameters['name']]
        self.metrics = self.metrics(**self.metricParameters)
        print(self.metrics)
      

    def compile(self):
        self.model.compile(optimizer=self.optimizer, loss = self.loss, metrics = self.metrics)

    def fit(self):

        
        #callbacks = tensorflow.keras.callbacks.ModelCheckpoint(filepath=self.checkpointPath,save_weights_only=True,verbose=1)

        self.datas.trainLabels = tf.keras.utils.to_categorical(self.datas.trainLabels, self.datas.classCount)
        self.model.compile(loss = self.loss, optimizer = self.optimizer, metrics = self.metrics)
        self.history = self.model.fit(self.datas.trainImages, self.datas.trainLabels, batch_size = int(self.datas.parameters['trainingParameters']['batch_size']) , epochs = int(self.datas.parameters['trainingParameters']['epochs']))

    def runModel(self):
        self.buildNetwork()
        self.compile()
        self.fit()
        
    
        self.predictModel()
        self.plot()
        self.saveParameters()
        self.saveEpochs()
        self.saveWeights()
    

    def initSave(self):
        self.timeStamp = str(int(time.time()))
        
        parameters = self.parameters['save']
        print(parameters)
        self.savePath = os.path.join(parameters['path'],parameters['name']+'_'+self.timeStamp) 
        self.weightsPath = os.path.join(self.savePath,'weights')
        self.epochResultsPath = os.path.join(self.savePath,'epochs')
        self.plotsPath = os.path.join(self.savePath,'plots')
        self.checkpointPath = os.path.join(self.savePath,'checkpoints')
        self.saveName = parameters['name']
        os.mkdir(self.savePath)
        os.mkdir(self.weightsPath)
        os.mkdir(self.epochResultsPath)
        os.mkdir(self.plotsPath)
        os.mkdir(self.checkpointPath)
    
    
    def saveWeights(self):
        r"""
        parameters = {'path':r'C:\xampp\htdocs\dicle.ai\users\f40b8a370870a98a39097c3faadfd7117ad7f2a7eec81455a54638788c405180\image-classification\trained-datasets','name':'dataset1'}

        """
        self.model.save_weights(filepath=os.path.join(self.weightsPath,self.saveName+'_weights_'+self.timeStamp+'.h5'))



    def predictModel(self):
        predicts = self.model.predict(self.datas.testImages,batch_size=  int(self.datas.parameters['trainingParameters']['batch_size'])).argmax(axis=1) 
        self.cfm = tensorflow.math.confusion_matrix(self.datas.testLabels,predicts)
        self.cr = classification_report(self.datas.testLabels,predicts,output_dict = True)
    def saveEpochs(self):
        _history = json.dumps(self.history.history,indent= 4)
        with open(os.path.join(self.epochResultsPath,self.saveName+'_epochs_'+self.timeStamp+'.json'),'w') as epochsFile:
            epochsFile.write(_history)

    def saveParameters(self):
        _parameters = json.dumps(self.parameters,indent=4)
        with open(os.path.join(self.savePath,self.saveName+'_parameters_'+self.timeStamp+'.json'),'w') as parametersFile:
            parametersFile.write(_parameters)
        
    
    def plot(self):
        
        #Confusion matrix
        seaborn.set(color_codes = True)
        seaborn.set(font_scale = 1.4)
        plt.figure()
        plt.title('CONFUSION MATRIX')
        seaborn.heatmap(self.cfm,annot = True, cmap = 'Blues', fmt = 'g')
        plt.savefig(fname = os.path.join(self.plotsPath,'confusion_matrix.svg'),format = 'svg',bbox_inches = 'tight')
        #plt.show()


        #classification report
        plt.figure()
        plt.title("CLASSIFICATION REPORT")
        seaborn.heatmap(DataFrame(self.cr).iloc[:-1, :].T, annot=True, cmap = 'Blues', fmt = '.2g')
        plt.savefig(fname = os.path.join(self.plotsPath,'classification_report.svg'),format = 'svg',bbox_inches = 'tight')
        

        xaxis = list(range(1, int(self.parameters['trainingParameters']['epochs'])+1))
        
        
        #epoch-loss grafiği
        loss = self.history.history['loss']
        plt.figure()
        plt.xlabel('Epochs')
        plt.ylabel('loss')
        plt.xticks(xaxis)
        plt.plot(xaxis, loss,marker = 'o')
        plt.ticklabel_format(useOffset=False)
        plt.savefig(fname = os.path.join(self.plotsPath,'epoch-loss.svg'),format = 'svg',bbox_inches = 'tight')
        
        
      
        
        #epoch-accuracy grafiği
        accuracyValues = self.history.history[self.parameters['trainingParameters']['metrics']['name']]
        plt.figure()
        plt.xlabel('Epochs')
        plt.ylabel(self.parameters['trainingParameters']['metrics']['name'])
        plt.xticks(xaxis)
        plt.plot(xaxis, accuracyValues,marker = 'o')
        plt.ticklabel_format(useOffset=False)
        plt.savefig(fname = os.path.join(self.plotsPath,'epoch-accuracy.svg'),format = 'svg',bbox_inches = 'tight')
        
        