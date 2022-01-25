from os import O_TEMPORARY
import cv2

def zoom(images : list , parameters : dict):

    """
    Girdi olarak verilem resmin boyutunu değiştirmeden zoomlar.
    
    image: hedef resim ve etiketi.
    image = [resim, label] 

    parameters: zoom fonksiyonunun parametrelerini belirler.
    parameters = {'zoomFactor':0.2, 'zoomDirectories':['in', 'out']}

    ###Halaa bitmedi, zoomout kısmı sıkıntılı. Zoomout yapınca padding yapılmasi gerekiyor.
    
    """
    outputs = images.copy()
    _zoomFactor = float(parameters['zoomFactor'])
    zoomFactor = 1 +_zoomFactor
    
    for zoomDirectories in parameters['zoomDirectories']:
        print(zoomDirectories)
        for image in images:
            
            interpolation = {'linear':cv2.INTER_LINEAR,'cubic':cv2.INTER_CUBIC, 'area':cv2.INTER_AREA, 'lanczos4':cv2.INTER_LANCZOS4}
            interpolation = cv2.INTER_CUBIC#interpolation[parameters['interpolation']]
            imageH, imageW = image[0].shape[0], image[0].shape[1]
            
            imageHCenter, imageWCenter = imageH//2, imageW//2
            #print('resizeIMage: ', image[0])
            #print('zoomFactor: ',zoomFactor)
            #print('imageH: ',imageH)
            resizedImage = cv2.resize(image[0],(int(zoomFactor*imageW),int(zoomFactor*imageH)),interpolation=interpolation)     
        
            resizedImageHCenter, resizedImageWCenter = resizedImage.shape[0]//2, resizedImage.shape[1]//2

            h1 = resizedImageHCenter - imageHCenter
            h2 = resizedImageHCenter + imageHCenter

            w1 = resizedImageWCenter - imageWCenter
            w2 = resizedImageWCenter + imageWCenter

            zoomedImage = resizedImage[w1:w2,h1:h2]
          
            tmp = [[zoomedImage, image[1]]]#
            outputs.extend(tmp)

        #zoomFactor = 1 - _zoomFactor
   
    return outputs
