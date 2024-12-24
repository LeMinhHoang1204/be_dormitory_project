@extends('Auth_.index')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('./css/detail_payment.css') }}" type="text/css">
    <script src="{{ asset('javascript/payment.js') }}"></script>
</head>

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Residence Detail</h2>
            </div>
{{--            Left--}}
            <div class="card-body">
                <h3>Transfer by</h3>
                <p>Dorm ID: <strong>{{ $residence->student->id }}</strong></p>
                <p>Student ID: <strong>{{ $residence->student->student->uni_id }}</strong></p>
                <p>Student Name: <strong>{{$residence->student->name }} </strong></p>
                <p>Date of birth: <strong>{{ $residence->student->student->dob }}</strong></p>
                <p>Gender: <strong>{{ $residence->student->student->gender }}</strong></p>
                <p>Phone: <strong>{{ $residence->student->phone }}</strong></p>
                <p>University: <strong>{{ $residence->student->student->uni_name }}</strong></p>

                <p>Registration Date: <strong>{{ $residence->created_at }}</strong></p>
                <p>Start Date: <strong>{{ $residence->start_date }}</strong></p>
                <p>End Date: <strong>{{ $residence->end_date }}</strong></p>

                <h3>Room Information</h3>
                <p>Room ID: <strong>{{ $residence->room_id }}</strong></p>
                <p>Room Name: <strong>{{ $residence->room->name }}</strong></p>
                <p>Room Type: <strong>{{ $residence->room->type }} members</strong></p>
                <p>Member Count: <strong>{{ $residence->room->member_count }}</strong></p>
            </div>
{{--            Right--}}
            <div class="container mt-5">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h2 class="mb-0">Search Student</h2>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="userIdInput" class="form-label">User ID</label>
                            <input type="text" class="form-control" id="userIdInput" placeholder="Enter User ID">
                        </div>
                        <div id="userInfo"></div>
                    </div>
                </div>
            </div>

{{--            Để chung section với phần search student--}}
            <script>
                document.getElementById('userIdInput').addEventListener('input', async function() {
                    const userId = this.value;
                    if (userId) {
                        await fetch(`/students/${userId}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    document.getElementById('userInfo').innerHTML = `
                                        <h3>Transferred Student</h3>
                                        <p>Dorm ID: <strong>${data.student.user.id}</strong></p>
                                        <p>Student ID: <strong>${data.student.uni_id}</strong></p>
                                        <p>Student Name: <strong>${data.student.user.name}</strong></p>
                                        <p>Date of birth: <strong>${data.student.dob}</strong></p>
                                        <p>Gender: <strong>${data.student.gender}</strong></p>
                                        <p>Phone: <strong>${data.student.user.phone}</strong></p>
                                        <p>University: <strong>${data.student.uni_name}</strong></p>
                                        ${data.student.user.residence[0] != null ? `
                                            <h3>Residence Information</h3>
                                            <p>Registration Date: <strong>${data.student.user.residence[0].created_at}</strong></p>
                                            <p id='startdate' value='${data.student.user.residence[0].start_date}'>Start Date: <strong>${data.student.user.residence[0].start_date}</strong></p>
                                            <p>End Date: <strong>${data.student.user.residence[0].end_date}</strong></p>
                                            <p id='checkoutdate' value='${data.student.user.residence[0].check_out_date}'>Check out Date: <strong>${data.student.user.residence[0].check_out_date}</strong></p>
                                            <h3>Room Information</h3>
                                            <p>Building ID: <strong>${data.student.user.residence[0].room.building_id}</strong></p>
                                            <p>Room ID: <strong>${data.student.user.residence[0].room.id}</strong></p>
                                            <p>Room Name: <strong>${data.student.user.residence[0].room.name}</strong></p>
                                            <p>Room Type: <strong>${data.student.user.residence[0].room.type} members</strong></p>
                                            <p>Member Count: <strong>${data.student.user.residence[0].room.member_count}</strong></p>
                                        ` : `
                                            <h3>Student never lived in dormitory</h3>
                                            <p id='startdate' value='null'></p>
                                            <p id='checkoutdate' value='null'></p>
                                        `}
                                    `;
                                    document.querySelector('input[name="tranfferingID"]').value = {{$residence->student->id}};
                                    document.querySelector('input[name="tranferredID"]').value = data.student.user.id;
                                } else {
                                    document.getElementById('userInfo').innerHTML = '<p>User with role student not found.</p>';
                                }
                            });
                    } else {
                        document.getElementById('userInfo').innerHTML = '';
                    }
                });
            </script>



            <form action="{{ route('requests.acceptCheckIn', $residence->id) }}" method="POST">
                @csrf
                <textarea id="note" rows="3" name="note"></textarea>
                <div class="button-group">
{{--                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#reportModal">Report</button>--}}
                    <button class="btn btn-primary" id="confirmButton" type="button">Accept</button>
                </div>
            </form>

            <script>
                document.getElementById('confirmButton').addEventListener('click', function() {
                    const userIdInput = document.getElementById('userIdInput').value;

                    if (!userIdInput) {
                        alert('Please enter a User ID before proceeding.');
                    } else {
                        const checkoutdate = document.getElementById('checkoutdate');
                        const startDate = document.getElementById('startdate');

                        if(startDate.getAttribute('value') ==='null'){
                            console.log('This student has already checked in');
                            const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
                            confirmModal.show();
                        }
                        else if(startDate.getAttribute('value') !== 'null' && checkoutdate.getAttribute('value') === 'null'){
                            console.log('This student has already checked out');
                            alert('This student has already checked out');
                        }
                        else{
                            const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
                            confirmModal.show();
                        }
                    }
                });
            </script>

        </div>
    </div>

    <div id="successNotification" class="alert alert-success" style="display: none; position: fixed; top: 20px; right: 20px; z-index: 1000;">
        Send Successful
    </div>


@endsection

<!-- Report Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportModalLabel">Report Issue</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="reportForm">
                    <div class="mb-3">
                        <label for="reportDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="reportDescription" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="evidenceUpload" class="form-label">Upload Evidence</label>
                        <input class="form-control" type="file" id="evidenceUpload" accept="image/*">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="sendReport">Send</button>
            </div>
        </div>
    </div>
</div>

<!-- Confirm Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirm Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('requests.acceptTransferCheckInReq', $residence->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="tranfferingID" value="">
                <input type="hidden" name="tranferredID" value="">

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="confirmDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="confirmDescription" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="confirmEvidenceUpload" class="form-label">Upload room transfer report</label>
                        <input class="form-control" type="file" id="confirmEvidenceUpload" accept="image/*" name="image" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="sendConfirm">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#sendReport').click(function() {
            $('#successNotification').fadeIn().delay(1000).fadeOut();

            // An modal
            $('#reportModal').modal('hide');
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#sendConfirm').click(function() {
            $('#successNotification').fadeIn().delay(1000).fadeOut();

            // Hide modal
            $('#confirmModal').modal('hide');
        });
    });
</script>





<script src="{{ asset('javascript/payment.js') }}"></script>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
