/**
 * Обновление данных преподавателя
 * 
 */
function updateTeacherData() {
    var postData = getData('#teacherDataForm');
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "/teacher/update/",
        data: postData,
        dataType: 'text',
        success: function(data){
            var jsonData = JSON.parse(data);
            $('#teacherLink').html(jsonData['teacherName']);
            console.log(jsonData);
            alert(jsonData['message']);
        }
    });
}

/**
 * Добавление лабораторной
 * 
 */
function addlab() {
    var postData = getData('#add-lab-form');
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "/lab/addlab/",
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
 * Изменение данных лабораторной
 * 
 * @param {integer} id
 */
function updateLab(id) {
    var newNumber = $('#labNumber_' + id).val();
    var newTitle = $('#labTitle_' + id).val();
    var newTask = $('#labTask_' + id).val();
    var newAccess = $('#labAccess_' + id).val();
    var newCourse_id = $('#labCourseId_' + id).val(); 
    /* Альтернативный вариант:
    var e = document.getElementById('labCourseId_' + labId);
    var newCourse_id = e.value;*/
    
    var postData = {labId: id, newNumber: newNumber, 
                    newTitle: newTitle, newTask: newTask, newAccess: newAccess,
                    newCourse_id: newCourse_id};
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "/lab/updatelab/",
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
 * Удаление лабораторной
 * 
 * @param {integer} id
 */
function deleteLab(id) {
    var postData = {id: id};
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "/lab/deletelab/",
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
 * Открыти
 * 
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
