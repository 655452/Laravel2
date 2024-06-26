var uploadedDocumentMap = {};
Dropzone.options.documentDropzone = {
    url: product_req_store_url,
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
        file.previewElement.remove();
        var name = ''
        if (typeof file.file_name !== 'undefined') {
            name = file.file_name
        } else {
            name = uploadedDocumentMap[file.name]
        }
        $('form').find('input[name="document[]"][value="' + name + '"]').remove()
    },
    init: function () {
        if(request_product !='' && request_products){
            var files = files;
            for (var i in files) {
                var file = files[i]
                this.options.addedfile.call(this, file)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">')
            }
        }
    }
}