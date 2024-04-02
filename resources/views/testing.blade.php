<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Divs Dynamically</title>
    <link rel="stylesheet" href="https://soulhousing.anchorstech.net/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
</head>
<body>
<form method="POST" action="{{route('save.data')}}">
    @csrf
    <div class="container mt-5">
        <div class="map-bg-sec">
            <div class="map-content">
                <div class="d-flex align-items-center mt-3">
                    <h5>No. of Floors:</h5>
                    <div class="form-floating mb-3 ms-3 w-50">
                        <input type="number" id="numberOfFloors" name="number_of_floors" class="form-control">
                        <label for="numberOfFloors">Enter No. of Floors</label>
                    </div>
                    <button id="addFloorsBtn" type="button" class="btn btn-primary ms-3">Add Floors</button>
                </div>
            </div>
        </div>
    </div>
    <button  type="submit">Submit Data</button>
</form>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function(){
        $('#addFloorsBtn').click(function(){
            var numberOfFloors = $('#numberOfFloors').val();
            for(var i = 1; i <= numberOfFloors; i++) {
                var newFloor = `
                <div class="map-bg mt-3">
                    <div class="d-flex align-items-center">
                        <h5>Floor No. ${i}</h5>
                        <div class="d-flex align-items-center ms-auto">
                            <h5>No. of Rooms:</h5>
                            <div class="form-floating ms-3 w-100">
                                <input type="number" class="form-control roomInput" name="number_of_rooms[]" placeholder="Enter No. of Rooms">
                                <label for="floatingInput">Enter No. of Rooms</label>
                            </div>
                        </div>
                    </div>
                    <div class="map-border"></div>
                </div>`;
                $('.map-content').append(newFloor);
            }
        });

        $(document).on('input', '.roomInput', function(){
            var numberOfRooms = $(this).val();
            var parentDiv = $(this).closest('.map-bg');
            parentDiv.find('.roomsContainer').remove(); // Remove previous rooms container
            var roomsContainer = $('<div class="roomsContainer"></div>');
            for(var i = 1; i <= numberOfRooms; i++) {
                var newRoom = `
                <div class="row mt-3">
                    <div class="col-6">
                        <h5 class="mt-3 mb-3">Room No. ${i}</h5>
                        <div class="d-flex align-items-center ms-auto">
                            <h5>No. of Bed</h5>
                            <div class="form-floating mb-3 ms-3 w-75">
                                <input type="number" class="form-control" name="number_of_beds[]" placeholder="Enter No. of Beds">
                                <label for="floatingInput">Enter No. of Beds</label>
                            </div>
                        </div>
                    </div>
                </div>`;
                roomsContainer.append(newRoom);
            }
            parentDiv.append(roomsContainer);
        });
    });
</script>

</body>
</html>
