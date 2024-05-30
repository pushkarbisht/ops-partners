@extends('includes.layout')
@section('title', 'One Point Solution:Login')
@section('content')
<div class="w-full">
    <div class="grid h-screen place-items-center min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
        <div class="relative py-3 sm:max-w-xl sm:mx-auto">
            <div
                class="absolute inset-0 bg-gradient-to-r from-blue-300 to-blue-600 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl">
            </div>
            <div class="relative px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20">
                <div class="max-w-md mx-auto">
                    <div>
                        <h1 class="text-2xl font-semibold">Add Password</h1>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <div
                            class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7 flex flex-col gap-4">
                            <div class="relative">
                                <input autocomplete="off" id="password" name="password" type="password"
                                    class="peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 outline-none border-0"
                                    placeholder="Password" />
                                <label for="password"
                                    class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:-top-[23px] peer-focus:text-gray-600 peer-focus:text-sm">Password</label>
                            </div>
                            <div class="relative mt-6">
                                <input autocomplete="off" id="confirmPassword" name="confirmPassword" type="password"
                                    class="peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 outline-none border-0"
                                    placeholder="Confirm Password" />
                                <label for="confirmPassword"
                                    class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:-top-[23px] peer-focus:text-gray-600 peer-focus:text-sm">Confirm
                                    Password</label>
                            </div>
                            <div class="relative">
                                <button class="bg-blue-500 text-white rounded-md px-2 py-1"
                                    id="submitBtn">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="tokenInput">

<!-- jQuery CDN link -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const urlParams = new URLSearchParams(window.location.search);
        const token = urlParams.get('token');
        console.log(token); // Log the token to the console

        // Assign the token value to a hidden input field
        $('#tokenInput').val(token);
    });

    $(document).ready(function () {
        // Click event handler for the submit button
        $('#submitBtn').click(function () {
            // Get password and confirm password values
            const password = $('#password').val();
            const confirmPassword = $('#confirmPassword').val();
            const token = $('#tokenInput').val(); // Retrieve the token from the hidden input field

            // Validate passwords
            if (password !== confirmPassword) {
                alert('Passwords do not match');
                return;
            }

            // Data to be sent in the AJAX request
            const requestData = {
                password: password,
                token: token // Send the token extracted from the URL
            };

            console.log("Request data:", requestData); // Log request data

            // AJAX request to your API route
            $.ajax({
                type: 'POST',
                url: 'https://partners.opsol.in/api/set-password',
                data: requestData,
                dataType: 'json',
                success: function (response) {
                    console.log("Response:", response);
                    alert('Password set successfully');
                    window.location.href = 'https://partners.opsol.in/login';
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    console.error('Response Text:', xhr.responseText);
                    console.error('Status Code:', xhr.status);
                    alert('Error setting password: ' + xhr.responseText);
                }
            });

        });
    });
</script>
@endsection