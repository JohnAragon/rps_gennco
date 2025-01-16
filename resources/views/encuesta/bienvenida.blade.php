@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Bienvenida') }}</div>

                <div class="card-body">
                  <form  method="GET" action="{{ route('survey.advise') }}" name="form-advise" id="login-advice" >
                  @csrf
                    <div align="justify" class="information-box round" style="font-size:14px;"> Este cuestionario de factores psicosociales busca conocer su opinión sobre algunos aspectos de su trabajo. <br>
                      Le agradecemos que usted se sirva  contestar a las preguntas de forma absolutamente sincera. Las respuestas que usted de al cuestionarío, no son ni buenas, ni malas, lo importante es que reflejen su manera de pensar sobre su trabajo. <br>
                      Al responder por favor lea cuidadosamente cada pregunta, luego piense como es su trabajo y responda a todas las preguntas, en cada una de ellas marque una sola respuesta. <br>
                      Tenga presente que el cuestionario <b>NO lo evalúa a usted como trabajador</b>, sino busca conocer cómo es el trabajo que le han asignado. <br>
                      Sus respuestas seran manejadas de forma <b>absolutamente confidencial</b>. </div>
                    
                    <div align="center" class="information-box round" style="font-size:14px;">
                      <strong>
                        Su registro será el número N° 4273404. 
                      </strong>
                      <br>
                      
                      <input title="Debe aceptar términos y condiciones" type="radio" name="terminos" id="terminos" onchange="activateButton(this)" required="">

                      <a href="{{route('survey.terms')}}">
                        <span style="font-size:12px;">
                        Acepto los Terminos y Condiciones
                      </span>
                      </a>
                      <br>
                      <input class="button round blue image-right ic-right-arrow" type="submit" name="submit" id="submit" value="INGRESAR" style="margin-left:20 px;">
                      <br>
                    (Consentimiento informado).
                    </div>
                    <div class="information-box round" align="justify" style="font-size:14px;">
                      Contacte con nosotros al correo
                      <span style="color:#33F">
                        webmaster@gennco.com.co
                      </span>
                      , si experimenta problemas o no tiene datos de acceso.
                    </div>
                  </form>
               
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection  