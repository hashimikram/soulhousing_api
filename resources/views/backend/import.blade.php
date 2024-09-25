<style>
    .progress-bar {
        transition: width 0.4s ease; /* Smooth transition for better visibility */
        background-color: #007bff; /* Ensure the color is distinct */
    }

</style>
<form id="importForm" action="{{ route('patients.import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div id="errors" style="display:none;">
        @foreach($errors->all() as $error)
            <div class="alert alert-danger">{{ $error }}</div>
        @endforeach
    </div>
    <div class="form-group">
        <label for="file">Choose CSV File</label>
        <input type="file" name="file" class="form-control" id="file">
    </div>
    <div class="progress" style="display:none; height: 20px; background-color: grey">
        <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
             aria-valuemax="100"></div>
    </div>

    <button type="submit" class="btn btn-primary">Import</button>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#importForm').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function (e) {
                        if (e.lengthComputable) {
                            var percentComplete = Math.round((e.loaded / e.total) * 100);
                            console.log('Upload progress:', percentComplete + '%'); // Debugging
                            $('.progress').show();
                            $('.progress-bar').css('width', percentComplete + '%');
                            $('.progress-bar').attr('aria-valuenow', percentComplete);
                        }
                    }, false);
                    return xhr;
                },
                beforeSend: function () {
                    $('.progress-bar').css('width', '0%');
                    $('#errors').hide();
                    $('.progress').show();
                },
                success: function (response) {
                    console.log(response); // Debugging
                    $('.progress').hide();
                    alert('Patients imported successfully!');
                    window.location.reload();
                },
                error: function (response) {
                    console.log('Error:', response); // Debugging
                    $('.progress').hide();
                    var errors = response.responseJSON.errors;
                    var errorHtml = '';
                    $.each(errors, function (key, value) {
                        errorHtml += '<div class="alert alert-danger">' + value + '</div>';
                    });
                    $('#errors').html(errorHtml);
                    $('#errors').show();
                }
            });
        });
    });
</script>
