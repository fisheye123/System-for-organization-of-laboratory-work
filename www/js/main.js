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
 * Регистрация нового преподавателя
 * 
 */
function registerNewTeacher() {
    var postData = getData('#registerBox');
    //console.log(postData);
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "/teacher/register/",
        data: postData,
        dataType: 'text',
        success: function(data){
            var jsonData = JSON.parse(data);
            
            if(jsonData['success']){
                alert(jsonData['message']);
                console.log(jsonData['message']);  
                
                $('#registerBox').hide("fast");
                $('#loginBox').hide("fast");
                
                $('#teacherLink').attr('href', '/teacher/');
                $('#teacherLink').html(jsonData['teacherName']);
                $('#teacherBox').show();
            } else {
                console.log(jsonData['message']);          
                alert(jsonData['message']);
            }
        },
        error: function (xhr, ajaxOptions, thrownError, data) {
            console.log(data);
            alert(xhr.status);
            alert(thrownError);
        }
    });
};

/**
 * Авторизация пользователя
 * 
 * @type jQuery
 */
function login() {
    var login = $('#loginLogin').val();
    var password = $('#loginPassword').val();
    
    // Можно переделать под функцию getData
    // НУЖНО!
    var postData = "login="+ login +"&password=" + password;
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "/teacher/login/",
        data: postData,
        dataType: 'text',
        success: function(data){
            var jsonData = JSON.parse(data);
            
            if (jsonData['success']){
                $('#registerBox').hide("fast");
                $('#loginBox').hide("fast");
                
                $('#teacherLink').attr('href', '/teacher/');
                $('#teacherLink').html(jsonData['displayName']);
                $('#teacherBox').show();
                window.location.reload();
            } else {
                console.log(jsonData);
                alert(jsonData['message']);
            }
        }
    });
}

/**
 * Показывает или скрывает блок регистрации
 * 
 */
function showRegisterBox() {
    $("#registerBoxHidden").toggle();﻿
}

/**
 * Показывает или скрывает блок авторизации
 * 
 */
function showLoginBox() {
    $("#loginBoxHidden").toggle();﻿
}

/**
 * Показывает или скрывает лабораторные карса в левом меню
 * 
 */
function showLab() {
    if( $("#labHidden").css('display') != 'block' ) {
        $("#labHidden").show();
    } else {
        $("#labHidden").hide();
    }
}

/**
 * Обновление данных пользователя
 * 
 */
function updateTeacherData() {
    // Можно переделать под функцию getData(teacherDataForm)
    //НУЖНО!
    var name = $('#newName').val();
    var email = $('#newEmail').val();
    var password1 = $('#newPassword1').val();
    var password2 = $('#newPassword2').val();
    var curPassword = $('#curPassword').val();
    
    var postData = {name: name,
                    email: email,
                    password1: password1,
                    password2: password2,
                    curPassword: curPassword};
   
    $.ajax({
        type: 'POST',
        async: false,
        url: "/teacher/update/",
        data: postData,
        dataType: 'text',
        success: function(data){
            var jsonData = JSON.parse(data);
            
            if (jsonData['success']){
                $('#teacherLink').html(jsonData['teacherName']);
                
                console.log(jsonData);
                alert(jsonData['message']);
            } else {
                console.log(jsonData);
                alert(jsonData['message']);
            }
        }
    });
}

function addlab() {
    var postData = getData('#add-lab-form');
    //console.log(postData);
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "/lab/add/",
        data: postData,
        dataType: 'text',
        success: function(data){
            //console.log(data);
            var jsonData = JSON.parse(data);
            
            if(jsonData['success']){
                alert(jsonData['message']);
                console.log(jsonData['message']);
            } else {
                console.log(jsonData['message']);          
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

