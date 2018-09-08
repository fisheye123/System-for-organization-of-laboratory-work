/**
 * Получение данных с формы
 * 
 * @param {string} obj_form элемент html документа
 * @returns {array} массив полученных данных с элемента страницы
 */
function getData(obj_form){
    var hData = {};
    $('input, textarea, select', obj_form).each(function(){
        if( this.name && this.name != '' ){
            hData[this.name] = this.value;
            console.log('hData[' + this.name + '] = ' + hData[this.name]);
        }
    });
    return hData;
};

/**
 * Авторизация
 * 
 */
function login() {
    var postData = getData('#loginBox');
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "/auth/login/",
        data: postData,
        dataType: 'text',
        success: function(data){
            var jsonData = JSON.parse(data);
            console.log(jsonData);
            if (jsonData['success']){
                window.location.reload();
            } else {
                alert(jsonData['message']);
            }
        },
        error: function (xhr, ajaxOptions, thrownError, data) {
            console.log(data);
            alert(xhr.status);
            alert(thrownError);
        }
    });
}

//*************************************************Не используются
/**
 * Показывает или скрывает блок авторизации
 * 
 */
function showLoginBox() {
    $("#loginBoxHidden").toggle();﻿
}

/**
 * Показывает или скрывает лабораторные курса в левом меню
 * 
 */
function showLab() {
    if( $("#labHidden").css('display') != 'block' ) {
        $("#labHidden").show();
    } else {
        $("#labHidden").hide();
    }
}

