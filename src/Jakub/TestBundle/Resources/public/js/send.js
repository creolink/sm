
$(document).ready(
    function()
    {
        $("form.restform").submit(
            function(e)
            {
                e.preventDefault();
                
                var jsonData = {};
                var formData = $("form.restform").serializeArray();

                $.each(formData, function() {
                    if (jsonData[this.name]) {
                        if (!jsonData[this.name].push) {
                            jsonData[this.name] = [jsonData[this.name]];
                        }
                        jsonData[this.name].push(this.value || '');
                    } else {
                        jsonData[this.name] = this.value || '';
                    }
                });
                
                $.ajax({
                    url: Routing.generate('rest-create-topic'),
                    type: 'post',
                    data: JSON.stringify(jsonData),
                    //data: JSON.stringify({"formData":formData}),
                    //data: JSON.stringify(formData),
                    //cache: false,
                    dataType: "json",
                    contentType: 'application/json; charset=utf-8',
                    //processData: false,
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
