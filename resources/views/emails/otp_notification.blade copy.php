<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OTP Notification</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body class="font-poppins bg-white text-gray-700 text-base">
    <div class="max-w-2xl mx-auto px-6 md:px-0 py-12 md:py-16 bg-blue-300 bg-cover bg-center rounded-lg">
        <header class="mb-8 md:mb-12">
            <table class="w-full">
                <tr class="h-0">
                    {{--
                    <!-- <td><img src="{{ URL::asset('assets/img/logo') }}" alt="profile Pic" height="98" width="88"> -->
                    <!-- </td> -->--}}
                    {{-- <td class="text-right"><span class="text-white text-lg leading-8 md:text-xl">12 Nov,
                            2021</span> --}}
                        {{--<!-- </td> -->--}}
                </tr>
            </table>
        </header>
        <main>
            <div class="mx-auto mb-12 md:mb-16 p-8 md:p-12 bg-white rounded-lg text-center max-w-md">
                <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-4">Your OTP</h1>
                {{-- <p class="mt-4 md:mt-6 font-semibold">Hi,</p> --}}
                <p class="mt-4 md:mt-6 font-semibold text-gray-700 leading-7">Thank you for choosing OPS
                    Company. Use the following OTP to complete the procedure to change your email address. OTP is valid
                    for <span class="font-bold">30 minutes</span>. Do not share this code with others, including
                    Archisketch employees.</p>
                <p class="mt-8 md:mt-12 text-4xl md:text-6xl font-semibold tracking-widest text-red-600">
                    {{ $otp }}</p>
            </div>
            <p class="mx-auto mt-12 md:mt-16 text-center font-semibold text-gray-600 max-w-md">Need help? Ask at <a
                    href="mailto:ops@gmail.com" mailto:class="text-blue-600">ops@gmail.com</a> or visit our <a href="#"
                    target="_blank" class="text-blue-600">Help Center</a></p>
        </main>
        <footer class="w-full max-w-md mx-auto mt-8 md:mt-12 border-t border-gray-300 text-center">
            <p class="mt-8 text-lg font-semibold text-gray-700">One Point Solution</p>
            <p class="mt-2 text-gray-700">Address 540, City, State.</p>

            {{--<!-- <div class="mt-4">
                <a href="#" target="_blank" class="inline-block"><img
                        src="https://archisketch-resources.s3.ap-northeast-2.amazonaws.com/vrstyler/1661502815169_682499/email-template-icon-facebook"
                        alt="Facebook" class="w-8 md:w-9"></a>
                <a href="#" target="_blank" class="inline-block ml-2"><img
                        src="https://archisketch-resources.s3.ap-northeast-2.amazonaws.com/vrstyler/1661504218208_684135/email-template-icon-instagram"
                        alt="Instagram" class="w-8 md:w-9"></a>
                <a href="#" target="_blank" class="inline-block ml-2"><img
                        src="https://archisketch-resources.s3.ap-northeast-2.amazonaws.com/vrstyler/1661503043040_372004/email-template-icon-twitter"
                        alt="Twitter" class="w-8 md:w-9"></a>
                <a href="#" target="_blank" class="inline-block ml-2"><img
                        src="https://archisketch-resources.s3.ap-northeast-2.amazonaws.com/vrstyler/1661503195931_210869/email-template-icon-youtube"
                        alt="Youtube" class="w-8 md:w-9"></a>
            </div> -->--}}
            <p class="mt-4 text-gray-700">Copyright © 2022 Company. All rights reserved.</p>
        </footer>
    </div>
</body>

</html>