@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Consentimiento') }}</div>

                <div class="card-body">	  	
	                    <form method="GET" action="{{ route('survey.data') }}"  id="form-accept" name="formconfirma">
                        <p style="color:#000;">
                        </p><h2 align="center"> <strong><span style="font-size:18px">¡BIENVENIDO!</span></strong></h2>
                        <h2 align="center">Usted está ingresando a la encuesta: Factores de Riesgo Psicosocial, recuerde que su plazo para finalizar el proceso es hasta: <strong>2023-02-24</strong></h2>
                        <p></p>
                        <br>
                        
                        <input type="hidden" value="4273404" name="registro">
                        <input type="hidden" value="SI" name="acuerdo">
                        <input type="hidden" name="MM_update" value="formconfirma"><!--Inyecci�n sql actualiza datos a la tabla -->
                        <input style="float:left" type="submit" name="submit" class="button round blue ic-right-arrow image-right" id="button" value="DESEO REALIZAR LA ENCUESTA">
                        
                    </form>
                        <form action="{{ route('survey.data.not') }}" method="POST" id="form-decline" name="formnoconfirma">
                            <input type="hidden" value="4273404" name="registro">
                            <input type="hidden" value="NO" name="acuerdo">
                            <input type="hidden" value="noconsentimiento.php" name="pagina">
                            <input type="hidden" name="MM_update" value="formconfirma1"><!--Inyecci�n sql actualiza datos a la tabla -->
                            <input style="float:right" type="submit" name="submit" class="button round red ic-cancel image-right" id="button" value="NO DESEO REALIZAR LA ENCUESTA">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>            
@endsection    