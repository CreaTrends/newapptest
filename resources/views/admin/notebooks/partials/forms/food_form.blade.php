<div class="card border-0">
    <div class="card-header is-darkgreen">
        <i class="icofont icofont-fast-food"></i> <strong>Comidas</strong>
    </div>
    <div class="card-body p-0 mt-3">
        <div class="food-container">
            <div class="food-item d-flex flex-row">
                <div class="mr-3">
                    <div class="form-group">
                        <select class="form-control input-sm" name="data[0][type]">
                        <option value="">Seleccionar Comida</option>
                        <option value="breakfast">Desayuno</option>
                        <option value="midmorning">colación AM</option>
                        <option value="lunch">almuerzo</option>
                        <option value="evening">colación PM</option>
                        <option value="dinner">cena</option>
                    </select>
                    </div>
                </div>
                <div class="mr-3">
                    <div class="form-group">
                        <select class="form-control input-sm" name="data[0][amount]">
                            <option value="">Cantidad</option>
                            <option value="none">Nada</option>
                            <option value="some">Algo</option>
                            <option value="half">La Mitad</option>
                            <option value="most">Casi Todo</option>
                            <option value="all">Todo</option>
                        </select>
                    </div>
                </div>
                <div class="p-2"></div>
            </div>
            
        </div>
        <a href="#" id="add_food" data-link="">Agregar Comida</a>
    </div>
</div>
<script>
$(document).ready(function()
{
    var max_fields = 10; //maximum input boxes allowed
    var wrapper = $(".food-container"); //Fields wrapper
    var add_button = $("#add_food"); //Add button ID
    var x = 1; //initlal text box count
    $(add_button).click(function(e)
    { //on add input button click
        e.preventDefault();
        var html = '';
        html += '<div class="food-item d-flex flex-row" id="row' + x + '">';
        html += '<div class="mr-3">';
        html += '<div class="form-group">';
        html += '<select class="form-control input-sm" name="data[' + x + '][type]">';
        html += '<option value="">Seleccionar Comida</option>';
        html += '<option value="breakfast">Desayuno</option>';
        html += '<option value="midmorning">colación AM</option>';
        html += '<option value="lunch">almuerzo</option>';
        html += '<option value="evening">colación PM</option>';
        html += '<option value="dinner">cena</option>';
        html += '</select>';
        html += '</div>';
        html += '</div>';
        html += '<div class="mr-3">';
        html += '<div class="form-group">';
        html += '<select class="form-control input-sm" name="data[' + x + '][amount]">';
        html += '<option value="">Cantidad</option>';
        html += '<option value="none">Nada</option>';
        html += '<option value="some">Algo</option>';
        html += '<option value="half">La Mitad</option>';
        html += '<option value="most">Casi Todo</option>';
        html += '<option value="all">Todo</option>';
        html += '</select>';
        html += '</div>';
        html += '</div>';
        html +=
            '<button type="button" class="close remove_field align-self-center" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        html += '</div>';
        if (x < max_fields)
        { //max input box allowed
            x++; //text box increment
            $(wrapper).append(html); //add input box
        }
    });
    $(document).on('click', '.remove_field', function(e)
    { //user click on remove text
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
    })
});

</script>