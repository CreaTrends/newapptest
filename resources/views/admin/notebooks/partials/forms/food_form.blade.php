<div class="card border-0">
    <div class="card-header is-darkgreen">
        <i class="icofont icofont-fast-food"></i> <strong>Comidas</strong>
    </div>
    <div class="card-body p-0 mt-3">
        
        <div id="food-table-0">
            <div class="form-row" >
                <div class="form-group col-md-6">
                    <select class="form-control input-sm" name="data[0][type]">
                        <option value="">Seleccionar Alimentacion</option>
                        <option value="breakfast">Almuerzo</option>
                        <option value="midmorning">colación AM</option>
                        <option value="lunch">almuerzo</option>
                        <option value="evening">colación PM</option>
                        <option value="dinner">cena</option>
                        <option value="milk">Leche</option>
                        <option value="salad">Ensalada</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <select class="form-control input-sm" name="data[0][amount]">
                        <option value="">Seleccionar Alimentacion</option>
                        <option value="none">Nada</option>
                        <option value="some">Algo</option>
                        <option value="half">La Mitad</option>
                        <option value="most">Casi Todo</option>
                        <option value="all">Todo</option>
                    </select>
                </div>
                
            </div>
            
        </div>
        <a href="#" id="add_food" data-link="">Agregar Comida</a>
    </div>
</div>
<script>
$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".form-row"); //Fields wrapper
    var add_button      = $("#add_food"); //Add button ID

    var x = 1; //initlal text box count

   
    
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        var html = '';
    html += '<div class="form-row d-flex justify-content-start px-1" id="row'+x+'">';
        html += '<div class="form-group">';
            html += '<select name="data['+x+'][type]" class="form-control item_unit">';
            html +='<option value="">Seleccionar Alimentacion</option>';
            html +='<option value="breakfast">Almuerzo</option>';
            html +='<option value="midmorning">colación AM</option>';
            html +='<option value="lunch">almuerzo</option>';
            html +='<option value="evening">colación PM</option>';
            html +='<option value="dinner">cena</option>';
            html +='<option value="milk">Leche</option>';
            html +='<option value="salad">Ensalada</option>';
            html +="</select>";
        html +="</div>";
        html += '<div class="form-group ml-auto w-25 ">';
            html += '<select name="data['+x+'][amount]" class="form-control item_unit">';
            html += '<option value="">Cantidad</option>';
            html += '<option value="none">Nada</option>';
            html += '<option value="some">Algo</option>';
            html += '<option value="half">La Mitad</option>';
            html += '<option value="most">Casi Todo</option>';
            html += '<option value="all">Todo</option>';
            html +="</select>";
        html +="</div>";
        html +='<a href="#" class="ml-auto remove_field">Remove</a>';
    html +="</div>";
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).parent().append(html); //add input box
        }
    });
   
    $(document).on('click','.remove_field',function(e){//user click on remove text
        
         e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});

</script>