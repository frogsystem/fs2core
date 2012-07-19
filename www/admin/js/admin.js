//--------------------------------
// START - Document Ready Functions
//--------------------------------
$().ready(function(){

    //~ Remove No Script CSS
    $("head > link#noscriptcss").remove();

    //~ Image Checkboxes
    $("input[type='checkbox']:enabled").prev("img.checkbox").each(function(){
        colorcb($(this), false, "checkbox");
    ;});
    $("input[type='checkbox']:enabled").prev("img.checkbox").hover(function(){
        colorcb($(this), true, "checkbox");
    }, function(){
        colorcb($(this), false, "checkbox");
    });
    $("input[type='checkbox']:enabled").prev("img.checkbox").click(function(){
        var checkbox = $(this).next("input[type='checkbox']:enabled");
        checkbox.trigger('click');
        $(this).trigger('mouseenter');
    });
    $("img.checkbox+input[type='checkbox']:enabled").change(function(){
        colorcb($(this).prev("img.checkbox"), false, "checkbox");
    ;});

    //~ Image Radios
    $("input[type='radio']:enabled").prev("img.checkbox").each(function(){
        colorcb($(this), false, "radio");
    ;});
    $("input[type='radio']:enabled").prev("img.checkbox").hover(function(){
        colorcb ($(this), true, "radio");
    }, function(){
        colorcb($(this), false, "radio");
    });
    $("input[type='radio']:enabled").prev("img.checkbox").click(function(){
        var checkbox = $(this).next("input[type='radio']:enabled");
        checkbox.trigger('click');
        $(this).trigger('mouseenter');
    });
    $("img.checkbox+input[type='radio']:enabled").change(function(){
        $("input[type='radio'][name='"+$(this).attr("name")+"']:enabled").prev("img.checkbox").each(function(index, img){
            colorcb($(img), false, "radio");
        ;});
    ;});
});
//--------------------------------
// END - Document Ready Functions
//--------------------------------


//--------------------------------
// START - Functions
//--------------------------------

    //~ Image Checkboxes
    function colorcb (cb, hover, type) {
        var checkbox = cb.next("input[type='"+type+"']:enabled");
        
        if (checkbox.hasClass("cb-red")) {
            var color = "red";
        } else {
            var color = "green";
        }
        
        if (checkbox.is(":checked")) {
            if (hover) {
                cb.attr("src", "images/"+type+"-"+color+"-active-hover.png");
            } else {
                cb.attr("src", "images/"+type+"-"+color+"-active.png");
            }

            if (type == "radio") {
                cb.attr("alt", "(x)");
            } else {
                cb.attr("alt", "[x]");
            }
        } else {
            if (hover) {
                cb.attr("src", "images/"+type+"-"+color+"-hover.png");
            } else {
                cb.attr("src", "images/"+type+".png");
            }

            if (type == "radio") {
                cb.attr("alt", "(_)");
            } else {
                cb.attr("alt", "[_]");
            }
        }
    }

    //~ (De-)Select Checkboxes of paragraph
    function permselect (obj, checked) {
        obj.parents("p:first").find("input[type=checkbox]:enabled").each(function (index, ele) {
            $(ele).prop("checked", checked);
            $(ele).change();
        });
    }
    
    //~ (De-)Select Checkboxes of generic parent
    function groupselect (parentstr, checked) {
        $(parentstr).find("input[type=checkbox]:enabled").each(function (index, ele) {
            $(ele).prop("checked", checked);
            $(ele).change();
        });
    }    

//--------------------------------
// END - Functions
//--------------------------------
