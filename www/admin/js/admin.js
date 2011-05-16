//--------------------------------
// START - Document Ready Functions
//--------------------------------
$().ready(function(){
    
    //~ Remove No Scrip CSS    
    $("head > link#noscriptcss").remove();
    
    //~ Image Checkboxes
    $("input[type='checkbox']:enabled").prev("img.checkbox").each(function(){
        colorcb($(this));
    ;});
    $("img.checkbox").hover(function(){
        var checkbox = $(this).next("input[type='checkbox']:enabled");
        if (checkbox.is(":checked")) {
            $(this).attr("src", "img/test-active-hover.png");
        } else {
            $(this).attr("src", "img/test-hover.png");
        }            
    }, function(){
        var checkbox = $(this).next("input[type='checkbox']:enabled");
        if (checkbox.is(":checked")) {
            $(this).attr("src", "img/test-active.png");
        } else {
            $(this).attr("src", "img/test.png");
        }  
    });
    $("img.checkbox").click(function(){
        var checkbox = $(this).next("input[type='checkbox']:enabled");
        if (checkbox.is(":checked")) {
            checkbox.removeProp("checked");
        } else {
            checkbox.prop("checked", true);
        }
        checkbox.trigger('change'); 
        $(this).trigger('mouseenter');  
    });
    $("img.checkbox+input[type='checkbox']:enabled").change(function(){
        colorcb($(this).prev("img.checkbox"));
    ;});    
});
//--------------------------------
// END - Document Ready Functions
//--------------------------------


//--------------------------------
// START - Functions
//--------------------------------

    //~ Image Checkboxes
    function colorcb (cb) {
        var checkbox = cb.next("input[type='checkbox']:enabled");
        if (checkbox.is(":checked")) {
            cb.attr("src", "img/test-active.png");
        } else {
            cb.attr("src", "img/test.png");
        }
    }
//--------------------------------
// END - Functions
//--------------------------------
