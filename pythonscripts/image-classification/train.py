
from json import load



    
import argparse
from utils.customImageDataGenerator import customImageDataGenerator
import timeit
import json
import importlib.util
import base64
#from models.lenet import Model

def main():

    parser = argparse.ArgumentParser(description='uygulamanını çalıştırılması için gereken parametreleriin girilmesi gerekir. ')
    parser.add_argument('-p','--parameters',help='Eğitilecek datasetin parametrelerini içerir')
    parser.add_argument('-m','--model',help='Datasetinin hangi model ile eğitileceğini belirler')

    args = parser.parse_args()
   
    modelName = str(args.model).lower()
    #modelName = 'lenet'
    parameters = json.loads(base64.b64decode(args.parameters))
    #parameters = {"augmentation":[],"trainingParameters":{"model":"lenet","epochs":"10","batch_size":"8","metrics":{"name":"CategoricalAccuracy"},"optimizer":{"learning_rate":"0.00004","name":"Adam"},"loss":{"name":"CategoricalCrossentropy"}},"save":{"name":r"C:\xampp\htdocs\dicle.ai\users\7752ebfece062cb5f74af41532841d20c7db40f30019962bcbed95fb4a599508\image-classification\trained-datasets\mnist24Test1"},"dataset":{"path":r"C:\xampp\htdocs\dicle.ai\users\7752ebfece062cb5f74af41532841d20c7db40f30019962bcbed95fb4a599508\image-classification\datasets\mnist24","color_mode":"GRAY","validation_split":0.1,"shuffle":1}}
    #parameters = {"augmentation":{"rotate":{"angle":"30","rotateDirectories":"left;right"},"zoom":{"zoomFactor":"2","zoomDirectories":"in"},"reshape":{"new_width":"227","new_height":"227","interpolation":"cubic"}},"trainingParameters":{"model":"vgg16","epochs":"1","batch_size":"1","metrics":{"name":"CategoricalAccuracy"},"optimizer":{"learning_rate":"1","name":"SGD"},"loss":{"name":"CategoricalCrossentropy"}},"save":{"name":"test","path":"C:\\xampp\\htdocs\\dicle.ai\\users\\7752ebfece062cb5f74af41532841d20c7db40f30019962bcbed95fb4a599508\\image-classification\\trained-datasets"},"dataset":{"path":"C:\\xampp\\htdocs\\dicle.ai\\users\\7752ebfece062cb5f74af41532841d20c7db40f30019962bcbed95fb4a599508\\image-classification\\datasets\\dataset3","color_mode":"BGR","validation_split":0.1,"shuffle":1}}
    #modelName = 'vgg16'
    #print(args.parameters)




    spec = importlib.util.spec_from_file_location("models."+modelName, "C:\\xampp\\htdocs\\dicle.ai\\pythonscripts\\image-classification\\models\\" + modelName+'.py')
    Model = importlib.util.module_from_spec(spec)
    spec.loader.exec_module(Model)
    Model = Model.Model
    dataGenerator = customImageDataGenerator(parameters)
    dataGenerator.flow_from_directory()
    #start = timeit.default_timer()

    dataGenerator.preprocess()#parameters = {'zoom':{'zoomFactor':0.2, 'zoomDirectories':['in'],'interpolation':'cubic'}},,'zoom':{'zoomFactor':0.2, 'zoomDirectories':['in'],'interpolation':'cubic'},'rotate':{'angle':45,'rotateDirectories':['left','right']}}

    #end = timeit.default_timer()
    #print(end-start)
    datas = dataGenerator.build()

    model = Model(datas)
    model.runModel()


if __name__ == '__main__':
   main()
