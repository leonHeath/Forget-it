$(function(){

    var $notes = $('.note-space');

    $(document).on('click', 'li.selectable',function () {
        console.log('Clicked an item');
        $('li.selectable').removeClass('selected');
        $(this).addClass('selected');
    });

    $('#new-project').on('click', function(){
       console.log('Creating new project');
       //Create new li node inside here
        //$('li.projects')
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
        var $newTask = $('<div class="note">\n' +
            '            <div contenteditable="true" class="note-header editable">\n' +
            '                <div class="note-title"><h3>Title</h3></div>\n' +
            '                <button id=\'edit-task\' class="hide"></button>\n' +
            '            </div>\n' +
            '            <div class="note-content">\n' +
            '               <p class="note-description">Note description.</p>\n' +
            '            </div>\n' +
            '        </div>');
        $(this).parent().before($newTask);
    });

    $notes.on('mouseenter', '.note', function() {

            $(this).find('#edit-task').removeClass('hide');
    });

    $notes.on('mouseleave', '.note', function() {
            $(this).find('#edit-task').addClass('hide');
        }
    );
    /*
    $notes.on('click', '#edit-task', function () {
        console.log('clicked');

    });
    */
});
