@extends('Auth_.index')

<head>
    <title>Student Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('./css/student/extension.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/student/acitivities.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/button.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/avatar.css') }}" type="text/css">
</head>
@section('content')
    @include('layouts.sidebar_student')
    @if (auth()->check() && auth()->user()->role === 'student')
        <div class="extension">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif
                @if ($errors->has('profile_image'))
                    <div class="alert alert-danger">
                        {{ $errors->first('profile_image') }}
                    </div>
                @endif

            <div class="bluefont" style="border: #4a5568 0.2px solid">
                <h3>Student Profile</h3>
            </div>


                <form id="profile-image-form" method="POST" action="{{ route('user_profile.php.update-image') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="profile-image">
                        <img src="{{
            auth()->user()->profile_image_path && file_exists(storage_path('app/public/' . auth()->user()->profile_image_path))
            ? asset('storage/' . auth()->user()->profile_image_path)
            : asset('images/avatar.png')  }}"
                             alt="Profile Image" class="profile-img" id="profile-image">

                        <label for="file-upload" class="upload-icon">
                            <i class="fas fa-camera"></i>
                        </label>
                        <input type="file" id="file-upload" name="profile_image" style="display: none;" accept="image/*" onchange="previewImage(event)">
                    </div>
                    <button type="submit" id="save-button" class="blue-btn" style="display: none; align-items: center ">Save</button>

                </form>




                <script>
                    function previewImage(event) {
                        var reader = new FileReader();
                        reader.onload = function () {
                            var output = document.getElementById('profile-image');
                            output.src = reader.result;
                        };
                        reader.readAsDataURL(event.target.files[0]);

                        var saveButton = document.getElementById('save-button');
                        saveButton.style.display = 'block';
                    }

                    function saveAvatar() {
        var formData = new FormData();
        var fileInput = document.getElementById('file-upload');
        var file = fileInput.files[0];

        if (!file) {
            alert('No file selected.');
            return;
        }

        formData.append('profile_image', file);

        fetch('/upload-profile-image', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('user_profile.php-image').src = '/storage/' + data.imagePath;

                    document.getElementById('save-avatar').style.display = 'none';
                    alert('Profile image updated successfully!');
                } else {
                    alert('Failed to update image. ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error uploading image:', error);
                alert('Error uploading image.');
            });
    }

</script>
                <div class="student-details">
                <div class="info-left">
                    <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
                    <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                    <p><strong>Phone:</strong> {{ auth()->user()->phone ?? 'Not provided' }}</p>
                    <p><strong>University ID:</strong> {{ $student->uni_id }}</p>
                    <p><strong>Date of Birth:</strong> {{ \Carbon\Carbon::parse($student->dob)->format('d M, Y') }}</p>
                    <p><strong>Training Points:</strong> {{ $student->training_point }}</p>
                </div>
                <div class="info-right">
                    <p><strong>Student ID:</strong> #STU_{{ $student->id }}</p>
                    <p><strong>Registration Date:</strong> {{ \Carbon\Carbon::parse($student->created_at)->format('d M, Y') }}</p>
                    <p><strong>Gender:</strong> {{ ucfirst($student->gender) }}</p>
                    <p><strong>University Name:</strong> {{ $student->uni_name }}</p>
                    <p><strong>Status:</strong> {{ auth()->user()->status ? 'Active' : 'Inactive' }}</p>
                    <p><strong>Room:</strong> {{ $currentResidence?->room?->name ?? 'Not assigned' }}</p>
                    {{--                    <p><strong>Profile Image:</strong> <img src="{{ asset('storage/' . auth()->user()->profile_image_path) }}" alt="Profile Image" style="width: 100px; height: 100px; border-radius: 50%"></p>--}}
                </div>
            </div>

            <!-- About Section -->
            <div class="popup-about">
                <h3>About Me:</h3>
                <p>{{ auth()->user()->bio ?? 'There is no bio provided!' }}</p>
            </div>

            <div class="popup-buttons">
                <a href="javascript:void(0);" class="grey-btn" onclick="goBack()"> < Back</a>

                <script>
                    function goBack() {
                        window.location.href = "{{ route('dashboard') }}";
                    }
                </script>

{{--                <a href="{{ route('profile.edit') }}" class="blue-btn">Edit Profile</a>--}}
            </div>
        </div>
    @endif

    @if (auth()->check() && auth()->user()->role === 'accountant')
        <div class="extension">
            <div>
                <p style="color: var(--Close, #FF2F5C);
                    font-family: Poppins;
                    font-size: 16px;
                    font-style: italic;
                    font-weight: 400;
                    line-height: normal;">
                    You cannot access this page!
                </p>
            </div>
        </div>
    @endif
@endsection

<style>
    .bluefont {
        margin-bottom: 15px!important;
    }
    .extension {
        position: relative;
        max-width: 45%;
        padding-left: 40px;
        padding-right: 40px;
    }
    .student-details {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .info-left,
    .info-right {
        width: 48%;
    }
    .popup-about {
        margin-top: 20px;
        font-size: 14px;
    }
    .popup-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
    }
    .grey-btn,
    .blue-btn {
        padding: 10px 20px;
        text-decoration: none;
        color: white;
        border-radius: 5px;
    }
    .grey-btn {
        background-color: grey;
    }
    .blue-btn {
        background-color: #2F6BFF;
    }
</style>
