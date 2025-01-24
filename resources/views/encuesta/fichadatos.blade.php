@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Ficha de datos') }}</div>
                        <div class="card-body">
                            <p class="justify-content">Las siguientes son algunas preguntas que se refieren a información general de usted o su
                                ocupación.<br>
                                <form action="submit.php" method="POST">
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="empresas">Empresa o entidad</label>
                                            <i class="fas fa-building"></i>
                                            <input id="empresas" name="empresas" type="text" placeholder="Nombre de la compañia" value="{{Auth::user()->lugartrabajo}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="sede">Sede/sucursal/sección</label>
                                            <i class="fas fa-city"></i>
                                            <input id="sede" name="sede" type="text" placeholder="Sede o sucursal" value="{{Auth::user()->sede}}">
                                        </div>
                                        <div class="form-group full-width">
                                            <label for="nombre">Nombre Completo</label>
                                            <i class="fas fa-user"></i>
                                            <input id="nombre" name="nombre" type="text" placeholder="Nombre completo" value="{{Auth::user()->nombre}}">
                                        </div>
                                        <div class="form-group ">
                                            <label for="cedula">Identificación</label>
                                            <i class="fas fa-id-card"></i>
                                            <input id="cedula" name="cedula" type="text" placeholder="Numero de identificación" value="{{Auth::user()->cedula}}">
                                        </div>
                                        <div class="form-group checkbox-group">
                                            <div class="row" col=12>
                                                <div class="row" col=12>
                                                    <label for="genero">Sexo</label>
                                                </div>
                                                <div class="row" col=6>
                                                    <label>
                                                        <input type="radio" id="genero" name="genero" value="Masculino">Masculino
                                                    </label>
                                                </div>
                                                <div class="row" col=6>
                                                    <label>
                                                        <input type="radio" id="genero" name="genero" value="Femenino"> Femenino
                                                    </label>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="anonaci">Año de nacimiento</label>
                                            <i class="fas fa-birthday-cake"></i>
                                            <select id="anonaci" name="anonaci">
                                                <option value="" disabled selected>Seleccione un año</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="estadociv">Estado Civil</label>
                                            <i class="fas fa-heart"></i>
                                            <select id="estadociv" name="estadociv">
                                                <option value="" disabled selected>Seleccione una opción</option>
                                                <option value="CASADO">Casado(a)</option>
                                                <option value="SOLTERO">Soltero(a)</option>
                                                <option value="UNION LIBRE">Union libre</option>
                                                <option value="SEPARADO">Separado(a)</option>
                                                <option value="DIVORCIADO">Divorciado(a)</option>
                                                <option value="VIUDO">Viudo(a)</option>
                                                <option value="RELIGIOSO">Religioso(a)</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="nivelEstudio">Nivel de estudios</label>
                                            <i class="fas fa-user-graduate"></i>
                                            <select id="nivelEstudio" name="nivelEstudio">
                                                <option value="" disabled selected>Seleccione una opción</option>
                                                <option value="NINGUNO">Ninguno</option>
                                                <option value="PRIMARIA INCOMPLETA">Primaria incompleta</option>
                                                <option value="PRIMARIA COMPLETA">Primaria completa</option>
                                                <option value="BACHILLERATO INCOMPLETO">Bachillerato in completo</option>
                                                <option value="Bachillerato completo">Bachillerato completo</option>
                                                <option value="TECNICO INCOMPLETO">Técnico / tecnológico incompleto</option>
                                                <option value="TECNICO OMPLETO">Técnico / tecnológico completo</option>
                                                <option value="PROFESIONAL INCOMPLETO">Profesional incompleto</option>
                                                <option value="PROFESIONAL COMPLETO">Profesional incompleto</option>
                                                <option value="CARRERA MILITAR">Carrera Militar / Policía</option>
                                                <option value="POST-GRADO INCOMPLETO">Post-grado incompleto</option>
                                                <option value="POST-GRADO COMPLETO">Post-grado completo</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="ocupacion">Ocupación</label>
                                            <i class="fas fa-hard-hat"></i>
                                            <input id="ocupacion" name="ocupacion" type="text" placeholder="Ocupación u oficio">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="residenciadepto">Departamento de residencia</label>
                                            <i class="fas fa-map-marker-alt"></i>
                                            <select id="residenciadepto" name="residenciadepto">
                                                <option value="" disabled selected>Selecccione una opción</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="residenciaciudad">Ciudad de residencia</label>
                                            <i class="fas fa-map-marker-alt"></i>
                                            <select id="residenciaciudad" name="residenciaciudad">
                                                 <option value="" disabled selected>Selecccione una opción</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="estrato">Estrato de servicios públicos</label>
                                            <i class="fas fa-poll"></i>
                                            <select id="estrato" name="estrato" required>
                                                <option value="" disabled selected>Seleccione una opción</option>
                                                <option value=1>1</option>
                                                <option value=2>2</option>
                                                <option value=3>3</option>
                                                <option value=4>4</option>
                                                <option value=5>5</option>
                                                <option value=6>6</option>
                                                <option value="FINCA">Finca</option>
                                                <option value="NO SE">No sé</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="tipoVivienda">Tipo de vivienda</label>
                                            <i class="fas fa-home"></i>
                                            <select id="tipoVivienda" name="tipoVivienda">
                                                <option value="" disabled selected>Seleccione una opción</option>
                                                <option value="PROPIA">Propia</option>
                                                <option value="EN ARRIENDO">En Arriendo</option>
                                                <option value="FAMILIAR">Familiar</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="personasdependientes">Número de personas que dependen economicamente</label>
                                            <i class="fas fa-users"></i>
                                            <input id="personasdependientes" name="personasdependientes" type="number" placeholder="Ingrese el numero de personas">
                                        </div>
                                        <div class="form-group">
                                            <label for="lugartrabajodpto">Departamento donde trabaja actualmente:</label>
                                            <i class="fas fa-map-marker-alt"></i>
                                            <input id="lugartrabajodpto" name="lugartrabajodpto" type="text" placeholder="Departamento donde trabaja" value="{{Auth::user()->delaciudad}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="lugartrabajocity">Ciudad donde trabaja actualmente:</label>
                                            <i class="fas fa-map-marker-alt"></i>
                                            <input id="lugartrabajocity" name="lugartrabajocity" type="text" placeholder="Ciudad donde trabaja" value="{{Auth::user()->deptociudad}}">
                                        </div>

                                        <div class="form-group">
                                            <label for="tiempotrabajo">Hace cuantos años trabaja en esta empresa</label>
                                            <i class="fas fa-calendar-check"></i>
                                            <select id="tiempotrabajo" name="tiempotrabajo" required>
                                                <option value="" disabled selected>Seleccione un opción</option>
                                                <option value="MENOS DE 1 AÑO">Menos de un año</option>
                                                <option value="MAS DE 1 AÑO">Mas de un año</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="cargoempresa">Cargo que ocupa en la empresa</label>
                                            <i class="fas fa-hard-hat"></i>
                                            <input id="cargoempresa" name="cargoempresa" type="text" placeholder="Nombre completo" value="{{Auth::user()->cargo}}">
                                        </div>         
                                        <div class="form-group">
                                            <label for="tipocargo">Tipo del cargo</label>
                                            <i class="fas fa-briefcase"></i>                                           
                                            <select id="tipocargo" name="tipocargo" required>
                                                <option value="" disabled selected>Seleccione una opción lo mas parecida</option>
                                                <option value="Jefatura">Jefatura: tiene personal a cargo</option>
                                                <option value="Profesional, Analista, Técnico, Tecnólogo">Profesional, Analista, Técnico, Tecnólogo</option>
                                                <option value="Auxiliar, Asistente Administrativo, Asistente técnico">Auxiliar, Asistente Administrativo, Asistente técnico</option>
                                                <option value="Operario, Operador, Ayudante, Servicios">Operario, Operador, Ayudante, Servicios</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="anoscargo">Hace cuantos años trabaja en el cargo</label>
                                            <i class="fas fa-calendar-check"></i>
                                            <select id="anoscargo" name="anoscargo" required>
                                                <option value="" disabled selected>Seleccione un opción</option>
                                                <option value="MENOS DE 1 AÑO">Menos de un año</option>
                                                <option value="MAS DE 1 AÑO">Mas de un año</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="nombredepto">Area de trabajo</label>
                                            <i class="fas fa-network-wired"></i>
                                            <input id="nombredepto" name="nombredepto" type="text" placeholder="Area de trabajo" value="{{Auth::user()->areatrabajo}}">
                                        </div>

                                        <div class="form-group">
                                            <label for="contratoactual">Tipo de contrato actual</label>
                                            <i class="fas fa-file-signature"></i>
                                            <select id="contratoactual" name="contratoactual" required>
                                                <option value="" disabled selected>Seleccione una opción</option>
                                                <option value="Temporal menos de un año">Temporal menos de un año</option>
                                                <option value="Temporal mas de un año">Temporal mas de un año</option>
                                                <option value="Termino indefinido">Termino indefinido</option>
                                                <option value="Cooperado (Cooperativa)">Cooperado (Cooperativa)</option>
                                                <option value="Prestación de servicios">Prestación de servicios</option>
                                                <option value="No se">No sé</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="horastrabajo">Número de horas que trabaja al día</label>
                                            <i class="fas fa-business-time"></i>
                                            <input id="horastrabajo" name="horastrabajo" type="number" placeholder="Numero de horas trabajadas">
                                        </div>
	           
                                        <div class="form-group">
                                            <label for="tiposalario">Tipo de salario</label>
                                            <i class="fas fa-money-check-alt"></i>
                                            <select id="tiposalario" name="tiposalario" required>
                                            <option selected="">Seleccione Opción...</option>
                                            <option value="fijo">Fijo(Diario, Semanal, Quincenal, Mensual)</option>
                                            <option value="fijo y variable">Una parte fija, Otra variable</option>
                                            <option value="Variable">Todo variable(A destajo, Por producción, Por comisión)</option>
                                            </select>
                                        </div>

                                        <!-- Submit Button -->
                                        <button type="submit" class="submit-btn">Continuar</button>
                                    </div>
                                </form>                     
                         </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection    