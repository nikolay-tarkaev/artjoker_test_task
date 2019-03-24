var modalTerritorySelect = false;

function getDataAjaxModal(ter_id, callback){
    $.ajax({
        type: "POST",
        url: "/main/ajax",
        data: "getTerModal=true&ter_id=" + ter_id,
        async: false,
        success: callback
    });
}

function appendOptionModal(ter_level, ter_id, msg){
    msg = jQuery.parseJSON(msg);
    if(msg.length != 0){
        for(i=0; i<msg.length; i++){
            $("#selectTerLevel_" + ter_level).append($("<option></option>", {value: msg[i].ter_id, text: msg[i].ter_name}));
        }
        $(".selectTerLevel_" + ter_level).removeClass('modal-select-hidden');
        $("#selectTerLevel_" + ter_level).chosen({no_results_text: "Не найдено!", width: "100%"});
        window.modalTerritorySelect = false;
    } else{
        window.modalTerritorySelect = ter_id;
    }
}

function ifChangedSelectModal(ter_level){
    cleanSelect(ter_level);
    var select_ter_id = ($('#selectTerLevel_' + ter_level).find(':selected').attr('value'));
    var ter_level_next = ter_level + 1;
    $('#selectTerLevel_' + ter_level_next + ' option').remove();
    $('#selectTerLevel_' + ter_level_next).append("<option></option>");
    getDataAjaxModal(select_ter_id, function(msg){
        appendOptionModal(ter_level_next, select_ter_id, msg);
    });
    $('#selectTerLevel_' + ter_level_next).trigger("chosen:updated");
}

function cleanSelect(num_changed){
    if(num_changed == 1 || num_changed == 2){
        $('#selectTerLevel_3 option').remove();
        $('#selectTerLevel_4 option').remove();
        $('#selectTerLevel_3').append("<option></option>");
        $('#selectTerLevel_4').append("<option></option>");
        $('#selectTerLevel_3').trigger("chosen:updated");
        $('#selectTerLevel_4').trigger("chosen:updated");
        $('.selectTerLevel_3').addClass('modal-select-hidden');
        $('.selectTerLevel_4').addClass('modal-select-hidden');
    } else if(num_changed == 3){
        $('#selectTerLevel_4 option').remove();
        $('#selectTerLevel_4').append("<option></option>");
        $('#selectTerLevel_4').trigger("chosen:updated");
        $('.selectTerLevel_4').addClass('modal-select-hidden');
    }
}

$('#addUserModal').on('show.bs.modal', function (e) {
    getDataAjaxModal("", function(msg){
        appendOptionModal(1, false, msg);
        $('#selectTerLevel_1').trigger("chosen:updated");
    });
});

$('#selectTerLevel_1').change(function(){
    ifChangedSelectModal(1);
});

$('#selectTerLevel_2').change(function(){
    ifChangedSelectModal(2);
});

$('#selectTerLevel_3').change(function(){
    ifChangedSelectModal(3);
});

$('#selectTerLevel_4').change(function(){
    ifChangedSelectModal(4);
});

function isEmailExist(email, callback){
    $.ajax({
        type: "POST",
        url: "/main/ajax",
        data: "checkEmailModal=" + email,
        async: false,
        success: callback
    });
}

function saveUserModal(name, email, territory, callback){
    $.ajax({
        type: "POST",
        url: "/main/ajax",
        data: "saveUserModal=true&name=" + name + "&email=" + email + "&territory=" + territory,
        async: false,
        success: callback
    });
}

$('#addUserModal').on('hidden.bs.modal', function (e) {
    $('.addUserModalInfo').css('display', 'none');
    $('.email-exist').css('display', 'none');
    $('#inputNameModal').val('');
    $('#inputEmailModal').val('');
    for(i=1; i<=4; i++){
        $('#selectTerLevel_' + i +' option').remove();
        $('#selectTerLevel_' + i).append("<option></option>");
        $('#selectTerLevel_' + i).trigger("chosen:updated");
        $('.selectTerLevel_' + i).addClass('modal-select-hidden');
    }
    $(".error").remove();
    window.modalTerritorySelect = false;
});

$('#submitButtonModal').click(function(){
    $(".error").remove();
    $('.email-exist').css('display', 'none');
    var name = jQuery.trim($('#inputNameModal').val());
    var email = jQuery.trim($('#inputEmailModal').val());
    var territory = window.modalTerritorySelect;
    if(name.length<1){
        $('#inputNameModal').after('<div class="error alert alert-danger text-center">Введите ФИО</div>');
    } else if(email.length<1){
        $('#inputEmailModal').after('<div class="error alert alert-danger text-center">Введите email</div>');
    } else{
        var regEx = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var validEmail = regEx.test(email);
        if (!validEmail){
            $('#inputEmailModal').after('<div class="error alert alert-danger text-center">Некорректный email</div>');
        } else{
            isEmailExist(email, function(msg){
                is_email_exist = jQuery.parseJSON(msg);
                if(is_email_exist.info == "find"){
                    $('#emailExistName span').html(is_email_exist.name);
                    $('#emailExistEmail span').html(is_email_exist.email);
                    $('#emailExistTerritory span').html(is_email_exist.territory);
                    $('.email-exist').css('display', 'block');

                } else if(is_email_exist.info == "empty"){
                    if(window.modalTerritorySelect === false){
                        $('.selectTerLevel_4').after('<div class="error alert alert-danger text-center">Введите адрес</div>');
                    } else{
                        saveUserModal(name, email, territory, function(msg){
                            if(msg == 'true'){
                                $('#addUserModal').modal('hide');
                                setTimeout(function(){
                                    location.reload();
                                }, 500);
                            } else if(msg == 'false'){
                                $('.addUserModalInfo').html('Не удалось зарегистрировать нового пользователя');
                                $('.addUserModalInfo').addClass('alert alert-danger');
                                $('.addUserModalInfo').css('display', 'block');
                            }
                        });
                    }
                }
            });
        }
    }
});