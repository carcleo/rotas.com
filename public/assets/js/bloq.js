$(".bloq").click(function(){

    bloq = $(this);
    
    url = bloq.attr("data-bloq");
    id = bloq.attr("id");

    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: {
            'id' : id,
            'method' : 'PUT'
        },

        beforeSend: function () {
			$("div.loading").css("display", "flex");
        },

        success: function (response) {
            
            $("div.loading").hide();    
        
            src = response === "Sim"
                    ? "../../../public/assets/imgs/desbloq.png"
                    : "../../../public/assets/imgs/bloq.png";

            bloq.css("background", "url(" + src + ")");

        }

    });

});