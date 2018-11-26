
<div class="card border-0">
    <div class="card-header is-orange">
        <i class="icofont icofont-baby-cloth"></i> <strong>Mudas </strong>
    </div>
    <div class="card-body p-0 mt-3">
        <div class="muda-container">
            <div class="muda-item d-flex flex-row">
                <div class="mr-3">
                    <div class="input-group mb-3">
                      <input type="text" class="form-control is-timepicker" id='timepicker' name="data[0][time]" placeholder="Hora Inicio" aria-label="Hora Inicio" aria-describedby="basic-addon2">
                      <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2"><i class="far fa-clock"></i></span>
                      </div>
                    </div>
                </div>
                <div class="mr-3">
                    <div class="form-group">
                        <select class="form-control input-sm" name="data[0][type]">
                            <option value="">Seleccionar</option>
                            <option value="normal">Normal</option>
                            <option value="hard">Duro</option>
                            <option value="soft">Blanda</option>
                            <option value="liquid">Liquido</option>
                        </select>
                    </div>
                </div>
                <div class="p-2"></div>
            </div>            
        </div>
        <a href="#" id="add_nap" data-link="">Agregar Muda</a>
        
    </div>
</div>

<script>
$(document).ready(function() {

    addTimepicker();

    //maximum input boxes allowed
    var max_fields = 10;
    //Fields wrapper
    var wrapper = $(".muda-container"); 
    //Add button ID
    var add_button = $("#add_nap"); 

    var x = 1; //initlal text box count 
    // on add button
    $(add_button).click(function(e) { //on add input button click
        e.preventDefault();
        var html = '';
        html += '<div class="muda-item d-flex flex-row" id="row' + x + '">';
            html += '<div class="mr-3">';
                html += '<div class="input-group mb-3">';
                    html += '<input type="text" class="form-control is-timepicker" placeholder="Hora Inicio" aria-label="Hora Inicio" aria-describedby="basic-addon2" id="timepicker" name="data[' + x + '][time]">';
                html += '<div class="input-group-append">';
                    html += '<span class="input-group-text" id="basic-addon2"><i class="far fa-clock"></i></span>';
                html += '</div>';
            html += '</div>';
        html += '</div>';
        html += '<div class="mr-3">';
            html += '<div class="form-group">';
                html += '<select class="form-control input-sm" name="data['+ x +'][type]">';
                    html +='<option value="">Seleccionar</option>'
                    html += '<option value="normal">Normal</option>';
                    html += '<option value="hard">Duro</option>';
                    html += '<option value="soft">Blanda</option>';
                    html += '<option value="liquid">Liquido</option>';
                html +="</select>";
            html += '</div>';
        html += '</div>';
        html += '<button type="button" class="close remove_field align-self-center" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        html += '</div>';

        //max input box allowed
        if (x < max_fields) { 
            x++; //text box increment
            $(wrapper).fadeIn(300,function(){
                $(this).append(html);
            }); //add input box
        }
        addTimepicker();
    });

    $(document).on('click', '.remove_field', function(e) { //user click on remove text

        e.preventDefault();
        $(this).parent('div').fadeOut(300,function(){
            $(this).remove();
        })
        x--;
    })

});

function addTimepicker(){
    $('.is-timepicker').timepicki({
        show_meridian:false,
        min_hour_value:0,
        max_hour_value:23,
        overflow_minutes:true,
        increase_direction:'up',
        disable_keyboard_mobile: true
    });
}

</script>