var uploadedDocumentMap = {};
Dropzone.options.documentDropzone = {
    url: product_req_update_url,
    maxFilesize: 2, // MB
    maxFiles:5,
    acceptedFiles: "image/jpeg, image/png, image/jpg",
    addRemoveLinks: true,
    headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    success: function (file, response) {
        $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">')
        uploadedDocumentMap[file.name] = response.name
    },
    removedfile: function (file) {
        $.ajax({
            type: 'POST',
            url: product_req_removeMedia_url,
            data: { "id" : request_product_id, '_token': _token, "media": file.name },
            success: function(data) {
                $('#document-dropzone').children().remove();
                var dataArr = JSON.parse(data);
                $.each(dataArr, function(key,value) {
                    var mockFile = { name: value.name, size: value.size };
                    thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                    thisDropzone.options.thumbnail.call(thisDropzone, mockFile, value.url);
                    $('form').append('<input type="hidden" data-browse="'+value.id+'" name="document[]" value="' + value.name + '">');
                });
            }
        });
    },
    init: function () {
        thisDropzone = this;
        $.ajax({
            type: 'POST',
            url: product_req_getMedia_url,
            data: { "id" : request_product_id, '_token': _token },
            success: function(data) {
                var dataArr = JSON.parse(data);
                $.each(dataArr, function(key,value) {
                    var mockFile = { name: value.name, size: value.size };
                    thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                    thisDropzone.options.thumbnail.call(thisDropzone, mockFile, value.url);
                    $('form').append('<input type="hidden" data-browse="'+value.id+'" name="document[]" value="' + value.name + '">');
                });
            }
        });
    }
}