require([ 'jquery', 'jquery/ui'], function($){
        function explode(){
            var a = $("a[class='action-menu-item']").length;
            //console.log(a);
            /*if(parseInt(a)==0){
                setTimeout(explode, 2000);
            }
            else{
                for(var m=1;m<a;m++){
                    var dis = $("tbody").children('.data-row:eq('+m+')').children('td').children('div:eq(3)').text();
                    console.log(dis);
                    if(dis==="Disabled"){
                        $(".action-select-wrap:eq("+m+")").children('.action-menu').children('li:eq('+m+')').attr("style",'display:none');
                    }

                }
            }*/

            console.log(a);
            /*$('a[class="action-menu-item"]:eq(15)').click(function () {
                var tabindex = "ddd";
                jQuery.ajax({
                 type: "POST",
                 dataType: "JSON",
                 data :{'tabindex':tabindex},
                 url :"gridpart2/grouped/grouped?isAjax=true",
                 success:function(data){

                 }
                 });
                $(".modal-popup, .ui-dialog-active, .ui-popup-message, .modal-system-messages").remove();
                $('.modals-overlay').remove();
                $(".admin__data-grid-loading-mask").css('display','block');

            });*/
        }
        setTimeout(explode, 1000);
    $('a[class="action-menu-item"]:eq(15)').click(function () {
        var tabindex = "ddd";
        jQuery.ajax({
            type: "POST",
            dataType: "JSON",
            data :{'tabindex':tabindex},
            url :"gridpart2/grouped/grouped?isAjax=true",
            success:function(data){

            }
        });
        $(".modal-popup, .ui-dialog-active, .ui-popup-message, .modal-system-messages").remove();
        $('.modals-overlay').remove();
        $(".admin__data-grid-loading-mask").css('display','block');
    });

});