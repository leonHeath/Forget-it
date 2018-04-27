$(function(){

    var $notes = $('.note-space');
    var resetTasks;
    var clearTasks;
    var loadTasks;

    clearTasks = function(){
        //Delete all visible tasks
        $('#button-holder').siblings().remove();
    };

    loadTasks = function () {
        //Load tasks here
        $.get("homepage_func.php", { func: 'load_tasks' }, function (data) {
            console.log(data);
            var ret_tasks = JSON.parse(data);
            var x;
            for (x in ret_tasks) {
                var newTask = $('<div class="note">\n' +
                    '            <div class="note-header">\n' +
                    '                <input type="hidden" id="note_id" name="note_id" value=' + ret_tasks[x].task_id + '>\n' +
                    '                <div class="note-title"><h3>' + ret_tasks[x].task_name + '</h3></div>\n' +
                    '                <button id="edit-task" class="hide"></button>\n' +
                    '            </div>\n' +
                    '            <div class="note-content">\n' +
                    '               <p class="note-description">' + ret_tasks[x].task_desc + '</p>\n' +
                    '            </div>\n' +
                    '        </div>');
                $('#add-task').parent().before(newTask);
            }
        })
    };

    resetTasks = function () {
        //Clear initial tasks and then reload them
        clearTasks();
        loadTasks();
    };

    //Reset tasks on start up of web page
    resetTasks();

    $(document).on('click', 'li.selectable',function () {
        console.log('Clicked an item');
        $('li.selectable').removeClass('selected');
        $(this).addClass('selected');
    });

    $('#new-project').on('click', function(){
       console.log('Creating new project');
       //Create new li node inside here
        var $newProject = $('<li type="text" class="selectable editable" id="current_project" contenteditable="true">Untitled Project</li>');
        $('#new-project').before($newProject);
        var current = $('#current_project').focus();
    });

    $(document).on('keydown','.editable',function(e){
        if (e.keyCode === 13) {
            console.log('Enter was hit');
            $(this).blur();
        }
    });

    $(document).on('blur','li.editable',function(e){
        //remove contenteditable=true and editable class
        $(this).attr('contenteditable', 'false');
        $(this).removeClass('editable');
        $(this).removeAttr('id');
    });

    $('#add-task').click(function (e) {
        //Return with note id so we can add within html
        //<input type="hidden" id="note_id" name="note_id" value="NOTE_ID"> Store note id with this
        e.preventDefault();
        var $newTaskId = 0;

        $.post("homepage_func.php", {func: 'new_task' }, function(data) {
            $newTaskId = data;
            resetTasks();
        })
            .fail(function () {
                alert("Problem creating new task");
        });
    });


    $('#delete-task').click(function(){
        $.post("homepage_func.php", { func: 'delete_task', task_id: $('#current-task-id').val()})
            .done(function () {
                $('#edit-task-modal').modal('hide');
                //refresh tasks
                resetTasks();
            })
            .fail(function () {
                alert("Problem deleting task");
            });

    });

    $('#save-edit').click(function() {
        $.post("homepage_func.php", { func: 'edit_task', task_id: $('#current-task-id').val(), task_name: $('#task-title').val(), task_desc: $('#task-desc').val()})
            .done(function () {
                $('#edit-task-modal').modal('hide');
                //refresh tasks
                resetTasks();
            })
            .fail(function () {
                alert("Problem deleting task");
            });
    });

    $notes.on('mouseenter', '.note', function() {
            $(this).find('#edit-task').removeClass('hide');
    });

    $notes.on('mouseleave', '.note', function() {
            $(this).find('#edit-task').addClass('hide');
        }
    );

    $notes.on('click', '#edit-task', function (e) {
        e.preventDefault();
        console.log($(this).parent('.note-header').next('.note-content').children('.note-description').text());
        console.log($(this).siblings('#note_id').val());
        $('#current-task-id').val($(this).siblings('#note_id').val());
        //Load task values into modal here
        $('#task-title').val($(this).prev().text());
        $('#task-desc').val($(this).parent('.note-header').next('.note-content').children('.note-description').text());
        $('#edit-task-modal').modal('show');
    });

    $('#logout').click(function(){
        $.post("homepage_func.php", { func: 'logout_user' }, function (data) {
                console.log(data);
                var loc = data.split(" ");
                document.location.href = loc[1];
            });
    });

});