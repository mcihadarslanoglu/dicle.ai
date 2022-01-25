import os
import cv2
import numpy
from sklearn.model_selection import train_test_split
#from .preprocessing import *
from .augmentation import reshape
import random
class Datas():

    def __init__(self,trainImages, trainLabels, valImages,valLabels, testImages,
        testLabels,classes, classCount, sampleCount,parameters):

        
        self.trainImages = trainImages
        self.trainLabels = trainLabels
        self.valImages = valImages
        self.valLabels = valLabels
        self.testImages = testImages
        self.testLabels = testLabels
        self.classes = classes
        self.classCount = classCount
        self.sampleCount = sampleCount
        self.parameters = parameters
    
class customImageDataGenerator():

    r"""
    Bu sınıf resimlerin bir klasörden okunması, üzerlerinde preprocessing yapılması özelliklerine sahiptir.
    
    DEĞİŞKENLER
    ----------

    rescale: resimlerin 0-255 aralığındaki değerlerini resim*rescale olarak değiştirir.
    
    validation_split: resimlerin yüzde kaçının validasyon için kullanılması gerektiğini belirler.
    
    batch_size: resimlerin derin öğrenme algoritmaları ile eğitilirken gereken parametre.
        varsayılan olarak 32 değerine sahiptir.
    
    class_mode: farklı sınıftaki resimlerin nasıl etiketleneceğini belirleyen değişken.
        varsayılan olarak categorical değerine sahiptir.

    images: klasörlerden yüklenen bütün resimleri içerir.
        [[resim1, label1],[resim2, label2],[resim3, label3],[resim4, label4]...] şeklindedir.
    
    classes: yüklenen verilerin bütün etiketlerini barındırır.
        [0,1,2,3,4,5,6...] şeklindedir.

    classCount: veri setinde sınıf sayısı
    classCount = 10

    sampleCount: verisetinde bulunan resimlerin sayısı.
    sampleCount = 480

    
    
    """
    def __init__(self, parameters) -> None:#validation_split,epochs, batch_size=32,class_mode='categorical'
        #self.rescale = rescale
        self.parameters = parameters
        self.datasetParameters = self.parameters['dataset']
        self.validation_split = self.datasetParameters['validation_split']
        self.test_split = self.datasetParameters['test_split']
        self.images = []
        self.classes = []
        self.classCount = 0
        self.sampleCount = 0 
    
    def flow_from_directory(self) -> None:


        r"""
        paramtere olarak verilen directory klasöründeki bütün resimleri okur.

        PARAMETRELER
        ------------
        
        directory: okunacak verilerin bukunduğu klasörün yolu.
        directory = "C:\xampp\htdocs\dicle.ai\users\f40b8a370870a98a39097c3faadfd7117ad7f2a7eec81455a54638788c405180\image-classification\datasets\dataset1"

        color_mode: resimlerin gri, rgb veya varsayılan olarak okunmasını sağlar ve varsayılan değeri True'dur.
        olası değerler: ['gray','rgb','original']
        color_mode =  gray


        shuffle: verilerin eğitim için karıştırılmasını sağlar ve varsayılan değeri True'dur.
        olası değerler = [True, False]
        shuffle = False

        images: bütün okunan resimleri etiketleriyle beraber barındırır.
        images = [[resim1, label1],[resim2, label2],[resim3, label3],[resim4, label4]...]

        """

        SPACE_COLORS = {'bgr':cv2.IMREAD_COLOR,'gray':cv2.IMREAD_GRAYSCALE,'original':cv2.IMREAD_UNCHANGED}
        color_mode = self.datasetParameters['color_mode'].lower()
        self.directory = self.datasetParameters['path']
        #self.target_size = self.datasetParameters
        
        self.shuffle = bool(self.datasetParameters['shuffle'])
        #self.subset = subset

        

        self.subDirs = [folder for folder in os.listdir(self.directory) if os.path.isdir(os.path.join(self.directory,folder))]
        for classFolder in self.subDirs:
            
            for imageName in os.listdir(os.path.join(self.directory,classFolder)):

                

                image = cv2.imread(os.path.join(self.directory,classFolder,imageName), SPACE_COLORS[color_mode])
                self.images.append([image,self.classCount])
                self.sampleCount+=1

                

            self.classes.append(self.classCount)
            self.classCount+=1
        #print('flow',len(self.images))

    """          
    def preprocess(self, functions : list, parameters : dict) -> list:

       
        Veri setindeki bütün resimleri istenen işlemlerden geçirir.

        functions: geçirilmesi istenen işlemlerin isimleri. Birden fazla parametre verilebilir ve her durumda da liste veri tipindedir.
        olası değerler: ['rotate','reshape','zoom']
        functions = ['rotate','reshape']

        parameters: yapılması istenen işlemlerin parametrelerini barındırıd.
        parameters = {'zoom':{'zoomFactor':0.2, 'zoomDirectories':['in', 'out']},'reshape':{'sizes':(1920,1080),'interpolation':'nearst'}}
        
                

        functionsDict = {'rotate':rotate, 
                        'reshape':reshape, 
                        'zoom':zoom,
                        }

        tmImages = []
        #self.images = [[numpy.zeros((1,2,3)),0], [numpy.zeros((1,2,3))+1,1]]
        count = 0
        for image in self.images:
        
        
            
            #count+=1
            for functionName in functions:

                exposeToFunction = functionsDict[functionName]
                exposedImage = exposeToFunction(image,parameters[functionName])
                tmImages.extend(exposedImage)
                self.sampleCount +=1
        
        self.images.extend(tmImages)
        del tmImages
        
    """
    def preprocess(self):
        print('preprocessing')
        parameters = self.parameters['augmentation']
        for functionName in parameters:
            #print('start',functionName,' ',len(self.images))
            function = __import__('utils.augmentation.'+functionName)
            function = getattr(function,'augmentation')
            function = getattr(function,functionName)
            function = getattr(function,functionName)
            self.images = function(self.images, parameters[functionName])
            #print('end',functionName,' ',len(self.images))
 
        #reshape(self.images,parameters['reshape'])
  
    def build(self):
        self.splitDataset()
        #print()
        #self.trainDataset = numpy.array(self.train_dataset)
        #self.trainImages, self.trainLabels = numpy.stack(self.trainDataset[:,0])/255,numpy.stack(self.trainDataset[:,1]) #.astype(numpy.float32)/

        #self.valDataset = numpy.array(self.val_dataset)#.astype(numpy.float32)
        #self.valImages, self.valLabels = numpy.stack(self.valDataset[:,0])/255, numpy.stack(self.valDataset[:,1]) #.astype(numpy.float32)/255
        
        
        return self.returnDatas()
    
    def returnDatas(self):
        
        return Datas(self.trainImages, 
        self.trainLabels, 
        self.valImages,
        self.valLabels,
        self.testImages,
        self.testLabels,
        self.classes, 
        self.classCount, 
        self.sampleCount,
        self.parameters)

        
    def splitDataset(self) -> None:
        #print((self.validation_split*self.sampleCount))
        samplePerClassValidation = int(numpy.ceil(self.validation_split*self.sampleCount/self.classCount))
        samplePerClassTest = int(numpy.ceil(self.test_split*self.sampleCount/self.classCount))
        #print('len',len(self.images))
        self.images = numpy.array(self.images)
        self.images,self.labels =self.images[:,0],self.images[:,1]

        self.valImages = []
        self.valLabels = []

        self.testImages = []
        self.testLabels = []

        if samplePerClassValidation < self.classCount:
            samplePerClassValidation = 1
        
        if samplePerClassTest < self.classCount:
            samplePerClassTest = 1
        
        #Validasyon split
        for label in range(0,self.classCount):
            targets = numpy.where(self.labels == label)[0]
            choosen = []
            #print(targets)
            for count in range(samplePerClassValidation):
                choice = numpy.random.choice(targets)   
                choosen.append(choice)
                self.valImages.append(self.images[choice])
                self.valLabels.append(self.labels[choice])

            self.images = numpy.delete(self.images, choosen)
            self.labels = numpy.delete(self.labels,choosen)
        
        #Test split
        for label in range(0,self.classCount):
            targets = numpy.where(self.labels == label)[0]
            choosen = []
            #print(targets)
            for count in range(samplePerClassTest):
                choice = numpy.random.choice(targets)   
                choosen.append(choice)
                self.testImages.append(self.images[choice])
                self.testLabels.append(self.labels[choice])

            self.images = numpy.delete(self.images, choosen)
            self.labels = numpy.delete(self.labels,choosen)

       
        #print('split', self.testImages)
        """
        for image in self.images:
            print('self.images size: ',image.shape)
        """
        self.trainImages, self.trainLabels =  numpy.stack(self.images)/255, numpy.stack(self.labels)
        self.valImages, self.valLabels = numpy.stack(self.valImages)/255, numpy.stack(self.valLabels)
        self.testImages, self.testLabels =  numpy.stack(self.testImages)/255, numpy.stack(self.testLabels)

        print('shape test', self.testImages.shape)
        




        #self.train_dataset, self.val_dataset = train_test_split(self.images, shuffle = self.shuffle, test_size=int(self.validation_split*self.sampleCount))
        
        

        
#test = customImageDataGenerator(1,1)
#test.flow_from_directory(r"C:\\xampp\\htdocs\\dicle.ai\\users\\f40b8a370870a98a39097c3faadfd7117ad7f2a7eec81455a54638788c405180\\image-classification\\datasets\\dataset1")
#test.splitDataset(0.1)
#print(len(test.images))
#test.preprocess(['rotate'],{'rotate':{'angle':60, 'rotateDirectories':['left','right']}})
#test.preprocess(['reshape'], {'reshape':{'new_height':1920, 'new_width':1080, 'interpolation':'linear'}})
#test.preprocess(['zoom'],parameters = {'zoom':{'zoomFactor':0.2, 'zoomDirectories':['in'],'interpolation':'cubic'}})
#datas = test.build()
#model = Model()
#print(len(test.images))
"""
for j in test.images:
    cv2.imshow('test', j[0])
    print(j[0].shape)
    cv2.waitKey(0)"""