
$(document).ready(
    function()
    {
        $("a.delete").click(
            function(e)
            {
                e.preventDefault();

				var topicId = $(this).attr('rel').replace('#', '');
                
                $.ajax({
                    url: Routing.generate('rest-delete-topic'),
                    type: 'delete',
                    data: JSON.stringify({"topicId":topicId}),
                    dataType: "json",
                    contentType: 'application/json; charset=utf-8',
                    success: function(response) {
                        if(response.result != 'OK')
                        {
                            alert(response.result); // show error
                        }
                        else
                        {
                            window.location.href = Routing.generate('topics-list');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        //alert('jqXHR = '+jqXHR+', textStatus = '+textStatus+', errorThrown = '+errorThrown);
                    }
                });
            }
        );
    }
);
