import argparse
import json
import importlib.util
import ast
import base64
spec = importlib.util.spec_from_file_location('models.lenet',r"./models/lenet.py")

parser = argparse.ArgumentParser(description='uygulamanını çalıştırılması için gereken parametreleriin girilmesi gerekir. ')
parser.add_argument('-p','--parameters',help='Eğitilecek datasetin parametrelerini içerir')
parser.add_argument('-m','--model',help='Datasetinin hangi model ile eğitileceğini belirler')

try:
    args = parser.parse_args()
    #print('test')
    #argss = json.loads(args.parameters)
    #print(ast.literal_eval(args.parameters))
    #print(str(type(argss)['augmentation']))
    print(json.loads(base64.b64decode(args.parameters))['augmentation'])
except Exception as e:
    print(e)
