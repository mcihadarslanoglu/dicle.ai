import cv2


def rotate(images : list, parameters : dict):
    
    """
    Girdi olarak verilen resmi verilen parametrelere göre çevirerek geri döndürür.

    parameters: rotate fonksiyonunun parametrelerini belirler.
    parameters = {'angle':10, 'rotateDirectories':['left','right']}

    """

    outputs = images.copy()
    angle = float(parameters['angle'])
    parameters['rotateDirectories'] = parameters['rotateDirectories'].split(';')
    #print(len(images))
    for directories in parameters['rotateDirectories']:
    
        for image in images:    

            #outputs.extend([[image[0],image[1]]])
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
    #print(len(outputs))
    return outputs