

$("#category-list").children('a').click(function(){
    var id = $(this).attr('data-bind-id').replace("category-", '');
    $("#category-list").children('a').removeClass('active');
    $("#category-list").children("[data-bind-id='category-"+id+"']").addClass('active');
    $.ajax({
        method: "GET",
        url: "/article/category/"+id,
        data: { _token: $("input[name='_token']").val() }
    }).done(function( msg ) {
        if (msg.status==1) {
            $("#div-title-list").children().remove();
            $.each(msg.data, function(index, obj){
                $("#div-title-list").append('<a href="/article/edit/'+obj.id+'" class="list-group-item" style="margin:-1px;">'+obj.title+'</a>');
            });
        }
    });
});

$("#div-category").click(function(){
    if ( $("#div-button").is(':hidden') ) {
        $("#div-button").show();
    } else {
        $("#div-button").hide();
    }
    if ( $("#inputCategory").is(':hidden') ) {
        $("#inputCategory").show();
    } else {
        $("#inputCategory").hide();
    }
});

$("#div-article").click(function(){
    $("#button-article-delete").hide();
    $("#articleFormTitle").val('');
    $("#articleFormNote").val('')
    testEditor.clear();
});

$("#button-category-cancel").click(function(){
    $("#div-button").hide();
    $("#inputCategory").hide();
});

$("#button-category-save").click(function(){
    var categoryName = $("#inputCategory").val();
    $.ajax({
        method: "POST",
        url: "/category/add",
        data: { name: categoryName, _token: $("input[name='_token']").val() }
    }).done(function( msg ) {
        if (msg.status==1) {
            $("#category-list a").each(function(){
                $(this).prop('class', 'list-group-item');
            });
            $("#category-list").append('<a href="#" class="list-group-item active" style="margin:-1px;">'+categoryName+'</a>');
        } else {
            console.log(msg.msg);
        }
    });
    $("#div-button").hide();
    $("#inputCategory").hide();
});

$("#button-article-save").click(function(){
    $.ajax({
        method: "POST",
        url: "/article/save",
        data: { 
            title: $("#articleFormTitle").val(), 
            note: $("#articleFormNote").val(), 
            category: $("input[name='articleFormCategory']:checked").val(), 
            _token: $("input[name='_token']").val(), 
            status:1, 
            dosubmit:1 }
    }).done(function( msg ) {
        if (msg.status==1) {
            // $("#article-post-header").animate({ backgroundColor:'#dff0d8'},1000);
            // $("#article-post-header").delay(1000).animate({ backgroundColor:'#fff'},1000);
            window.location.reload();
        }
    });
});

$("#button-article-publish").click(function(){
    $.ajax({
        method: "POST",
        url: "/article/save",
        data: { title: $("#articleFormTitle").val(), note: $("#articleFormNote").val(), _token: $("input[name='_token']").val(), status:1, dosubmit:1 }
    }).done(function( msg ) {
        if (msg.status==1) {
            location.href = "/article/"+msg.param.id;
        }
    });
});