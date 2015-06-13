
!function($){
    
    $('#new-todo').keyup(function(e){
        var o = $(this)
        if (e.keyCode === 13) {
            var value = $.trim(o.val())
            value && save(value)
            o.val('')
        }
    })
    
    function save(value) {
        $.post('/todos/save', {title: value}, function(todo, status) {
            $('#list').append('<li><span class="title">'+ value +'</span><span class="edit"><a data-type="ok" data-id="'+ todo.id +'">搞定</a> <a data-type="delete" data-id="'+ todo.id +'">删除</a></span></li>')
        }, 'JSON')
        .error(function(res, status) {
            console.log(res)
            if (status === 'parsererror') {
                console.log(res.responseText)
            } else {
                console.log(res.responseJSON)
            }
        })
    }
    
    
    $('#list').on('click', 'a', function() {
        var o = $(this)
        var data = o.data()
        
        $.ajax({
            url: '/todos/'+data.type,
            type: 'POST',
            data: {'id': data.id},
            success: function(data) {
                if(data === 'ok') {
                    o.closest('li')
                    .find('.title')
                    .removeClass('status-0')
                    .addClass('status-1')
                }else if(data === 'delete') {
                    o.closest('li').remove()
                }
            }
        })
    })
    
}(jQuery)