import multiprocessor


class customImageDataGenerator():

    def __init__(self, rescale, validation_split, batch_size=32,class_mode='categorical'):
        self.rescale = rescale
        self.validation_split = validation_split
        self.batch_size = batch_size
        self.class_mode = class_mode
    @multiprocessor.setMultiProcessor(args='test')
    def flow_from_directory(self,
                            directory,
                            target_size=(256, 256),
                            color_mode='rgb',
                            shuffle=True,
                            subset=None,
                            ):

        self.directory = directory
        self.target_size = target_size
        self.color_mode = color_mode
        self.shuffle = shuffle
        self.subset = subset

        

                
        pass


test = customImageDataGenerator(1,1)