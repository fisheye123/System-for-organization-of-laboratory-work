/**
 * Загрузка файла на сервер
 * 
 */
function uploadFile() {
    $("form").on("submit", function(e){
        e.preventDefault();
        var form = $(this),
            labId = $('#labId').val(),
            answer = $('#lab_answer').val(),
            data = new FormData(this),
            url = "/file/upload/?labId=" + labId + "&answer=" + answer;
    
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            cache: false,
            async: true,
            contentType: false,
            processData: false,
            mimeType: "multipart/form-data",
            dataType : "text",
            success: function(data){
                console.log(data);
                
                setTimeout(function(){
                    form.trigger("reset");
                }, 3000);
            },
            error: function (xhr, thrownError, data) {
                console.log(data);
                alert(xhr.status);
                alert(thrownError);
                
                setTimeout(function(){
                    form.trigger("reset");
                }, 3000);
            }
        });
    });
};

