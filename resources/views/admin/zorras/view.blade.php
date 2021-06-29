<div class="col-12 col-sm-12">
            <div class="card card-primary card-outline card-outline-tabs">
              <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                  <!-- Creacioon de Zorras -->
                  @foreach($zorras as $zorra)
                  @if($camara->id === $zorra->idcamara)
                        @if($zorra->id === 1 ||$zorra->id === 5 || $zorra->id ===  9 || $zorra->id === 13 || $zorra->id === 17)
                        <li class="nav-item">
                          <a class="nav-link active" id="custom-tabs-four-zorra{{$zorra->id}}-tab" data-toggle="pill" href="#custom-tabs-four-zorra{{$zorra->id}}" role="tab" aria-controls="custom-tabs-four-zorra{{$zorra->id}}" aria-selected="true">{{ $zorra->nombre }}</a>
                        </li>
                        @else
                        <li class="nav-item">
                          <a class="nav-link" id="custom-tabs-four-zorra{{$zorra->id}}-tab" data-toggle="pill" href="#custom-tabs-four-zorra{{$zorra->id}}" role="tab" aria-controls="custom-tabs-four-zorra{{$zorra->id}}" aria-selected="true">{{ $zorra->nombre }}</a>
                        </li>
                        @endif
                  @endif
                  @endforeach
                  <!-- Fin de zorras-->
                </ul>
              </div>
              <div class="card-body">
              <!-- Creacion de Tachos -->
                <div class="tab-content" id="custom-tabs-four-tabContent">
                  
                  <div class="tab-pane fade show active" id="custom-tabs-four-zorra1" role="tabpanel" aria-labelledby="custom-tabs-four-zorra1-tab">
                  <div class="camaras">
                  
                  <div >17
                                <div class="form-group">
                                      <select name="camara1zorra117" id="camara1zorra117" class="select2 selectrefresh"  style="width: 100%;" class="form-control"
                                      onchange="guardarTacho(this.value,'17',1,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '17') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }}</option>
                                            @endif
                                        @endforeach 
                                        <option value="0">Ninguna</option>
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}                    
                                          </option>
                                        @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >16
                                  <div class="form-group">
                                  <select name="camara1zorra116" id="camara1zorra116" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'16',1,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '16') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >1
                                  <div class="form-group">
                                  <select name="camara1zorra11" id="camara1zorra11" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'1',1,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '1') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >18
                                    <div class="form-group">
                                    <select name="camara1zorra118" id="camara1zorra118" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'18',1,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '18') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >15
                                  <div class="form-group">
                                  <select name="camara1zorra115" id="camara1zorra115" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'15',1,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '15') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >2
                                    <div class="form-group">
                                    <select name="camara1zorra12" id="camara1zorra12" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'2',1,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '2') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >19
                                  <div class="form-group">
                                  <select name="camara1zorra119" id="camara1zorra119" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'19',1,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '19') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >14
                                  <div class="form-group">
                                  <select name="camara1zorra114" id="camara1zorra114" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'14',1,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '14') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >3
                                  <div class="form-group">
                                  <select name="camara1zorra13" id="camara1zorra13" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'3',1,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '3') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >20
                                  <div class="form-group">
                                  <select name="camara1zorra120" id="camara1zorra120" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'20',1,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '20') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >13
                                  <div class="form-group">
                                  <select name="camara1zorra113" id="camara1zorra113" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'13',1,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '13') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >4
                                    <div class="form-group">
                                    <select name="camara1zorra14" id="camara1zorra14" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'4',1,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '4') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >21
                                    <div class="form-group">
                                    <select name="camara1zorra121" id="camara1zorra121" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'21',1,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '21') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >12
                                  <div class="form-group">
                                  <select name="camara1zorra112" id="camara1zorra112" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'12',1,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '12') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >5
                                  <div class="form-group">
                                  <select name="camara1zorra15" id="camara1zorra15" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'5',1,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '5') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >22
                                  <div class="form-group">
                                  <select name="camara1zorra122" id="camara1zorra122" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'22',1,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '22') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >11
                                    <div class="form-group">
                                    <select name="camara1zorra111" id="camara1zorra111" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'11',1,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '11') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >6
                                  <div class="form-group">
                                  <select name="camara1zorra16" id="camara1zorra16" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'6',1,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '6') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >23
                                    <div class="form-group">
                                    <select name="camara1zorra123" id="camara1zorra123" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'23',1,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '23') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >10
                                    <div class="form-group">
                                    <select name="camara1zorra110" id="camara1zorra110" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'10',1,1);">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '10') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >7
                                    <div class="form-group">
                                    <select name="camara1zorra17" id="camara1zorra17" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'7',1,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '7') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >24
                                    <div class="form-group">
                                    <select name="camara1zorra124" id="camara1zorra124" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'24',1,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '24') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >9
                                  <div class="form-group">
                                  <select name="camara1zorra19" id="camara1zorra19" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'9',1,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '9') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >8
                                    <div class="form-group">
                                    <select name="camara1zorra18" id="camara1zorra18" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'8',1,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '8') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                      </div>
                  </div>

                  <div class="tab-pane fade show active" id="custom-tabs-four-zorra2" role="tabpanel" aria-labelledby="custom-tabs-four-zorra2-tab">
                  <div class="camaras">
                  
                  <div >17
                                <div class="form-group">
                                      <select name="camara1zorra217" id="camara1zorra217" class="select2 selectrefresh"  style="width: 100%;" class="form-control"
                                      onchange="guardarTacho(this.value,'17',2,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '17') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }}</option>
                                            @endif
                                        @endforeach 
                                        <option value="0">Ninguna</option>
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}                    
                                          </option>
                                        @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >16
                                  <div class="form-group">
                                  <select name="camara1zorra216" id="camara1zorra216" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'16',2,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '16') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >1
                                  <div class="form-group">
                                  <select name="camara1zorra21" id="camara1zorra21" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'1',2,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '1') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >18
                                    <div class="form-group">
                                    <select name="camara1zorra218" id="camara1zorra218" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'18',2,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '18') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >15
                                  <div class="form-group">
                                  <select name="camara1zorra215" id="camara1zorra215" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'15',2,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '15') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >2
                                    <div class="form-group">
                                    <select name="camara1zorra22" id="camara1zorra22" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'2',2,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '2') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >19
                                  <div class="form-group">
                                  <select name="camara1zorra219" id="camara1zorra219" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'19',2,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '19') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >14
                                  <div class="form-group">
                                  <select name="camara1zorra214" id="camara1zorra214" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'14',2,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '14') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >3
                                  <div class="form-group">
                                  <select name="camara1zorra23" id="camara1zorra23" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'3',2,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '3') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >20
                                  <div class="form-group">
                                  <select name="camara1zorra220" id="camara1zorra220" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'20',2,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '20') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >13
                                  <div class="form-group">
                                  <select name="camara1zorra213" id="camara1zorra213" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'13',2,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '13') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >4
                                    <div class="form-group">
                                    <select name="camara1zorra24" id="camara1zorra24" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'4',2,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '4') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >21
                                    <div class="form-group">
                                    <select name="camara1zorra221" id="camara1zorra221" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'21',2,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '21') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >12
                                  <div class="form-group">
                                  <select name="camara1zorra212" id="camara1zorra212" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'12',2,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '12') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >5
                                  <div class="form-group">
                                  <select name="camara1zorra25" id="camara1zorra25" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'5',2,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '5') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >22
                                  <div class="form-group">
                                  <select name="camara1zorra222" id="camara1zorra222" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'22',2,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '22') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >11
                                    <div class="form-group">
                                    <select name="camara1zorra211" id="camara1zorra211" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'11',2,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '11') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >6
                                  <div class="form-group">
                                  <select name="camara1zorra26" id="camara1zorra26" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'6',2,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '6') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >23
                                    <div class="form-group">
                                    <select name="camara1zorra223" id="camara1zorra223" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'23',2,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '23') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >10
                                    <div class="form-group">
                                    <select name="camara1zorra210" id="camara1zorra210" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'10',2,1);">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '10') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >7
                                    <div class="form-group">
                                    <select name="camara1zorra27" id="camara1zorra27" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'7',2,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '7') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >24
                                    <div class="form-group">
                                    <select name="camara1zorra224" id="camara1zorra224" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'24',2,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '24') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >9
                                  <div class="form-group">
                                  <select name="camara1zorra29" id="camara1zorra29" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'9',2,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '9') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >8
                                    <div class="form-group">
                                    <select name="camara1zorra28" id="camara1zorra28" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'8',2,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '8') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                      </div>
                  </div>


                  <div class="tab-pane fade show active" id="custom-tabs-four-zorra3" role="tabpanel" aria-labelledby="custom-tabs-four-zorra3-tab">
                  <div class="camaras">
                  
                  <div >17
                                <div class="form-group">
                                      <select name="camara1zorra317" id="camara1zorra317" class="select2 selectrefresh"  style="width: 100%;" class="form-control"
                                      onchange="guardarTacho(this.value,'17',3,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '17') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }}</option>
                                            @endif
                                        @endforeach 
                                        <option value="0">Ninguna</option>
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}                    
                                          </option>
                                        @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >16
                                  <div class="form-group">
                                  <select name="camara1zorra316" id="camara1zorra316" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'16',3,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '16') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >1
                                  <div class="form-group">
                                  <select name="camara1zorra31" id="camara1zorra31" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'1',3,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '1') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >18
                                    <div class="form-group">
                                    <select name="camara1zorra318" id="camara1zorra318" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'18',3,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '18') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >15
                                  <div class="form-group">
                                  <select name="camara1zorra315" id="camara1zorra315" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'15',3,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '15') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >2
                                    <div class="form-group">
                                    <select name="camara1zorra32" id="camara1zorra32" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'2',3,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '2') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >19
                                  <div class="form-group">
                                  <select name="camara1zorra319" id="camara1zorra319" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'19',3,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '19') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >14
                                  <div class="form-group">
                                  <select name="camara1zorra314" id="camara1zorra314" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'14',3,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '14') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >3
                                  <div class="form-group">
                                  <select name="camara1zorra33" id="camara1zorra33" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'3',3,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '3') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >20
                                  <div class="form-group">
                                  <select name="camara1zorra320" id="camara1zorra320" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'20',3,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '20') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >13
                                  <div class="form-group">
                                  <select name="camara1zorra313" id="camara1zorra313" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'13',3,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '13') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >4
                                    <div class="form-group">
                                    <select name="camara1zorra34" id="camara1zorra34" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'4',3,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '4') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >21
                                    <div class="form-group">
                                    <select name="camara1zorra321" id="camara1zorra321" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'21',3,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '21') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >12
                                  <div class="form-group">
                                  <select name="camara1zorra312" id="camara1zorra312" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'12',3,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '12') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >5
                                  <div class="form-group">
                                  <select name="camara1zorra35" id="camara1zorra35" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'5',3,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '5') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >22
                                  <div class="form-group">
                                  <select name="camara1zorra322" id="camara1zorra322" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'22',3,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '22') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >11
                                    <div class="form-group">
                                    <select name="camara1zorra311" id="camara1zorra311" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'11',3,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '11') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >6
                                  <div class="form-group">
                                  <select name="camara1zorra36" id="camara1zorra36" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'6',3,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '6') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >23
                                    <div class="form-group">
                                    <select name="camara1zorra323" id="camara1zorra323" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'23',3,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '23') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >10
                                    <div class="form-group">
                                    <select name="camara1zorra310" id="camara1zorra310" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'10',3,1);">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '10') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >7
                                    <div class="form-group">
                                    <select name="camara1zorra37" id="camara1zorra37" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'7',3,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '7') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >24
                                    <div class="form-group">
                                    <select name="camara1zorra324" id="camara1zorra324" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'24',3,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '24') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >9
                                  <div class="form-group">
                                  <select name="camara1zorra39" id="camara1zorra39" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'9',3,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '9') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >8
                                    <div class="form-group">
                                    <select name="camara1zorra38" id="camara1zorra38" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'8',3,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '8') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                      </div>
                  </div>


                  <div class="tab-pane fade show active" id="custom-tabs-four-zorra4" role="tabpanel" aria-labelledby="custom-tabs-four-zorra4-tab">
                  <div class="camaras">
                  
                  <div >17
                                <div class="form-group">
                                      <select name="camara1zorra417" id="camara1zorra417" class="select2 selectrefresh"  style="width: 100%;" class="form-control"
                                      onchange="guardarTacho(this.value,'17',4,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '17') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }}</option>
                                            @endif
                                        @endforeach 
                                        <option value="0">Ninguna</option>
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}                    
                                          </option>
                                        @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >16
                                  <div class="form-group">
                                  <select name="camara1zorra416" id="camara1zorra416" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'16',4,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '16') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >1
                                  <div class="form-group">
                                  <select name="camara1zorra41" id="camara1zorra41" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'1',4,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '1') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >18
                                    <div class="form-group">
                                    <select name="camara1zorra418" id="camara1zorra418" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'18',4,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '18') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >15
                                  <div class="form-group">
                                  <select name="camara1zorra415" id="camara1zorra415" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'15',4,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '15') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >2
                                    <div class="form-group">
                                    <select name="camara1zorra42" id="camara1zorra42" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'2',4,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '2') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >19
                                  <div class="form-group">
                                  <select name="camara1zorra419" id="camara1zorra419" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'19',4,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '19') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >14
                                  <div class="form-group">
                                  <select name="camara1zorra414" id="camara1zorra414" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'14',4,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '14') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >3
                                  <div class="form-group">
                                  <select name="camara1zorra43" id="camara1zorra43" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'3',4,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '3') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >20
                                  <div class="form-group">
                                  <select name="camara1zorra420" id="camara1zorra420" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'20',4,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '20') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >13
                                  <div class="form-group">
                                  <select name="camara1zorra413" id="camara1zorra413" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'13',4,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '13') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >4
                                    <div class="form-group">
                                    <select name="camara1zorra44" id="camara1zorra44" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'4',4,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '4') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >21
                                    <div class="form-group">
                                    <select name="camara1zorra421" id="camara1zorra421" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'21',4,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '21') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >12
                                  <div class="form-group">
                                  <select name="camara1zorra412" id="camara1zorra412" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'12',4,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '12') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >5
                                  <div class="form-group">
                                  <select name="camara1zorra45" id="camara1zorra45" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'5',4,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '5') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >22
                                  <div class="form-group">
                                  <select name="camara1zorra422" id="camara1zorra422" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'22',4,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '22') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >11
                                    <div class="form-group">
                                    <select name="camara1zorra411" id="camara1zorra411" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'11',4,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '11') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >6
                                  <div class="form-group">
                                  <select name="camara1zorra46" id="camara1zorra46" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'6',4,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '6') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >23
                                    <div class="form-group">
                                    <select name="camara1zorra423" id="camara1zorra423" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'23',4,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '23') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >10
                                    <div class="form-group">
                                    <select name="camara1zorra410" id="camara1zorra410" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'10',4,1);">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '10') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >7
                                    <div class="form-group">
                                    <select name="camara1zorra47" id="camara1zorra47" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'7',4,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '7') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >24
                                    <div class="form-group">
                                    <select name="camara1zorra424" id="camara1zorra424" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'24',4,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '24') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >9
                                  <div class="form-group">
                                  <select name="camara1zorra49" id="camara1zorra49" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                  onchange="guardarTacho(this.value,'9',4,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '9') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                        <div >8
                                    <div class="form-group">
                                    <select name="camara1zorra48" id="camara1zorra48" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                    onchange="guardarTacho(this.value,'8',4,1,{{$idcampania}});">
                                        @foreach($ubicaciontacho as $ubi)
                                            @if(($ubi->ubicacion === '8') && ($ubi->idzorra == $zorra->id) && ($ubi->idcamara === $camara->id) && ($ubi->idtacho !== null))
                                              <option value="{{ $ubi->idtacho }}"> {{ $ubi->codigo }} - {{ $ubi->subcodigo }} - {{ $ubi->variedad }} </option>
                                            @endif
                                        @endforeach 
                                        
                                        <option value="0">Ninguna</option>
                                        
                                        @foreach ($tachos as $t)
                                          <option value="{{ $t->idtacho }}">
                                              {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>
                        </div>
                      </div>
                  </div>


                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
		
