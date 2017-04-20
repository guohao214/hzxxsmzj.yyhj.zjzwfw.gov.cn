/**
 * Created by denny on 1/13/17.
 */
$(function(){
    $(window).resize(function(){
        var h_doc = $(document).height();
        var h_foo = h_doc-20;
        $('#footer').offset({top:h_foo,left:0});
    });
});