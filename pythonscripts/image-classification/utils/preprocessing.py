import cv2
import numpy
from numpy.core.fromnumeric import resize
from numpy.lib.twodim_base import _diag_dispatcher





def rotate(image : numpy.array, parameters : dict):
    
    """
    Girdi olarak verilen resmi verilen parametrelere göre çevirerek geri döndürür.

    parameters: rotate fonksiyonunun parametrelerini belirler.
    parameters = {'angle':10, 'rotateDirectories':['left','right']}

    """

    outputs = []
    angle = parameters['angle']
    for directories in parameters['rotateDirectories']:

        
        #print(directories)
        h,w = image[0].shape[:2]
        image_center = (w//2, h//2)
        
        rot = cv2.getRotationMatrix2D(image_center, angle , 1.0)
        rotatedImg = cv2.warpAffine(image[0], rot, (w, h))
        ###
        # Affine Transforn
        # https://mathworld.wolfram.com/AffineTransformation.html
        ###
         
        tmp = [[rotatedImg, image[1]]]
        outputs.extend(tmp)
      
        angle = -angle
        
    return outputs
   
def reshape(image : numpy.array , parameters : dict):
    
    """
    girdi olarak verilen resmin boyutunu değiştirir.

    image: hedef resim ve etiketi.
    image = [resim, label]

    parameters: reshape fonksiyonunun parametrelerini belirler.
    parameters = {'new_height':1920, 'new_width':1080, 'interpolation':'linear'}

    """
    interpolation = {'linear':cv2.INTER_LINEAR,'cubic':cv2.INTER_CUBIC, 'area':cv2.INTER_AREA, 'lanczos4':cv2.INTER_LANCZOS4}
    reshapedImage =  cv2.resize(image[0],(parameters['new_width'], parameters['new_height']), interpolation = interpolation[parameters['interpolation']])
   
    return [[reshapedImage, image[1]]]

def zoom(image : numpy.array, parameters : dict):

    """
    Girdi olarak verilem resmin boyutunu değiştirmeden zoomlar.
    
    image: hedef resim ve etiketi.
    image = [resim, label] 

    parameters: zoom fonksiyonunun parametrelerini belirler.
    parameters = {'zoomFactor':0.2, 'zoomDirectories':['in', 'out']}

    ###Halaa bitmedi
    
    """
    outputs = []
    _zoomFactor = parameters['zoomFactor']
    zoomFactor = 1 +_zoomFactor
    for zoomDirectories in parameters['zoomDirectories']:
        interpolation = {'linear':cv2.INTER_LINEAR,'cubic':cv2.INTER_CUBIC, 'area':cv2.INTER_AREA, 'lanczos4':cv2.INTER_LANCZOS4}
        interpolation = interpolation[parameters['interpolation']]
        imageH, imageW = image[0].shape[0], image[0].shape[1]
        
        imageHCenter, imageWCenter = imageH//2, imageW//2
        #print(zoomFactor*imageW, zoomFactor*imageH)
        resizedImage = cv2.resize(image[0],(int(zoomFactor*imageW),int(zoomFactor*imageH)),interpolation=interpolation)        
        """if resizedImage.shape[0]<imageH or resizedImage.shape[1]<imageW:
            pad_left, pad_right, pad_top, pad_bottom = (imageH -resizedImage.shape[0])//2 , (imageW - resizedImage.shape[1])//2,(imageH -resizedImage.shape[0])//2, (imageW - resizedImage.shape[1])//2  
            #pad = [(image[0].shape[0] - resizedImage.shape[0], image[0].shape[1] - resizedImage.shape[1])
            resizedImage = numpy.pad(resizedImage, pad_width = 2, mode = 'constant')#((pad_left,pad_right), (pad_top, pad_bottom)),
            print(resizedImage.shape)"""
        resizedImageHCenter, resizedImageWCenter = resizedImage.shape[0]//2, resizedImage.shape[1]//2

        h1 = resizedImageHCenter - imageHCenter
        h2 = resizedImageHCenter + imageHCenter

        w1 = resizedImageWCenter - imageWCenter
        w2 = resizedImageWCenter + imageWCenter

        zoomedImage = resizedImage[w1:w2,h1:h2]
        #print(w1,w2,h1,h2)
        tmp = [[zoomedImage, image[1]]]
        outputs.extend(tmp)

        zoomFactor = 1 - _zoomFactor

    return outputs


    
    
