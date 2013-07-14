//--------------------------------
// START - Document Ready Functions
//--------------------------------
$(document).ready(function(){
		$('.colorpickerInput').ColorPicker({
			onSubmit: function(hsb, hex, rgb, ele) {
                $(ele).val(hex.toUpperCase());
                $(ele).parents('.colorpickerParent').find('.colorpickerSelector div').css('background-color', '#' + hex);
				$(ele).ColorPickerHide();
			},
			onBeforeShow: function () {
				$(this).ColorPickerSetColor(this.value);
			},
            onShow: function (colpkr) {
                $(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb, ele) {
                $(ele).val(hex.toUpperCase());
                $(ele).parents('.colorpickerParent').find('.colorpickerSelector div').css('background-color', '#' + hex);
            }
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(getCorrectHex(this.value));
		});

        $('.colorpickerSelector, .colorpickerSelector div').click(function() {
            $(this).parents('.colorpickerParent').find('.colorpickerInput').ColorPickerShow();
        });
        
        $('.colorpickerInput').change(function() {
            var newhex = getCorrectHex($(this).val());
            $(this).parents('.colorpickerParent').find('.colorpickerSelector div').css('background-color', '#' + newhex);
        });
        
        $('.colorpickerInput').keydown(function() {
            $(this).change();
        });
        $('.colorpickerInput').keyup(function() {
            $(this).change();
        });
        
        $('.colorpickerInput').focusout(function() {
            $(this).val(getCorrectHex($(this).val()));
        });
        
        
});
//--------------------------------
// END - Document Ready Functions
//--------------------------------

function getCorrectHex (wrongVal) {
    wrongVal = wrongVal.toUpperCase();
    if (wrongVal.length == 3) {
        var first = wrongVal.charAt(0);
        var second = wrongVal.charAt(1);
        var third = wrongVal.charAt(2);
        return first+first+second+second+third+third;
    } else {
        var full = wrongVal+"000000";
        return full.substr(0,6);
    }
}
