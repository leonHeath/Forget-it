$(function(){

    var $notes = $('.note-space');

    //Loads notes on startup of page
    $.get("Requests/load_user_tasks.php", function(data){
        //Load tasks here
        var ret_tasks = JSON.parse(data);
        console.log(ret_tasks);
        var x;
        for(x in ret_tasks) {
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
    });

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

    $('#add-task').click(function () {
        console.log('Add a new task');

        //Ajax call to create new task in db
        //Return with note id so we can add within html
        //<input type="hidden" id="note_id" name="note_id" value="NOTE_ID"> Store note id with this

        var $newTaskId = 0;

        $.post("Requests/create_new_task.php", function(data) {
            $newTaskId = data;
            console.log($newTaskId);
        })
            .fail(function () {
                alert("Problem creating new task");
        });

        var $newTask = $('<div class="note">\n' +
            '            <div class="note-header">\n' +
            '                <input type="hidden" id="note_id" name="note_id" value=$newTaskId>\n' +
            '                <div class="note-title"><h3>Default task</h3></div>\n' +
            '                <button id="edit-task" class="hide"></button>\n' +
            '            </div>\n' +
            '            <div class="note-content">\n' +
            '               <p class="note-description">Write task description here.</p>\n' +
            '            </div>\n' +
            '        </div>');
        $(this).parent().before($newTask);
    });

    $('#delete-task').click(function(){
        $.post("Requests/delete_task.php", { task_id: $('#current-task-id').val()})
            .done(function () {
                $('#edit-task-modal').modal('hide');
                //call refresh of page
            })
            .fail(function () {
                alert("Problem deleting task");
            });

    });

    $('#save-edit').click(function() {
        $.post("Requests/edit_task.php", { task_id: $('#current-task-id').val(), task_name: $('#task-title').val(), task_desc: $('#task-desc').val()})
            .done(function () {
                $('#edit-task-modal').modal('hide');
                //call refresh of page
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
});