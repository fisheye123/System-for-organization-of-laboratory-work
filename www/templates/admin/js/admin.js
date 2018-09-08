/**
 * Добавление преподавателя
 * 
 */
function registerTeacher() {
    var postData = getData('#registerBox');
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "/teacher/register/",
        data: postData,
        dataType: 'text',
        success: function(data){
            var jsonData = JSON.parse(data);
            alert(jsonData['message']);
            console.log(jsonData['message']);
            if (jsonData['success']) {
                window.location.reload();
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
 * Изменение данных преподавателя
 * 
 * @param {integer} id
 */
function updateTeacher(id) {    
    var newName = $('#teacherName_' + id).val();
    var newEmail = $('#teacherEmail_' + id).val();
    var newLogin = $('#teacherLogin_' + id).val();
    var newPassword = $('#teacherPassword_' + id).val();
    
    var postData = {teacherId: id, newName: newName, newEmail: newEmail, 
                    newLogin: newLogin, newPassword: newPassword};
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "/teacher/updateteacher/",
        data: postData,
        dataType: 'text',
        success: function(data){
            var jsonData = JSON.parse(data);
            alert(jsonData['message']);
            console.log(jsonData['message']);
        },
        error: function (xhr, ajaxOptions, thrownError, data) {
            console.log(data);
            alert(xhr.status);
            alert(thrownError);
        }
    });
};

/**
 * Удаление преподавателя
 * 
 * @param {integer} id
 */
function deleteTeacher(id) {
    var postData = {id: id};
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "/teacher/deleteteacher/",
        data: postData,
        dataType: 'text',
        success: function(data){
            var jsonData = JSON.parse(data);
            alert(jsonData['message']);
            console.log(jsonData['message']);
            window.location.reload();
        },
        error: function (xhr, ajaxOptions, thrownError, data) {
            console.log(data);
            alert(xhr.status);
            alert(thrownError);
        }
    });
};

/**
 * Добавление курса
 * 
 */
function addcourse() {
    var postData = getData('#add-course-form');
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "/course/addcourse/",
        data: postData,
        dataType: 'text',
        success: function(data){
            var jsonData = JSON.parse(data);
            alert(jsonData['message']);
            console.log(jsonData['message']);
            if (jsonData['success']) {
                window.location.reload();
            }
        },
        error: function (xhr, ajaxOptions, thrownError, data) {
            console.log(data);
            alert(xhr.status);
            alert(thrownError);
        }
    });
}

/**
 * Изменение данных курса
 * 
 * @param {integer} id
 */
function updateCourse(id) {
    var newTitle = $('#courseTitle_' + id).val();
    var newDescription = $('#courseDescription_' + id).val();
    var newLogin = $('#courseLogin_' + id).val();
    var newPassword = $('#coursePassword_' + id).val();
    
    var postData = {id: id, newTitle: newTitle, 
                    newDescription: newDescription,
                    newLogin: newLogin, newPassword: newPassword};
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "/course/updatecourse/",
        data: postData,
        dataType: 'text',
        success: function(data){
            var jsonData = JSON.parse(data);
            alert(jsonData['message']);
            console.log(jsonData['message']);
        },
        error: function (xhr, ajaxOptions, thrownError, data) {
            console.log(data);
            alert(xhr.status);
            alert(thrownError);
        }
    });
};

/**
 * Удаление курса
 * 
 * @param {integer} id
 */
function deleteCourse(id) {
    var postData = {id: id};
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "/course/deletecourse/",
        data: postData,
        dataType: 'text',
        success: function(data){
            var jsonData = JSON.parse(data);
            alert(jsonData['message']);
            console.log(jsonData['message']);
            window.location.reload();
        },
        error: function (xhr, ajaxOptions, thrownError, data) {
            console.log(data);
            alert(xhr.status);
            alert(thrownError);
        }
    });
};

/**
 * Добавление студента
 * 
 */
function addstudent() {
    var postData = getData('#add-student-form');
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "/student/addstudent/",
        data: postData,
        dataType: 'text',
        success: function(data){
            console.log(data);
            var jsonData = JSON.parse(data);
            alert(jsonData['message']);
            console.log(jsonData['message']);
            if (jsonData['success']) {
                window.location.reload();
            }
        },
        error: function (xhr, ajaxOptions, thrownError, data) {
            console.log(data);
            alert(xhr.status);
            alert(thrownError);
        }
    });
}

/**
 * Изменение данных студента
 * 
 * @param {integer} id
 */
function updateStudent(id) {
    var newName = $('#studentName_' + id).val();
    var newGroup = $('#studentGroup_' + id).val();
    
    var postData = {id: id, newName: newName, newGroup: newGroup};
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "/student/updatestudent/",
        data: postData,
        dataType: 'text',
        success: function(data){
            console.log(data);
            var jsonData = JSON.parse(data);
            alert(jsonData['message']);
            console.log(jsonData['message']);
        },
        error: function (xhr, ajaxOptions, thrownError, data) {
            console.log(data);
            alert(xhr.status);
            alert(thrownError);
        }
    });
};

/**
 * Удаление студента
 * 
 * @param {integer} id
 */
function deleteStudent(id) {
    var postData = {id: id};
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "/student/deletestudent/",
        data: postData,
        dataType: 'text',
        success: function(data){
            var jsonData = JSON.parse(data);
            alert(jsonData['message']);
            console.log(jsonData['message']);
            window.location.reload();
        },
        error: function (xhr, ajaxOptions, thrownError, data) {
            console.log(data);
            alert(xhr.status);
            alert(thrownError);
        }
    });
};

/**
 * Загрузка страницы изменения курсов преподавателя
 * 
 * @param {integer} id
 *//*
function teachersCourses(id) {
    var postData = {id: id};
    
    $.ajax({
        type: 'POST',
        async: true,
        url: "/admin/courses/",
        data: postData,
        dataType: 'text',
        success: function(data){
            console.log(data);
        }
    });
};*/

/**
 * Изменение таблицы `teacher_course` (many-to-many)
 * 
 * @param {integer} id
 */
function teacherseeeeeeeCourses(id) {
    var newName = $('#studentName_' + id).val();
    var newGroup = $('#studentGroup_' + id).val();
    
    var postData = {id: id, newName: newName, newGroup: newGroup};
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "/teacher/courses/",
        data: postData,
        dataType: 'text',
        success: function(data){
            console.log(data);
            var jsonData = JSON.parse(data);
            alert(jsonData['message']);
            console.log(jsonData['message']);
        },
        error: function (xhr, ajaxOptions, thrownError, data) {
            console.log(data);
            alert(xhr.status);
            alert(thrownError);
        }
    });
};


$(document).ready(function(){
    $('#mySelect').on('change click',function(e){
        var sel=$(this);
        var len=sel.find('option').length;
        if(e.type=='click'){
            if(len>1) return false;
            if(!sel.hasClass('clickd')){
                sel.addClass('clickd');
                return false;
            }else sel.removeClass('clickd');
        }
        var opt=sel.find(':selected');
        if(!opt.length){
            alert('Выберите элемент!');
            return false;
        }else opt=opt.eq(0);
        var txt=opt.text();
        var val=opt.val();
        $('#myForm').prepend('<div><input name="'+val+'" type="text" value="'+txt+'" readonly> <input type="button" class="XX" value="X"></div>');
        opt.remove();
    });
    $('#myForm').on('click','input.XX',function(){
        var btn=$(this);
        var div=btn.parent();
        var inp=div.find('input:first');
        var val=inp.attr('name');
        var txt=inp.val();
        $('#mySelect').append('<option value="'+val+'">'+txt+'</option>');
        btn.remove();
        inp.remove();
        div.remove();
    });
    $('#myForm').submit(function(e){
        e.preventDefault();
        var frm=$(this);
        var lst=frm.find('input[type="text"]');
        var len=lst.length;
        if(!len){
            alert('Нет выбранных элементов!');
            return false;
        }
        var s='';
        for(var j=0; j<len; j++){
            var el=lst.eq(j);
            s+='<p>[id= <b>'+el.attr('name')+'</b>] [text= <b>'+el.val()+'</b>]</p>';
            el.parent().find('.XX').click();
        }
        $('#results').html(s);
        return false;
    });
});
