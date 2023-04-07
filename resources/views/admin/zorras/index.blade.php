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
                  @foreach($zorras as $zorra)
                  @if($camara->id === $zorra->idcamara)
                        @if($zorra->id === 1 ||$zorra->id === 5 || $zorra->id ===  9 || $zorra->id === 13 || $zorra->id === 17)
                          <div class="tab-pane fade show active" id="custom-tabs-four-zorra{{$zorra->id}}" role="tabpanel" aria-labelledby="custom-tabs-four-zorra{{$zorra->id}}-tab">
                            <div class="camaras">
                            
                                  <div >17
                                          <div class="form-group">
                                                <select name="camara{{$camara->id}}zorra{{$zorra->id}}17" id="camara{{$camara->id}}zorra{{$zorra->id}}17" class="select2 selectrefresh"  style="width: 100%;" class="form-control"
                                                onchange="guardarTacho(this.value,'17',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                                @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='17')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} - {{ $t->idtacho }}</option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >16
                                            <div class="form-group">
                                            <select name="camara{{$camara->id}}zorra{{$zorra->id}}16" id="camara{{$camara->id}}zorra{{$zorra->id}}16" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                            onchange="guardarTacho(this.value,'16',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                                  @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='16')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >1
                                            <div class="form-group">
                                            <select name="camara{{$camara->id}}zorra{{$zorra->id}}1" id="camara{{$camara->id}}zorra{{$zorra->id}}1" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                            onchange="guardarTacho(this.value,'1',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                                  @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='1')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                            </select>
                                            </div>
                                  </div>
                                  <div >18
                                              <div class="form-group">
                                              <select name="camara{{$camara->id}}zorra{{$zorra->id}}18" id="camara{{$camara->id}}zorra{{$zorra->id}}18" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                              onchange="guardarTacho(this.value,'18',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                              @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='18')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >15
                                            <div class="form-group">
                                            <select name="camara{{$camara->id}}zorra{{$zorra->id}}15" id="camara{{$camara->id}}zorra{{$zorra->id}}15" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                            onchange="guardarTacho(this.value,'15',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                                @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='15')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >2
                                              <div class="form-group">
                                              <select name="camara{{$camara->id}}zorra{{$zorra->id}}2" id="camara{{$camara->id}}zorra{{$zorra->id}}2" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                              onchange="guardarTacho(this.value,'2',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                              @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='2')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >19
                                            <div class="form-group">
                                            <select name="camara{{$camara->id}}zorra{{$zorra->id}}19" id="camara{{$camara->id}}zorra{{$zorra->id}}19" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                            onchange="guardarTacho(this.value,'19',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                            @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='19')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >14
                                            <div class="form-group">
                                            <select name="camara{{$camara->id}}zorra{{$zorra->id}}14" id="camara{{$camara->id}}zorra{{$zorra->id}}14" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                            onchange="guardarTacho(this.value,'14',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                            @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='14')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >3
                                            <div class="form-group">
                                            <select name="camara{{$camara->id}}zorra{{$zorra->id}}3" id="camara{{$camara->id}}zorra{{$zorra->id}}3" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                            onchange="guardarTacho(this.value,'3',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                            @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='3')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >20
                                            <div class="form-group">
                                            <select name="camara{{$camara->id}}zorra{{$zorra->id}}20" id="camara{{$camara->id}}zorra{{$zorra->id}}20" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                            onchange="guardarTacho(this.value,'20',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                            @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='20')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >13
                                            <div class="form-group">
                                            <select name="camara{{$camara->id}}zorra{{$zorra->id}}13" id="camara{{$camara->id}}zorra{{$zorra->id}}13" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                            onchange="guardarTacho(this.value,'13',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                            @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='13')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >4
                                              <div class="form-group">
                                              <select name="camara{{$camara->id}}zorra{{$zorra->id}}4" id="camara{{$camara->id}}zorra{{$zorra->id}}4" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                              onchange="guardarTacho(this.value,'4',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                              @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='4')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >21
                                              <div class="form-group">
                                              <select name="camara{{$camara->id}}zorra{{$zorra->id}}21" id="camara{{$camara->id}}zorra{{$zorra->id}}21" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                              onchange="guardarTacho(this.value,'21',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                              @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='21')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >12
                                            <div class="form-group">
                                            <select name="camara{{$camara->id}}zorra{{$zorra->id}}12" id="camara{{$camara->id}}zorra{{$zorra->id}}12" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                            onchange="guardarTacho(this.value,'12',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                            @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='12')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >5
                                            <div class="form-group">
                                            <select name="camara{{$camara->id}}zorra{{$zorra->id}}5" id="camara{{$camara->id}}zorra{{$zorra->id}}5" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                            onchange="guardarTacho(this.value,'5',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                            @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='5')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >22
                                            <div class="form-group">
                                            <select name="camara{{$camara->id}}zorra{{$zorra->id}}22" id="camara{{$camara->id}}zorra{{$zorra->id}}22" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                            onchange="guardarTacho(this.value,'22',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                            @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='22')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >11
                                              <div class="form-group">
                                              <select name="camara{{$camara->id}}zorra{{$zorra->id}}11" id="camara{{$camara->id}}zorra{{$zorra->id}}11" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                              onchange="guardarTacho(this.value,'11',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                              @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='11')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >6
                                            <div class="form-group">
                                            <select name="camara{{$camara->id}}zorra{{$zorra->id}}6" id="camara{{$camara->id}}zorra{{$zorra->id}}6" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                            onchange="guardarTacho(this.value,'6',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                            @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='6')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >23
                                              <div class="form-group">
                                              <select name="camara{{$camara->id}}zorra{{$zorra->id}}23" id="camara{{$camara->id}}zorra{{$zorra->id}}23" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                              onchange="guardarTacho(this.value,'23',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                              @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='23')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >10
                                              <div class="form-group">
                                              <select name="camara{{$camara->id}}zorra{{$zorra->id}}10" id="camara{{$camara->id}}zorra{{$zorra->id}}10" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                              onchange="guardarTacho(this.value,'10',{{$zorra->id}},{{$camara->id}});">
                                              @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='10')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >7
                                              <div class="form-group">
                                              <select name="camara{{$camara->id}}zorra{{$zorra->id}}7" id="camara{{$camara->id}}zorra{{$zorra->id}}7" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                              onchange="guardarTacho(this.value,'7',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                              @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='7')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >24
                                              <div class="form-group">
                                              <select name="camara{{$camara->id}}zorra{{$zorra->id}}24" id="camara{{$camara->id}}zorra{{$zorra->id}}24" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                              onchange="guardarTacho(this.value,'24',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                              @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='24')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >9
                                            <div class="form-group">
                                            <select name="camara{{$camara->id}}zorra{{$zorra->id}}9" id="camara{{$camara->id}}zorra{{$zorra->id}}9" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                            onchange="guardarTacho(this.value,'9',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                            @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='9')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >8
                                              <div class="form-group">
                                              <select name="camara{{$camara->id}}zorra{{$zorra->id}}8" id="camara{{$camara->id}}zorra{{$zorra->id}}8" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                              onchange="guardarTacho(this.value,'8',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                              @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='8')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                </div>
                            </div>
                          @else
                          <div class="tab-pane fade " id="custom-tabs-four-zorra{{$zorra->id}}" role="tabpanel" aria-labelledby="custom-tabs-four-zorra{{$zorra->id}}-tab">
                            <div class="camaras">
                            
                            <div >17
                                          <div class="form-group">
                                                <select name="camara{{$camara->id}}zorra{{$zorra->id}}17" id="camara{{$camara->id}}zorra{{$zorra->id}}17" class="select2 selectrefresh"  style="width: 100%;" class="form-control"
                                                onchange="guardarTacho(this.value,'17',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                                @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='17')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >16
                                            <div class="form-group">
                                            <select name="camara{{$camara->id}}zorra{{$zorra->id}}16" id="camara{{$camara->id}}zorra{{$zorra->id}}16" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                            onchange="guardarTacho(this.value,'16',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                            @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='16')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >1-zorra:{{ $zorra->id}}-camara:{{$camara->id}}
                                            <div class="form-group">
                                            <select name="camara{{$camara->id}}zorra{{$zorra->id}}1" id="camara{{$camara->id}}zorra{{$zorra->id}}1" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                            onchange="guardarTacho(this.value,'1',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                            @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='1')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >18
                                              <div class="form-group">
                                              <select name="camara{{$camara->id}}zorra{{$zorra->id}}18" id="camara{{$camara->id}}zorra{{$zorra->id}}18" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                              onchange="guardarTacho(this.value,'18',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                              @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='18')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >15
                                            <div class="form-group">
                                            <select name="camara{{$camara->id}}zorra{{$zorra->id}}15" id="camara{{$camara->id}}zorra{{$zorra->id}}15" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                            onchange="guardarTacho(this.value,'15',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                            @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='15')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >2
                                              <div class="form-group">
                                              <select name="camara{{$camara->id}}zorra{{$zorra->id}}2" id="camara{{$camara->id}}zorra{{$zorra->id}}2" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                              onchange="guardarTacho(this.value,'2',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                              @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='2')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >19
                                            <div class="form-group">
                                            <select name="camara{{$camara->id}}zorra{{$zorra->id}}19" id="camara{{$camara->id}}zorra{{$zorra->id}}19" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                            onchange="guardarTacho(this.value,'19',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                            @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='19')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >14
                                            <div class="form-group">
                                            <select name="camara{{$camara->id}}zorra{{$zorra->id}}14" id="camara{{$camara->id}}zorra{{$zorra->id}}14" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                            onchange="guardarTacho(this.value,'14',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                            @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='14')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >3
                                            <div class="form-group">
                                            <select name="camara{{$camara->id}}zorra{{$zorra->id}}3" id="camara{{$camara->id}}zorra{{$zorra->id}}3" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                            onchange="guardarTacho(this.value,'3',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                            @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='3')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >20
                                            <div class="form-group">
                                            <select name="camara{{$camara->id}}zorra{{$zorra->id}}20" id="camara{{$camara->id}}zorra{{$zorra->id}}20" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                            onchange="guardarTacho(this.value,'20',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                            @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='20')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >13
                                            <div class="form-group">
                                            <select name="camara{{$camara->id}}zorra{{$zorra->id}}13" id="camara{{$camara->id}}zorra{{$zorra->id}}13" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                            onchange="guardarTacho(this.value,'13',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                            @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='13')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >4
                                              <div class="form-group">
                                              <select name="camara{{$camara->id}}zorra{{$zorra->id}}4" id="camara{{$camara->id}}zorra{{$zorra->id}}4" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                              onchange="guardarTacho(this.value,'4',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                              @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='4')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >21
                                              <div class="form-group">
                                              <select name="camara{{$camara->id}}zorra{{$zorra->id}}21" id="camara{{$camara->id}}zorra{{$zorra->id}}21" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                              onchange="guardarTacho(this.value,'21',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                              @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='21')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >12
                                            <div class="form-group">
                                            <select name="camara{{$camara->id}}zorra{{$zorra->id}}12" id="camara{{$camara->id}}zorra{{$zorra->id}}12" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                            onchange="guardarTacho(this.value,'12',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                            @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='12')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >5
                                            <div class="form-group">
                                            <select name="camara{{$camara->id}}zorra{{$zorra->id}}5" id="camara{{$camara->id}}zorra{{$zorra->id}}5" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                            onchange="guardarTacho(this.value,'5',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                            @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='5')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >22
                                            <div class="form-group">
                                            <select name="camara{{$camara->id}}zorra{{$zorra->id}}22" id="camara{{$camara->id}}zorra{{$zorra->id}}22" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                            onchange="guardarTacho(this.value,'22',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                            @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='22')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >11
                                              <div class="form-group">
                                              <select name="camara{{$camara->id}}zorra{{$zorra->id}}11" id="camara{{$camara->id}}zorra{{$zorra->id}}11" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                              onchange="guardarTacho(this.value,'11',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                              @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='11')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >6
                                            <div class="form-group">
                                            <select name="camara{{$camara->id}}zorra{{$zorra->id}}6" id="camara{{$camara->id}}zorra{{$zorra->id}}6" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                            onchange="guardarTacho(this.value,'6',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                            @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='6')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >23
                                              <div class="form-group">
                                              <select name="camara{{$camara->id}}zorra{{$zorra->id}}23" id="camara{{$camara->id}}zorra{{$zorra->id}}23" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                              onchange="guardarTacho(this.value,'23',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                              @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='23')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >10
                                              <div class="form-group">
                                              <select name="camara{{$camara->id}}zorra{{$zorra->id}}10" id="camara{{$camara->id}}zorra{{$zorra->id}}10" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                              onchange="guardarTacho(this.value,'10',{{$zorra->id}},{{$camara->id}});">
                                              @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='10')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >7
                                              <div class="form-group">
                                              <select name="camara{{$camara->id}}zorra{{$zorra->id}}7" id="camara{{$camara->id}}zorra{{$zorra->id}}7" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                              onchange="guardarTacho(this.value,'7',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                              @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='7')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >24
                                              <div class="form-group">
                                              <select name="camara{{$camara->id}}zorra{{$zorra->id}}24" id="camara{{$camara->id}}zorra{{$zorra->id}}24" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                              onchange="guardarTacho(this.value,'24',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                              @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='24')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >9
                                            <div class="form-group">
                                            <select name="camara{{$camara->id}}zorra{{$zorra->id}}9" id="camara{{$camara->id}}zorra{{$zorra->id}}9" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                            onchange="guardarTacho(this.value,'9',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                            @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='9')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                  <div >8
                                              <div class="form-group">
                                              <select name="camara{{$camara->id}}zorra{{$zorra->id}}8" id="camara{{$camara->id}}zorra{{$zorra->id}}8" class="select2 selectrefresh"  style="width: 100%;" class="form-control" 
                                              onchange="guardarTacho(this.value,'8',{{$zorra->id}},{{$camara->id}},{{$idcampania}});">
                                              @foreach ($tachos as $t)
                                                    @if(($t->idcampania==$idcampania)&&($t->idcamara===$camara->id)&&($t->idzorra==$zorra->id)&&($t->nombre=='8')&& ($t->idtacho !== null))
                                                        <option value="{{ $t->idtacho }}" selected> {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}} </option>
                                                    @endif
                                                  @endforeach
                                                  <option value="0">Ninguna</option>
                                                  @foreach ($piletones as $t)
                                                        <option value="{{ $t->idtacho }}">
                                                        {{ $t->codigo}} - {{ $t->subcodigo}} - {{ $t->variedad}}
                                                        </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                  </div>
                                </div>
                            </div>
                          @endif
                  @endif
                  @endforeach
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
		
