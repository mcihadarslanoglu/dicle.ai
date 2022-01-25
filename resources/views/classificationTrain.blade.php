<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('/css/classificationTrain.css') }}" />
    <title>Document</title>
  
</head>
<body>
   
    <section class = 'container'>
        @include('layouts.header')
        <div class = 'row'>
        <div class = 'wizard-steps-container '>
            <div class = 'wizard-steps d-flex justify-content-center '>
                <span class = 'step '>Dataset</span>
                <span class = 'step'>Augmentation</span>
                <span class = 'step'>Train</span>
        
            </div>
        </div>
        <div class = 'wizard-content'>
            <!--Select Dataset Start-->
            <div class = 'tab-content'>
                <div class = 'row justify-content-center'>
                    <div class = 'col-4 align-self-center'>
                        <div class = 'title'>
                            <h3>Dataset</h3>
                        </div>
                            <form >
                                <div class = 'select-dataset-container'>
                                    <select class="form-select mb-1" aria-label="Default select example" id = 'dataset' name = 'dataset'>
                                        <option selected >Select Dataset</option>

                                        @foreach($datasets as $dataset)
                                            <option value="{{$dataset['name']}}">{{$dataset['name']}}</option>
                                        <!--<option value="Dataset1">Dataset1</option>
                                        <option value="Dataset2">Dataset2</option>
                                        <option value="Dataset3">Dataset1</option>
                                        -->
                                        @endforeach
                                    </select>
                                </div>
                                <div class = 'select-colormode-container' id = 'colorMode'>
                                    <select class="form-select mb-1" aria-label="Default select example"  name = 'colorMode'> 
                                        <option selected>Select Color Mode</option>
                                        <option value="BGR">BGR</option>
                                        <option value="GRAY">GRAY</option>
                                        <option value="ORIGINAL">ORIGINAL</option>
                                    </select>
                                </div>

                                <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Validasyon%</span>
                                <input type="number" step = '1' pattern="^/d+*$" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name = 'validation_split'>
                              
                                </div>

                                <div class="input-group input-group-sm mb-3">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">test%</span>
                                    <input type="number" step = '1' pattern="^/d+*$" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name = 'test_split'>
                                  
                                </div>

                            </form>
                    </div>
                </div> 
            </div>
            <!--Select Dataset End-->
            <div class = 'tab-content'>
                
                <!--Augmentation Start-->
                <div class = 'row justify-content-center'>     
                    <div class = 'col-4 align-self-center'>
                        <div class = 'title'>
                            <h3>Augmentation</h3>
                        </div>
                        <!----->
                        
                            
                            <div class = 'augmentation-container'>
                            <!-- Rotate Start-->
                                
                                <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" data-bs-toggle="collapse" href="#rotateContent" role="button" aria-expanded="false" aria-controls="collapseExample" name = 'rotateCheck'>
                                <label class="form-check-label" for="flexSwitchCheckDefault">Rotate</label>
                                
                                <div class="collapse" id="rotateContent" name = 'parameterContent'>
                                    <div class="card card-body">
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">Angle</span>
                                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name = 'rotateAngle' id = 'rotateAngle'>
                                          </div>
                                    </div>
                                </div>
                            
                            </div>
                               
                            <!--Rotate End-->
                            <!--Zoom Start-->
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" data-bs-toggle="collapse" href="#zoomContent" role="button" aria-expanded="false" aria-controls="collapseExample" name = 'zoomCheck'>
                                <label class="form-check-label" for="flexSwitchCheckDefault">Zoom</label>
                                
                                <div class="collapse" id="zoomContent" name = 'parameterContent'>
                                    <div class="card card-body">
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">Zoom Factor</span>
                                            <input type="number" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name = 'zoomFactor'>
                                          </div>
                                    </div>
                                </div>

                            </div>
                            <!--Zoom End-->

                            <!--Reshape Start-->
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" data-bs-toggle="collapse" href="#reshapeContent" role="button" aria-expanded="false" aria-controls="collapseExample" name = 'reshapeCheck'>
                                <label class="form-check-label" for="flexSwitchCheckDefault">Reshape</label>
                                
                                <div class="collapse" id="reshapeContent" name = 'parameterContent'>
                                    <div class="card card-body">
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">Size</span>
                                            <input type="number" step = '1' pattern="^/d+*$" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name = 'reshapeSize'>
                                          </div>
                                    </div>
                                </div>

                            </div>
                            <!--Reshape End-->

                            
                        </div>
                          
                        <!---->
                    </div>
                </div>
            </div>
            <!--Augmentation End-->
            <!--Train Start-->
            <div class = 'tab-content'>
                <div class = 'row justify-content-center'>
                    <div class = 'col-4 align-self-center'>
                        <div class = 'title'>
                            <h3>Train Parameters</h3>
                        </div>
                        <div class = 'train-container' name = 'parameterContent'>
                            <form>
                            <div class = 'select-colormode-container' id = 'modelContainer'>
                                <select class="form-select mb-1" aria-label="Default select example" name= 'model'>
                                    <option selected >Select model</option>
                                    @foreach($models as $model)
                                    @if(!in_array($userRole, explode(',',$model->permissions)))
                                        <option value="{{$model->name}}" class = 'lock' disabled>{{$model->name}} </option>
                                        
                                    @else
                                        <option value="{{$model->name}}">{{$model->name}}</option>
                                    @endif
                                    @endforeach

                                    <!--
                                    <option value="lenet">lenet</option>
                                    <option value="vgg16">vgg16</option>
                                    <option value="vgg19">vgg19</option>
                                    -->
                                </select>
                            </div>

                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Epochs</span>
                                <input type="number" step = '1' pattern="^/d+*$" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name = 'epochs'>
                              
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Batch size</span>
                                <input type="number" step = '1' pattern="^/d+*$" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name = 'batchSize'>
                              
                            </div>

                            <div class = 'select-colormode-container' id = 'metricsContainer'>
                                <select class="form-select mb-1" aria-label="Default select example" name = 'metrics'>
                                    <option selected>Select Metrics</option>
                                    @foreach($metrics as $metric)
                                    @if(!in_array($userRole, explode(',',$metric->permissions)))
                                    <option value="{{$metric->name}}" class = 'lock' disabled>{{$metric->name}}</option>
                                    @else
                                    <option value="{{$metric->name}}">{{$metric->name}}</option>
                                    @endif
                                    @endforeach
                                    <!--
                                    <option value="CategoricalAccuracy">CategoricalAccuracy</option>
                                    <option value="BinaryCrossentropy">BinaryCrossentropy</option>
                                    <option value="CategoricalHinge">CategoricalHinge</option>
                                    -->
                                </select>
                            </div>

                            <div class = 'select-colormode-container' id = 'metricsContainer'>
                                <select class="form-select mb-1" aria-label="Default select example" name = 'optimizer'>
                                    <option selected>Select Optimizer</option>
                                    @foreach($optimizers as $optimizer)
                                    @if(!in_array($userRole, explode(',',$optimizer->permissions)))
                                    <option value="{{$optimizer->name}}" disabled class = 'lock'>{{$optimizer->name}}</option>
                                    @else
                                    <option value="{{$optimizer->name}}">{{$optimizer->name}}</option>
                                    @endif
                                    @endforeach
                                    <!--
                                    <option value="SGD">SGD</option>
                                    <option value="Adadelta">Adadelta</option>
                                    <option value="Adam">Adam</option>
                                    -->
                                </select>
                            </div>
                            
                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Learning Rate</span>
                                <input type="number" step = '1' pattern="^/d+*$" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name = 'learningRate'>
                              
                            </div>

                            <div class = 'select-colormode-container' id = 'lossFunctionContainer'>
                                <select class="form-select mb-1" aria-label="Default select example" name = 'loss'>
                                    <option selected>Select loss function</option>
                                    @foreach($losses as $loss)
                                    @if(!in_array($userRole, explode(',',$loss->permissions)))
                                    <option value="{{$loss->name}}" disabled class = 'lock'>{{$loss->name}}</option>
                                    @else
                                    <option value="{{$loss->name}}">{{$loss->name}}</option>
                                    @endif
                                    @endforeach
                                    <!--
                                    <option value="BinaryCrossentropy">BinaryCrossentropy</option>
                                    <option value="CategoricalCrossentropy">CategoricalCrossentropy</option>
                                    <option value="CategoricalHinge">CategoricalHinge</option>
                                    -->
                                </select>
                            </div>

                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Save name</span>
                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name = 'saveName'>
                            </div>
                            
                            <button type="button" class="btn btn-success float-end" onclick="run()">Run</button>
                        </form>
                        </div>
                    </div>
                </div>          
            </div>
            <!--Train End-->
            
        </div>
        <div class = 'wizard-buttons row justify-content-center mt-5'>
            <div class = 'col-4 align-self-center'>
            <div class = 'prevNextBtnContainer '>
                <div class = 'nextBtnContainer float-start'>
                    <button type = 'button' class="btn btn-primary float-start" id = 'prevBtn' onclick = 'nextPrev(-1)'>Prev</button>
                </div>    
            

                <div class = 'prevBtnContainer float-end'>
                    <button type = 'button' class="btn btn-primary" id = 'nextBtn' onclick = 'nextPrev(1)'>Next</button>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.footer')
    <section>
       
        
</body>

<style>
    .lock{
       
        color:red;
        
    }
   
</style>
<script src = '{{ asset("/js/classificationTrain.js") }}'>
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>