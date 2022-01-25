import cv2
def reshape(images  , parameters : dict):
    
    """
    girdi olarak verilen resmin boyutunu değiştirir.

    image: hedef resim ve etiketi.
    image = [resim, label]

    parameters: reshape fonksiyonunun parametrelerini belirler.
    parameters = {'new_height':1920, 'new_width':1080, 'interpolation':'linear'}

    """
    
    outputs = []
    interpolation = {'linear':cv2.INTER_LINEAR,'cubic':cv2.INTER_CUBIC, 'area':cv2.INTER_AREA, 'lanczos4':cv2.INTER_LANCZOS4}
    for image in images:
        
        reshapedImage =  cv2.resize(image[0],(int(parameters['new_width']), int(parameters['new_height'])), interpolation = cv2.INTER_CUBIC)#interpolation[parameters['interpolation']]
        tmp = [[reshapedImage, image[1]]]
        outputs.extend(tmp)
        
    return outputs