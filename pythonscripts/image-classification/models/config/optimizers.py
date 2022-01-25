"""{"SGD":tf.keras.optimizers.SGD(learning_rate = float(self.PARAMETERS["learningRate"]), momentum = 0.0, nesterov = False, name = "SGD", ),
        "Adadelta":tf.keras.optimizers.Adadelta(learning_rate=float(self.PARAMETERS["learningRate"]), rho=0.95, epsilon=1e-07, name='Adadelta'),
        "Adagrad":tf.keras.optimizers.Adagrad(learning_rate=float(self.PARAMETERS["learningRate"]), initial_accumulator_value=0.1, epsilon=1e-07,name='Adagrad'),
        "Adam":tf.keras.optimizers.Adam(learning_rate=float(self.PARAMETERS["learningRate"]), beta_1=0.9, beta_2=0.999, epsilon=1e-07, amsgrad=False,name='Adam'),
        "RMSprop":tf.keras.optimizers.RMSprop(learning_rate=float(self.PARAMETERS["learningRate"]), rho=0.9, momentum=0.0, epsilon=1e-07, centered=False,name='RMSprop')}"""
import tensorflow as tf



optimizers = {"SGD":tf.keras.optimizers.SGD,
        "Adadelta":tf.keras.optimizers.Adadelta,
        "Adagrad":tf.keras.optimizers.Adagrad,
        "Adam":tf.keras.optimizers.Adam,
        "RMSprop":tf.keras.optimizers.RMSprop}